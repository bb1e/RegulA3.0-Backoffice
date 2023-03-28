<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Estrategia;

use Google\Cloud\Firestore\DocumentSnapshot;

class EstrategiaController extends Controller
{
    public function index(){
        return view('estrategias.estrategias');
    }

    public function adicionarEstrategia(){
        return view('estrategias.criar');
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
            'tipoAlvo' => 'required',
            'titulo' => 'required',
            'descricao' => 'required',
        ]);

        $milliseconds = round(microtime(true) * 1000);
        $dados = [
            'data' => $milliseconds,
            'id' => $milliseconds,
            'descricao' => $request->input('descricao'),
            'tipoAlvo' => $request->input('tipoAlvo'),
            'titulo' => $request->input('titulo'),
            'validated' => false,
        ];

        $stuRef = app('firebase.firestore')->database()->collection('estrategias_demo')->Document($milliseconds);
        $stuRef->set($dados);

        return redirect()->route('estrategias')->with('sucess', 'Estratégia adicionada com sucesso: '.$dados['descricao']);
    }



    public function getAll(){
        $estrategias = app('firebase.firestore')->database()->collection('estrategias_demo')->documents();
        return view('estrategias.estrategias',compact('estrategias'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        app('firebase.firestore')->database()->collection('estrategias_demo')->document($id)->delete();

        return redirect()->route('estrategias')->with('sucess', 'Estratégia apagada com sucesso.');
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $doc
     * @return \Illuminate\Http\Response
     */
    public function edit(string $doc)
    {
        $estrategia = app('firebase.firestore')->database()->collection('estrategias_demo')->document($doc)->snapshot();
        //var_dump($estrategia);
        return view('estrategias.editar',compact('estrategia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $doc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $doc)
    {
        $request->validate([
            'tipoAlvo' => 'required',
            'titulo' => 'required',
            'descricao' => 'required',
        ]);


        //var_dump($doc);


            $estrategia = app('firebase.firestore')->database()->collection('estrategias_demo')->document($doc);

            $estrategia->update([
                ['path' => 'descricao', 'value' => $request->input('descricao')]
               ]);

            $estrategia->update([
                ['path' => 'tipoAlvo', 'value' => $request->input('tipoAlvo')]
               ]);

            $estrategia->update([
                ['path' => 'titulo', 'value' => $request->input('titulo')]
               ]);


        return redirect()->route('estrategias')->with('sucess', 'Estratégia editada com sucesso.');
    }

}
