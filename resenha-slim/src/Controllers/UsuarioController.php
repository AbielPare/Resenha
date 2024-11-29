<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User; // Modelo User que será criado com Eloquent

class UsuarioController
{
    // Método para cadastrar o usuário
    public function cadastrar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();

        // Obtenha os dados de cadastro
        $nome = $dados['nome'] ?? '';
        $email = $dados['email'] ?? '';
        $senha = $dados['senha'] ?? '';

        // Verificar se o email já está cadastrado
        $usuarioExistente = User::where('email', $email)->first();
        if ($usuarioExistente) {
            $response->getBody()->write("Este email já está cadastrado.");
            return $response->withStatus(400); // Retornar erro se o email já existir
        }

        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Criar um novo usuário com Eloquent
        $usuario = new User();
        $usuario->name = $nome;
        $usuario->email = $email;
        $usuario->password = $senhaHash;
        $usuario->save();

        // Resposta de sucesso
        $response->getBody()->write("Usuário $nome cadastrado com sucesso!");
        return $response;
    }

    // Método para login do usuário
    public function login(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();

        // Obtenha os dados de login
        $email = $dados['email'] ?? '';
        $senha = $dados['senha'] ?? '';

        // Buscar o usuário no banco de dados usando Eloquent
        $usuario = User::where('email', $email)->first();

        // Verificar se o usuário existe e se a senha está correta
        if ($usuario && password_verify($senha, $usuario->password)) {
            // Armazenar o ID do usuário na sessão para autenticação
            $_SESSION['user_id'] = $usuario->id;
            $response->getBody()->write("Login efetuado com sucesso!");
        } else {
            $response->getBody()->write("Login ou senha inválidos!");
            return $response->withStatus(401); // Retornar erro 401 (não autorizado) se falhar
        }

        return $response;
    }
}
