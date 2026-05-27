<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modo Quiz (F9) - Calculadora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <div class="card shadow">
                    <div class="card-header bg-info text-white text-center">
                        <h4 class="mb-0">Modo Quiz</h4>
                    </div>
                    
                    <div class="card-body text-center p-4">
                        
                        @if(isset($acertou))
                            
                            @if($acertou)
                                <div class="alert alert-success fs-4">Parabéns! Você Acertou!</div>
                            @else
                                <div class="alert alert-danger fs-5">Que pena, você errou!</div>
                            @endif

                            <p class="fs-5 mt-4">
                                A conversão de <strong>{{ $numeroOrigem }}</strong> (Base {{ $baseOrigem }}) 
                                para a Base {{ $baseDestino }} é:
                            </p>
                            
                            <h2 class="text-primary fw-bold">{{ $respostaCorreta }}</h2>
                            
                            @if(!$acertou)
                                <p class="text-muted mt-2">Sua resposta foi: <em><del>{{ $respostaUsuario }}</del></em></p>
                            @endif

                            <div class="mt-4">
                                <a href="/quiz" class="btn btn-success me-2">Gerar Nova Pergunta</a>
                                <a href="/" class="btn btn-secondary">Voltar ao Menu</a>
                            </div>

                        @else
                            <h5 class="text-muted mb-4">Teste seus conhecimentos!</h5>
                            
                            <p class="fs-5">Converta o número abaixo:</p>
                            <h1 class="display-4 fw-bold text-dark mb-2">{{ $numeroOrigem }}</h1>
                            <p class="badge bg-secondary fs-6 mb-4">Da Base {{ $baseOrigem }} para a Base {{ $baseDestino }}</p>

                            <form action="/quiz" method="POST">
                                @csrf
                                <input type="hidden" name="numero_origem" value="{{ $numeroOrigem }}">
                                <input type="hidden" name="base_origem" value="{{ $baseOrigem }}">
                                <input type="hidden" name="base_destino" value="{{ $baseDestino }}">
                                
                                <div class="mb-4">
                                    <input type="text" class="form-control form-control-lg text-center" name="resposta_usuario" placeholder="Digite sua resposta aqui..." required autocomplete="off" autofocus>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg w-100">Verificar Resposta</button>
                            </form>

                            <div class="mt-3">
                                <a href="/" class="text-decoration-none text-muted">Voltar ao Menu Principal</a>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>