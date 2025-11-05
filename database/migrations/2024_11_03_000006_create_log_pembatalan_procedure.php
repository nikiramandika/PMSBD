<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus semua trigger yang lama
        DB::unprepared('DROP TRIGGER IF EXISTS log_pembatalan_trigger');

        // Hapus temporary table jika masih ada
        DB::unprepared('DROP TABLE IF EXISTS temp_cancellation_context');
        DB::unprepared('DROP TABLE IF EXISTS cancellation_context');

        // Hapus procedure lama jika ada
        DB::unprepared('DROP PROCEDURE IF EXISTS log_pembatalan_procedure');

        // Buat stored procedure untuk log pembatalan
        DB::unprepared('
            CREATE PROCEDURE log_pembatalan_procedure(
                IN p_transaksi_id INT,
                IN p_alasan VARCHAR(255),
                IN p_user_name VARCHAR(255)
            )
            BEGIN
                DECLARE v_existing_count INT DEFAULT 0;

                -- Cek apakah log sudah ada untuk transaksi ini
                SELECT COUNT(*) INTO v_existing_count
                FROM log_pembatalan
                WHERE transaksi_id = p_transaksi_id;

                -- Jika belum ada log, buat baru
                IF v_existing_count = 0 THEN
                    INSERT INTO log_pembatalan (
                        transaksi_id,
                        alasan,
                        dibatalkan_oleh,
                        deleted_at,
                        created_at,
                        updated_at
                    ) VALUES (
                        p_transaksi_id,
                        p_alasan,
                        p_user_name,
                        NOW(),
                        NOW(),
                        NOW()
                    );
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus procedure
        DB::unprepared('DROP PROCEDURE IF EXISTS log_pembatalan_procedure');

        // Kembalikan trigger sederhana
        DB::unprepared('
            CREATE TRIGGER log_pembatalan_trigger
            BEFORE UPDATE ON transactions
            FOR EACH ROW
            BEGIN
                IF OLD.status != "dibatalkan" AND NEW.status = "dibatalkan" THEN
                    INSERT INTO log_pembatalan (
                        transaksi_id,
                        alasan,
                        dibatalkan_oleh,
                        deleted_at,
                        created_at,
                        updated_at
                    ) VALUES (
                        NEW.id,
                        "Transaksi dibatalkan",
                        "Sistem",
                        NOW(),
                        NOW(),
                        NOW()
                    );
                END IF;
            END
        ');
    }
};