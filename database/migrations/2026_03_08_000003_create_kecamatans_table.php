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
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. 'sungailiat', 'belinyu'
            $table->string('name');
            $table->string('capital');
            $table->double('area_km2')->default(0);
            $table->double('density')->default(0);
            $table->integer('order')->default(0);

            // Nilai dasar / agregat default kecamatan
            $table->double('population')->default(0);
            $table->double('pdrb_kapita')->default(0);
            $table->double('angkatan_kerja')->default(0);
            $table->double('puskesmas_faskes')->default(0);
            $table->double('sekolah_total')->default(0);
            $table->double('lahan_tani')->default(0);
            $table->double('penerima_bansos')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};
