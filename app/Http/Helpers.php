<?php



function saveLog($userId, $actividadId, $accion){
    $log = new \App\Models\LogActivity();
    $log->user_id = $userId;
    $log->item_id = $actividadId;
    $log->accion = $accion;
    $log->save();
}

