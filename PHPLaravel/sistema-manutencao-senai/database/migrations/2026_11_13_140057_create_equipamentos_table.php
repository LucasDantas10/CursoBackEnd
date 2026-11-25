<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();//primary key
            $table->string("tag")->unique();
            $table->string("nome");
            $table->string("setor");
            $table->string("criticidade");
            $table->string("status");
            $table->timestamps();//carimbo de data e hora da criação da entidade no banco de dados
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};
