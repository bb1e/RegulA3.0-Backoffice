<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Auth as FirebaseAuth;
use Carbon\Carbon;


class EstatisticasController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth) {
        $this->auth = $auth;
    }



    public function index()
    {
	$minutes = 24 * 60;
        $qtdEstrategias = Cache::remember('qtdEstrategias',$minutes, fn () =>  $this->getQtdEstrategias());
        $qtdUsers = Cache::remember('qtdUsers',$minutes, fn () =>  $this->getQtdUsers());
        $qtdRelatorios = Cache::remember('qtdRelatorios',$minutes, fn () => $this->getQtdRelatoriosSemanais());
        $qtdFeedback = Cache::remember('qtdFeedback',$minutes, fn () => $this->getQtdFeedback());

        return view('dashboard.index', compact('qtdEstrategias', 'qtdUsers', 'qtdRelatorios', 'qtdFeedback'));
    }


    protected function getQtdUsers()
    {
        $database = app('firebase.firestore')->database();
        $users = $this->auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        $terapeutasDB = $database->collection('terapeutas')->documents();
        $criancasDB = $database->collection('criancas_test')->documents();

        $qtdTotal = 0;
        $qtdPais = 0;
        $qtdTerapeutas = 0;
        $qtdAdministradores = 0;
        $qtdCriancas = 0;
        $qtdBackOfficeUsers = 0;

        foreach ($users as $user) {
            $qtdTotal++;
        }

        if (!empty($terapeutasDB)){
            foreach($terapeutasDB as $terapeuta){
                $backofficeUser = $terapeuta->data();

                if($backofficeUser['tipo'] == "T"){
                    $qtdTerapeutas++;
                }elseif($backofficeUser['tipo'] == "A"){
                    $qtdAdministradores++;
                }
                $qtdBackOfficeUsers++;
            }
        }

        $qtdPais = $qtdTotal-$qtdBackOfficeUsers;

        if (!empty($criancasDB)){
            foreach($criancasDB as $crianca){
                $qtdCriancas++;
            }
        }


        $percPais = floor(( $qtdPais * 100 ) / $qtdTotal);
        $percTerapeutas = floor(( $qtdTerapeutas * 100 ) / $qtdTotal);
        $percdministradores = floor(( $qtdAdministradores * 100 ) / $qtdTotal);

        $qtdUsers = [
            'qtdTotal' => $qtdTotal,
            'qtdPais' => $qtdPais,
            'qtdTerapeutas' => $qtdTerapeutas,
            'qtdAdministradores' => $qtdAdministradores,
            'qtdCriancas' => $qtdCriancas,
            'percPais' => $percPais,
            'percTerapeutas' => $percTerapeutas,
            'percdministradores' => $percdministradores,
        ];

        return $qtdUsers;
    }

    protected function getQtdEstrategias()
    {
        $database = app('firebase.firestore')->database();

        $estrategiasDB = $database->collection('estrategias_demo')->documents();

        $qtdTotal = 0;

        $qtdAVD = 0;
        $qtdDormir = 0;
        $qtdBrincar = 0;
        $qtdRegulatorias = 0;

        if (!empty($estrategiasDB)){
            foreach($estrategiasDB as $estrategia){
                $strat = $estrategia->data();

                if ($strat['titulo'] == "Vestir/despir" || $strat['titulo'] ==  "Alimentação e horas da refeição" ||
                    $strat['titulo'] == "Tomar banho" || $strat['titulo'] == "Higiene sanitária" || $strat['titulo'] == "Higiene pessoal – lavar os dentes" ||
                    $strat['titulo'] == "Higiene Pessoal – cortar as unhas" || $strat['titulo'] == "Higiene Pessoal – lavar a mãos" ||
                    $strat['titulo'] == "Higiene Pessoal - colocar creme" || $strat['titulo'] == "Higiene Pessoal – cortar o cabelo"){
                        $qtdAVD++;
                }
                elseif($strat['titulo'] == "Preparação do sono" || $strat['titulo'] == "Participação do sono"){
                    $qtdDormir++;
                }
                elseif($strat['titulo'] == "Brincar/Jogar"){
                    $qtdBrincar++;
                }
                else{
                    $qtdRegulatorias++;
                }

                $qtdTotal++;
            }
        }

        $qtdEstrategias = [
            'qtdTotal' => $qtdTotal,
            'qtdAVD' => $qtdAVD,
            'qtdDormir' => $qtdDormir,
            'qtdBrincar' => $qtdBrincar,
            'qtdRegulatorias' => $qtdRegulatorias,
        ];

        return $qtdEstrategias;
    }

    protected function getQtdRelatoriosSemanais()
    {
        $database = app('firebase.firestore')->database();
        $relatoriosDB = $database->collection('relatorioSemanal')->documents();

        $qtdTotal = 0;
        $qtdTotalAno = 0;
        $qtdPMes = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
        ];

        if (!empty($relatoriosDB)){
            foreach($relatoriosDB as $rel){
                $relatorio = $rel->data();
                $data = $relatorio['data'];
                $anoAtual = Carbon::now()->format('Y');
                if ($anoAtual == $data['ano']){
                    $mes = $relatorio['data']['mes'];
                    $qtdPMes[$mes] ++;
                    $qtdTotalAno++;
                }
                $qtdTotal++;
            }
        }

        $qtdRelatorios = [
            'qtdTotal' => $qtdTotal,
            'qtdTotalAno' => $qtdTotalAno,
            'qtdPMes' => $qtdPMes,
        ];

        return $qtdRelatorios;
    }

    protected function getQtdFeedback()
    {
        $database = app('firebase.firestore')->database();
        $feedbackDB = $database->collection('feedbackEstrategias_demo')->documents();
        $estrategiasDB = $database->collection('estrategias_demo')->documents();

        $estrategias = [];
        if (!empty($estrategiasDB)){
            foreach($estrategiasDB as $str){
                $estrategia = $str->data();
                $estrategias[$estrategia['id']] = $estrategia;
            }
        }

        //dd($estrategias);

        $qtdTotal = 0;
        $qtdAVD = 0;
        $qtdDormir = 0;
        $qtdBrincar = 0;
        $qtdRegulatorias = 0;

        if (!empty($feedbackDB)){
            foreach($feedbackDB as $fb){
                $feedback = $fb->data();
                $idEstrategia = $feedback['idEstrategia'];
                if ($estrategias[$idEstrategia]['titulo'] == "Vestir/despir" ||
                    $estrategias[$idEstrategia]['titulo'] ==  "Alimentação e horas da refeição" ||
                    $estrategias[$idEstrategia]['titulo'] == "Tomar banho" ||
                    $estrategias[$idEstrategia]['titulo'] == "Higiene sanitária" ||
                    $estrategias[$idEstrategia]['titulo'] == "Higiene pessoal – lavar os dentes" ||
                    $estrategias[$idEstrategia]['titulo'] == "Higiene Pessoal – cortar as unhas" ||
                    $estrategias[$idEstrategia]['titulo'] == "Higiene Pessoal – lavar a mãos" ||
                    $estrategias[$idEstrategia]['titulo'] == "Higiene Pessoal - colocar creme" ||
                    $estrategias[$idEstrategia]['titulo'] == "Higiene Pessoal – cortar o cabelo")
                {
                        $qtdAVD++;
                }
                elseif($estrategias[$feedback['idEstrategia']]['titulo'] == "Preparação do sono" ||
                    $estrategias[$feedback['idEstrategia']]['titulo'] == "Participação do sono")
                {
                    $qtdDormir++;
                }
                elseif($estrategias[$feedback['idEstrategia']]['titulo'] == "Brincar/Jogar")
                {
                    $qtdBrincar++;
                }
                else
                {
                    $qtdRegulatorias++;
                }

                $qtdTotal++;
            }
        }

        if($qtdTotal > 0){
            $percAVD = floor(( $qtdAVD * 100 ) / $qtdTotal);
            $percDormir = floor(( $qtdDormir * 100 ) / $qtdTotal);
            $percBrincar = floor(( $qtdBrincar * 100 ) / $qtdTotal);
            $percRegulatorias = floor(( $qtdRegulatorias * 100 ) / $qtdTotal);
        } else {
            $percAVD = 0;
            $percDormir = 0;
            $percBrincar = 0;
            $percRegulatorias = 0;
        }

        $qtdFeedback = [
            'qtdTotal' => $qtdTotal,
            'qtdAVD' => $qtdAVD,
            'AVD%' => $percAVD,
            'qtdDormir' => $qtdDormir,
            'dormir%' => $percDormir,
            'qtdBrincar' => $qtdBrincar,
            'brincar%' => $percBrincar,
            'qtdRegulatorias' => $qtdRegulatorias,
            'regulatorias%' => $percRegulatorias,
        ];

        return $qtdFeedback;

    }
}
