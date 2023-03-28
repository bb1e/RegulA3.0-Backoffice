<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invite;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use App\Notifications\Convite;
use Google\Cloud\Core\Exception\NotFoundException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use App\Helpers\Helper;
use App\Helpers\UserRole;


class UserManagementController extends Controller
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
        $terapeutas = app('firebase.firestore')->database()->collection('terapeutas')->documents();
        return view('terapeutas.terapeutas', compact('terapeutas'));
    }

    public function convites(){

        $convites = app('firebase.firestore')->database()->collection('convites')->documents();
        $erros = array();
        return view ('terapeutas.convidar',compact('erros', 'convites'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'tipo' => 'required',
        ]);

        //Verifica se há algum user já registado com esse email
        try {
            $user = $this->auth->getUserByEmail($request->input('email'));

            if($user != null){
                return redirect()->back()->withErrors('Já existe um utilizador com esse email');
            }
        } catch (UserNotFound $e) {}

        //Não há users encontrados

        //Verifica se há convites para esse email criados
        $convites = app('firebase.firestore')->database()->collection('convites')->documents();
        foreach($convites as $convite){
            if($convite->data()['email'] == $request->input('email')){
                return redirect()->back()->withErrors("Esse email já recebeu um convite.");
            }
        }

        //Não existe convite.
        //Criar convite se não houve erros
        $data = date("Y/m/d");
        $convite = new Invite();
        $convite->codigo = bin2hex(random_bytes(6));
        $convite->email = $request->input('email');
        $convite->tipo = $request->input('tipo');
        $convite->data = $data;
        //print_r($convite);

        //Enviar email
        $convite->notify(new Convite($convite));

        $dados = [
            'codigo' => $convite->codigo,
            'email' => $convite->email,
            'tipo' => $convite->tipo,
            'data' => $convite->data,
        ];
        //Guardar convite no firebase para confirmar registo depois
        $conviteDB = app('firebase.firestore')->database()->collection('convites')->Document($convite->codigo);
        $conviteDB->set($dados);

        $convites = app('firebase.firestore')->database()->collection('convites')->documents();

        //Redirecionar para pagina anterior
        return redirect()->back()->with('sucess', 'O convite foi gerado com sucesso');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $ola = app('firebase.firestore')->database()->collection('convites')->document($id)->delete();

        return redirect()->back()->with('sucess', 'O convite foi apagado com sucesso');
    }

    public function profile($id)
    {
        $terapeuta = app('firebase.firestore')->database()->collection('terapeutas')->document($id)->snapshot();
        $criancasDoTerapeuta = $this->getCriancasDoTerapeuta($terapeuta->data()['criancas']);
        $imagem = $this->getPerfilPic($terapeuta->data()['image']);
        $qtdCriancas = count($criancasDoTerapeuta);
        return view ('terapeutas.terapeuta', compact('terapeuta', 'criancasDoTerapeuta', 'qtdCriancas', 'imagem'));
    }

    public function trocarTipo($id)
    {
        $terapeuta = app('firebase.firestore')->database()->collection('terapeutas')->document($id)->snapshot();
        $doc = app('firebase.firestore')->database()->collection('terapeutas')->document($id);

        $user = $this->getCurrentUser()->data();
        if ($user['id'] == $terapeuta->data()['id']){
            return redirect()->back()->withErrors("Não pode alterar o seu cargo.");
        }

        if ($terapeuta->data()['tipo'] == 'T'){
            $doc->update([
                ['path' => 'tipo', 'value' => 'A']
               ]);
               $tipoFinal = "Administrador";

        }elseif($terapeuta->data()['tipo'] == 'A'){
            $doc->update([
                ['path' => 'tipo', 'value' => 'T']
            ]);
            $tipoFinal = "Terapeuta";
        }

        return redirect()->back()->with('sucess', 'A conta de '.$terapeuta->data()['nome']. ' passou a ter o cargo de '.$tipoFinal.'.');
    }

    public function trocarEstado($id){
        $terapeuta = app('firebase.firestore')->database()->collection('terapeutas')->document($id)->snapshot();

        $doc = app('firebase.firestore')->database()->collection('terapeutas')->document($id);

        $user = $this->getCurrentUser()->data();
        if ($user['id'] == $terapeuta->data()['id']){
            return redirect()->back()->withErrors("Não pode bloquear a sua conta");
        }

        if ($terapeuta->data()['bloqueado'] == false){
            $doc->update([
                ['path' => 'bloqueado', 'value' => true]
               ]);
               $estadoFinal = "bloqueada";
        }elseif($terapeuta->data()['bloqueado'] == true){
            $doc->update([
                ['path' => 'bloqueado', 'value' => false]
            ]);
            $estadoFinal = "ativada";
        }

        return redirect()->back()->with('sucess', 'A conta de '.$terapeuta->data()['nome']. ' foi '.$estadoFinal.' com sucesso');
    }



    public function perfil(){
        $terapeuta = $this->getCurrentUser();
        $terapeuta = $terapeuta->data();
        $imagem = $this->getPerfilPic($terapeuta['image']);
        $qtdCriancas = count($terapeuta['criancas']);
        return view ('terapeutas.perfil', compact('terapeuta', 'imagem', 'qtdCriancas'));
    }

    /**
     * Upload e muda a imagem de perfil do utilizador
     */
    public function profilePictureUpload(Request $request){
        $terapeuta = $this->getCurrentUser();
        $uid = $terapeuta->data()['id'];

        try {
            $imageDeleted = app('firebase.storage')->getBucket()->object($terapeuta->data()['image'])->delete();
            //dd($imageDeleted);
        } catch (NotFoundException $e) {

        }

        if($request->hasFile('foto')){
            $fotoPath = $request->file('foto');
            $fotoName = $uid . "." . $fotoPath->getClientOriginalExtension();
            //Image::make($foto)->resize(250,250)->save(public_path('/img/perfil_terapeuta/' . $nome));
            //dd($nome);
            $path = $request->file('foto')->storeAs('terapeutas', $fotoName);
            //dd($path);

            $imageRef = "terapeutaProfPic/".$fotoName;

            $storage = app('firebase.storage');
            $defaultBucket = $storage->getBucket();


            $pathName = $fotoPath->getPathName();
            $file = fopen($pathName, 'r');
            $object = $defaultBucket->upload($file, [
                'name' => $imageRef,
                'predefinedAcl' => 'publicRead'
            ]);
            //$image_url = 'https://storage.googleapis.com/'.env('FIREBASE_PROJECT_ID').'.appspot.com/'.$name;
            //dd($object);

            //ATUALIZAR DADOS NAS BDs
                //FIRESTORE
                $doc = app('firebase.firestore')->database()->collection('terapeutas')->document($uid);

                $doc->update([
                    ['path' => 'image', 'value' => $imageRef]
                ]);

                //FIREBASE
                $database = app('firebase.database');
                $oldValues = $database->getReference('Terapeutas/'.$terapeuta->data()['id'])->getSnapshot();

                //dd($oldValues->getValue()['description']);
                $database->getReference('Terapeutas/'.$terapeuta->data()['id'])
                ->set([
                    'image' => $imageRef,
                    'name' => $oldValues->getValue()['name'],
                    'description' =>  $oldValues->getValue()['description'],
                    'uid' => $oldValues->getValue()['uid'],
                    ]);

                $session = Session::get('admin_session');
                $session['imagem'] = $fotoName;
                Session::put('admin_session', $session);


            //return back();
            return redirect()->route('terapeuta.perfil')->with('sucess', 'Upload realizado com sucesso.');
        }else{
            //Retirar foto do perfil (fica a null e usa a default)
            //ATUALIZAR DADOS NAS BDs
                //FIRESTORE
                $doc = app('firebase.firestore')->database()->collection('terapeutas')->document($uid);

                $doc->update([
                    ['path' => 'image', 'value' => '']
                ]);

                //FIREBASE
                $database = app('firebase.database');
                $oldValues = $database->getReference('Terapeutas/'.$terapeuta->data()['id'])->getSnapshot();

                //dd($oldValues->getValue()['description']);
                $database->getReference('Terapeutas/'.$terapeuta->data()['id'])
                ->set([
                    'image' => '',
                    'name' => $oldValues->getValue()['name'],
                    'description' =>  $oldValues->getValue()['description'],
                    'uid' => $oldValues->getValue()['uid'],
                    ]);

                $session = Session::get('admin_session');
                $session['imagem'] = "default.png";
                Session::put('admin_session', $session);

            return redirect()->route('terapeuta.perfil')->with('sucess', 'Fotografia de perfil removida com sucesso.');
        }

    }



    /**
     * Muda a descrição do User no firestore e no realtime database
     */
    public function profileDescriptionChange(Request $request){
        $request->validate([
            'descricao' => 'nullable',
        ]);

        $terapeuta = $this->getCurrentUser();
        $idTerapeuta = $terapeuta->data()['id'];

        $doc = app('firebase.firestore')->database()->collection('terapeutas')->document($idTerapeuta);
        //Mudar descrição no firestore
        $doc->update([
            ['path' => 'descricao', 'value' => $request->input('descricao')]
        ]);

        //Mudar descrição no firebase
        $database = app('firebase.database');
        $oldValues = $database->getReference('Terapeutas/'.$terapeuta->data()['id'])->getSnapshot();

        //dd($oldValues->getValue()['description']);
        if($request->input('descricao') == null){
            $database->getReference('Terapeutas/'.$terapeuta->data()['id'])
            ->set([
                'image' => $oldValues->getValue()['image'],
                'name' => $oldValues->getValue()['name'],
                'description' => '',
                'uid' => $oldValues->getValue()['uid'],
                ]);
        }else{
            $database->getReference('Terapeutas/'.$terapeuta->data()['id'])
            ->set([
                'image' => $oldValues->getValue()['image'],
                'name' => $oldValues->getValue()['name'],
                'description' => $request->input('descricao'),
                'uid' => $oldValues->getValue()['uid'],
            ]);
        }


        return redirect()->route('terapeuta.perfil')->with('sucess', 'Descrição editada com sucesso com sucesso.');
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

    public function printProfilePic()
    {
        $terapeuta = $this->getCurrentUser();
        $imageName = $terapeuta->data()['image'];
        if($imageName == ''){
            return response()->file(storage_path('app/terapeutas/default.png'));
        }

        $array = explode('/', $imageName);
        //return response()->file(storage_path('app/terapeutas/'. ));
        return response()->file(storage_path('app/terapeutas/'.$array[1]));
    }






    /**
     *
     * Associação de crianças ao terapeuta e vice versa
     *
     */


     public function indexAddCriancas($id)
     {
        $user = $this->getCurrentUser()->data();
        $terapeuta = $this->getTerapeuta($id);
        $criancas = $this->getAllCriancas();
        $criancasDoTerapeuta = [];
        //dd($criancas);

        $idsCriancas = $terapeuta['criancas'];
        if (!empty($idsCriancas)){
            $criancasDoTerapeuta = $this->getCriancasDoTerapeuta($idsCriancas);
        }

        return view('terapeutas.gestao_criancas', compact('criancas', 'criancasDoTerapeuta', 'terapeuta'));
     }

     public function addCriancaToTerapeuta(Request $request, $id, $idCrianca){
        $database = app('firebase.firestore')->database();

        $terapeuta = $this->getTerapeuta($id);
        $crianca = [];

        $documentCrianca = $database->collection('criancas_test')->document($idCrianca);
        $documentTerapeuta = $database->collection('terapeutas')->document($id);

        //Adicionar o id do terapeuta à crianca
        $documentCrianca->update([
            ['path' => 'idTerapeuta', 'value' => $id]
           ]);

        $idsCriancasDoTerapeuta = $terapeuta['criancas'];
        array_push($idsCriancasDoTerapeuta, $idCrianca);
        //dd($idsCriancasDoTerapeuta);

        $documentTerapeuta->update([
            ['path' => 'criancas', 'value' => $idsCriancasDoTerapeuta]
           ]);

        return redirect()->back()->with('sucess', 'A criança '.$documentCrianca->snapshot()->data()['nome']. ' é agora acompanhada por este terapeuta.');

     }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeCriancaToTerapeuta($id, $idCrianca){
        $database = app('firebase.firestore')->database();

        $terapeuta = $this->getTerapeuta($id);
        $crianca = [];

        $documentCrianca = $database->collection('criancas_test')->document($idCrianca);
        $documentTerapeuta = $database->collection('terapeutas')->document($id);

        //Adicionar o id do terapeuta à crianca
        $documentCrianca->update([
            ['path' => 'idTerapeuta', 'value' => '']
           ]);

        $idsCriancasDoTerapeuta = $terapeuta['criancas'];
        if (($key = array_search($idCrianca, $idsCriancasDoTerapeuta)) !== false) {
            unset($idsCriancasDoTerapeuta[$key]);
        }

        $documentTerapeuta->update([
            ['path' => 'criancas', 'value' => $idsCriancasDoTerapeuta]
           ]);

           return redirect()->back()->with('sucess', 'A criança '.$documentCrianca->snapshot()->data()['nome']. ' deixou de ser acompanhada por este terapeuta.');

    }

     protected function getAllCriancas(){
        $database = app('firebase.firestore')->database();

        $documents = $database->collection('criancas_test')->where('idTerapeuta', '=', "")->documents();

        $criancas = array();

        if(!empty($documents)){
            foreach ($documents as $document){
                array_push($criancas, $document->data());
            }
        }

        return $criancas;
     }

     protected function getTerapeuta($id){
         //apenas os utilizadores não bloqueados
        $database = app('firebase.firestore')->database();

        $document = $database->collection('terapeutas')->document($id);

        $terapeuta = [];

        if(!empty($document)){
            $terapeuta = $document->snapshot()->data();
        }

        return $terapeuta;
     }


     protected function getCriancasDoTerapeuta($criancas){
         //apenas os utilizadores não bloqueados
        $database = app('firebase.firestore')->database();

        $criancasDoTerapeuta = [];
        foreach($criancas as $crianca){
            $document = $database->collection('criancas_test')->document($crianca);
            if(!empty($document)){
                $snapshot = $document->snapshot()->data();
                array_push($criancasDoTerapeuta, $snapshot);
            }
        }

        return $criancasDoTerapeuta;
     }



    public function getPerfilPic($imageRef)
    {
        if(!empty($imageRef)){
            $storage = app('firebase.storage');
            $bucket = $storage->getBucket();
            $image = $bucket->object($imageRef);
            //$image->downloadToFile('/img/perfil/'.$id.'.png');
            $array = explode('/', $imageRef);

            $path_to_file='img/terapeuta/'.$array[1];
            $bk = $image->downloadToFile($path_to_file);

            return $array[1];
        }

        return "default.png";
    }




    public function changePasswordIndex()
    {
        return view('terapeutas.change_password');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request,
        [
            'password_old' => 'required',
            'password' => 'required|confirmed|min:8|different:password_old',
        ],
        [
            'password.confirmed' => 'A password nova e a confirmação não são iguais.',
            'password.different' => 'A password nova tem que ser diferente da antiga.',
            'password.required' => 'A password é um campo obrigatório.',
            'password_old.required' => 'A password é um campo obrigatório.',
            'password.min' => 'A password tem que ter no mínimo 8 caracteres.'
        ]);

        $terapeuta = $this->getCurrentUser()->data();

        try {
            $this->auth->signInWithEmailAndPassword($terapeuta['email'], $request->input('password_old'));
        } catch (FailedToSignIn $e) {
            return back()->withErrors('Password antiga incorreta.');
        }

        $user = $this->auth->getUserByEmail($terapeuta['email']);
        $uid = $user->uid;
        $updatedUser = $this->auth->changeUserPassword($uid, $request->input('password'));

        return redirect()->route('default');
    }

    protected function logout(){
        $db = app('firebase.firestore')->database();

        $session = Session::get('admin_session')->toArray();
        $uid = $session['localId'];

        $this->auth->revokeRefreshTokens($uid);
        Session::forget('admin_session');
        Session::remove('admin_session');

    }





}
