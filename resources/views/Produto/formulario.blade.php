@extends('TemplateAdmin.index')
@section('contents')

@php
    $titulo = "Cadastro de Produto";
    $endpoint = "/produto/novo";
    $input_nome = "";    
    $input_id = "";
    $input_preco = "";
    $input_quantidade = "";
    $input_id_categoria = "";
    $input_id_marca = "";
    $input_descricao = "";


    if(isset($produto)){
        $titulo = "Alteração do produto";
        $endpoint = "/produto/update";
        $input_nome = $produto["nome"];        
        $input_id = $produto["id"];
        $input_preco = $produto["preco"];
        $input_quantidade = $produto["quantidade"];
        $input_id_categoria = $produto["id_categoria"];
        $input_id_marca = $produto["id_marca"];
        $input_descricao = $produto["descricao"];
    }
@endphp

<h1 class="h3 mb-4 text-gray-800">{{$titulo}}</h1>
<div class="card">
        <div class="card-header">
            Produto
        </div>
        <div class="card-body">
            <form method="post" action="{{$endpoint}}" enctype="multipart/form-data">
                @CSRF
                <input type="hidden" name="id" value="{{$input_id}}">
                <label class="form-label">Nome da produto</label>
                <input class="form-control" name="nome" placeholder="Nome do produto" value="{{$input_nome}}"> 

                <label class="form-label">Categoria</label>
                <select class="form-control" name='id_categoria'>           
                    @foreach($categorias as $dado)
                        <option value='{{$dado["id"]}}' {{$dado["id"] == $input_id_categoria  ? 'selected' : ''}}>{{$dado['nome']}}</option>
                    @endforeach
                </select>  
                <label class="form-label">Marcas</label>
                <select class="form-control" name='marca'>           
                    @foreach($marcas as $dado)
                        <option value='{{$dado["id"]}}' {{$dado["id"] == $input_id_marca  ? 'selected' : ''}}>{{$dado['nome']}}</option>
                    @endforeach
                </select>
                 

                <label class="form-label">Preço</label>
                <input class="form-control" name="preco" placeholder="Preço do produto" value="{{$input_preco}}"> 

                <label class="form-label">Quantidade</label>
                <input class="form-control" name="quantidade" placeholder="Quantidade do produto" value="{{$input_quantidade}}"> 

                <label class="form-label">Descricao</label>
                <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição do item"> {{$input_descricao}}</textarea>
               
                <label class="form-label">Imagem</label>
                <input input class="form-control-file" id="imagem" type="file" name="imagem" accept="image/*">

                <br/>
                <input type="submit" class="btn btn-success" value="Salvar">
            </form>  
            
        </div>
</div>  
<script>
         ClassicEditor
                 .create( document.querySelector( '#descricao' ) )
                 .then( editor => {
                         console.log( editor );
                 } )
                 .catch( error => {
                         console.error( error );
                                } );
</script>
@endsection
