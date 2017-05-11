<?php
namespace SONFin;

use Xtreamwayz\Pimple\Container;

class ServiceContainer implements ServiceContainerInterface{
	
	private $container;

	// Criamos um novo Container, essa instancia vem do pimple
	public function __construct(){
		$this->container = new Container();
	}

	// Metodo para criar um novo container
	public function add(string $name,$service){
		$this->container[$name] = $service;
	}
	
	// Também cria um novo container, mas dessa ver utilizando a estrategia lazyload. Também vem implementada do pimple
	public function addLazy(string $name, callable $callable){
		$this->container[$name] = $this->container->factory($callable);
	}
	
	// Método para retornar os dados de um container 
	public function get(string $name){
		return $this->container->get($name);
	}
	
	//Método para verificar se um container existe 
	public function has(string $name){
		return $this->container->has($name);
	}
	
}