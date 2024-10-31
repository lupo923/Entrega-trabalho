@extends('TemplateAdmin.index')
@section('contents')

@php
    $titulo = "Inclusão de uma nova marca";
    $endpoint = "/marca/novo";
    $input_nome = "";
    $input_fantasia = "";
    $input_id = "";

    if(isset($marca)){
        $titulo = "Alteração da marca";
        $endpoint = "/marca/update";
        $input_nome = $marca['nome'];
        $input_fantasia = $marca['nome_fantasia'];
        $input_id = $marca["id"];
    }
@endphp

<h1 class="h3 mb-4 text-gray-800">{{$titulo}}</h1>
<div class="card">
        <div class="card-header">
            Cadastro de Marca
        </div>
        <div class="card-body">
            <form method="post" action="{{$endpoint}}">
                @CSRF
                <input type="hidden" name="id" value="{{$input_id}}">
                <label class="form-label">Nome da marca</label>
                <input class="form-control" name="nome" placeholder="Digite o nome da marca" value="{{$input_nome}}"> 

                <label class="form-label">Nome fantasia</label>
                <input class="form-control" name="nome_fantasia" placeholder="Digite o nome fantasia" value="{{$input_fantasia}}">

                <label class="form-label">Situação</label>
                <select class="form-control" name='situacao'>           
                <option value="1" selected>Ativo</option>
                <option value="0">Inativo</option>            
                </select>

                <br/>

                <input type="submit" class="btn btn-success" value="Salvar">
            </form>        
        </div>
</div>    
@endsection

<!-- 
    php artisan make:migration create_table_marca 
-->