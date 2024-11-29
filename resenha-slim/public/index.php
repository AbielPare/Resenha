<?php

use Slim\Factory\AppFactory;
use DI\Container;
use App\Controllers\UsuarioController;

// Ajuste no caminho para o eloquent.php
require __DIR__ . '/../src/Config/eloquent.php';  // Verifique se o caminho está correto

App\Config\Eloquent::setup();

require __DIR__ . '/../vendor/autoload.php';

// Configurar o DI Container
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

// Configuração do banco de dados no contêiner
$container->set('db', function () {
    $pdo = new PDO('mysql:host=localhost;dbname=resenhas', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
});

// Middleware de sessões
session_start();

// Middleware de erros
$app->addErrorMiddleware(true, true, true);

// Rotas para o controlador de usuários
$app->post('/usuario/cadastrar', [UsuarioController::class, 'cadastrar']);
$app->post('/usuario/login', [UsuarioController::class, 'login']);

// Executar a aplicação
$app->run();
