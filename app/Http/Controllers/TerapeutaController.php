<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use App\Models\Notificavel;
use App\Models\Reset;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;

use Kreait\Firebase\Exception\Auth\UserNotFound;

use Auth;
use App\Models\User;
use App\Notifications\PasswordChanged;
use App\Notifications\ResetPassword;
use Exception;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use App\Helpers\Helper;
use App\Helpers\UserRole;

class TerapeutaController extends Controller
{
    protected $auth;
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $signInResult;
    protected $database;




    public function __construct(FirebaseAuth $auth) {
        $this->middleware('guest')->except('logout');
        $this->auth = $auth;
        $this->database = app('firebase.database');
     }

    public function email(){
        return 'email';
    }

    public function logout(){
        $db = app('firebase.firestore')->database();

        $session = Session::get('admin_session')->toArray();
        $token = $session['localId'];


        $this->auth->revokeRefreshTokens($token);
        Session::forget('admin_session');
        Session::remove('admin_session');

        return redirect()->route('login');


    }
    public function login(Request $request){
        try {
            $signInResult = $this->auth->signInWithEmailAndPassword(
                $request['email'],
                $request['password']);
            return $this->baseLogin($request, $signInResult->data()['localId']);
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors("Dados inseridos incorretos");
        }
    }
    public function googleLogin(Request $request){
        try {
            $socialTokenId = $request->input('social-login-tokenId', '');
            $verifiedIdToken = $this->auth->verifyIdToken($socialTokenId);
            $uid = $verifiedIdToken->claims()->get('sub');
            return $this->baseLogin($request, $uid);
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors("Dados inseridos incorretos");
         }
    }

    public function baseLogin(Request $request, $uid) {
        try {
            //Se o utilizador não existir na tabela é porque não é terapeuta/admin
            $userFromAuth = $this->auth->getUser($uid);
            $userFromFirestore = app('firebase.firestore')->database()->collection('terapeutas')->document($uid)->snapshot()->data();
            $userRole = Helper::getRole($userFromAuth);
            if($userRole != UserRole::AdminRole && $userRole != UserRole::TerapeutaRole){
                return redirect()->route('login')->withErrors("Este utilizador não tem acesso ao BackOffice.");
            }
            //Verifica se o utilizador está bloqueado
            if($userFromFirestore['bloqueado']){
                return redirect()->route('login')->withErrors("Este utilizador está bloqueado");
            }
            //Cria a sessão e o user model
            $user = new User(["email" => $userFromAuth->email, "localId" => $uid]);
            $user->tipo = $userFromFirestore['tipo'];
            $user->nome = $userFromFirestore['nome'];
            $user->firestoreId = $userFromFirestore['id'];
            $user->imagem = $this->getPerfilPic($userFromFirestore['image']);
            Session::put('admin_session',$user);
            return redirect()->route('default');
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors("Dados inseridos incorretos");
        }
    }


    public function register(Request $request){
        $socialTokenId = $request->input('social-login-tokenId', '');
        $registerOption = $request->input('registerOption');

        switch($registerOption) {
            case "google":
                $request->validate([
                    'codigo' => 'required',
                    'social-login-tokenId' => 'required',
                    'social-login-email' => 'required',
                ], [
                    'social-login-tokenId.required' => '',
                    'social-login-email.required' => 'Erro: Autenticação com a google em falta.',
                ]);
                $email = $request->input('social-login-email');
               break;

            case "password":
                $request->validate([
                    'codigo' => 'required',
                    'email' => 'required',
                    'password' => ['required', 'string', 'min:8', 'max:12', 'confirmed'],
                ]);

                $email = $request->input('email');
                break;
            default:
                return redirect()->back()->withErrors(["Método de login desconhecido, por favor tente novamente"]);

        }

        $confirmacao = app('firebase.firestore')->database()->collection('convites')->document($request->input('codigo'))->snapshot();
        //$uid = round(microtime(true) * 1000);

        $data = date("d/m/Y");

        if(!$confirmacao->exists()){
            return redirect()->back()->withErrors(["O código introduzido não é válido."]);
        }

        //Ver se o email e o codigo batem certo
        if($confirmacao->data()['email'] != $email){
            return redirect()->back()->withErrors(["O email e código inseridos não estão associados.", "Verifique que o email que recebeu o código é o mesmo que introduziu"]);
        }

        try {
            $this->validator([
                ...$request->all(),
                'email' => $email,
            ])->validate();

            switch($registerOption) {
                case "google":
                    // User Record already created through frontend, update it
                    $socialTokenId = $request->input('social-login-tokenId', '');
                    $verifiedIdToken = $this->auth->verifyIdToken($socialTokenId);
                    $uid = $verifiedIdToken->claims()->get('sub');
                    $this->auth->updateUser($uid,[
                        'name' => $request->input('nome'),
                        'disabled' => false,
                    ]);
                    break;
                case "password":
                    $this->auth->createUser([
                        'email' => $email,
                        'emailVerified' => false,
                        'password' => $request->input('password'),
                        'name' => $request->input('nome'),
                        'disabled' => false,
                    ]);
                    $uid = $this->auth->getUserByEmail($email)->uid;
                    break;
            }

            if($confirmacao->data()['tipo'] == 'A'){
                Helper::setRoleAdmin($this->auth,$uid);
            }else {
                Helper::setRoleTerapeuta($this->auth,$uid);
            }

            $firestore = app('firebase.firestore')->database();
            $dados = [
                'nome' => $request->input('nome'),
                'email' => $email,
                'descricao' => "",
                'criancas' => [],
                'tipo' => $confirmacao->data()['tipo'],
                'bloqueado' => false,
                'id' => $uid."",
                'image' => "",
                'data' => $data,
            ];

            $terapeuta = $firestore->collection('terapeutas')->Document($uid);
            $terapeuta->set($dados);
            $this->database->getReference('Terapeutas/'.$uid)
            ->set([
                'image' => '',
                'name' => $request->input('nome'),
                'description' => '',
                'uid' => $uid,
                ]);

            //Apagar o código de convite
            $firestore->collection('convites')->document($confirmacao->data()['codigo'])->delete();
            return redirect()->route('login')->with('sucess', 'Conta registada com sucesso.');
          } catch (FirebaseException $e) {
             Session::flash('error', $e->getMessage());
             return redirect()->back()->withErrors(["Houve um problema com o registo.", "Tente preencher o formulário de registo novamente", "Se o problema persistir, contacte um Administrador"]);
          }
    }


