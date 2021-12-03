<?php

namespace App\Http\Controllers;

use App\Mail\NewUser;
use App\Models\ComentarioProyecto;
use App\Models\Documento;
use App\Models\Iniciativa;
use App\Models\LogActivity;
use App\Models\Mensaje;
use App\Models\Municipio;
use App\Models\Pilar;
use App\Models\Proyecto;
use App\Models\ProyectoFavorito;
use App\Models\Ruta;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PilaresController extends Controller
{

    public function getPilares(Request $request){
        $data = Pilar::where('municipio_id',$request->municipio_id)->where('tipo',$request->tipo)->orderBy('descripcion')->get();
        return response()->json($data);
    }

    public function getPilar(Request $request){
        $data = Pilar::where('id',$request->pilar)->with('iniciativas','municipio')->first();
        return response()->json($data);
    }

    public function getRutas(){
        $data = Ruta::get();
        return response()->json($data);
    }

    public function getUsers(){
        $data = User::where('id','>',1)->get();
        return response()->json($data);
    }

    public function getUser(Request $request){
        $data = User::where('id',$request->user_id)->first();
        return response()->json($data);
    }

    public function proyectos(Request $request){
        $data = Iniciativa::where('id',$request->iniciativa_id)->with('pilar.municipio','proyectos')->get();
        return response()->json($data);
    }

    public function getIniciativa(Request $request){
        $data = Iniciativa::where('id',$request->iniciativa_id)->with('pilar.municipio','proyectos')->get();
        return response()->json($data);
    }

    public function proyecto(Request $request){
        $data = Proyecto::where('id',$request->proyecto_id)->with('iniciativa.pilar','documentos')->get();
        return response()->json($data);
    }

    public function crearProyecto(Request $request){
        $proyecto =  Proyecto::where('id',$request->id)->first();
        if(empty($proyecto)){
            $proyecto = new Proyecto();
        }

        $user = $request->user();
        $proyecto->avance = $user->id;
        $proyecto->avance = $request->avance;
        $proyecto->comentario = $request->comentario;
        $proyecto->iniciativa_id = $request->iniciativa_id;
        $proyecto->nombre = $request->nombre;
        $proyecto->institucion = $request->institucion;
        
        $proyecto->tiempo = $request->tiempo;
        $proyecto->valor = $request->valor;
        $proyecto->save();

        return response()->json(['resul'=>'ok']);
    }

    public function crearUsuario(Request $request){

        $user = new User();
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 6);
        $user->municipio_id = $request->municipio_id;
        $user->cedula = $request->cedula;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        //$user->photo = photo();
        $user->rol = $request->rol;
        $user->vereda = $request->vereda;
        $user->username = $request->username;
        $user->password = bcrypt($password);
        $user->save();
        $user['password_txt'] = $password;

        Mail::to($user->email)->send(new NewUser($user));
        return response()->json(['result'=>'ok'],200);
    }

    public function updateUsuario(Request $request){
        $user = User::where('id',$request->id)->first();

        $user->municipio_id = $request->municipio_id;
        $user->cedula = $request->cedula;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->rol = $request->rol;
        $user->vereda = $request->vereda;
        $user->username = $request->username;

        $user->save();

        return response()->json(['result'=>'ok'],200);
    }




    public function uploadFiles(Request $request){
        $user = $request->user();
        $proyectId = $request->proyecto_id;
        $file = $request->file('file');


        $filename = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath ='files/proyecto_'.$proyectId;
        $path = $file->storeAs($destinationPath, $filename);


        $nombre = $file->getClientOriginalName();


        $proyecto = Proyecto::where('id',$request->proyecto_id)->first();

        $proyecto->avance= $request->avance;
        $proyecto->save();

        $documento = new Documento();
        $documento->proyecto_id = $proyectId;
        $documento->user_id = $user->id;
        $documento->nombre = $nombre;
        $documento->archivo = $filename;
        $documento->archivo = $path;
        $documento->save();

        $comentario = new ComentarioProyecto();

        $comentario->user_id = $user->id;
        $comentario->proyecto_id = $request->proyecto_id;
        $comentario->comentario = $request->comment;
        $comentario->save();

        $comentarios = ComentarioProyecto::where('proyecto_id',$request->proyecto_id)->with('user')->orderBy('id','DESC')->get();
        $documentos = Documento::where('proyecto_id',$proyectId)->get();

        saveLog($user->id, $request->proyecto_id,'Cargo archivo y agrego avance al proyecto');
        return response()->json(['documentos'=>$documentos,'comentarios'=>$comentarios]);
    }

    public function download(Request $request){
        $file = Documento::where('id',$request->id)->first();
        if(!empty($file)) {
            return Storage::download($file->archivo, $file->nombre);
        }
    }

    public function setComment(Request $request){
        $user = $request->user()->id;
        $comentario = new ComentarioProyecto();

        $comentario->user_id = $user;
        $comentario->proyecto_id = $request->proyecto_id;
        $comentario->comentario = $request->comment;
        $comentario->save();
        $log = new LogActivity();

        $log->user_id = $user;
        $log->user_id = $request->proyecto_id;
        $log->user_id='Agrego comentario a proyecto';
        $log->user_id='';

        $comentarios = ComentarioProyecto::where('proyecto_id',$request->proyecto_id)->with('user')->orderBy('id','DESC')->get();

        //saveLog($user->id, $request->proyecto_id,'Realizo un comentario al proyecto');
        return response()->json($comentarios);
    }
    public function getComments(Request $request){

        $comentarios = ComentarioProyecto::where('proyecto_id',$request->proyecto_id)->with('user')->orderBy('id','DESC')->get();
        return response()->json($comentarios);
    }
    public function getProyectosFavoritos(Request $request){
        $userId = $request->user()->id;
        $favoritos = ProyectoFavorito::where('user_id',$userId)->with('proyecto')->get();
        return response()->json($favoritos);
    }
    public function isFavorito(Request $request){
        $userId = $request->user()->id;
        $favoritos = ProyectoFavorito::where('user_id',$userId)->where('proyecto_id',$request->proyecto_id)->first();
        if(!empty($favoritos)){
            return response()->json('SI');
        }
        return response()->json('NO');
    }

    public function addAvance(Request $request){
        $user = $request->user()->id;
        $proyecto = Proyecto::where('id',$request->proyecto_id)->first();

        $proyecto->avance= $request->avance;
        $proyecto->save();

        $comentario = new ComentarioProyecto();

        $comentario->user_id = $user;
        $comentario->proyecto_id = $request->proyecto_id;
        $comentario->comentario = $request->comment;
        $comentario->save();

        saveLog($user->id, $proyecto->id,'Realizo un comentario a un proyecto');


        return response()->json(['ok']);
    }

    public function addFavorite(Request $request){
        $user = $request->user()->id;
        if($request->op==1) {

            $comentario = new ProyectoFavorito();
            $comentario->user_id = $user;
            $comentario->proyecto_id = $request->proyecto_id;
            $comentario->save();

            saveLog($user, $request->proyecto_id, 'Agrego un proyecto a favorito');
            return response()->json('OK');

        }else{
            ProyectoFavorito::where('user_id',$user)->here('proyecto_id', $request->proyecto_id)->delete();
            saveLog($user, $request->proyecto_id, 'Elimino un proyecto de favoritos');
            return response()->json('OK');
        }
    }

    public function updateDeviceUser(Request $request){
        $user = $request->user();

        $user->device_token = $request->token;
        $user->save();
        return response()->json($user);
    }

    public function changePassword(Request $request){

        $user = $request->user();

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'error']);

    }

    public function getMunicipios(Request $request){

       $municipios = Municipio::orderBy('created_at','ASC')->get();

        return response()->json($municipios);

    }

    public function getUsersChat(Request $request){
        $user = $request->user();

        if($user->rol=='Dinamizador'){
            $usuarios = User::select('id','name','rol','photo')
                ->where('rol','ART')
                ->withCount(['chats_unread' => function ($q)use($user) {
                    $q->where('origen_id',$user->id);
                }])
                ->get();
        }elseif($user->rol=='ART'){
            $usuarios = User::select('id','name','rol','photo')->where('rol','Dinamizador')->with('chats_unread')->get();
        }elseif($user->rol=='ART'){
            $usuarios = User::select('id','name','rol','photo')->where('rol','Dinamizador')->with('chats_unread')->get();
        }else{
            $usuarios = [];
        }
        $usuarios->map(function ($q) use ($user){
            if($user->rol=='Dinamizador'){
                $q['chat_id'] = $user->id.'TO'.$q->id;
            }elseif($user->rol=='ART'){
                $q['chat_id'] = $q->id.'TO'.$user->id;
            }
        });

        return response()->json($usuarios);

    }

    public function getChatUserAdmin(){
        $chats = Mensaje::select('chat_id')->distinct('chat_id')
            ->get();
        $userChat=collect();
        foreach ($chats as $chat) {

            $users = User::select('id','name')->whereIn('id', explode('TO',$chat->chat_id))->get();
            $users = $users->toArray();
            $userChat->push(array(
                'chatId' => $chat->chat_id,
                'origen' => $users[0]['name'],
                'origen_id' => $users[0]['id'],
                'destino' => $users[1]['name']
            ));

        }
        //dd($userChat->all());

        return response()->json($userChat);

    }
    public function chat(Request $request){
        $user = $request->user();
        $id= $request->user_id;
        $chatId='';
        if($user->rol=='Administrador'){
            $chatId = $request->chat_id;
        }
        elseif($user->rol=='Dinamizador'){
            $chatId = $user->id.'TO'.$id;
        }
        elseif($user->rol=='ART'){
            $chatId = $id.'TO'.$user->id;
        }

        $mensajes = Mensaje::where('chat_id',$chatId)
            ->get();

        return response()->json($mensajes->groupBy('fecha'));
    }
    public function sendMsgChat(Request $request){
        $user = $request->user();
        $destino= $request->user_id;
        if($user->rol=='Dinamizador'){
            $chatId = $user->id.'TO'.$destino;
        }elseif($user->rol=='ART'){
            $chatId = $destino.'TO'.$user->id;
        }

        $mensaje = new Mensaje();

        $mensaje->mensaje = $request->msg;
        $mensaje->destino_id = $destino;
        $mensaje->origen_id = $user->id;
        $mensaje->chat_id = $chatId;
        $mensaje->save();

       send_push_notification($user->name,$request->msg,'/'.$mensaje->destino->device_token,'chat');


        return response()->json($mensaje);
    }

    public function proyectoMunicipio(Request $request){
        $user = $request->user();

        $pilares = Pilar::select('id')->where('municipio_id',$user->municipio_id)->pluck('id')->toArray();

        $proyectos = Proyecto::with(['iniciativa'=>function($q)use($pilares){
            $q->whereIn('pilar_id',$pilares);
        }])->get();

        return response()->json($proyectos);
    }

    public function setPhoto(Request $request){
        $user = $request->user();

        $user->photo = $request->photo;
        $user->save();

        return response()->json($user->photo);
    }

    public function removePhoto(Request $request){
        $user = $request->user();

        $user->photo= photo();
        $user->save();

        return response()->json($user->photo);
    }

    public function getLog(Request $request){

        $logs = LogActivity::with('user')->get();


        return response()->json($logs);
    }

}
