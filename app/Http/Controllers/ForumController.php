<?php

namespace App\Http\Controllers;

use DateTime;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Auth as FirebaseAuth;

class ForumController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth) {
        $this->auth = $auth;
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = $this->getThreads();
        $threadsRecentes = $threads;
        $threadsPopulares = $this->getPopulares($threads);
        return view ('forum.forum', compact('threadsRecentes', 'threadsPopulares'));
    }


    public function publicar(Request $request)
    {
        $request->validate([
            'description' => 'nullable',
            'title' => 'required',
        ]);

        $description = $request->input('description');
        $data = date("Y-m-d H:m:s");
        $user = $this->getCurrentUser();


        //FIREBASE
        $database = app('firebase.database');

        if($description == null || $description == ""){
            $postData = [
                'created_time' => $data,
                'description' =>  '',
                'user_id' => $user->data()['id'],
                'user_name' => $user->data()['nome'],
                'title' => $request->input('title'),
                'qtdComentarios' => 0,
                'profissional' => $user->data()['tipo']
            ];
        } else{
            $postData = [
                'created_time' => $data,
                'description' =>  $description,
                'user_id' => $user->data()['id'],
                'user_name' => $user->data()['nome'],
                'title' => $request->input('title'),
                'qtdComentarios' => 0,
                'profissional' => $user->data()['tipo']
            ];
        }
        $postRef = $database->getReference('message_threads')->push($postData);

        return redirect()->back()->with('sucess', 'A publicação foi criada com sucesso.');
    }

    public function personal ()
    {
        $personalThreads = $this->getPersonalThreads();

        return view('forum.personal', compact('personalThreads'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete ($id){
        $database = app('firebase.database');
        $database->getReference('message_threads/'.$id)->remove();

        return redirect()->back()->with('sucess', 'A publicação foi removida com sucesso.');
    }

    public function thread ($id) {
        $user = $this->getCurrentUser();
        $uid = $user->data()['id'];

        $database = app('firebase.database');
        $thread = $database->getReference('message_threads/'.$id)->getSnapshot();


        try {
            $comentarios = $thread->getValue()['messages'];
        } catch (ErrorException $e) {
            //Não há users encontrados
            $comentarios = array();
        }

        return view('forum.thread', compact('thread', 'comentarios', 'uid'));
    }

    public function comentar (Request $request, $id) {
        $request->validate([
            'comentario' => 'required',
        ]);

        $data = date("Y-m-d H:m:s");
        $user = $this->getCurrentUser();


        //FIREBASE
        $database = app('firebase.database');
        $thread = $database->getReference('message_threads/'.$id)->getSnapshot();
        $qtdComentarios = $thread->getValue()['qtdComentarios'];
        $qtdComentariosNovos = $qtdComentarios + 1;

        // Novo comentário
        $postData = [
                'created_time' => $data,
                'message' =>  $request->input('comentario'),
                'user_id' => $user->data()['id'],
                'user_name' => $user->data()['nome'],
                'title' => $request->input('title'),
                'profissional' => $user->data()['tipo']
            ];

        $key = $database->getReference('message_threads')->push()->getKey();
        $postRef = $database->getReference('message_threads/'.$id.'/'.'messages/')->update(array($key => $postData));

        //Update qtdComentarios
        $postRefThread = $database->getReference('message_threads/'.$id)->update(array('qtdComentarios' => $qtdComentariosNovos));

        return redirect()->back()->with('sucess', 'Comentário adicionado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function apagarComentario ($idThread, $idComentario){
        $database = app('firebase.database');
        $database->getReference('message_threads/'.$idThread.'/messages'.'/'.$idComentario)->remove();

        //Alterar qtdComentarios
        $thread = $database->getReference('message_threads/'.$idThread)->getSnapshot();
        $qtdComentarios = $thread->getValue()['qtdComentarios'];
        $qtdComentariosNovos = $qtdComentarios -1;

        $postRefThread = $database->getReference('message_threads/'.$idThread)->update(array('qtdComentarios' => $qtdComentariosNovos));

        return redirect()->back()->with('sucess', 'Comentário apagado com sucesso.');
    }



    protected function getThreads(){
        $database = app('firebase.database');
        $keys = $database->getReference('message_threads')->getChildKeys();
        $threads = array();

        foreach($keys as $key){
            $snapshot = $database->getReference('message_threads/'.$key)->getSnapshot();
            array_push($threads, $snapshot);
        }

        usort($threads, function($first, $second){
            return $first->getValue()['created_time'] < $second->getValue()['created_time'];
        });

        //dd($threads);
        return $threads;
    }

    protected function getPersonalThreads(){
        $user = $this->getCurrentUser();
        $uid = $user->data()['id'];

        $database = app('firebase.database');
        $keys = $database->getReference('message_threads')->getChildKeys();
        $threads = array();

        foreach($keys as $key){
            $snapshot = $database->getReference('message_threads/'.$key)->getSnapshot();
            if($snapshot->getValue()['user_id'] == $uid){
                array_push($threads, $snapshot);
            }
        }

        usort($threads, function($first, $second){
            return $first->getValue()['created_time'] < $second->getValue()['created_time'];
        });

        //dd($threads);
        return $threads;
    }

    protected function getPopulares($threads){
        $populares = $threads;

        usort($populares, function($first, $second){
            return $first->getValue()['qtdComentarios'] < $second->getValue()['qtdComentarios'];
        });

        return $populares;
    }

    static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'ano',
            'm' => 'mês',
            'w' => 'semana',
            'd' => 'dia',
            'h' => 'hora',
            'i' => 'minuto',
            's' => 'segundo',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                if($k == 'm' || $k == 'mês'){
                    if($diff->$k > 1){
                        $v = $diff->$k . ' ' . 'mes' . ($diff->$k > 1 ? 'es' : '');
                    } else{
                        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                    }
                }else{
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                }
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' atrás' : 'agora mesmo';
    }













    protected function getCurrentUser(){

        $db = app('firebase.firestore')->database();

        $session = Session::get('admin_session')->toArray();
        $email = $session['email'];

        $user = $this->auth->getUserByEmail($email);
        $terapeuta = null;

        $query = $db->collection('terapeutas')->where('email', '=', $user->email);
        $documents = $query->documents();
        foreach ($documents as $document) {
            if ($document->exists()) {
                $terapeuta = $document;
            }
        }

        return $terapeuta;
    }
}