    protected function validator(array $data) {
        return Validator::make($data, [
           'nome' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255'],
        ]);
     }









    /**
     * Reset PASSWORD (FORGOT PASSWORD)
     */

    public function resetIndex()
    {
        return view ('app.reset');
    }

    public function resetRequest (Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        //verificar se o user é válido
        $userFromFirestore = $this->getUserByEmail($request['email']);
        if(!isset($userFromFirestore)){
            return redirect()->back()->withErrors("Este utilizador não tem acesso ao BackOffice.");
        }

        $provider = $this->auth->getUserByEmail($request['email'])->providerData[0]->providerId;
        if($provider != 'password') {
            return redirect()->back()->withErrors("Este utilizador não utiliza password para se autenticar.");
        }



        // Criar o modelo da confirmação
        $data = date("Y/m/d");
        $confirmacao = new Reset();
        $confirmacao->codigo = bin2hex(random_bytes(8));
        $confirmacao->email = $request->input('email');
        $confirmacao->data = $data;

        $confirmacao->notify(new ResetPassword($confirmacao->codigo));

        //Enviar para o firestore database (reset_confirmation)
        $dados = [
            'codigo' => $confirmacao->codigo,
            'email' => $confirmacao->email,
            'data' => $confirmacao->data,
        ];

        $confirmacaoDB = app('firebase.firestore')->database()->collection('reset_confirmation')->Document($confirmacao->codigo);
        $confirmacaoDB->set($dados);

        return redirect()->route('reset.password')->with('sucess', 'Email enviado para: '.$request->input('email'));

    }

    public function changePasswordWConfirmationIndex ()
    {
        return view('app.change_password');
    }

    public function changePasswordWConfirmation(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|confirmed|min:8',
            'codigo' => 'required',
        ]);

        $newPassword = $request->input('password');

        //vai buscar o codigo
        $resetConfirmation = app('firebase.firestore')->database()->collection('reset_confirmation')->document($request->input('codigo'))->snapshot();
        $codInfo = $resetConfirmation->data();

        if(!empty($codInfo)){
            $hoje = date("Y/m/d");
            $diff = date_diff(date_create($codInfo['data']), date_create($hoje));
            $idadeCod = $diff->format('%d');

            //Verificar a validade do código
            if($idadeCod > 0){
                return back()->withErrors(["Este código de confirmação não é válido.", "Cada código é apenas válido durante 24h.", "Preencha de novo o formulário caso ainda pretenda mudar de password."]);
            }
            if($request->input('email') == $codInfo['email']){

                try {
                    $user = $this->auth->getUserByEmail($request->input('email'));
                    $uid = $user->uid;
                    $updatedUser = $this->auth->changeUserPassword($uid, $newPassword);

                    $utilizador = new Notificavel();
                    $utilizador->email = $user->email;

                    $utilizador->notify(new PasswordChanged());

                    //Apagar todos os códigos do utilizador
                        //
                        $userCodes = app('firebase.firestore')->database()->collection('reset_confirmation')->where('email', '==', $request->input('email'))->documents();
                        foreach($userCodes->rows() as $doc){
                            $doc->reference()->delete();
                        }

                    return redirect()->route('login')->with('sucess', 'Password mudada com sucesso');

                } catch (UserNotFound $e) {
                    return back()->withErrors("Não há nenhum utilizador com este email associado");
                }

            }else{
                return back()->withErrors("Este email e código não estão associados");
            }

        }else{
            return back()->withErrors("Código errado");
        }

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

    protected function getUserByEmail($email){

        $db = app('firebase.firestore')->database();


        $terapeuta = null;

        $query = $db->collection('terapeutas')->where('email', '=', $email);
        $documents = $query->documents();
        foreach ($documents as $document) {
            if ($document->exists()) {
                $terapeuta = $document;
            }
        }

        return $terapeuta;
    }

}
