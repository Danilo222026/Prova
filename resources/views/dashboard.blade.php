<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','Sabor do Brasil')</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
 
    <main>
      <h1 class="text-center navbar-dark bg-primary">Sabor do Brasil</h1>
      <div class="container">
        <div class="row">
          <div class="col">
              <img class="rounded mx-auto d-block" src="{{ asset($usuario->foto) }}" alt="Foto do usuário" style="width: 150px; height: 150px; object-fit: cover;">
            <h5 class="text-center border-bottom border-dark">{{ $usuario->nome }}</h5>
          <div class="container">
           <div class="row">
            <div class="col">
               <h3 class="text-center">{{ $totalLikes ?? 0 }}</h3>
               <h6 class="text-center">Likes Totais</h6>
             </div>
              <div class="col">
                <h3 class="text-center">{{ $totalDislikes ?? 0 }}</h3>
                <h6 class="text-center">Dislikes Totais</h6>
             </div>
            </div>
           </div>
          </div>

          <div class="col-6 border-left border-right border-dark">
            <h5 class="text-center mb-4">Publicações</h5>
            <div class="d-flex flex-column align-items-center">
          @foreach($publicacoes as $publicacao)
<div class="border border-dark p-3 mb-4 w-75 text-center rounded">
    <h6>{{$publicacao->titulo_prato}}</h6>
    <img src="{{asset($publicacao->foto)}}" alt="{{$publicacao->titulo_prato}}" class="img-fluid mb-2" style="max-height: 200px; object-fit: cover;">
    <div class="row">
        <p class="col text-left">{{$publicacao->local}}</p>
        <p class="col text-right">{{$publicacao->cidade}}</p>
    </div>

    <div class="mb-2">
        <small class="text-muted">
            Likes: {{ $publicacao->likes }} | Dislikes: {{ $publicacao->dislikes }}
        </small>
    </div>

    <div class="btn-group" role="group">
        @auth
        <form method="POST" action="{{ route('like', $publicacao->id) }}">
            @csrf
            <button type="submit" class="btn btn-light">
                @if(session("liked_{$publicacao->id}"))
                    <img src="{{ asset('imagens/flecha_cima_cheia.svg') }}" alt="like" width="20">
                @else
                    <img src="{{ asset('imagens/flecha_cima_vazia.svg') }}" alt="like" width="20">
                @endif
            </button>
        </form>
        
        <form method="POST" action="{{ route('dislike', $publicacao->id) }}">
            @csrf
            <button type="submit" class="btn btn-light">
                @if(session("disliked_{$publicacao->id}"))
                    <img src="{{ asset('imagens/flecha_baixo_cheia.svg') }}" alt="dislike" width="20">
                @else
                    <img src="{{ asset('imagens/flecha_baixo_vazia.svg') }}" alt="dislike" width="20">
                @endif
            </button>
        </form>
        @else
        <button class="btn btn-light" disabled>
            <img src="{{ asset('imagens/flecha_cima_vazia.svg') }}" alt="like" width="20">
        </button>
        <button class="btn btn-light" disabled>
            <img src="{{ asset('imagens/flecha_baixo_vazia.svg') }}" alt="dislike" width="20">
        </button>
        @endauth
        
        <a href="{{ route('comentarios.toggle', $publicacao->id) }}" class="btn btn-light">
            <img src="{{ asset('imagens/chat.svg') }}" alt="chat">
            <small>({{ $publicacao->comentarios->count() }})</small>
        </a>
    </div>

    @if(session("show_comentarios_{$publicacao->id}"))
    <div class="mt-4 border-top pt-3">
        <h6>Comentários:</h6>

        <form method="POST" action="{{ route('comentario.store', $publicacao->id) }}" class="mb-3">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="texto" rows="2" placeholder="Adicione um comentário..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Comentar</button>
        </form>
            @foreach($publicacao->comentarios as $comentario)
            <div class="border-bottom pb-2 mb-2 text-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="mb-1 small">{{ $comentario->texto }}</p>
                    </div>
                    <div class="btn-group btn-group-sm ml-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                data-toggle="collapse" 
                                data-target="#editForm{{ $comentario->id }}">
                            <img src="{{ asset('imagens/lapis_editar.svg') }}" alt="Editar" width="14">
                        </button>
                        <form method="POST" action="{{ route('comentario.destroy', $comentario->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                    onclick="return confirm('Tem certeza que deseja excluir este comentário?')">
                                <img src="{{ asset('imagens/lixeira_deletar.svg') }}" alt="Excluir" width="14">
                            </button>
                        </form>
                    </div>
                </div>

                <div class="collapse mt-2" id="editForm{{ $comentario->id }}">
                    <form method="POST" action="{{ route('comentario.update', $comentario->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <textarea class="form-control" name="texto" rows="2" required>{{ $comentario->texto }}</textarea>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                            <button type="button" class="btn btn-secondary btn-sm" 
                                    data-toggle="collapse" 
                                    data-target="#editForm{{ $comentario->id }}">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
    </div>
    @endif
</div>
@endforeach
        </div>
          </div>
          <div class="col text-center">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn btn-danger btn-lg text-center">
                Sair
              </button>
            </form>
          </div>
        </div>
      </div>
    </main>

    <footer class="bg-dark text-white container-fluid sticky-footer">
      <div class="container">
        <div class="row">
          <div class="col">
            <p class="text-center">Sabor do Brasil</p>
          </div>
          <div class="col-6">
            <nav class="nav row">
              <a class="nav-link text-center col" href=""><img src="{{ asset('imagens/Instagram.svg') }}" alt="Insta"></a>
              <a class="nav-link text-center col" href=""><img src="{{ asset('imagens/Whatsapp.svg') }}" alt="Whatss"></a>
              <a class="nav-link text-center col" href=""><img src="{{ asset('imagens/Twitter.svg') }}" alt="Twitter"></a>
              <a class="nav-link text-center col" href=""><img src="{{ asset('imagens/Globe.svg') }}" alt="Goggle"></a>
            </nav>
          </div>
          <div class="col">
            <p>&copy; Direitos Autorais 2025</p>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>