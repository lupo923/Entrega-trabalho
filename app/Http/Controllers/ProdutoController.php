<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;


class ProdutoController extends Controller
{
    public function index(){
        //$produto = Produto::all()->toArray();
        
           $produtos = Produto::select("produto.id",
                                       "produto.nome",
                                       "produto.quantidade",
                                       "produto.preco",
                                       "categoria.nome AS cat",
                                       "marca.nome as marca",
                                       "produto.descricao")
                                    ->join("categoria","categoria.id", "=", "produto.id_categoria")
                                    ->join("marca","marca.id", "=", "produto.id_marca") 
                                    ->orderBy("produto.id")                                       
                                    ->get();

        return view("Produto.index",["produtos"=>$produtos]);
    }

    public function inserir(){
        $categorias = Categoria::all()->toArray();  //select de categorias - laravel
        $marcas = Marca::all()->toArray();      
        return view("Produto.formulario",['categorias' => $categorias,'marcas' => $marcas]);        
    }

    public function excluir($id){
        $produto = Produto::find($id);
        $produto->delete();
        return redirect("/produto"); 
    }
    
    public function alterar($id){
        $produto = Produto::find($id)->toArray();
        $categorias = Categoria::all()->toArray();  //select de categorias - laravel
        $marcas = Marca::all()->toArray(); 
        return View("Produto.formulario",['produto'=>$produto,'categorias' => $categorias,'marcas' => $marcas]);             
    }

  public function salvar_novo(Request $request)
  {
      $produto = new Produto();
      

      $produto->nome = $request->input("nome");
      $produto->id_categoria = $request->input("id_categoria");
      $produto->preco = $request->input("preco");
      $produto->quantidade = $request->input("quantidade");
      $produto->descricao = $request->input("descricao");
      $produto->id_marca = $request->input("marca");
  
      // Upload e salvamento da imagem
      if ($request->hasFile('imagem')) {    
        $requestImage = $request->file('imagem');
        $extension = $requestImage->extension();
        $imageName = md5($requestImage->getClientOriginalName()) . "." . $extension;
        $requestImage->move(public_path('img/produtos'), $imageName);
        $produto->imagem = $imageName;          
      }      
      
      $produto->save();      
  
      return redirect("/produto"); 
  }  

    public function salvar_update(Request $request){        
        $id = $request->input("id");
        $produto = Produto::find($id);
        $produto->nome = $request->input("nome");
        $produto->id_categoria = $request->input("id_categoria");
        $produto->preco = $request->input("preco");
        $produto->quantidade = $request->input("quantidade");
        $produto->descricao = $request->input("descricao");
        $produto->id_marca = $request->input("marca");

        if ($request->hasFile('imagem')) {    
            $requestImage = $request->file('imagem');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName()) . "." . $extension;
            $requestImage->move(public_path('img/produtos'), $imageName);
            $produto->imagem = $imageName;          
          }      


        $produto->save();
        return redirect("/produto"); 
    }
}
