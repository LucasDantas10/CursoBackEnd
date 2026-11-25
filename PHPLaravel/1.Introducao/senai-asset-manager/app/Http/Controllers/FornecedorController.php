<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class FornecedorController extends Controller
{
    // Lista os fornecedores cadastrados
    public function index(): JsonResponse
    {
        return response()->json([
            "fornecedores" => [
                ["id" => 1, "nome" => "Fornecedor SENAI"],
                ["id" => 2, "nome" => "Indústria ABC"]
            ]
        ]);
    }

    // Exibe um fornecedor específico
    public function show(int $fornecedor): JsonResponse
    {
        return response()->json([
            "id" => $fornecedor,
            "nome" => "Fornecedor SENAI"
        ]);
    }
}
