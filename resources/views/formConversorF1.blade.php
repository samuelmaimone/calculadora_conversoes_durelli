<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conversor de Bases</title>
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
        @if(isset($resultado))
            <div class="alert alert-success mb-4" role="alert">
                Resultado da conversão: {{ $resultado }}
            </div>
        @endif

        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_conversao">
                Fazer outra conversão
            </button>
            <a class="btn btn-danger" href="/">Cancelar</a>
        </div>
    </div>

    <div class="modal fade" id="modal_conversao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja converter para qual base?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <form method="POST" action="/converter">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="numero_decimal" class="form-label">Digite o número decimal:</label>
                            <input type="number" class="form-control" name="numero_decimal" id="numero_decimal" required>
                        </div>

                        <div class="mb-3">
                            <label for="bases" class="form-label">Selecione a base:</label>
                            <select class="form-select" name="bases" id="bases" required>
                                <option value="bin">Binário</option>
                                <option value="oct">Octal</option>
                                <option value="hex">Hexadecimal</option>
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