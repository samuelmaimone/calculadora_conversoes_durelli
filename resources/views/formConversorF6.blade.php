<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conversão com Fracionários (F6)</title>
    @vite(['resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container d-flex justify-content-between">
                <a href="/" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('storage/imagens/logo.jpg') }}" width="50" height="50" alt="Logo">
                    <strong class="px-4">Calculadora de Bases</strong>
                </a>
            </div>
        </div>
    </header>

    <div class="container py-4">
        
        @if(isset($erro))
            <div class="alert alert-danger mb-4" role="alert">
                <strong>Erro:</strong> {{ $erro }}
            </div>
        @endif

        @if(isset($resultado))
            <div class="alert alert-success mb-2" role="alert">
                Resultado da conversão: <strong>{{ $resultado }}</strong> 
                <br><small>(Da Base {{ $baseOrigem }} para a Base {{ $baseDestino }})</small>
            </div>
        @endif

        @if(isset($truncamento) && $truncamento)
            <div class="alert alert-warning mb-4" role="alert">
                <strong>Aviso:</strong> O resultado é uma dízima ou ultrapassa o limite da calculadora e foi <b>truncado em 16 casas decimais</b>.
            </div>
        @endif

        <div class="mt-4 mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_f6">
                Fazer outra conversão
            </button>
            <a class="btn btn-danger" href="/">Voltar ao Menu</a>
        </div>
    </div>

    <div class="modal fade" id="modal_f6" tabindex="-1" aria-labelledby="modalF6Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF6Label">Conversor de Fracionários</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <form method="POST" action="/converter-f6">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="numero_origem" class="form-label">Número a ser convertido (ex: 10.625 ou 10,625):</label>
                            <input type="text" class="form-control" name="numero_origem" id="numero_origem" required>
                        </div>

                        <div class="mb-3">
                            <label for="base_origem" class="form-label">Base de Origem:</label>
                            <select class="form-select" name="base_origem" id="base_origem" required>
                                <option value="2">Binário</option>
                                <option value="8">Octal</option>
                                <option value="10" selected>Decimal</option>
                                <option value="16">Hexadecimal</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="base_destino" class="form-label">Base de Destino:</label>
                            <select class="form-select" name="base_destino" id="base_destino" required>
                                <option value="2" selected>Binário</option>
                                <option value="8">Octal</option>
                                <option value="10">Decimal</option>
                                <option value="16">Hexadecimal</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Converter</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</html>