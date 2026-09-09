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
        Schema::create('indicators', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. 'ipm', 'kemiskinan', 'kependudukan'
            $table->string('name');
            $table->string('short_name');
            $table->string('category')->default('headline'); // 'headline' or 'sector'
            $table->string('sector_id')->nullable(); // 'pendidikan', 'perekonomian', etc.
            $table->string('unit')->default('%');
            $table->integer('digits')->default(2);
            $table->boolean('lower_is_better')->default(false);
            $table->integer('order')->default(0);

            // Kolom tabel matriks kecamatan
            $table->string('column_key')->nullable();
            $table->string('column_label')->nullable();
            $table->string('column_unit')->nullable();
            $table->integer('column_digits')->nullable();

            // Metadata SDI (Satu Data Indonesia)
            $table->string('metadata_produsen')->nullable();
            $table->text('metadata_definisi')->nullable();
            $table->string('metadata_satuan')->nullable();
            $table->text('metadata_metodologi')->nullable();
            $table->string('metadata_jadwal_rilis')->nullable();
            $table->string('metadata_sumber_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
