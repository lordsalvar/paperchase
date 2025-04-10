<?php

use App\Models\Transmittal;
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
        Schema::create('contents', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Transmittal::class)->constrained()->cascadeOnDelete();
            $table->integer('copies')->nullable();
            $table->integer('pages_per_copy')->nullable();
            $table->string('control_number')->nullable();
            $table->string('particulars')->nullable();
            $table->string('payee')->nullable();
            $table->double('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
