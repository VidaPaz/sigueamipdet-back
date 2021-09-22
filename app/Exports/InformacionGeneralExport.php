<?php

namespace App\Exports;

use App\Models\Incident;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InformacionGeneralExport implements FromCollection, Responsable, WithHeadings,WithMapping,ShouldQueue,ShouldAutoSize
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

        return Incident::whereBetween('creationdate', [$from, $to])->where('ticketid','like','INC%')->get();
    }

    public function map($row): array
    {
        return [
            $row->inccompany, //Compañia
            $row->ticketid, // Incidente
            $row->creado_por['displayname'],
            $row->description, // Descripcion
            $row->incservice, // Tipo
            $row->ruta_clasificacion['description'],
            $row->status, //Estado
            impacto($row->impact), //Impacto
            urgencia($row->urgency), //Urgencia
            urgencia($row->internalpriority), //Prioridad
            $row->creationdate, //Fecha Creacion
            $row->changedate, //Ultima modificacion
            $row->actualfinish, //Fecha Cierre
            $row->regional, //Regional
            $row->assignedownergroup, // Grupo Responsable
            ($row->incexcluir)?'Si':'No', //Exclusion
            $row->incmexclusion, //Motivo Exclusion
        ];
    }

    public function headings(): array
    {
        return [
            'Compañia',
            'Incidente',
            'Creado Por',
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
            ];
    }
}
