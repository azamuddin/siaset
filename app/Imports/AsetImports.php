<?php

namespace App\Imports;

use App\Aset;
use App\Kategori;
use App\Satker;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;


class AsetImports implements OnEachRow, WithHeadingRow
{

    public function onRow(Row $row)
    {

        $row = $row->toArray();

        $satker = Satker::where("nama_satker", $row["satker"])->first();

        if (!$satker) {
            // jika belum ada satker dengan nama sesuai nilai $row["satker"] buat satker baru
            $satker = new Satker;
            $satker->nama_satker = $row["satker"];
            $satker->save();
        }

        $kategori = Kategori::where("nama_kategori", $row["kategori"])->first();

        if (!$kategori) {
            $kategori = new Kategori;
            $kategori->nama_kategori = $row["kategori"];
            $kategori->save();
        }

        // asumsi column pertama di file excel adalah kode aset
        $aset = new Aset;
        $aset->kode = $row["kode"];
        $aset->nama_aset = $row["nama"];
        $aset->nilai_perolehan = $row["nilai"];
        $aset->jenis = $row["jenis"];
        $aset->kondisi = $row["kondisi"];
        $aset->satker_id = $satker->id;
        $aset->kategori_id = $kategori->id;
        $aset->tgl_terima = Carbon::create($row["tgl_terima"]);
        $aset->keterangan = $row["keterangan"];
        $aset->save();
    }
}
