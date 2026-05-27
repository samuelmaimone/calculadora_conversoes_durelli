<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class calculadoraController extends Controller
{
    public function converterBin(Request $requisicao) {
        $baseSelecionada = $requisicao->input('bases');
        $numeroDecimal = $requisicao->input('numero_decimal');
        $mostrarPassoAPasso = $requisicao->has('passo_a_passo');
        
        if (strpos($numeroDecimal, ',') !== false || strpos($numeroDecimal, '.') !== false) {
            return view('formConversorF1')->with('erro', "Entrada inválida! O Conversor Base aceita apenas números inteiros. Para valores com vírgula, volte ao menu e utilize a calculadora de Fracionários (F6).");
        }

        $resultadoFinal = '';
        $trace = [];
        
        $divisor = 2;
        if ($baseSelecionada === 'oct') $divisor = 8;
        if ($baseSelecionada === 'hex') $divisor = 16;

        if ($numeroDecimal == 0) {
            $resultadoFinal = '0';
        } else {
            $numeroTemporario = $numeroDecimal;
            while ($numeroTemporario > 0) {
                $restoDivisao = $numeroTemporario % $divisor;
                $quociente = intdiv($numeroTemporario, $divisor);
                
                if ($mostrarPassoAPasso) {
                    $trace[] = [
                        'dividendo' => $numeroTemporario,
                        'divisor' => $divisor,
                        'quociente' => $quociente,
                        'resto' => $restoDivisao
                    ];
                }

                $charResto = ($restoDivisao >= 10) ? chr($restoDivisao - 10 + ord('A')) : (string)$restoDivisao;
                $resultadoFinal = $charResto . $resultadoFinal; 
                $numeroTemporario = $quociente; 
            }
        }

        return view('formConversorF1', [
            'resultado' => $resultadoFinal,
            'base' => $baseSelecionada,
            'mostrarPassoAPasso' => $mostrarPassoAPasso,
            'trace' => $trace
        ]);
    }

    public function converterParaDecimal(Request $requisicao) {
        $numeroOrigem = strtoupper($requisicao->input('numero_origem'));
        $baseOrigem = (int) $requisicao->input('base_origem'); 
        $mostrarPassoAPasso = $requisicao->has('passo_a_passo');
        $trace = [];

        $caracteresInvalidos = false;
        for ($i = 0; $i < strlen($numeroOrigem); $i++) {
            $char = $numeroOrigem[$i];
            if ($baseOrigem == 2 && !($char >= '0' && $char <= '1')) $caracteresInvalidos = true;
            if ($baseOrigem == 8 && !($char >= '0' && $char <= '7')) $caracteresInvalidos = true;
            if ($baseOrigem == 16 && !($char >= '0' && $char <= '9' || $char >= 'A' && $char <= 'F')) $caracteresInvalidos = true;
        }

        if ($caracteresInvalidos) {
            return view('formConversorF2')->with('erro', "O valor digitado '$numeroOrigem' contém caracteres inválidos para a base $baseOrigem.");
        }

        $resultadoSoma = 0;
        $expoentePosicional = 0;

        for ($indice = strlen($numeroOrigem) - 1; $indice >= 0; $indice--) {
            $caractereAtual = $numeroOrigem[$indice];
            $valorNumerico = 0;

            if ($caractereAtual >= '0' && $caractereAtual <= '9') {
                $valorNumerico = ord($caractereAtual) - ord('0');
            } elseif ($caractereAtual >= 'A' && $caractereAtual <= 'F') {
                $valorNumerico = ord($caractereAtual) - ord('A') + 10;
            }

            $valorMultiplicado = $valorNumerico * ($baseOrigem ** $expoentePosicional);
            
            if ($mostrarPassoAPasso) {
                $trace[] = [
                    'digito' => $caractereAtual,
                    'valor' => $valorNumerico,
                    'expoente' => $expoentePosicional,
                    'parcial' => $valorMultiplicado
                ];
            }

            $resultadoSoma += $valorMultiplicado;
            $expoentePosicional++;
        }

        if ($mostrarPassoAPasso) {
            $trace = array_reverse($trace);
        }

        return view('formConversorF2', [
            'resultado' => $resultadoSoma,
            'base' => 10,
            'mostrarPassoAPasso' => $mostrarPassoAPasso,
            'trace' => $trace
        ]);
    }

    public function converterAgrupamento(Request $requisicao) {
        $binario = $requisicao->input('numero_binario');
        $baseDestino = (int) $requisicao->input('base_destino');
        $tamanhoGrupo = ($baseDestino == 8) ? 3 : 4;
        $mostrarPassoAPasso = $requisicao->has('passo_a_passo');
        $trace = [];

        for ($i = 0; $i < strlen($binario); $i++) {
            if ($binario[$i] !== '0' && $binario[$i] !== '1') {
                return view('formConversorF3')->with('erro', "Entrada inválida. Para o Requisito F3, forneça apenas dígitos binários (0 ou 1).");
            }
        }

        while (strlen($binario) % $tamanhoGrupo !== 0) {
            $binario = '0' . $binario;
        }

        $resultadoFinal = "";
        
        for ($i = 0; $i < strlen($binario); $i += $tamanhoGrupo) {
            $grupo = substr($binario, $i, $tamanhoGrupo);
            
            if ($tamanhoGrupo == 3) {
                $mapeamento = [
                    "000"=>"0", "001"=>"1", "010"=>"2", "011"=>"3",
                    "100"=>"4", "101"=>"5", "110"=>"6", "111"=>"7"
                ];
            } 
            else {
                $mapeamento = [
                    "0000"=>"0", "0001"=>"1", "0010"=>"2", "0011"=>"3",
                    "0100"=>"4", "0101"=>"5", "0110"=>"6", "0111"=>"7",
                    "1000"=>"8", "1001"=>"9", "1010"=>"A", "1011"=>"B",
                    "1100"=>"C", "1101"=>"D", "1110"=>"E", "1111"=>"F"
                ];
            }
            
            $resultadoFinal .= $mapeamento[$grupo];
            if ($mostrarPassoAPasso) {
                $trace[] = ['grupo' => $grupo, 'valor' => $mapeamento[$grupo]];
            }
        }

        return view('formConversorF3', [
            'resultado' => $resultadoFinal,
            'base' => $baseDestino,
            'mostrarPassoAPasso' => $mostrarPassoAPasso,
            'trace' => $trace
        ]);
    }

    public function converterIntermediario(Request $requisicao) {
        $opcaoConversao = $requisicao->input('opcao_conversao');
        $numeroEntrada = strtoupper($requisicao->input('numero_entrada'));
        $mostrarPassoAPasso = $requisicao->has('passo_a_passo');
        $trace = [];
        
        $mapaOctalBinario = [
            '0' => '000', '1' => '001', '2' => '010', '3' => '011',
            '4' => '100', '5' => '101', '6' => '110', '7' => '111'
        ];
        
        $mapaHexaBinario = [
            '0' => '0000', '1' => '0001', '2' => '0010', '3' => '0011',
            '4' => '0100', '5' => '0101', '6' => '0110', '7' => '0111',
            '8' => '1000', '9' => '1001', 'A' => '1010', 'B' => '1011',
            'C' => '1100', 'D' => '1101', 'E' => '1110', 'F' => '1111'
        ];

        $binarioIntermediario = "";
        $resultadoFinal = "";

        if ($opcaoConversao === 'oct_to_hex') {
            for ($i = 0; $i < strlen($numeroEntrada); $i++) {
                $caractere = $numeroEntrada[$i];
                if (!($caractere >= '0' && $caractere <= '7')) {
                    return view('formConversorF4')->with('erro', "Entrada inválida. O número fornecido não é um Octal válido.");
                }
                $binarioIntermediario .= $mapaOctalBinario[$caractere];
            }
            
            if ($mostrarPassoAPasso) {
                $trace[] = ['etapa' => 'Conversão para Binário', 'valor' => $binarioIntermediario];
            }

            while (strlen($binarioIntermediario) % 4 !== 0) {
                $binarioIntermediario = '0' . $binarioIntermediario;
            }

            for ($i = 0; $i < strlen($binarioIntermediario); $i += 4) {
                $grupo = substr($binarioIntermediario, $i, 4);
                $digitoHexa = array_search($grupo, $mapaHexaBinario);
                $resultadoFinal .= $digitoHexa;
            }
            
            if ($mostrarPassoAPasso) {
                $trace[] = ['etapa' => 'Conversão para Hexadecimal', 'valor' => $resultadoFinal];
            }
            
            $baseDestino = "Hexadecimal (16)";
        } 
        else {
            for ($i = 0; $i < strlen($numeroEntrada); $i++) {
                $caractere = $numeroEntrada[$i];
                if (!($caractere >= '0' && $caractere <= '9' || $caractere >= 'A' && $caractere <= 'F')) {
                    return view('formConversorF4')->with('erro', "Entrada inválida. O número fornecido não é um Hexadecimal válido.");
                }
                $binarioIntermediario .= $mapaHexaBinario[$caractere];
            }
            
            if ($mostrarPassoAPasso) {
                $trace[] = ['etapa' => 'Conversão para Binário', 'valor' => $binarioIntermediario];
            }

            while (strlen($binarioIntermediario) % 3 !== 0) {
                $binarioIntermediario = '0' . $binarioIntermediario;
            }
            
            for ($i = 0; $i < strlen($binarioIntermediario); $i += 3) {
                $grupo = substr($binarioIntermediario, $i, 3);
                $digitoOctal = array_search($grupo, $mapaOctalBinario);
                $resultadoFinal .= $digitoOctal;
            }
            
            if ($mostrarPassoAPasso) {
                $trace[] = ['etapa' => 'Conversão para Octal', 'valor' => $resultadoFinal];
            }
            
            $baseDestino = "Octal (8)";
        }

        $resultadoFinal = ltrim($resultadoFinal, '0');
        if ($resultadoFinal === '') {
            $resultadoFinal = '0';
        }

        return view('formConversorF4', [
            'resultado' => $resultadoFinal,
            'base' => $baseDestino,
            'mostrarPassoAPasso' => $mostrarPassoAPasso,
            'trace' => $trace
        ]);
    }

    public function suportarFracionarios(Request $requisicao) {
        $numeroOrigem = strtoupper(str_replace(',', '.', $requisicao->input('numero_origem')));
        $baseOrigem = (int) $requisicao->input('base_origem'); 
        $baseDestino = (int) $requisicao->input('base_destino');

        $partes = explode('.', $numeroOrigem);
        $strInteiraOrigem = $partes[0] !== '' ? $partes[0] : '0';
        $strFracaoOrigem = isset($partes[1]) ? $partes[1] : '';

        $decimalInteiro = 0;
        $decimalFracao = 0.0;

        $expoente = 0;
        for ($i = strlen($strInteiraOrigem) - 1; $i >= 0; $i--) {
            $char = $strInteiraOrigem[$i];
            $valorNumerico = ($char >= 'A' && $char <= 'F') ? ord($char) - ord('A') + 10 : ord($char) - ord('0');
            $decimalInteiro += $valorNumerico * ($baseOrigem ** $expoente);
            $expoente++;
        }

        for ($i = 0; $i < strlen($strFracaoOrigem); $i++) {
            $char = $strFracaoOrigem[$i];
            $valorNumerico = ($char >= 'A' && $char <= 'F') ? ord($char) - ord('A') + 10 : ord($char) - ord('0');
            $expoenteNegativo = -($i + 1);
            $decimalFracao += $valorNumerico * ($baseOrigem ** $expoenteNegativo);
        }

        $resultadoInteiro = '';
        $resultadoFracao = '';
        $houveTruncamento = false;

        if ($decimalInteiro == 0) {
            $resultadoInteiro = '0';
        } else {
            $tempInteiro = $decimalInteiro;
            while ($tempInteiro > 0) {
                $resto = $tempInteiro % $baseDestino;
                $charResto = ($resto >= 10) ? chr($resto - 10 + ord('A')) : (string)$resto;
                $resultadoInteiro = $charResto . $resultadoInteiro;
                $tempInteiro = intdiv($tempInteiro, $baseDestino);
            }
        }

        $tempFracao = $decimalFracao;
        $limiteCasas = 16;
        
        for ($i = 0; $i < $limiteCasas; $i++) {
            if ($tempFracao <= 0.0000000001) {
                break; 
            }

            $tempFracao = $tempFracao * $baseDestino;
            $digitoInteiro = (int) $tempFracao; 
            
            $charDigito = ($digitoInteiro >= 10) ? chr($digitoInteiro - 10 + ord('A')) : (string)$digitoInteiro;
            $resultadoFracao .= $charDigito;

            $tempFracao = $tempFracao - $digitoInteiro; 
        }

        if ($tempFracao > 0.0000000001) {
            $houveTruncamento = true;
        }

        $resultadoFinal = $resultadoInteiro;
        if ($resultadoFracao !== '') {
            $resultadoFinal .= ',' . $resultadoFracao;
        }

        return view('formConversorF6', [
            'resultado' => $resultadoFinal,
            'baseOrigem' => $baseOrigem,
            'baseDestino' => $baseDestino,
            'truncamento' => $houveTruncamento
        ]);
    }

    public function processarBatchCsv(Request $requisicao) {
        // Valida se o usuário realmente enviou um arquivo CSV
        $requisicao->validate([
            'arquivo_csv' => 'required|mimes:csv,txt|max:2048',
        ]);

        $arquivo = $requisicao->file('arquivo_csv');
        $leitor = fopen($arquivo->getRealPath(), "r");

        $escritor = fopen('php://memory', 'w');
        
        fputcsv($escritor, ['Numero Origem', 'Base Origem', 'Base Destino', 'Resultado Convertido']);

        $primeiraLinha = true;

        while (($linha = fgetcsv($leitor, 1000, ",")) !== FALSE) {
            // Pula a primeira linha se for um cabeçalho com letras
            if ($primeiraLinha && !is_numeric(trim($linha[1] ?? ''))) {
                $primeiraLinha = false;
                continue;
            }
            $primeiraLinha = false;
            
            if (count($linha) >= 3) {
                $numero = trim($linha[0]);
                $baseOrigem = (int) trim($linha[1]);
                $baseDestino = (int) trim($linha[2]);

                $resultado = strtoupper(base_convert($numero, $baseOrigem, $baseDestino));

                fputcsv($escritor, [$numero, $baseOrigem, $baseDestino, $resultado]);
            }
        }

        fclose($leitor);
        
        rewind($escritor);
        $conteudoFinal = stream_get_contents($escritor);
        fclose($escritor);

        return response($conteudoFinal)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="resultados_convertidos.csv"');
    }

    public function iniciarQuiz() {
        $bases = [2, 8, 10, 16];
        $baseOrigem = $bases[array_rand($bases)];
        
        do {
            $baseDestino = $bases[array_rand($bases)];
        } while ($baseOrigem == $baseDestino);

        $numeroDecimal = rand(10, 255);
        $numeroSorteado = strtoupper(base_convert($numeroDecimal, 10, $baseOrigem));

        return view('quizF9', [
            'numeroOrigem' => $numeroSorteado,
            'baseOrigem' => $baseOrigem,
            'baseDestino' => $baseDestino
        ]);
    }

    public function verificarQuiz(Request $requisicao) {
        $numeroOrigem = $requisicao->input('numero_origem');
        $baseOrigem = (int) $requisicao->input('base_origem');
        $baseDestino = (int) $requisicao->input('base_destino');
        $respostaUsuario = strtoupper(trim($requisicao->input('resposta_usuario')));

        $respostaCorreta = strtoupper(base_convert($numeroOrigem, $baseOrigem, $baseDestino));
        
        $acertou = ($respostaUsuario === $respostaCorreta);

        return view('quizF9', [
            'numeroOrigem' => $numeroOrigem,
            'baseOrigem' => $baseOrigem,
            'baseDestino' => $baseDestino,
            'respostaUsuario' => $respostaUsuario,
            'respostaCorreta' => $respostaCorreta,
            'acertou' => $acertou
        ]);
    }

    public function calcularLimites(Request $requisicao) {
        $k = (int) $requisicao->input('quantidade_bits');

        if ($k < 1 || $k > 64) {
            return redirect('/')->with('erro', 'Por favor, insira um valor entre 1 e 64 bits.');
        }

        $semSinalMax = bcpow('2', (string)$k) - 1;
        $semSinalMin = 0;

        $magnitudeMax = bcpow('2', (string)($k - 1)) - 1;
        $magnitudeMin = -$magnitudeMax;

        $comp2Max = $magnitudeMax; 
        $comp2Min = bcpow('2', (string)($k - 1)) * -1; 

        return view('formConversorF10', [
            'bits' => $k,
            'semSinal' => ['min' => $semSinalMin, 'max' => $semSinalMax],
            'magnitude' => ['min' => $magnitudeMin, 'max' => $magnitudeMax],
            'comp1' => ['min' => $magnitudeMin, 'max' => $magnitudeMax],
            'comp2' => ['min' => $comp2Min, 'max' => $comp2Max]
        ]);
    }
}
    