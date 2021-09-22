<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    $userId = $request->user()->id;
    $user = User::where('id',$userId)->with('municipio')->first();
    return $user;
});
Route::post('/reset-password', 'Auth\ForgotPasswordController@sendResetLinkEmail');

Route::get('get-municipios', 'PilaresController@getMunicipios');
Route::get('pilares', 'PilaresController@getPilares');
Route::get('iniciativa', 'PilaresController@getIniciativa');
Route::get('pilar', 'PilaresController@getPilar');
Route::get('rutas', 'PilaresController@getRutas');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('get-comments', 'PilaresController@getComments');
    Route::get('users', 'PilaresController@getUsers');
    Route::get('get-user', 'PilaresController@getUser');
    Route::get('proyectos', 'PilaresController@proyectos');
    Route::get('proyecto', 'PilaresController@proyecto');
    Route::post('crear_proyecto', 'PilaresController@crearProyecto');
    Route::post('crear_usuario', 'PilaresController@crearUsuario');
    Route::post('actualizar_usuario', 'PilaresController@updateUsuario');
    Route::post('uplaod-documentos', 'PilaresController@uploadFiles');
    Route::post('set-comment', 'PilaresController@setComment');
    Route::post('add-favorite', 'PilaresController@addFavorite');
    Route::post('is-favorite', 'PilaresController@isFavorito');
    Route::get('get-favoritos', 'PilaresController@getProyectosFavoritos');
    Route::post('add-avance', 'PilaresController@addAvance');
    Route::post('device-update', 'PilaresController@updateDeviceUser');
    Route::post('change-password', 'PilaresController@changePassword');
    Route::get('get-ussuarios-chat', 'PilaresController@getUsersChat');
    Route::get('chat-usuario', 'PilaresController@chat');
    Route::post('send-msg-chat', 'PilaresController@sendMsgChat');
    Route::get('proyectos-municipios', 'PilaresController@proyectoMunicipio');
    Route::post('set-photo', 'PilaresController@setPhoto');
    Route::post('remove-photo', 'PilaresController@removePhoto');
    Route::get('get-log', 'PilaresController@getLog');
    Route::get('/users-chat-admin','PilaresController@getChatUserAdmin');
});
Route::get('download-documentos', 'PilaresController@download')->name('download');