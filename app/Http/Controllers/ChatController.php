<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use ErrorException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Exception\OutOfRangeException;

class ChatController extends Controller
{

    protected $auth;

    public function __construct(FirebaseAuth $auth) {
        $this->auth = $auth;
     }

     public function index()
     {
         $contacts = $this->getContactos();
         $user = $this->getCurrentUser();
	 $customToken = $this->auth->createCustomToken($user['id'])->toString();

         return view('chat.chat', compact('contacts','user','customToken'));
     }

     public function changeContact($idTest)
     {
         $contacts = $this->getContactos();
         $user = $this->getCurrentUser();
         $sender = $this->getChatUser($idTest);
	 $customToken = $this->auth->createCustomToken($user['id'])->toString();

         return view('chat.chat', compact('contacts','user','sender','customToken'));
     }


     protected function download($messageID){

        $filename = 'teste.pdf';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy('https://firebasestorage.googleapis.com/v0/b/projeto-614bd.appspot.com/o/Document%20Files%2F-MeojZtD0epqN0onupCu.pdf?alt=media&token=ac4cbd74-58ea-4de2-af6d-7894a923013e', $tempImage);

        return response()->download($tempImage, $filename);
     }

     protected function getImage(){

     }
     protected function getContactos(){

        $user = $this->getCurrentUser();
        $id = $user->data()['id'];
        $contacts_array = array();
        $contacts = array();


        $database = app('firebase.database');

        try {
            $contacts_keys = $database->getReference('Contacts/'.$id)->getChildKeys();

            foreach($contacts_keys as $key){


                $snapshot = $this->getChatUser($key);
                array_push($contacts_array, $snapshot);
            }

            foreach($contacts_array as $contact){
                try{
                    $contactImage = $this->getPerfilPic($contact['image']);
                    $contactoAtualizado = [
                        'name' => $contact['name'],
                        'uid' => $contact['uid'],
                        'imageName' => $contactImage,
                    ];
                    array_push($contacts, $contactoAtualizado);

                } catch (ErrorException $ex) {
                    $contactoAtualizado = [
                        'name' => $contact['name'],
                        'uid' => $contact['uid'],
                        'imageName' => "pais/default.jpg",
                    ];
                    array_push($contacts, $contactoAtualizado);
                }
            }

        } catch (OutOfRangeException $e) {

        }

        return $contacts;
     }

     public function getPerfilPic($imageRef)
     {
         if(!empty($imageRef)){

             $array = explode('/', $imageRef);
             if($array[0] == "profilePictures") {
                $path_to_file='img/pais/'.$array[1];
                if (!is_file($path_to_file)) { //Apenas vai buscar a imagem se ainda não existir uma localmente para melhorar performance
                    $storage = app('firebase.storage');
                    $bucket = $storage->getBucket();
                    $image = $bucket->object($imageRef);
                    //$image->downloadToFile('/img/perfil/'.$id.'.png');

                    $bk = $image->downloadToFile($path_to_file);
                }
                return "pais/".$array[1];
             }
             $path_to_file='img/terapeuta/'.$array[1];
             if (!is_file($path_to_file)) { //Apenas vai buscar a imagem se ainda não existir uma localmente para melhorar performance
                 $storage = app('firebase.storage');
                 $bucket = $storage->getBucket();
                 $image = $bucket->object($imageRef);
                 //$image->downloadToFile('/img/perfil/'.$id.'.png');

                 $bk = $image->downloadToFile($path_to_file);
             }
             return "terapeuta/".$array[1];
         }
         return "terapeuta/default.png";
     }






     public function getMensageUpdate ($id) {
        $messages = $this->getMensage($id);
        $user = $this->getCurrentUser();
        return view('chat.messages', compact('messages', 'user'));
    }

     public function getMensage ($id) {
        $user = $this->getCurrentUser();
        $uid = $user->data()['id'];



        $database = app('firebase.database');
        try {
            $mensage = $database->getReference('Messages/'.$uid.'/'.$id)->getValue();
        } catch (ErrorException $e) {
            //Não há users encontrados
            $mensage = array();
        }


        return $mensage;
    }

    protected function getChatUser($id){
        $database = app('firebase.database');

        $query = $database->getReference('Users/'.$id)->getValue();
        if($query == null){
            $query = $database->getReference('Terapeutas/'.$id)->getValue();
        }


        return $query;


    }

