<?php

namespace App\Exports;

use App\Aset;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class AsetExports implements FromCollection
{

    use Exportable;

    public function collection()
    {
        return Aset::all();
    }
}
