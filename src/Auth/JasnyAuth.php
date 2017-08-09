<?php

namespace SONFin\Auth;

use Jasny\Auth\User;
use Jasny\Auth\Sessions;
use SONFin\Repository\RepositoryInterface;

// Criamos esta classe por que o Jasny � uma classe abstrata e para utilizar somos obrigado a implementar os m�todos abaixo

class JasnyAuth extends \Jasny\Auth
{
	// Isso � um facade. Ele vem do proprio pacote do Jasny
	use Sessions;
	
	private $repository;

	// Vamos utilizar o padr�o repository
	public function __construct(RepositoryInterface $repository)
	{
		$this->repository = $repository;
	}

	// De acordo com a forma que recebemos e
	public function fetchUserById($id)
	{
		return $this->repository->find($id,false);
	}
	
	public function fetchUserByUserName($username)
	{
		// Esse m�todo sempre vai receber um array no par�metro vindo do repository. S� nos interessa a posi��o 0 desse array
		//return $this->repository->findByField('email',$username)[0];
		$result = $this->repository->findByField('email', $username);	
        return count($result)? $result[0] : null;
	}	
}

