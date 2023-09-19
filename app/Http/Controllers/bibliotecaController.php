<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livros;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Http\Controllers;

class bibliotecaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dadosLivros = Livros::All();
        $contador = $dadosLivros->count();

        return 'Livros: ' . $contador . $dadosLivros . Response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dadosLivros = $request->All();

        $valida = Validator::make($dadosLivros, [
            'nome'=> 'required',
            'prateleira'=> 'required',
            'autor' => 'required'
        ]);

        if($valida->fails()){
            return 'Dados inválidos' . $valida->errors(true). 500;
        }
            $LivrosBanco = Livros::create($dadosLivros);
        if($LivrosBanco){
            return 'Bebidas cadastradas ' . Response()->json([], Response::HTTP_NO_CONTENT);          
        }else{
            return 'Bebidas não cadastradas '.Response()->json([], Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $LivrosBanco = Livros::find($id);
        $contador = $LivrosBanco->count();

        if($LivrosBanco){
            return 'Livros encontrados '. $contador . ' - ' . $LivrosBanco.response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return 'Livros não localizados.'.response()->json([],Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $LivrosDados = $request->All();
        $valida = Validator::make($LivrosDados,[
            'nome'=> 'required',
            'prateleira'=> 'required',
            'autor' => 'required'
        ]);

        if($valida->fails()){
            return 'Dados incompletos ' . $valida->errors(true). 500;
        }

        $LivrosBanco = Livros::find($id);
        $LivrosBanco->nome = $LivrosDados['nome'];
        $LivrosBanco->prateleira = $LivrosDados['prateleira'];
        $LivrosBanco->autor = $LivrosDados['autor'];

        $RegistrosLivros = $LivrosBanco->save();
        if($RegistrosLivros){
            return 'Dados alterados com sucesso.'.Response()->json([], Response::HTTP_NO_CONTENT);        
        }else{
            return 'Dados não alterados no banco de dados'.Response()->json([], Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $LivrosBanco = Livros::find($id);
        if($LivrosBanco){
            $LivrosBanco->destroy();
            return 'O livro foi deletado com sucesso.'.response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return 'O livro não foi deletado'.response()->json([],Response::HTTP_NO_CONTENT);
        }
    }
}
