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

class TareaInFoExport implements FromCollection,ShouldQueue,Responsable, WithHeadings,WithMapping,ShouldAutoSize
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
            $q->whereBetween('REPORTDATE', [$from, $to])->where('assignedownergroup','like','%FOPERFOR%');
        })->get();
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
