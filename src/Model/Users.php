<?php
declare(strict_types=1);
namespace SONFin\Model;

use Illuminate\Database\Eloquent\Model;
use Jasny\Auth\User as JasnyUser;

//Como fizemos uma integra��o com a biblioteca Jasny, precisamos que o nosso modelo de usu�rio implemente a interface do user do Jasny
class Users extends Model implements JasnyUser
{
	// O Eloquent trabalha com entradas de dados segura, significa que ele s� salva dados se esse dado for mapeado na classe
	// Contudo o Eloquent tamb�m trabalha com um mecanismo de massive assigment, assim qualquer dado que se passa para os m�todos de controle do banco, voc� passa apenas o dado que o Eloquent se vira
	// Posto isso, podemos criar um atributo $fillable, o que voc� colocar aqui o eloquent vai conseiderar dado seguro e o passar� diretamente para o model
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