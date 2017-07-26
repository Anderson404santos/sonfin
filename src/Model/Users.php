<?php
declare(strict_types=1);
namespace SONFin\Model;

use Illuminate\Database\Eloquent\Model;
use Jasny\Auth\User as JasnyUser;

//Como fizemos uma integração com a biblioteca Jasny, precisamos que o nosso modelo de usuário implemente a interface do user do Jasny
class Users extends Model implements JasnyUser
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
	
	public function getId()
	{
		return (int)$this->id;
	}
	
	public function getUserName()
	{
		return $this->email; 
	}
	
	public function getHashedPassword()
	{
		return $this->password;
	}
	
	public function onLogin()
	{
		//
	}
	public function onLogout()
	{
		//
	}
} 