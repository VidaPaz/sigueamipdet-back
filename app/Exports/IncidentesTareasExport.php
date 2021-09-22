<?php

namespace App\Exports;

use App\Models\WoActivity;
use App\Models\Worklog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncidentesTareasExport implements FromCollection,ShouldQueue,Responsable, WithHeadings,WithMapping,WithChunkReading,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
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

        return WoActivity::whereHas('incidente', function($q)use($from,$to){
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
            $row->wonum,
            $row->description,
            $row->status,
            $row->grupo_propietario['description'],
            $row->incidente['ticketid'],
            $row->incidente['creationdate'],
            $row->incidente['status'],
            $row->incidente['createdby'],
            $row->incidente['description'],
            $row->incidente['actualfinish'],
            $row->articulo_configuracion['ciname'],
            $row->articulo_configuracion,
            $row->cinum,
        ];
    }
    public function headings(): array
    {
        return [
            'TAREA',
            'RESUMEN',
            'ESTADO',
            'PROPIETARIO',
            'INCIDENTE',
            'FECHA CREACION INCIDENTE',
            'ESTADO INCIDENTE',
            'CREADO POR ID',
            'DESCRIPCION INCIDENTE',
            'FECHA CEIRRE',
            'ARTICULO DE CONFIGURACION',
            'ARTICULO DE CONFIGURACION COD' ,

        ];
    }
}
