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
        Schema::create('indicator_trends', function (Blueprint $table) {
            $table->id();
            $table->string('indicator_id');
            $table->string('wilayah')->default('kabupaten'); // 'kabupaten' atau slug kecamatan (sungailiat, dll)
            $table->integer('year');
            $table->double('value')->default(0);
            $table->timestamps();

            $table->foreign('indicator_id')->references('id')->on('indicators')->onDelete('cascade');
            $table->unique(['indicator_id', 'wilayah', 'year']);
            $table->index(['wilayah', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicator_trends');
    }
};
