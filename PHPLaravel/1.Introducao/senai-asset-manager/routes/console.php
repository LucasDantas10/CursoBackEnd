<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Comando corporativo SENAI
Artisan::command('senai:status', function () {
    $plataforma = config('app.name');
    $ambiente = config('app.env');
    $ativosOperacionais = 37;

    $this->line("<fg=blue>Plataforma: {$plataforma}</>");
    $this->line("Ambiente ativo: {$ambiente}");
    $this->line("Total de ativos operacionais: {$ativosOperacionais}");

})->purpose('Exibe o status corporativo da plataforma SENAI');
