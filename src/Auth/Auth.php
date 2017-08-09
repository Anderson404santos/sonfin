<?php
 
declare(strict_types=1);
namespace SONFin\Auth;
use SONFin\Models\UserInterface;

class Auth implements AuthInterface
{
	private $jasny;
	
	public function __construct(JasnyAuth $jasny)
	{
		$this->jasny = $jasny;
		$this->sessionStart();
	}
	
	public function login(array $credentials)
	{			
		list('email' => $email, 'password' => $password) = $credentials;
		return $this->jasny->login($email,$password) !== null;
	}
	
	// O método user retorna os dados da sessão do usuário, com ela podemos acessar dados como nome e email do usuario
	public function user()
	{
		return $this->jasny->user();
	}
	
	public function check():bool
	{
		// Verificando se o usuário é diferente de null
		return $this->user() !== null;
	}
	
	public function logout():void
	{
		
	}	
	public function hashPassword($password)
	{
		return $this->jasny->hashPassword($password);
	}
	
	// O JasnyAuth precisa que uma sessão seja iniciada antes de guardar o usuário na sessao, então vamos inciar a sessão
	protected function sessionStart()
	{
		if(session_status() == PHP_SESSION_NONE){
			session_start();	
		}
	}
} 