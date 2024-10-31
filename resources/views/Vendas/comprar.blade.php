@php
    if(isset($produto)){             
        $input_nome = $produto["nome"];              
        $input_id = $produto["id"];         
        $input_preco = $produto["preco"];
        $input_quantidade = $produto["quantidade"];       
        $input_imagem = $produto["imagem"];        
    }    
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

<body>
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
    <section class="conteudo">

        <div class="produtos">
            <div class="card mb-1" style="max-width: 100%;">
                <div class="row g-0">
                    <div class="col-md-4">
                    <img src="{{ asset('img/produtos/' . $input_imagem) }}" class="img-fluid w-100" alt="...">

                    </div>
                    <div class="col-md-8">
                        <div class="card-body text-center">
                            <h2 class="card-title">
                                <p class="titulo">
                                {{$input_nome}}
                                </p>
                            </h2>
                            </br>
                            <h4>
                                <p class="card-text">
                                    Preço: R$ {{$input_preco}}
                            </h4>
                            </br>
                            <div class="d-grid gap-2 col-6 mx-auto">

                            <form action="{{ route('adicionar-ao-carrinho', ['id' => $input_id]) }}" method="get">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">🛒 Comprar</button>
                            </form>
                            
                            </div>
                            </br>
                            <div class="badge bg-danger">
                                Frete Grátis
                            </div>


                        </div>
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