    protected function sendMesssage(Request $request,$id){
        $this->validate($request,
        [
            'message' => 'required_without:file-upload',
            'file-upload' => 'mimes:jpg,pdf,png',
        ],
        [
            'message.required_without:file-upload' => 'É necessário enviar um mensagem ou ficheiro',
            'file-upload.mimes:jpg,pdf,png' => 'Apenas são suportados ficheiros do tipo jpg, png e pdf.'
        ]);


        $database = app('firebase.database');

        $senderRef = $database->getReference('Users/'.$id)->getValue();

        $data = date("d/m/Y");

        $time = date("H:m:s");
        $user = $this->getCurrentUser();


        if($request->input('message') != ""){
            //FIREBASE
            $rootRef = $database->getReference('Messages/');

            $messageSenderRef="Messages/".$user->data()['id']."/".$id;
            $messageReceiverRef="Messages/".$id."/".$user->data()['id'];

            $key = $database->getReference('Messages/'.$user->data()['id'].'/'.$id)->push()->getKey();


            // Nova mensagem de texto
            $postData = [
                    'date' => $data,
                    'message' =>  $request->input('message'),
                    'from' => $user->data()['id'],
                    'messageID' => $key,
                    'time' => $time,
                    'to' => $id,
                    'type'=>"text"
                ];

                $postTree = [
                    $messageSenderRef.'/'.$key => $postData,
                    $messageReceiverRef.'/'.$key  =>  $postData,
                ];

            $query = $database->getReference('')->update($postTree);

            return back();


        } else {
            $rootRef = $database->getReference('Messages/');

            $messageSenderRef="Messages/".$user->data()['id']."/".$id;
            $messageReceiverRef="Messages/".$id."/".$user->data()['id'];

            $key = $database->getReference('Messages/'.$user->data()['id'].'/'.$id)->push()->getKey();

            $storage = app('firebase.storage');
            $defaultBucket = $storage->getBucket();

            $fotoPath = $request->file('file-upload');

            if($fotoPath->getMimeType() == "application/pdf"){
                $documentName = $key . "." . $fotoPath->getClientOriginalExtension();
                $imageRef = "Document Files/".$documentName;

                $pathName = $fotoPath->getPathName();
                $file = fopen($pathName, 'r');
                $object = $defaultBucket->upload($file, [
                    'name' => $imageRef,
                    'predefinedAcl' => 'publicRead'
                ]);

                $expiresAt = new DateTime('tomorrow');
                $expiresAt->modify('+1 month');
                $something = $defaultBucket->object($imageRef);
                $something = $defaultBucket->object($imageRef)->signedUrl($expiresAt);

                $postData = [
                    'date' => $data,
                    'message' =>  $something,
                    'from' => $user->data()['id'],
                    'messageID' => $key,
                    'time' => $time,
                    'to' => $id,
                    'type'=>"pdf"
                ];

                $postTree = [
                    $messageSenderRef.'/'.$key => $postData,
                    $messageReceiverRef.'/'.$key  =>  $postData,
                ];

                $query = $database->getReference('')->update($postTree);

                return back();

            }
            elseif($fotoPath->getMimeType() == "image/jpeg" || $fotoPath->getMimeType() == "image/png"){

                $imageName = $key . "." . $fotoPath->getClientOriginalExtension();
                $imageRef = "Image Files/".$imageName;


                $pathName = $fotoPath->getPathName();
                $file = fopen($pathName, 'r');
                $object = $defaultBucket->upload($file, [
                    'name' => $imageRef,
                    'predefinedAcl' => 'publicRead'
                ]);

                $expiresAt = new DateTime('tomorrow');
                $expiresAt->modify('+1 month');
                $something = $defaultBucket->object($imageRef);
                $something = $defaultBucket->object($imageRef)->signedUrl($expiresAt);

                $postData = [
                    'date' => $data,
                    'message' =>  $something,
                    'from' => $user->data()['id'],
                    'messageID' => $key,
                    'time' => $time,
                    'to' => $id,
                    'type'=>"image"
                ];

                $postTree = [
                    $messageSenderRef.'/'.$key => $postData,
                    $messageReceiverRef.'/'.$key  =>  $postData,
                ];

                $query = $database->getReference('')->update($postTree);

                return back();
            }
        }


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
                break;
            }
        }

        return $terapeuta;
    }

     public function pedidos_amizade(){
        $user = $this->getCurrentUser();
        $uid = $user->data()['id'];

        $database = app('firebase.database');
        $pedidosDB = $database->getReference('Chat Requests/'.$uid)->getValue();

        $pedidos = array();
        if (!empty($pedidosDB)){
            foreach ($pedidosDB as $key=>$pedido){
                $outroUser = $this->searchUser($key);
                if ($outroUser[0]){
                    $dados = [
                        'tipo' => $pedido['request_type'],
                        'key' => $key,
                        'remetente' => $outroUser[1],
                        'tipoUser' => "Terapeuta"
                    ];
                } else {
                    $dados = [
                        'tipo' => $pedido['request_type'],
                        'key' => $key,
                        'remetente' => $outroUser[1],
                        'tipoUser' => "Pai/Cuidador"
                    ];
                }

                array_push($pedidos, $dados);
            }
        }

        return view ('chat.requests', compact('pedidos'));

    }

    public function acceptRequest($key){
        $user = $this->getCurrentUser();
        $uid = $user->data()['id'];

        $database = app('firebase.database');
        $database->getReference('Chat Requests/'.$uid.'/'.$key)->remove();
        $database->getReference('Chat Requests/'.$key.'/'.$uid)->remove();

        $postRef = $database->getReference('Contacts/'.$uid.'/'.$key)->update(array('Contacts' => "Saved"));
        $postRef = $database->getReference('Contacts/'.$key.'/'.$uid)->update(array('Contacts' => "Saved"));
        return back();

    }

    public function rejectRequest($key){
        $user = $this->getCurrentUser();
        $uid = $user->data()['id'];

        $database = app('firebase.database');
        $database->getReference('Chat Requests/'.$uid.'/'.$key)->remove();
        $database->getReference('Chat Requests/'.$key.'/'.$uid)->remove();
        return back();
    }

    public function searchUser($key){

        $database = app('firebase.database');
        $outroUser = $database->getReference('Users/'.$key)->getValue();
        if($outroUser == null || empty($outroUser)){
            $outroUser = $database->getReference('Terapeutas/'.$key)->getValue();
            return [true, $outroUser];
        }
        return [false, $outroUser];
    }




    public function encontrarAmigos(){
        $user = $this->getCurrentUser();
        $uid = $user->data()['id'];

        $database = app('firebase.database');
        $utilizadoresDaWeb = $database->getReference('Terapeutas/')->getValue();
        $utilizadoresDaApp = $database->getReference('Users/')->getValue();

        $pedidos = $database->getReference('Chat Requests/'.$uid)->getValue();
        if(!empty($pedidos)){
            $pedidos = array_keys($pedidos);
        }
        $contactos = $this->getContactos();

        $webUsers = array();
        $appUsers = array();



        if($utilizadoresDaWeb != null) {
            foreach($utilizadoresDaWeb as $webUser){
                $validate = true;
                if ($webUser['uid'] == $uid){
                    $validate = false;
                }

                if($validate && !empty($pedidos)){
                    foreach($pedidos as $pedido){
                        if($webUser['uid'] == $pedido){
                            $validate = false;
                        }
                    }
                }
                if($validate){
                    foreach($contactos as $contacto){
                        if($webUser['uid'] == $contacto['uid']){
                            $validate = false;
                        }
                    }
                }
                if($validate){
                    array_push($webUsers, $webUser);
                }
            }
        }

        if($utilizadoresDaApp != null) {
            foreach($utilizadoresDaApp as $appUser){
                $validate = true;
                if ($appUser['uid'] == $uid){
                    $validate = false;
                }

                if($validate && !empty($pedidos)){
                    foreach($pedidos as $pedido){
                        if($appUser['uid'] == $pedido){
                            $validate = false;
                        }
                    }
                }
                if($validate){
                    foreach($contactos as $contacto){
                        if($appUser['uid'] == $contacto['uid']){
                            $validate = false;
                        }
                    }
                }
                if($validate){
                    array_push($appUsers, $appUser);
                }
            }
        }

        return view ('chat.request', compact('user', 'webUsers', 'appUsers'));

    }

    public function convidarAmigo($key){
        $user = $this->getCurrentUser();
        $uid = $user->data()['id'];

        $database = app('firebase.database');
        $database->getReference('Chat Requests/'.$uid.'/'.$key)->update(array('request_type' => "sent"));
        $database->getReference('Chat Requests/'.$key.'/'.$uid)->update(array('request_type' => "received"));

        return redirect()->back();

    }
}
