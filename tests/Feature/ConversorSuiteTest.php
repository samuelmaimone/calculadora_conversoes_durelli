<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConversorSuiteTest extends TestCase
{
    public function executar_suite_completa_f1_a_f10()
    {
        $this->post('/converter-bin', ['numero_decimal' => 10, 'bases' => 'bin'])->assertStatus(200);
        $this->post('/converter-bin', ['numero_decimal' => 8, 'bases' => 'oct'])->assertStatus(200);
        $this->post('/converter-bin', ['numero_decimal' => 15, 'bases' => 'hex'])->assertStatus(200);

        $this->post('/converter-para-decimal', ['numero_origem' => '1010', 'base_origem' => 2])->assertStatus(200);
        $this->post('/converter-para-decimal', ['numero_origem' => '12', 'base_origem' => 8])->assertStatus(200);
        $this->post('/converter-para-decimal', ['numero_origem' => 'F', 'base_origem' => 16])->assertStatus(200);

        $this->post('/converter-agrupamento', ['numero_binario' => '101010', 'base_destino' => 8])->assertStatus(200);
        $this->post('/converter-agrupamento', ['numero_binario' => '1111', 'base_destino' => 16])->assertStatus(200);
        $this->post('/converter-agrupamento', ['numero_binario' => '001', 'base_destino' => 8])->assertStatus(200);

        $this->post('/converter-intermediario', ['numero_entrada' => '7', 'opcao_conversao' => 'oct_to_hex'])->assertStatus(200);
        $this->post('/converter-intermediario', ['numero_entrada' => 'A', 'opcao_conversao' => 'hex_to_oct'])->assertStatus(200);
        $this->post('/converter-intermediario', ['numero_entrada' => '1', 'opcao_conversao' => 'oct_to_hex'])->assertStatus(200);

        $this->post('/converter-n-m', ['num' => '10', 'origem' => 10, 'destino' => 2])->assertStatus(200);
        $this->post('/converter-n-m', ['num' => '7', 'origem' => 8, 'destino' => 16])->assertStatus(200);
        $this->post('/converter-n-m', ['num' => '1', 'origem' => 2, 'destino' => 10])->assertStatus(200);

        $this->post('/suportar-fracionarios', ['numero_origem' => '10,5', 'base_origem' => 10, 'base_destino' => 2])->assertStatus(200);
        $this->post('/suportar-fracionarios', ['numero_origem' => '0,25', 'base_origem' => 10, 'base_destino' => 8])->assertStatus(200);
        $this->post('/suportar-fracionarios', ['numero_origem' => '1,1', 'base_origem' => 2, 'base_destino' => 10])->assertStatus(200);

        $this->post('/converter-bin', ['numero_decimal' => 10, 'bases' => 'bin', 'passo_a_passo' => 1])->assertStatus(200);
        $this->post('/converter-agrupamento', ['numero_binario' => '111', 'base_destino' => 8, 'passo_a_passo' => 1])->assertStatus(200);
        $this->post('/suportar-fracionarios', ['numero_origem' => '1,5', 'base_origem' => 10, 'base_destino' => 2, 'passo_a_passo' => 1])->assertStatus(200);

        $this->get('/quiz')->assertStatus(200);
        $this->post('/quiz', ['numero_origem' => '10', 'base_origem' => 10, 'base_destino' => 2, 'resposta_usuario' => '1010'])->assertStatus(200);

        $this->post('/limites', ['quantidade_bits' => 8])->assertStatus(200);
        $this->post('/limites', ['quantidade_bits' => 16])->assertStatus(200);
        $this->post('/limites', ['quantidade_bits' => 32])->assertStatus(200);
    }
}