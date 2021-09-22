<?php

namespace App\Exports;

use App\Models\ClAlarma;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AlarmasAutomatismoExport implements FromCollection,ShouldQueue,Responsable, WithHeadings,WithMapping,WithChunkReading,ShouldAutoSize
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

        return ClAlarma::whereHas('incidente', function($q)use($from,$to){
            $q->whereBetween('creationdate', [$from, $to])->where('ticketid','like','INC%')->where('CREATEDBY','MXINTADM');
        })->whereNotNull('idglobal')->get();
    }
    public function chunkSize(): int
    {
        return 1000;
    }
    public function map($row): array
    {
        return [
            $row->r_ticketnro,
            $row->incidente['description'],
            $row->incidente['status'],
            urgencia($row->incidente['internalpriority']),
            $row->incidente['proveedores'],
            $row->incidente['creationdate'],
            $row->incidente['actualfinish'],
            $row->incidente['grupo_propietario']['description'],
            $row->incidente['createdby'],
            $row->incidente['creado_por']['displayname'],
            $row->incidente['articulo_cf']['description'],
            $row->incidente['ruta_clasificacion']['description'],
            $row->node,
            $row->idglobal,
            $row->num_alarma,
            $row->nomb_alarma,
            $row->creada,
            $row->cancelada,
            $row->incidente['location'],
            ($row->incidente['incexcluir'])?'Si':'No',
            $row->incidente['incmexclusion'],
            $row->incidente['failurecode'],
        ];
    }
    public function headings(): array
    {
        return [
            'TICKET ID',
            'DESCRIPCION INCIDENTE',
            'ESTADO INCIDENTE',
            'PRIORIDAD',
            'PROVEEDORES',
            'FECHA CREACION INCIDENTE',
            'FECHA CIERRE INCIDENTE',
            'GRUPO PROPIETARIO',
            'CREADO POR ID',
            'CREADO POR NOMBRE',
            'ARTICULO CONFIGURACION',
            'RUTA CLASIFICACION',
            'ELEMENTO DE RED',
            'ID GLOBAL',
            'ID ALARMA',
            'ALARMA',
            'FECHA CREACION ALARMA',
            'FECHA CANCELACION ALARMA',
            'UBICACION',
            'EXCLUSION',
            'INCIDENTE EXCLUSION',
            'INCIDENTE CODIGO FALLA',

        ];
    }
}
