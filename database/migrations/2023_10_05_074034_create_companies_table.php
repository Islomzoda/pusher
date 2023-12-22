<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('service_name')->default('whatsapp');
            $table->string('name');
            $table->string('from_number')->nullable();
            $table->string('status')->default('new');
            $table->json('days_of_week')->nullable();  // Дни недели (пн, вт, чт)
            $table->time('start_time')->nullable();      // Начальное время (08:00)
            $table->time('end_time')->nullable();        // Конечное время (17:00)
            $table->integer('interval_min')->nullable(); // Минимальный интервал (30)
            $table->integer('interval_max')->nullable(); // Максимальный интервал (160)
            $table->string('start_day')->nullable();
            $table->unsignedInteger('completed')->default(0);
            $table->unsignedInteger('clients_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
