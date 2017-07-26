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
	}
	
	public function login(array $credentials)
	{			
		list('email' => $email, 'password' => $password) = $credentials;
		return $this->jasny->login($email,$password) !== null;
	}
	public function check():bool
	{
		
	}
	public function logout():void
	{
		
	}	
	public function hashPassword($password){
		return $this->jasny->hashPassword($password);
	}
} 