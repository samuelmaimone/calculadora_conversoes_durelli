<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Limites de Representação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white text-center">
                        <h4 class="mb-0">Limites para {{ $bits }} Bits</h4>
                    </div>
                    <div class="card-body">
                        
                        <table class="table table-bordered table-striped text-center align-middle mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Representação</th>
                                    <th>Valor Mínimo</th>
                                    <th>Valor Máximo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Sem Sinal</td>
                                    <td>{{ number_format($semSinal['min'], 0, '', '.') }}</td>
                                    <td>{{ number_format($semSinal['max'], 0, '', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Sinal e Magnitude</td>
                                    <td>{{ number_format($magnitude['min'], 0, '', '.') }}</td>
                                    <td>{{ number_format($magnitude['max'], 0, '', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Complemento de 1</td>
                                    <td>{{ number_format($comp1['min'], 0, '', '.') }}</td>
                                    <td>{{ number_format($comp1['max'], 0, '', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Complemento de 2</td>
                                    <td>{{ number_format($comp2['min'], 0, '', '.') }}</td>
                                    <td>{{ number_format($comp2['max'], 0, '', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4 text-center">
                            <a href="/" class="btn btn-primary">Voltar ao Menu Principal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>