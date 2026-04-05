<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE programs MODIFY image TEXT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE programs ALTER COLUMN image TYPE TEXT');
        } else {
            Schema::table('programs', function (Blueprint $table) {
                $table->text('image')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE programs MODIFY image VARCHAR(255) NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE programs ALTER COLUMN image TYPE VARCHAR(255)');
        } else {
            Schema::table('programs', function (Blueprint $table) {
                $table->string('image', 255)->nullable()->change();
            });
        }
    }
};
