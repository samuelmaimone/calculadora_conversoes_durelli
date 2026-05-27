<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calculadora</title>
    @vite(['resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <strong class="px-4">Calculadora</strong>
                </a>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        
        @if(isset($resultado))
            <div class="alert alert-success mb-4" role="alert">
                <strong>Resultado da conversão:</strong> {{ $resultado }}
            </div>
        @endif

        <div class="row justify-content-center">
            
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modal_f1">Decimal -> Binário/Octal/Hexa</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modal_f2">Binário/Octal/Hexa -> Decimal</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modal_f3">Binário -> Octal/Hexa</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modal_f4">Octal <-> Hexa (Via Binário)</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#modal_f6">Fracionários</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modal_f8">Processar CSV</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <a href="/quiz" class="btn btn-info w-100 text-white fw-bold">Modo Quiz</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal_f1" tabindex="-1" aria-labelledby="modalF1Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF1Label">Deseja converter para qual base?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <form method="POST" action="/converter">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="numero_decimal" class="form-label">Digite o número decimal:</label>
                            <input type="text" class="form-control" name="numero_decimal" id="numero_decimal" required>
                        </div>

                        <div class="mb-3">
                            <label for="bases" class="form-label">Selecione a base:</label>
                            <select class="form-select" name="bases" id="bases" required>
                                <option value="bin">Binário</option>
                                <option value="oct">Octal</option>
                                <option value="hex">Hexadecimal</option>
                            </select>
                        </div>
                        
                        <div class="form-check mt-3 mb-2">
                            <input class="form-check-input" type="checkbox" name="passo_a_passo" id="passo_a_passo_f1" value="1">
                            <label class="form-check-label fw-bold" for="passo_a_passo_f1">
                                Mostrar cálculo passo a passo
                            </label>
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

    <div class="modal fade" id="modal_f2" tabindex="-1" aria-labelledby="modalF2Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF2Label">Converter para Decimal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <form method="POST" action="/converter-para-decimal">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="numero_origem" class="form-label">Digite o número a ser convertido:</label>
                            <input type="text" class="form-control" name="numero_origem" id="numero_origem" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="base_origem" class="form-label">Qual é a base do número fornecido?</label>
                            <select class="form-select" name="base_origem" id="base_origem" required>
                                <option value="2">Binário</option>
                                <option value="8">Octal</option>
                                <option value="16">Hexadecimal</option>
                            </select>
                        </div>
                        <div class="form-check mt-3 mb-2">
                            <input class="form-check-input" type="checkbox" name="passo_a_passo" id="passo_a_passo_f2" value="1">
                            <label class="form-check-label fw-bold" for="passo_a_passo_f2">
                                Mostrar cálculo passo a passo
                            </label>
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

    <div class="modal fade" id="modal_f3" tabindex="-1" aria-labelledby="modalF3Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF3Label">Conversão por Agrupamento</h5>
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
                    
                    <div class="form-check mt-3 mb-2">
                        <input class="form-check-input" type="checkbox" name="passo_a_passo" id="passo_a_passo_f3" value="1">
                        <label class="form-check-label fw-bold" for="passo_a_passo_f3">Mostrar passo a passo</label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Converter</button>
                    </div>
                </form>

            </div>
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

                        <div class="form-check mt-3 mb-2">
                            <input class="form-check-input" type="checkbox" name="passo_a_passo" id="passo_a_passo_f4" value="1">
                            <label class="form-check-label fw-bold" for="passo_a_passo_f4">Mostrar passo a passo</label>
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
                            <label for="numero_origem" class="form-label">Número (ex: 10.625 ou 10,625):</label>
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

    <div class="modal fade" id="modal_f8" tabindex="-1" aria-labelledby="modalF8Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modalF8Label">Modo Batch (Processar CSV)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <form method="POST" action="/processar-csv" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="alert alert-info small">
                            <strong>Formato esperado do CSV:</strong><br>
                            O arquivo deve conter 3 colunas separadas por vírgula: <br>
                            <code>Número, Base de Origem, Base de Destino</code><br>
                            <em>Exemplo: 10, 10, 2</em>
                        </div>

                        <div class="mb-3">
                            <label for="arquivo_csv" class="form-label">Selecione o arquivo .csv:</label>
                            <input class="form-control" type="file" id="arquivo_csv" name="arquivo_csv" accept=".csv" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success">Processar e Baixar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</html>