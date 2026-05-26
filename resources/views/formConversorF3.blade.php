<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conversão por Agrupamento</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    
    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('storage/imagens/logo.jpg') }}" width="50" height="50" viewBox="0 0 54 54" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <strong class="px-4">Calculadora de Bases</strong>
                </a>
            </div>
        </div>
    </header>

    <div class="container py-4">
        
        @if(isset($erro))
            <div class="alert alert-danger mb-4" role="alert">
                Erro: {{ $erro }}
            </div>
        @endif

        @if(isset($resultado))
            <div class="alert alert-success mb-4" role="alert">
                Resultado da conversão por agrupamento: {{ $resultado }} (Base {{ $base }})
            </div>
        @endif

        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_f3">
                Fazer outra conversão
            </button>
            <a class="btn btn-danger" href="/">Cancelar</a>
        </div>
    </div>

    <div class="modal fade" id="modal_f3" tabindex="-1" aria-labelledby="modalF3Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF3Label">Binário para Octal/Hexa (Agrupamento)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <form method="POST" action="/converter-f3">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="numero_binario" class="form-label">Digite o número binário:</label>
                            <input type="text" class="form-control" name="numero_binario" id="numero_binario" required>
                        </div>

                        <div class="mb-3">
                            <label for="base_destino" class="form-label">Converter para qual base?</label>
                            <select class="form-select" name="base_destino" id="base_destino" required>
                                <option value="8">Octal (Agrupar 3 bits)</option>
                                <option value="16">Hexadecimal (Agrupar 4 bits)</option>
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