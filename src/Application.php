<?php
declare(strict_types=1);

namespace SONFin;

use SONFin\plugin\PluginInterface;

class Application{
	private $serviceContainer;

	// Aqui temos um exemplo de injeção de dependencia. Ao invés de ficar dando 'new ServiceContainer()' sempre que for necessário usar a aplication, faremos com que a nossa Application receba apenas uma instancia do serviceContainer obrigando que ela implemente a interface serviceContainerInterface.
	// Nesse caso estamos injetando a dependencia dentro da nossa classe, cabendo a nós apenas usar
	// Outro beneficio é que se os parametros do serviceContainer mudarem, não é necessário ficar entrando na classe para modifica-la, a menos que seja realmente necessário
	public function __construct(ServiceContainerInterface $serviceContainer){
		$this->serviceContainer = $serviceContainer;
	}
	
	public function service($name){
		return $this->serviceContainer->get($name);
	}
	
	public function addService(string $name,$service){
		if(is_callable($service)){
			$this->serviceContainer->addLazy($name,$service);
		}else{
			$this->serviceContainer->add($name,$service);
		}
	}
	
	public function plugin(PluginInterface $plugin){
		$plugin->register($this->serviceContainer);
	}

	//Esse método cria para nós a rota. precisamos passar para ela a pasta da aplicação. Passamos também a ação(function do controller) a ser executada. Também podemos nomear essa rota para acesso rápido
	public function get($path,$action, $name = null){
		$routing = $this->service('routing');
		$routing->get($name, $path, $action);
		return $this;
	}
	
	public function start(){
		$route = $this->service('route');
		$callable = $route->handler; 
		$callable();
	}
}