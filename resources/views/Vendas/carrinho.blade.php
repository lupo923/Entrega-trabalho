@php
use App\Classes\Carrinho;

$limpar = 0;
$remove = 2;
$subtotal = 0;
$subtotalFormatado = 0.00;
$totalFinalFormatado = 0.00;

    if (request()->has('remove')) {
        $remove = request()->input('remove');
    }

    if (request()->has('limpar')) {
        $limpar = request()->input('limpar');
    }

    $carrinho = session('carrinho', []);

    if (request()->has('id')) {
        $item = new Carrinho();
        $item->setId(request()->input('id'));
        $item->setNome(request()->input('nome'));
        $item->setPreco(request()->input('preco'));
        $item->setImagem(request()->input('imagem'));
    }

    $titulo = isset($produto) ? "Alteração do produto" : null;
    $endpoint = "/produto/update";
    $input_nome = isset($produto) ? $produto["nome"] : null;
    $input_id = isset($produto) ? $produto["id"] : null;
    $input_preco = isset($produto) ? $produto["preco"] : null;
    $input_quantidade = isset($produto) ? $produto["quantidade"] : null;
    $input_id_categoria = isset($produto) ? $produto["id_categoria"] : null;
    $input_id_marca = isset($produto) ? $produto["id_marca"] : null;
    $input_descricao = isset($produto) ? $produto["descricao"] : null;
    $input_imagem = isset($produto) ? $produto["imagem"] : null;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type='text/css' href="{{ asset('css/estilo.css') }}">
</head>
<body class="carrinho_compras">
<section class="barra_navegacao">
<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link active" href="/vendas">Inicio</a>
        </li>       
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Categorias
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach($categorias as $dado)
              <a class="dropdown-item" href="/vendas/categoria/{{$dado['id']}}">{{$dado["nome"]}}</a>
            @endforeach                
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Marcas
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach($marcas as $dado)
              <a class="dropdown-item" href="/vendas/marca/{{$dado['id']}}">{{$dado["nome"]}}</a>
            @endforeach 
            </div>
          </li>
      </ul>      
      <span class="navbar-text">
        <a class="btn btn-outline-light" href="/vendas/exibir-carrinho">🛒 Carrinho</a>
      </span>
    </div>
  </div>
</nav>
    </section>
    <section class="conteudo_carrinho">

        <div class="container">
            <div class="row">
                <div class="col-10">
                    <table class="table caption-top">
                        <caption>
                            <h1 class="title_carrinho">🛒 Meu Carrinho</h1>
                        </caption>
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Produto</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Preço Unitário</th>
                                <th scope="col">Total Produto</th>
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($carrinho as $produto)
    <tr>
        <td><img src="{{ asset('img/produtos/' . $produto['imagem']) }}"></td>
        <td>{{ $produto['nome'] }}</td>
        <td>
            <a href="/vendas/carrinho/remover/{{$produto['id']}}" class="hiperlink">➖</a>
            {{ $produto['quantidade'] }}
            <a href="/vendas/carrinho/{{$produto['id']}}" class="hiperlink"> ➕</a>
        </td>
        <td>R$ {{ $produto['preco'] }}</td>
        <td>R$ {{ $total = $produto['preco'] * $produto['quantidade'] }}</td>
        <td><a href="/vendas/carrinho/excluir/{{$produto['id']}}" class="hiperlink">🗑️</a></td>
    </tr>
    <?php
        $subtotal += (float)$total; 
        $totalFinal = $subtotal - ($subtotal * 0.1);                                         
        $subtotalFormatado = number_format($subtotal, 2);                              
        $totalFinalFormatado = number_format($totalFinal, 2);
    ?>
@endforeach
</tbody>
    

    </table>
    <div id="finalizarCompra">
        <form action="/vendas/finalizar-compra" method="post">
            @csrf   
            <div class="mb-3">
                <label for="email" class="form-label" id="labelEmail">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>    
            <button type="submit" class="btn btn-success btn-lg">✔️ Finalizar Compra</button>
        </form>
    </div>
                </div>
                <div class="col-2">
                    <caption>
                        <h1 class="title_resumo">Resumo</h1>
                    </caption>
                    <div class="card" style="width: 18rem;">                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i>Subtotal</i>: R$<?php echo $subtotalFormatado; ?></li>
                            <li class="list-group-item"><p class="desconto"><b>*10% de desconto*</b></p></li>                            
                            
                        </ul>
                        <ul class="list-group list-group-flush">                            
                            <li class="list-group-item"><b><i>Total:</i> R$<?php echo $totalFinalFormatado ?></b></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

                            

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>
</html>
