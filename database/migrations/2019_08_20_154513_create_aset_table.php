<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('kondisi', ["BAIK", "RUSAK"]);
            $table->enum('jenis', ['TETAP', 'BERGERAK']);
            $table->string('nama_aset', 255);
            $table->string('kode', 255);
            $table->integer('nilai_perolehan');
            $table->text('keterangan');
            $table->timestamp('tgl_terima');
            $table->string('photo_url')->nullable();
            $table->integer('satker_id')->unsigned();
            $table->integer('kategori_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aset');
    }
}
