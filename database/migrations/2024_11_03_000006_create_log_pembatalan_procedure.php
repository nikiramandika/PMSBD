<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE PROCEDURE log_pembatalan_procedure(
                IN p_transaksi_id INT,
                IN p_alasan VARCHAR(255),
                IN p_user_name VARCHAR(255)
            )
            BEGIN
                DECLARE v_existing_count INT DEFAULT 0;

                -- Cek apakah log pembatalan sudah ada untuk transaksi ini
                SELECT COUNT(*) INTO v_existing_count
                FROM log_pembatalan
                WHERE transaksi_id = p_transaksi_id;

                -- Insert log baru hanya jika belum ada
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
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS log_pembatalan_procedure");
    }
};
