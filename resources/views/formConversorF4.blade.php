<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conversão via Intermediário</title>
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
            <div class="alert alert-success mb-4" role="alert">
                Resultado da conversão via intermediário: <strong>{{ $resultado }}</strong> (Base {{ $base }})
            </div>
        @endif

        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_f4">
                Fazer outra conversão
            </button>
            <a class="btn btn-danger" href="/">Cancelar</a>
        </div>
    </div>

    <div class="modal fade" id="modal_f4" tabindex="-1" aria-labelledby="modalF4Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF4Label">Conversão via Intermediário (F4)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <form method="POST" action="/converter-f4">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="numero_entrada" class="form-label">Digite o número a ser convertido:</label>
                            <input type="text" class="form-control" name="numero_entrada" id="numero_entrada" required>
                        </div>

                        <div class="mb-3">
                            <label for="opcao_conversao" class="form-label">Selecione o tipo de conversão:</label>
                            <select class="form-select" name="opcao_conversao" id="opcao_conversao" required>
                                <option value="oct_to_hex">Octal para Hexadecimal</option>
                                <option value="hex_to_oct">Hexadecimal para Octal</option>
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