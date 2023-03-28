<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\EstrategiaController;
use App\Http\Controllers\CriancaController;
use App\Http\Controllers\EstatisticasController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\TerapeutaController;
use App\Http\Controllers\ProfissionalSaudeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Middleware\Administrador;
use App\Http\Middleware\IsAuthenticated;

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/', function(){
    return redirect()->route('default');
})->name('/');



// Rotas

    //Reset password
    Route::get('reset',[TerapeutaController::class,'resetIndex'])->name('reset');
    Route::post('reset',[TerapeutaController::class,'resetRequest'])->name('reset.index');
    Route::get('reset/newpassword',[TerapeutaController::class,'changePasswordWConfirmationIndex'])->name('reset.password');
    Route::post('reset/newpassword',[TerapeutaController::class,'changePasswordWConfirmation'])->name('reset.password.change');

    Route::prefix('login')->group(function(){
        Route::view('', 'app.login')->name('login')->middleware([IsAuthenticated::class]);
        Route::post('/auth',[TerapeutaController::class,'login'])->middleware([IsAuthenticated::class]);
        Route::post('/googleauth',[TerapeutaController::class,'googleLogin'])->middleware([IsAuthenticated::class]);
        Route::get('/logout',[TerapeutaController::class,'logout'])->name('logout');
    });

    Route::prefix('register')->group(function(){
        Route::view('', 'app.register')->name('register')->middleware([IsAuthenticated::class]);
        Route::post('/auth',[TerapeutaController::class,'register'])->middleware([IsAuthenticated::class]);
    });

    //meter aqui todas as rotas (verifica login)



    Route::group(['middleware'=>'role'], function(){
        //Route::view('home', 'dashboard.index')->name('default');
        Route::get('home', [EstatisticasController::class, 'index'])->name('default');

        //Estrategias
        Route::get('estrategias', [EstrategiaController::class, 'getAll'])->name('estrategias');
        Route::get('estrategias/adicionar', [EstrategiaController::class, 'adicionarEstrategia'])->name('adicionar_estrategia');
        Route::resource('estrategias_resources', EstrategiaController::class);

        //Criancas
        Route::get('criancas', [CriancaController::class, 'getAll'])->name('criancas');
        Route::get('crianca/{id}/perfil', [CriancaController::class, 'perfil'])->name('crianca.perfil');
        Route::get('crianca/{id}/avaliar', [CriancaController::class, 'avaliar'])->name('crianca.avaliar');
        Route::get('crianca/{id}/recomendar', [CriancaController::class, 'recomendar'])->name('crianca.recomendar');
        Route::get('crianca/{id}/recomendar/atualizar', [CriancaController::class, 'atualizar'])->name('crianca.atualizar');
        Route::get('crianca/{id}/dashboard', [CriancaController::class, 'dashboard'])->name('crianca.dashboard');
        Route::get('crianca/{id}/dashboard/feedback', [CriancaController::class, 'feedback'])->name('crianca.dashboard.feedback');
        Route::get('crianca/{id}/dashboard/relatorio', [CriancaController::class, 'relatorio'])->name('crianca.dashboard.relatorio');
        Route::get('crianca/{id}/dashboard/graficos', [CriancaController::class, 'graficos'])->name('crianca.dashboard.graficos');
        Route::get('crianca/{id}/teste', [CriancaController::class, 'teste'])->name('crianca.teste');
        Route::resource('crianca', CriancaController::class);


        //Gestão do perfil
        Route::get('terapeuta/perfil', [UserManagementController::class, 'perfil'])->name('terapeuta.perfil');
        Route::post('terapeuta/profilepicture', [UserManagementController::class, 'profilePictureUpload'])->name('terapeuta.perfil.foto');
        Route::post('terapeuta/descricao', [UserManagementController::class, 'profileDescriptionChange'])->name('terapeuta.perfil.descricao');
        Route::get('terapeutas/perfil/pic', [UserManagementController::class, 'printProfilePic'])->name('profilepic.print');
            //TODO
            Route::get('change/password',[UserManagementController::class,'changePasswordIndex'])->name('change.password');
            Route::post('change/password',[UserManagementController::class,'changePassword'])->name('change.password.post');

        //Forum
        Route::get('forum', [ForumController::class, 'index'])->name('forum');
        Route::post('forum', [ForumController::class, 'publicar'])->name('forum.publicar');
        Route::get('forum/personal', [ForumController::class, 'personal'])->name('forum.personal');
        Route::get('forum/thread/{id}', [ForumController::class, 'thread'])->name('forum.thread');
        Route::post('forum/thread/{id}', [ForumController::class, 'comentar'])->name('forum.comentar');
        Route::delete('forum/personal/{id}', [ForumController::class, 'delete'])->name('forum.personal.delete');
        Route::delete('forum/thread/{idThread}/{idComentario}', [ForumController::class, 'apagarComentario'])->name('forum.comentario.delete');

        //Chat
        Route::get('chat/download/{messageID}', [ChatController::class,'download'])->name('chat.downloadfile');

        Route::get('chat/encontrar', [ChatController::class, 'encontrarAmigos'])->name('chat.encontrar');
        Route::get('chat/convidar/{key}', [ChatController::class, 'convidarAmigo'])->name('send.request');
        Route::get('chat/pedidos', [ChatController::class, 'pedidos_amizade'])->name('chat.pedidos');
        Route::get('chat/pedidos/aceitar/{key}', [ChatController::class, 'acceptRequest'])->name('accept_request');
        Route::get('chat/pedidos/rejeitar/{key}', [ChatController::class, 'rejectRequest'])->name('deny_request');
        Route::get('chat', [ChatController::class,'index'])->name('chat');
        Route::get('chat/{id}', [ChatController::class, 'changeContact'])->name('chatRecreate');
        Route::post('message/{id}', [ChatController::class, 'sendMesssage'])->name('message');
        Route::get('/message/update/{id}', [ChatController::class, 'getMensageUpdate'])->name('message.update');


    });

    //ROTAS DO ADMINISTRADOR
    Route::middleware([Administrador::class])->group(function () {
        //GestaoTerapeutas
        Route::get('terapeutas', [UserManagementController::class, 'index'])->name('terapeutas');
        Route::get('terapeutas/convidar', [UserManagementController::class, 'convites'])->name('terapeutas.convidar');
        Route::resource('convite', UserManagementController::class);
        Route::delete('terapeutas/convite/{id}', [UserManagementController::class, 'delete'])->name('delete_convite');
        Route::get('terapeutas/{id}', [UserManagementController::class, 'profile'])->name('terapeutas.profile');
        Route::get('terapeutas/{id}/tipo', [UserManagementController::class, 'trocarTipo'])->name('terapeutas.profile.tipo');
        Route::get('terapeutas/{id}/estado', [UserManagementController::class, 'trocarEstado'])->name('terapeutas.profile.estado');
        //Associar criancas a terapeutas
        Route::get('terapeuta/{id}/gestao-criancas', [UserManagementController::class, 'indexAddCriancas'])->name('terapeutas.criancas.gestao');
        Route::post('terapeuta/{id}/adicionar/{idCrianca}', [UserManagementController::class, 'addCriancaToTerapeuta'])->name('terapeutas.criancas.adicionar');
        Route::delete('terapeuta/{id}/remover/{idCrianca}', [UserManagementController::class, 'removeCriancaToTerapeuta'])->name('terapeutas.criancas.remover');

    });




Route::prefix('pages')->group(function () {
    Route::view('sample-page', 'pages.sample-page')->name('sample-page');
    Route::view('support-ticket', 'pages.support-ticket')->name('support-ticket');
    Route::view('search', 'pages.search')->name('search');
    Route::view('error-400', 'pages.error-400')->name('error-400');
    Route::view('error-404', 'pages.error-404')->name('error-404');
    Route::view('error-500', 'pages.error-500')->name('error-500');
    Route::view('maintenance', 'pages.maintenance')->name('maintenance');

    Route::view('signup', 'pages.signup')->name('signup');
    Route::view('forget-password', 'pages.forget-password')->name('forget-password');
    Route::view('comingsoon', 'pages.comingsoon')->name('comingsoon');
    Route::view('comingsoon-bg-video', 'pages.comingsoon-bg-video')->name('comingsoon-bg-video');
    Route::view('comingsoon-bg-img', 'pages.comingsoon-bg-img')->name('comingsoon-bg-img');
});

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');








