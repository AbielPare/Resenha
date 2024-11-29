<?php

namespace App\Config;

use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent
{
    public static function setup()
    {
        // Criar instância do Capsule (Eloquent)
        $capsule = new Capsule;

        // Configuração do banco de dados
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'resenhas',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        // Definir o Eloquent para usar o banco de dados
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
