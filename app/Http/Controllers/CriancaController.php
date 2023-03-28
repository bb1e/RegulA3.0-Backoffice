<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Firestore\DocumentSnapshot;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Auth as FirebaseAuth;

class CriancaController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth) {
        $this->auth = $auth;
     }


    public function index(){
        return view('criancas.criancas');
    }

    public function getAll(){
        //$criancas = app('firebase.firestore')->database()->collection('criancas_test')->documents();
        $criancas = $this->getCriancasDoTerapeuta();

        return view('criancas.criancas',compact('criancas'));
    }


    public function perfil($id)
    {

        $crianca = app('firebase.firestore')->database()->collection('criancas_test')->document($id)->snapshot();
        //$cuidador = app('firebase.firestore')->database()->collection('cuidadores_test')->document($crianca->data()['idPai'])->snapshot();
        $cuidador = app('firebase.firestore')->database()->collection('sessions_test')->document($crianca->data()['idSession'])->snapshot();
        $estrategiasTotais = app('firebase.firestore')->database()->collection('estrategias_demo')->documents();

        $idsRcmds = $this->getStratsRecomendadsDaBD($crianca);
        $estrategiasRecomendadas = array();

        foreach($estrategiasTotais as $strat){
            foreach($idsRcmds as $idrcmd){
                if ($strat->data()['id'] == $idrcmd){
                    array_push($estrategiasRecomendadas, $strat);
                }
            }
        }

        $this->getPerfilPic($id);
        return view('criancas.profile',compact('crianca', 'cuidador', 'estrategiasRecomendadas'));
    }

    public function avaliar($id)
    {

        $crianca = app('firebase.firestore')->database()->collection('criancas_test')->document($id)->snapshot();
        return view('criancas.avaliacao',compact('crianca'));
    }


    public function dashboard($id)
    {

        $crianca = app('firebase.firestore')->database()->collection('criancas_test')->document($id)->snapshot();
        $relatoriosTotais = app('firebase.firestore')->database()->collection('relatorioSemanal')->documents();
        $feedbacksTotais = app('firebase.firestore')->database()->collection('feedbackEstrategias_demo')->documents();
        $estrategiasTotais = app('firebase.firestore')->database()->collection('estrategias_demo')->documents();

        $feedbackCounter = 0;
        $feedbacks = array();
        foreach($feedbacksTotais as $feedback){
            if($feedback->data()['idCrianca'] == $id) {
                $feedbackCounter++;
                array_push($feedbacks, $feedback);
            }
        }

        $relatoriosCounter = 0;
        $relatorios = array();
        $av1Soma = array();
        $av2Soma = array();
        $av3Soma = array();
        $av4Soma = array();
        $av5Soma = array();
        $av6Soma = array();
        $av7Soma = array();
        foreach($relatoriosTotais as $relatorio){
            if($relatorio->data()['idCrianca'] == $id) {
                $relatoriosCounter++;
                array_push($relatorios, $relatorio);
                array_push($av1Soma, $relatorio->data()['avaliacao1']);
                array_push($av2Soma, $relatorio->data()['avaliacao2']);
                array_push($av3Soma, $relatorio->data()['avaliacao3']);
                array_push($av4Soma, $relatorio->data()['avaliacao4']);
                array_push($av5Soma, $relatorio->data()['avaliacao5']);
                array_push($av6Soma, $relatorio->data()['avaliacao6']);
                array_push($av7Soma, $relatorio->data()['avaliacao7']);
            }
        }
        $mediaAv1 = $this->average($av1Soma);
        $mediaAv2 = $this->average($av2Soma);
        $mediaAv3 = $this->average($av3Soma);
        $mediaAv4 = $this->average($av4Soma);
        $mediaAv5 = $this->average($av5Soma);
        $mediaAv6 = $this->average($av6Soma);
        $mediaAv7 = $this->average($av7Soma);


        $estrategiasComFeedback = array();
        $ids = array();
        foreach($estrategiasTotais as $estrategia){
            foreach($feedbacks as $fb){
                if($estrategia->data()['id'] == $fb->data()['idEstrategia']){
                    if(!in_array($estrategia->data()['id'], $ids)){
                        array_push($ids, $estrategia->data()['id']);
                        array_push($estrategiasComFeedback, $estrategia);
                    }
                }
            }
        }

        return view('criancas.dashboard',compact('crianca', 'relatorios', 'relatoriosCounter', 'feedbacks', 'feedbackCounter', 'estrategiasComFeedback', 'mediaAv1', 'mediaAv2', 'mediaAv3', 'mediaAv4', 'mediaAv5', 'mediaAv6', 'mediaAv7'));
    }



    public function graficos($id){
        $crianca = app('firebase.firestore')->database()->collection('criancas_test')->document($id)->snapshot();

        $relatoriosTotais = app('firebase.firestore')->database()->collection('relatorioSemanal')->documents();

        $relatorios = array();
        foreach($relatoriosTotais as $relatorio){
            if($relatorio->data()['idCrianca'] == $id) {
                array_push($relatorios, $relatorio);
            }
        }

        $av1 = array();
        $av2 = array();
        $av3 = array();
        $av4 = array();
        $av5 = array();
        $av6 = array();
        $av7 = array();
        $data = array();
        foreach($relatorios as $rel){
            $dia = $rel->data()['data']['dia'];
            $mes = $rel->data()['data']['mes'];
            $ano = $rel->data()['data']['ano'];
            $dataRel = $dia."/".$mes."/".$ano;
            array_push($data, $dataRel);
            array_push($av1, $rel->data()['avaliacao1']);
            array_push($av2, $rel->data()['avaliacao2']);
            array_push($av3, $rel->data()['avaliacao3']);
            array_push($av4, $rel->data()['avaliacao4']);
            array_push($av5, $rel->data()['avaliacao5']);
            array_push($av6, $rel->data()['avaliacao6']);
            array_push($av7, $rel->data()['avaliacao7']);
        }

        $data = json_encode($data, JSON_UNESCAPED_SLASHES);
        $av1 = json_encode($av1);
        $av2 = json_encode($av2);
        $av3 = json_encode($av3);
        $av4 = json_encode($av4);
        $av5 = json_encode($av5);
        $av6 = json_encode($av6);
        $av7 = json_encode($av7);


        return view('criancas.graficos', compact('crianca', 'relatorios', 'av1', 'av2', 'av3', 'av4', 'av5', 'av6', 'av7', 'data'));
    }

    public function feedback($id)
    {

        $feedback = app('firebase.firestore')->database()->collection('feedbackEstrategias_demo')->document($id)->snapshot();

        $idEstrategia = $feedback->data()['idEstrategia'];
        $estrategia = app('firebase.firestore')->database()->collection('estrategias_demo')->document($idEstrategia)->snapshot();



        $feedbacksTotais = app('firebase.firestore')->database()->collection('feedbackEstrategias_demo')->documents();
        $feedbacks = array();
        foreach($feedbacksTotais as $fb1){
            if($fb1->data()['idCrianca'] == $feedback->data()['idCrianca']) {
                array_push($feedbacks, $fb1);
            }
        }

        $feedbacksDaEstrategia = array();
        $contador = 0;
        $avs = array();
        $datas = array();
        foreach($feedbacks as $fb){
            if($fb->data()['idEstrategia'] == $idEstrategia){
                array_push($feedbacksDaEstrategia, $fb);
                $contador++;
                array_push( $avs, $fb->data()['avaliacao']);
                $dia = $fb->data()['data']['dia'];
                $mes = $fb->data()['data']['mes'];
                $ano = $fb->data()['data']['ano'];
                $temp = $dia."/".$mes."/".$ano;
                array_push($datas, $temp);
            }
        }

        //Calcular media
        $media = $this->average($avs);


        //Dados para o gráfico
        $avaliacoes = array();
        foreach ($avs as $av){
            if($av == 2){
                array_push($avaliacoes, 1);
            }
            if($av == 3){
                array_push($avaliacoes, 2);
            }
            if($av == 5){
                array_push($avaliacoes, 3);
            }
        }
        $datas = json_encode($datas, JSON_UNESCAPED_SLASHES);
        $avaliacoes = json_encode($avaliacoes);


        return view('criancas.feedback',compact('feedback', 'estrategia', 'contador', 'feedbacksDaEstrategia', 'media', 'datas', 'avaliacoes'));
    }

    public function recomendar($id){

        $crianca = app('firebase.firestore')->database()->collection('criancas_test')->document($id)->snapshot();
        $estrategias = app('firebase.firestore')->database()->collection('estrategias_demo')->documents();

        $estrategiasRecomendadas = $this->getStratsRecomendadsDaBD($crianca);


        $banho = $this->getEstrategiaPTipo($estrategias, "Tomar banho");
        $vestir = $this->getEstrategiaPTipo($estrategias, "Vestir/despir");
        $alimentacao = $this->getEstrategiaPTipo($estrategias, "Alimentação e horas da refeição");
        $higiene = $this->getEstrategiaPTipo($estrategias, "Higiene sanitária");
        $dentes = $this->getEstrategiaPTipo($estrategias, "Higiene pessoal – lavar os dentes");
        $unhas = $this->getEstrategiaPTipo($estrategias, "Higiene Pessoal – cortar as unhas");
        $maos = $this->getEstrategiaPTipo($estrategias, "Higiene Pessoal – lavar a mãos");
        $creme = $this->getEstrategiaPTipo($estrategias, "Higiene Pessoal - colocar creme");
        $cabelo = $this->getEstrategiaPTipo($estrategias, "Higiene Pessoal – cortar o cabelo");
        $sonoPrep = $this->getEstrategiaPTipo($estrategias, "Preparação do sono");
        $sonoPart = $this->getEstrategiaPTipo($estrategias, "Participação do sono");
        $brincar = $this->getEstrategiaPTipo($estrategias, "Brincar/Jogar");
        $regulatorias = $this->getEstrategiaPTipo($estrategias, "Estratégias Regulatórias");


        return view('criancas.recomendar',compact('crianca', 'estrategiasRecomendadas', 'banho', 'vestir', 'alimentacao', 'higiene', 'dentes', 'unhas', 'maos', 'creme', 'cabelo', 'sonoPrep', 'sonoPart', 'brincar', 'regulatorias'));
    }

    public function getStratsRecomendadsDaBD($crianca){
        return $crianca->data()['estrategiasRecomendadas'];
    }

    public function getEstrategiaPTipo($estrategias, $tipo){

        $doTipo = array();
        foreach ($estrategias as $strat){
            if($strat->data()['titulo'] === $tipo){
                array_push($doTipo, $strat);
            }
        }
        return $doTipo;
    }


    public function getPerfilPic($id)
    {
        $crianca = app('firebase.firestore')->database()->collection('criancas_test')->document($id)->snapshot();
        $imageRef = $crianca->data()['storageImageRef'];

        $storage = app('firebase.storage');
        $bucket = $storage->getBucket();
        $image = $bucket->object($imageRef);
        //$image->downloadToFile('/img/perfil/'.$id.'.png');
        $path_to_file='img/perfil/'.$id.'.png';
        $image->downloadToFile($path_to_file);
    }

    public function average($numbers=array()){
        if (!is_array($numbers))
		$numbers = func_get_args();

        $sum = 0;
        $amt = count($numbers);

        foreach($numbers as $num)
            $sum += $num;

        return ($amt > 0) ? (floor($sum / $amt)) : false; // no division by zero
    }


    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function atualizar(Request $request, string $id)
    {

        $request->validate([]);
        $crianca = app('firebase.firestore')->database()->collection('criancas_test')->document($id);

        if($request->input('checkbox') == null){
            $crianca->update([
                ['path' => 'estrategiasRecomendadas', 'value' => []]
               ]);

            return redirect()->route('crianca.perfil', ['id' => $id])->with('sucess', 'A criança ficou sem estratégias recomendadas.');
        }

        $idsRecomendadasNumber =  array_keys($request->input('checkbox'));

        $idsRecomendadas = array();
        foreach($idsRecomendadasNumber as $temp){
            array_push($idsRecomendadas, strval($temp));
        }

        print_r($idsRecomendadas);

            $crianca->update([
                ['path' => 'estrategiasRecomendadas', 'value' => $idsRecomendadas]
               ]);

        return redirect()->route('crianca.perfil', ['id' => $id])->with('sucess', 'Estratégias recomendadas com sucesso.');

    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'av1' => 'required',
            'av2' => 'required',
            'av3' => 'required',
            'av4' => 'required',
            'av5' => 'required',
            'av6' => 'required',
            'av7' => 'required',
            'comentario' => 'nullable',
        ]);


            $crianca = app('firebase.firestore')->database()->collection('criancas_test')->document($id)->snapshot();
            //$session = app('firebase.firestore')->database()->collection('sessions_test')->document($crianca->data()['idSession'])->snapshot();
            $data = date("d/m/Y");

            $estrategia = app('firebase.firestore')->database()->collection('criancas_test')->document($id);

            $estrategia->update([
                ['path' => 'ssAv1', 'value' => $request->input('av1')]
               ]);
            $estrategia->update([
                ['path' => 'ssAv2', 'value' => $request->input('av2')]
               ]);
            $estrategia->update([
                ['path' => 'ssAv3', 'value' => $request->input('av3')]
               ]);
            $estrategia->update([
                ['path' => 'ssAv4', 'value' => $request->input('av4')]
               ]);
            $estrategia->update([
                ['path' => 'ssAv5', 'value' => $request->input('av5')]
               ]);
            $estrategia->update([
                ['path' => 'ssAv6', 'value' => $request->input('av6')]
               ]);
            $estrategia->update([
                ['path' => 'ssAv7', 'value' => $request->input('av7')]
               ]);

            $estrategia->update([
                ['path' => 'comentario', 'value' => $request->input('comentario')]
               ]);

            $estrategia->update([
                ['path' => 'dataUltimaAvaliacao', 'value' => $data]
               ]);


        return redirect()->route('crianca.perfil', ['id' => $id])->with('sucess', 'Criança avaliada com sucesso.');
    }



    protected function getCriancasDoTerapeuta(){
         //apenas os utilizadores não bloqueados
        $database = app('firebase.firestore')->database();
        $user = $this->getCurrentUser()->data();
        $criancas = $user['criancas'];

        $criancasDoTerapeuta = [];
        if (!empty($criancas) || $criancasDoTerapeuta != null){
            foreach($criancas as $crianca){
                $document = $database->collection('criancas_test')->document($crianca);
                if(!empty($document)){
                    $snapshot = $document->snapshot()->data();
                    array_push($criancasDoTerapeuta, $snapshot);
                }
            }
        }

        return $criancasDoTerapeuta;
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
