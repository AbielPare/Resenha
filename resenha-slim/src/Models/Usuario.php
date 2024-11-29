<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Definir o nome da tabela caso seja diferente do padrão (plural do nome da classe)
    protected $table = 'usuarios';

    // Definir quais campos são 'mass assignable'
    protected $fillable = ['name', 'email', 'password'];

    // Desabilitar timestamps, se não for necessário
    public $timestamps = false;
}
