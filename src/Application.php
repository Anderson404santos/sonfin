<?php
declare(strict_types=1);

namespace SONFin;

use SONFin\plugin\PluginInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\SapiEmitter;

class Application{
	private $serviceContainer;

	// Aqui temos um exemplo de inje��o de dependencia. Ao inv�s de ficar dando 'new ServiceContainer()' sempre que for necess�rio usar a aplication, faremos com que a nossa Application receba apenas uma instancia do serviceContainer obrigando que ela implemente a interface serviceContainerInterface.
	// Nesse caso estamos injetando a dependencia dentro da nossa classe, cabendo a n�s apenas usar
	// Outro beneficio � que se os parametros do serviceContainer mudarem, n�o � necess�rio ficar entrando na classe para modifica-la, a menos que seja realmente necess�rio
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

	//Esse m�todo cria para n�s a rota. precisamos passar para ela a pasta da aplica��o. Passamos tamb�m a a��o(function do controller) a ser executada. Tamb�m podemos nomear essa rota para acesso r�pido
	public function get($path,$action, $name = null){
		$routing = $this->service('routing');
		$routing->get($name, $path, $action);
		return $this;
	}
	
	// Esse m�todo executa a rota
	public function start(){
		
		// Obt�m a rota acessada
		$route = $this->service('route');
		$request = $this->service(RequestInterface::class);
		
		// Verifica se a tora � v�lida
		if(!$route)
		{
			echo "Page not found";
			exit;
		}
		
		// Pega os atributos passados junto com a rota
		foreach($route->attributes as $key => $value)
		{			
			// O m�todo withAttribute() pertence a  biblioteca aura, vai fazer uma busca no cabe�alho pelo campo que for requisitado na rota
			$request = $request->withAttribute($key,$value);
		}	
	
		// Vamos acessar a a��o da rota que vai retornar dados processados
		$callable = $route->handler; 
		// Recebendo os dados processados pela a��o da rota
		$response = $callable($request);
		$this->emitResponse($response);
	}
	
	// Esse m�todo pega os dados retornados pela rota e joga eles na response
	protected function emitResponse(ResponseInterface $response){
		$emitter = new SapiEmitter();
		$emitter->emit($response);
	}
}