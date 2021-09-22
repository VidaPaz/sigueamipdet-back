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

class TareaIncidenteNotasExport implements FromCollection,ShouldQueue,Responsable, WithHeadings,WithMapping,ShouldAutoSize
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

        return Worklog::whereHas('tarea', function($q)use($from,$to){
            $q->whereBetween('REPORTDATE', [$from, $to]);
        })
            ->whereIn('createby',array('ECM5328C', 'ECM1834A', 'EHT6616A', 'EHT7557A', 'EHT2516A', 'EHT6183A', 'EHT0444A', 'EHT6335B', 'EHT3528A', 'EHT3738A', 'ECM0131B', 'EHT7568A', 'ECM2787B', 'ECM7949D', 'ECM6382B', 'ECM0939B', 'ECM0147DD', 'EHT6225A', 'ECM0074E', 'ECM6746F', 'MXINTADM', 'EYQ8858A', 'ECM6817A', 'ECM4818E', 'ECM7266B', 'ECM5144B', 'ECM5403C', 'ECM4092B', 'ECM3259D', 'ECM8722B', 'ECM0046A', 'ECM3294B', 'ENS1619A', 'ECM1006D', 'ECM9977B', 'ECM1480A', 'ECM3654A', 'ECM7770E', 'ENA9609A', 'ECM9077B', 'ECM5901C', 'EYQ1621A', 'ECM7835D', 'ECM1258B', 'ENA1282A', 'ICM7261A', 'ECM4082C', 'ECM3921D', 'ECM4229E', 'ECM7045G', 'EHT7841A', 'ECM6500F', 'ENS0586A', 'ECM7414E', 'ECM3478C', 'ECM8048C'))
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->tarea->wonum,
            $row->tarea->reportdate,
            $row->tarea->description,
            $row->tarea->status,
            $row->tarea->propietario->displayname,
            $row->tarea->incidente['ticketid'],
            $row->tarea->incidente['creationdate'],
            $row->tarea->incidente['status'],
            $row->tarea->incidente['description'],
            $row->tarea->incidente['actualfinish'],
            $row->creador->displayname,
            $row->createdate,
            $row->description,

        ];
    }
    public function headings(): array
    {
        return [
            'TAREA',
            'FECHA CREACION DE TAREA',
            'DESCRIPCION TAREA',
            'ESTADO TAREA',
            'PROPIETARIO TAREA',
            'INCIDENTE',
            'FECHA CREACION INCIDENTE',
            'ESTADO INCIDENTE',
            'DESCRIPCION INCIDENTE',
            'FECHA CIERRE INCIDENTE',
            'CREADOR DE NOTA',
            'FECHA NOTA',
            'RESUMEN NOTA',


        ];
    }
}
