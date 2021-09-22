<?php

namespace App\Exports;

use App\Models\TkStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InformeDetalladoExport implements FromCollection, Responsable, WithHeadings,WithMapping,ShouldQueue,ShouldAutoSize
{
    use Exportable;
    public function __construct($date)
    {
        $this->date = $date;
    }
    public function collection()
    {
        $fecha = explode('/',$this->date);
        $from = $fecha[0].'00:00:00';
        $to = $fecha[1].' 23:59:59';

        return TkStatus::whereHas('incidente', function($q)use($from,$to){
            $q->whereBetween('creationdate', [$from, $to])
                ->where('ticketid','like','INC%');
        })->get();
    }

    public function map($row): array
    {
        return [
            $row->ticketid,
            $row->incidente['description'],
            $row->incidente['incservice'],
            $row->incidente['ruta_clasificacion']['description'],
            $row->incidente['creationdate'],
            urgencia($row->incidente['internalpriority']),
            $row->incidente['creado_por']['displayname'],
            $row->status,
            $row->propietario['displayname'],
            $row->ownergroup,
            $row->assignedownergroup,
            $row->changedate,
            $row->modificadopor['displayname'],
            $row->statustracking,
            strip_tags($row->nota['description_longdescription']),
        ];
    }
    public function headings(): array{
        return [
            'INCIDENTE',
            'DESCRIPCION',
            'TIPO',
            'RUTA CLASIFICACION',
            'FECHA CREACION',
            'PRIORIDAD',
            'CREADO POR',
            'ESTADO',
            'PROPIETARIO',
            'GRUPO PROPIETARIO',
            'GRUPO PROPIETARIO ASIGNADO',
            'FECHA',
            'MODIFICADO POR',
            'DURACION ESTADO',
            'NOTA',

            ];
    }
}
