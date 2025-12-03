<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('worker_id')->constrained()->onDelete('cascade');
            $table->date('order_date');
            $table->string('time_slot'); // 08.00-10.00
            $table->decimal('distance_km', 8, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', [
                'pending', 
                'accepted', 
                'on_the_way', 
                'in_progress', 
                'completed', 
                'cancelled'
            ])->default('pending');
            $table->string('photo_before')->nullable();
            $table->string('photo_after')->nullable();
            $table->decimal('user_rating', 3, 2)->nullable();
            $table->text('user_review')->nullable();
            $table->timestamp('worker_arrived_at')->nullable();
            $table->timestamp('work_started_at')->nullable();
            $table->timestamp('work_completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};