<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'program_id']);
        });

        if (Schema::hasTable('orders')) {
            DB::table('orders')->where('status', 'completed')->update(['status' => 'approved']);
        }

        if (Schema::hasTable('order_items') && Schema::hasTable('orders')) {
            $rows = DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.status', 'approved')
                ->whereNotNull('order_items.program_id')
                ->whereNotNull('orders.user_id')
                ->select('orders.user_id', 'order_items.program_id', 'orders.id as order_id')
                ->get();

            $now = now();
            foreach ($rows as $row) {
                DB::table('program_user')->insertOrIgnore([
                    'user_id' => $row->user_id,
                    'program_id' => $row->program_id,
                    'order_id' => $row->order_id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('program_user');

        if (Schema::hasTable('orders')) {
            DB::table('orders')->where('status', 'approved')->update(['status' => 'completed']);
        }
    }
};
