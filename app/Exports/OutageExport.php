<?php

namespace App\Exports;

use App\Models\OutagesReport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class OutageExport implements FromQuery
{
    use Exportable;
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function query()
    {
        return OutagesReport::query()->where('id', $this->id);
    }





}
