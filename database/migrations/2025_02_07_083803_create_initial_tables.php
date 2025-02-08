<?php

use App\Models\TimeSlot;
use App\Models\Psychologist;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('psychologists', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email')->unique();
        });

        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Psychologist::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->boolean('is_booked')->default(false);
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TimeSlot::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete()->unique();
            $table->string('client_name', 255);
            $table->string('client_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('time_slots');
        Schema::dropIfExists('psychologists');
    }
};
