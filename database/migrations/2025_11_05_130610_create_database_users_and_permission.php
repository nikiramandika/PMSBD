<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Grant permissions untuk user kasir
        // Kasir hanya bisa akses tabel yang diperlukan untuk transaksi
        DB::statement("GRANT SELECT, INSERT, UPDATE ON smartSalon.customers TO 'kasir'@'localhost'");
        DB::statement("GRANT SELECT, INSERT, UPDATE, DELETE ON smartSalon.cache TO 'admin'@'localhost'");
        DB::statement("GRANT SELECT, INSERT, UPDATE ON smartSalon.sessions TO 'kasir'@'localhost'");
        DB::statement("GRANT SELECT ON smartSalon.treatments TO 'kasir'@'localhost'");
        DB::statement("GRANT SELECT, INSERT ON smartSalon.transactions TO 'kasir'@'localhost'");
        DB::statement("GRANT SELECT, INSERT ON smartSalon.transaction_details TO 'kasir'@'localhost'");
        DB::statement("GRANT SELECT, INSERT ON smartSalon.log_pembatalan TO 'kasir'@'localhost'");
        DB::statement("GRANT SELECT ON smartSalon.migrations TO 'kasir'@'localhost'");

        // Kasir hanya bisa lihat dan update transaksi miliknya sendiri
        // Kita akan handle ini di aplikasi level, tapi di database kita berikan akses dasar

        // Grant permissions untuk user admin
        // Admin memiliki akses lebih luas untuk manajemen data
        DB::statement("GRANT SELECT, INSERT, UPDATE, DELETE ON smartSalon.customers TO 'admin'@'localhost'");
        DB::statement("GRANT SELECT, INSERT, UPDATE, DELETE ON smartSalon.treatments TO 'admin'@'localhost'");
        DB::statement("GRANT SELECT, INSERT, UPDATE, DELETE ON smartSalon.cache TO 'admin'@'localhost'");
        DB::statement("GRANT SELECT, INSERT, UPDATE ON smartSalon.transactions TO 'admin'@'localhost'");
        DB::statement("GRANT SELECT, INSERT, UPDATE ON smartSalon.transaction_details TO 'admin'@'localhost'");
        DB::statement("GRANT SELECT, INSERT, DELETE ON smartSalon.log_pembatalan TO 'admin'@'localhost'");
        DB::statement("GRANT SELECT, UPDATE ON smartSalon.users TO 'admin'@'localhost'");
        DB::statement("GRANT SELECT ON smartSalon.migrations TO 'admin'@'localhost'");

        // Grant permissions untuk mengeksekusi stored procedures dan functions
        DB::statement("GRANT EXECUTE ON PROCEDURE smartSalon.log_pembatalan_procedure TO 'kasir'@'localhost'");
        DB::statement("GRANT EXECUTE ON PROCEDURE smartSalon.log_pembatalan_procedure TO 'admin'@'localhost'");

        // Grant execute pada semua functions
        $functions = [
            'calculate_today_revenue',
            'calculate_month_revenue',
            'calculate_year_revenue',
            'calculate_total_revenue',
            'count_today_transactions',
            'count_month_transactions',
            'count_year_transactions',
            'count_total_transactions',
            'calculate_user_revenue',
            'count_user_transactions',
            'calculate_transaction_total'
        ];

        foreach ($functions as $function) {
            DB::statement("GRANT EXECUTE ON FUNCTION smartSalon.{$function} TO 'kasir'@'localhost'");
            DB::statement("GRANT EXECUTE ON FUNCTION smartSalon.{$function} TO 'admin'@'localhost'");
        }

        // Reload privileges untuk apply changes
        DB::statement("FLUSH PRIVILEGES");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revoke semua permissions
        DB::statement("REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'kasir'@'localhost'");
        DB::statement("REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'admin'@'localhost'");

        // Drop users
        DB::statement("DROP USER IF EXISTS 'kasir'@'localhost'");
        DB::statement("DROP USER IF EXISTS 'admin'@'localhost'");

        // Reload privileges
        DB::statement("FLUSH PRIVILEGES");
    }
};
