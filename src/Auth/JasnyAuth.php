<?php

namespace SONFin\Auth;

use Jasny\Auth\User;
use Jasny\Auth\Sessions;
use SONFin\Repository\RepositoryInterface;

// Criamos esta classe por que o Jasny é uma classe abstrata e para utilizar somos obrigado a implementar os métodos abaixo

class JasnyAuth extends \Jasny\Auth
{
	// Isso é um facade. Ele vem do proprio pacote do Jasny
	use Sessions;
	
	private $repository;

	// Vamos utilizar o padrão repository
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
		// Esse método sempre vai receber um array no parâmetro vindo do repository. Só nos interessa a posição 0 desse array
		//return $this->repository->findByField('email',$username)[0];
		$result = $this->repository->findByField('email', $username);	
        return count($result)? $result[0] : null;
	}	
}

