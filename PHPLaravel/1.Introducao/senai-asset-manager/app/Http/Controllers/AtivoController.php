<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AtivoController extends Controller
{
    /**
     * Método index() - Retorna a view com as métricas mockadas
     */
    public function index(): View
    {
        $metricas = [
            "totalAtivos"    => 42,
            "emOperacao"     => 37,
            "emManutencao"   => 4,
            "parados"        => 1,
            "taxaEficiencia" => 88.5
        ];

        return view("ativos.index", [
            "metricas" => $metricas,
            "titulo" => "Painel Geral de Ativos Industriais"
        ]);
    }

    // Método para retornar o status do servidor em JSON
    public function status(): JsonResponse
    {
        return response()->json([
            "plataforma" => config("app.name"),
            "ambiente" => config("app.env"),
            "version_php" => PHP_VERSION,
            "status" => "ONLINE",
            "timestamp" => now()->toIso8601String()
        ]);
    }

    // Método para retornar os setores da fábrica em JSON
    public function setores(): JsonResponse
    {
        $setores = [
            [
                "nome" => "Usinagem",
                "quantidade_maquinas" => 15,
                "eficiencia_media" => 92.5
            ],
            [
                "nome" => "Estamparia",
                "quantidade_maquinas" => 10,
                "eficiencia_media" => 88.7
            ],
            [
                "nome" => "Montagem Robótica",
                "quantidade_maquinas" => 8,
                "eficiencia_media" => 95.3
            ]
        ];

        return response()->json([
            "setores" => $setores
        ]);
    }

    // Método para detalhar um ativo pelo código
    public function detalhar(string $codigo): JsonResponse
    {
        // Valida o padrão do código corporativo
        if (!preg_match('/^PAT-\d{3}$/', $codigo)) {
            return response()->json([
                "erro" => "Código inválido. Utilize o padrão PAT-001."
            ], 400);
        }

        // Lista simulada de ativos
        $ativos = [
            "PAT-001" => [
                "nome" => "Torno CNC",
                "tensao" => "220V",
                "horas_uso" => 1500
            ],
            "PAT-002" => [
                "nome" => "Prensa Hidráulica",
                "tensao" => "380V",
                "horas_uso" => 2300
            ]
        ];

        // Verifica se o ativo existe
        if (!isset($ativos[$codigo])) {
            return response()->json([
                "erro" => "Ativo não encontrado. Verifique o código informado."
            ], 404);
        }

        return response()->json([
            "codigo" => $codigo,
            "detalhes" => $ativos[$codigo]
        ]);
    }
    
    // Retorna os contratos de um cliente por ano
    public function contratosPorAno(int $cliente, int $ano): JsonResponse
    {
        $contratos = [
            ["numero" => "CTR-001", "ano" => 2025, "valor" => 15000],
            ["numero" => "CTR-002", "ano" => 2025, "valor" => 22000],
            ["numero" => "CTR-003", "ano" => 2024, "valor" => 18000]
        ];

        $resultado = array_values(array_filter(
            $contratos,
            fn ($contrato) => $contrato["ano"] === $ano
        ));

        return response()->json([
            "cliente" => $cliente,
            "ano" => $ano,
            "contratos" => $resultado
        ]);
    }

}
