<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class calculadoraController extends Controller
{
    public function converterBin(Request $requisicao) {
        $baseSelecionada = $requisicao->input('bases');
        $numeroDecimal = $requisicao->input('numero_decimal');
        $resultadoFinal = '';

        if ($baseSelecionada === 'bin') {
            if ($numeroDecimal == 0) {
                $resultadoFinal = '0';
            } else {
                $numeroTemporario = $numeroDecimal;
                while ($numeroTemporario > 0) {
                    $restoDivisao = $numeroTemporario % 2;
                    $resultadoFinal = $restoDivisao . $resultadoFinal; 
                    $numeroTemporario = intdiv($numeroTemporario, 2); 
                }
            }
        }

        return view('formConversorF1', [
            'resultado' => $resultadoFinal,
            'base' => $baseSelecionada
        ]);
    }

    public function converterParaDecimal(Request $requisicao) {
    $numeroOrigem = strtoupper($requisicao->input('numero_origem'));
    $baseOrigem = (int) $requisicao->input('base_origem'); 

    $caracteresInvalidos = false;
    for ($i = 0; $i < strlen($numeroOrigem); $i++) {
        $char = $numeroOrigem[$i];
        

        if ($baseOrigem == 2 && !($char >= '0' && $char <= '1')) {
            $caracteresInvalidos = true;
        }

        if ($baseOrigem == 8 && !($char >= '0' && $char <= '7')) {
            $caracteresInvalidos = true;
        }

        if ($baseOrigem == 16 && !($char >= '0' && $char <= '9' || $char >= 'A' && $char <= 'F')) {
            $caracteresInvalidos = true;
        }
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

        $resultadoSoma += $valorNumerico * ($baseOrigem ** $expoentePosicional);
        $expoentePosicional++;
    }

    return view('formConversorF2', [
        'resultado' => $resultadoSoma,
        'base' => 10
    ]);
}

public function converterAgrupamento(Request $requisicao) {
    $binario = $requisicao->input('numero_binario');
    $baseDestino = (int) $requisicao->input('base_destino');
    $tamanhoGrupo = ($baseDestino == 8) ? 3 : 4;

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
    }

    return view('formConversorF3', [
        'resultado' => $resultadoFinal,
        'base' => $baseDestino
    ]);
}

public function converterIntermediario(Request $requisicao) {
    $opcaoConversao = $requisicao->input('opcao_conversao');
    $numeroEntrada = strtoupper($requisicao->input('numero_entrada'));
    
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

        while (strlen($binarioIntermediario) % 4 !== 0) {
            $binarioIntermediario = '0' . $binarioIntermediario;
        }

        for ($i = 0; $i < strlen($binarioIntermediario); $i += 4) {
            $grupo = substr($binarioIntermediario, $i, 4);
            $digitoHexa = array_search($grupo, $mapaHexaBinario);
            $resultadoFinal .= $digitoHexa;
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

        while (strlen($binarioIntermediario) % 3 !== 0) {
            $binarioIntermediario = '0' . $binarioIntermediario;
        }
        for ($i = 0; $i < strlen($binarioIntermediario); $i += 3) {
            $grupo = substr($binarioIntermediario, $i, 3);
            $digitoOctal = array_search($grupo, $mapaOctalBinario);
            $resultadoFinal .= $digitoOctal;
        }
        $baseDestino = "Octal (8)";
    }

    $resultadoFinal = ltrim($resultadoFinal, '0');
    if ($resultadoFinal === '') {
        $resultadoFinal = '0';
    }

    return view('formConversorF4', [
        'resultado' => $resultadoFinal,
        'base' => $baseDestino
    ]);
}

}
