<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Transmittal;


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
            $table->integer('copies');
            $table->integer('pages_per_copy');
            $table->string('control_number');
            $table->string('particulars');
            $table->string('payee');
            $table->double('amount', 15, 2);
            $table->string('attachment');
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
