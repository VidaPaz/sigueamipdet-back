<?php

namespace App\Exports;

use App\Models\FailureReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CausalesCierreExport implements FromCollection, Responsable, WithHeadings,WithMapping,ShouldQueue,ShouldAutoSize
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

        return FailureReport::whereHas('incidente', function($q)use($from,$to){
            $q->whereBetween('creationdate', [$from, $to])
                ->where('ticketid','like','INC%')
                ->where('status','CERRADO');
        })->get();
    }

    public function map($row): array
    {
        return [
            $row->incidente['inccompany'], //Compañia
            $row->incidente['ticketid'], // Incidente
            $row->incidente['description'], // Descripcion
            $row->incidente['incservice'], // Tipo
            $row->incidente['ruta_clasificacion']['description'],
            $row->incidente['status'], //Estado
            impacto($row->incidente['impact']), //Impacto
            urgencia($row->incidente['urgency']), //Urgencia
            urgencia($row->incidente['internalpriority']), //Prioridad
            $row->incidente['creationdate'], //Fecha Creacion
            $row->incidente['changedate'], //Ultima modificacion
            $row->incidente['actualfinish'], //Fecha Cierre
            $row->incidente['regional'], //Regional
            $row->incidente['assignedownergroup'], // Grupo Responsable
            ($row->incidente['incexcluir'])?'Si':'No', //Exclusion
            $row->incidente['incmexclusion'], //Motivo Exclusion
            $row->incidente['incsolucion'],
            $row->type,
            $row->incidente['failurecode'],
            $row->falla['description'],


        ];
    }

    public function headings(): array
    {
        return [
            'Compañia',
            'Incidente',
            'Descripcion',
            'Tipo',
            'Ruta Clasificacion',
            'Estado',
            'Impacto',
            'Urgencia',
            'Prioridad',
            'Fecha Creacion',
            'Ultima modificacion',
            'Fecha Cierre',
            'Regional',
            'Grupo Responsable',
            'Exclusion',
            'Motivo Exclusion',
            'Solucion',
            'Tipo',
            'Codigo',
            'Descripcion',
        ];
    }
}
