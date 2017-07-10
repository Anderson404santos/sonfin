<?php
declare(strict_types=1);
namespace SONFin\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
	// O Eloquent trabalha com entradas de dados segura, significa que ele só salva dados se esse dado for mapeado na classe
	// Contudo o Eloquent também trabalha com um mecanismo de massive assigment, assim qualquer dado que se passa para os métodos de controle do banco, você passa apenas o dado que o Eloquent se vira
	// Posto isso, podemos criar um atributo $fillable, o que você colocar aqui o eloquent vai conseiderar dado seguro e o passará diretamente para o model
	protected $fillable = [
			'first_name',
			'last_name',
			'email',
			'password'
	];
} 