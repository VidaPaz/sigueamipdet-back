<?php

namespace App\Exports;

use App\Models\Worklog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WorklogExport implements FromCollection,ShouldQueue,Responsable, WithHeadings,WithMapping,WithChunkReading,ShouldAutoSize
{
    use Exportable;
    public function __construct($date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        $fecha = explode('/',$this->date);
        $from = $fecha[0].' 00:00:00';
        $to = $fecha[1].' 23:59:59';

        return Worklog::whereHas('incidente', function($q)use($from,$to){
            $q->whereBetween('creationdate', [$from, $to])->where('ticketid','like','INC%');
        })->get();
    }
    public function chunkSize(): int
{
    return 1000;
}
    public function map($row): array
    {
        return [
            $row->createby,
            $row->recordkey,
            $row->createdate,
            $row->description,
            strip_tags($row->description_longdescription),
            $row->incidente['creationdate'],
            $row->incidente['status'],
            $row->incidente['createdby'],
            $row->incidente['creado_por']['displayname'],
            $row->incidente['description'],
            $row->incidente['actualfinish'],
            $row->incidente['ruta_clasificacion']['description'],
            $row->incidente['incservice'],
            $row->incidente['articulo_cf']['ciname'],
            $row->incidente['incinifalla'],
            urgencia($row->incidente['internalpriority']),
            urgencia($row->incidente['urgency']),
            impacto($row->incidente['impact']),
            $row->incidente['proveedores'],
            $row->incidente['location'],
            $row->incidente['grupo_propietario']['description'],
        ];
    }
    public function headings(): array
    {
        return [
            'CREADO POR',
            'TICKET ID',
            'CREACION NOTA',
            'RESUMEN NOTA',
            'DETALLE NOTA',
            'CREACION INCIDENTE',
            'ESTADO INCIDENTE',
            'INCIDENTE CREADO POR',
            'INCIDENTE CREADO NOMBRE',
            'DESCRIPCION INCIDENTE',
            'FECHA CIERRE INCIDENTE',
            'RUTA CLASIFICACION',
            'TIPO INCIDENTE',
            'ARTICULO DE CONFIGURACION',
            'FECHA AFECTACION',
            'PRIORIDAD',
            'URGENCIA',
            'IMPACTO',
            'PROVEEDORES',
            'UBICACION',
            'GRUPO PROPIETARIO',
        ];
    }
}
