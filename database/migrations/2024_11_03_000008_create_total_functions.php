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
        // Buat function untuk menghitung total harga transaksi details
        DB::unprepared('
            CREATE FUNCTION calculate_transaction_total(p_transaction_id INT)
            RETURNS DECIMAL(10,2)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_total DECIMAL(10,2) DEFAULT 0.00;

                SELECT COALESCE(SUM(subtotal), 0.00) INTO v_total
                FROM transaction_details
                WHERE transaction_id = p_transaction_id;

                RETURN v_total;
            END
        ');

        // Buat function untuk menghitung total pendapatan hari ini
        DB::unprepared('
            CREATE FUNCTION calculate_today_revenue()
            RETURNS DECIMAL(15,2)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_total DECIMAL(15,2) DEFAULT 0.00;

                SELECT COALESCE(SUM(total_harga), 0.00) INTO v_total
                FROM transactions
                WHERE DATE(tanggal) = CURDATE()
                AND status != "dibatalkan";

                RETURN v_total;
            END
        ');

        // Buat function untuk menghitung total pendapatan bulan ini
        DB::unprepared('
            CREATE FUNCTION calculate_month_revenue()
            RETURNS DECIMAL(15,2)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_total DECIMAL(15,2) DEFAULT 0.00;

                SELECT COALESCE(SUM(total_harga), 0.00) INTO v_total
                FROM transactions
                WHERE MONTH(tanggal) = MONTH(CURDATE())
                AND YEAR(tanggal) = YEAR(CURDATE())
                AND status != "dibatalkan";

                RETURN v_total;
            END
        ');

        // Buat function untuk menghitung total pendapatan tahun ini
        DB::unprepared('
            CREATE FUNCTION calculate_year_revenue()
            RETURNS DECIMAL(15,2)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_total DECIMAL(15,2) DEFAULT 0.00;

                SELECT COALESCE(SUM(total_harga), 0.00) INTO v_total
                FROM transactions
                WHERE YEAR(tanggal) = YEAR(CURDATE())
                AND status != "dibatalkan";

                RETURN v_total;
            END
        ');

        // Buat function untuk menghitung total transaksi (all time)
        DB::unprepared('
            CREATE FUNCTION calculate_total_revenue()
            RETURNS DECIMAL(15,2)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_total DECIMAL(15,2) DEFAULT 0.00;

                SELECT COALESCE(SUM(total_harga), 0.00) INTO v_total
                FROM transactions
                WHERE status != "dibatalkan";

                RETURN v_total;
            END
        ');

        // Buat function untuk menghitung jumlah transaksi hari ini
        DB::unprepared('
            CREATE FUNCTION count_today_transactions()
            RETURNS INT
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_count INT DEFAULT 0;

                SELECT COUNT(*) INTO v_count
                FROM transactions
                WHERE DATE(tanggal) = CURDATE()
                AND status != "dibatalkan";

                RETURN v_count;
            END
        ');

        // Buat function untuk menghitung jumlah transaksi bulan ini
        DB::unprepared('
            CREATE FUNCTION count_month_transactions()
            RETURNS INT
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_count INT DEFAULT 0;

                SELECT COUNT(*) INTO v_count
                FROM transactions
                WHERE MONTH(tanggal) = MONTH(CURDATE())
                AND YEAR(tanggal) = YEAR(CURDATE())
                AND status != "dibatalkan";

                RETURN v_count;
            END
        ');

        // Buat function untuk menghitung jumlah transaksi tahun ini
        DB::unprepared('
            CREATE FUNCTION count_year_transactions()
            RETURNS INT
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_count INT DEFAULT 0;

                SELECT COUNT(*) INTO v_count
                FROM transactions
                WHERE YEAR(tanggal) = YEAR(CURDATE())
                AND status != "dibatalkan";

                RETURN v_count;
            END
        ');

        // Buat function untuk menghitung total transaksi (all time)
        DB::unprepared('
            CREATE FUNCTION count_total_transactions()
            RETURNS INT
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_count INT DEFAULT 0;

                SELECT COUNT(*) INTO v_count
                FROM transactions
                WHERE status != "dibatalkan";

                RETURN v_count;
            END
        ');

        // Buat function untuk menghitung total transaksi per user
        DB::unprepared('
            CREATE FUNCTION count_user_transactions(p_user_id INT)
            RETURNS INT
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_count INT DEFAULT 0;

                SELECT COUNT(*) INTO v_count
                FROM transactions
                WHERE user_id = p_user_id
                AND status != "dibatalkan";

                RETURN v_count;
            END
        ');

        // Buat function untuk menghitung total pendapatan per user
        DB::unprepared('
            CREATE FUNCTION calculate_user_revenue(p_user_id INT)
            RETURNS DECIMAL(15,2)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_total DECIMAL(15,2) DEFAULT 0.00;

                SELECT COALESCE(SUM(total_harga), 0.00) INTO v_total
                FROM transactions
                WHERE user_id = p_user_id
                AND status != "dibatalkan";

                RETURN v_total;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus semua function yang dibuat
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_transaction_total');
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_today_revenue');
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_month_revenue');
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_year_revenue');
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_total_revenue');
        DB::unprepared('DROP FUNCTION IF EXISTS count_today_transactions');
        DB::unprepared('DROP FUNCTION IF EXISTS count_month_transactions');
        DB::unprepared('DROP FUNCTION IF EXISTS count_year_transactions');
        DB::unprepared('DROP FUNCTION IF EXISTS count_total_transactions');
        DB::unprepared('DROP FUNCTION IF EXISTS count_user_transactions');
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_user_revenue');
    }
};