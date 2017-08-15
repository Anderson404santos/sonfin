<?php
declare(strict_types=1);

namespace SONFin;

use SONFin\plugin\PluginInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\SapiEmitter;

class Application{
	private $serviceContainer;
	private $middleware = [];

	// Aqui temos um exemplo de inje��o de dependencia. Ao inv�s de ficar dando 'new ServiceContainer()' sempre que for necess�rio usar a aplication, faremos com que a nossa Application receba apenas uma instancia do serviceContainer obrigando que ela implemente a interface serviceContainerInterface.
	// Nesse caso estamos injetando a dependencia dentro da nossa classe, cabendo a n�s apenas usar
	// Outro beneficio � que se os parametros do serviceContainer mudarem, n�o � necess�rio ficar entrando na classe para modifica-la, a menos que seja realmente necess�rio
	public function __construct(ServiceContainerInterface $serviceContainer){
		$this->serviceContainer = $serviceContainer;
	}

	// M�todo realiza uma pesquisa no service container e retorna a instancia do objeto solicitado se existir 
	public function service($name){
		return $this->serviceContainer->get($name);
	}
	
	// Guarda um objeto no conainter de servi�os, para poder ser acessado atravez de um nome cadastrado
	public function addService(string $name,$service){
		if(is_callable($service)){
			$this->serviceContainer->addLazy($name,$service);
		}else{
			$this->serviceContainer->add($name,$service);
		}
	}
	
	// ...
	public function plugin(PluginInterface $plugin){
		$plugin->register($this->serviceContainer);
	}

	//Esse m�todo cria para n�s a rota. precisamos passar para ela a pasta da aplica��o. Passamos tamb�m a a��o(function do controller) a ser executada. Tamb�m podemos nomear essa rota para acesso r�pido
	//M�todo para requisi��es
	public function get($path,$action, $name = null){
		$routing = $this->service('routing');
		$routing->get($name, $path, $action);
		return $this;
	}
	
	// Agora vamos criar o post
	public function post($path,$action,$name = null){
		$routing = $this->service('routing');
		$routing->post($name, $path, $action);
		return $this;
	}	
	
	// Faz redirecionamento de p�gina
	public function redirect($path){
		// O Diactoros tem esse m�todo pronto para n�s 
		return new \Zend\Diactoros\Response\RedirectResponse($path);
	}
	
	// M�todo para fazer redirecionamento atrav�z de uma roda informada
	public function route(string $name, array $params = [] ){
		$generator  = $this->service('routing.generator');
		// O m�todo recebe uma rota e gera o caminho dela caso exista nos controllers
		$path = $generator->generate($name,$params);
		return $this->redirect($path); 
	}
	
	// Vamos implementar um middleware no nosso sistema de autentica��o, ele fica entre a aplica��o e a requisi��o do servidor, assim poderemos processar a requisi��o antes mesmo dela chegar na nossa aplica��o, no caso nas rotas
	// O objeto que receberemos ser� um callable, ou seja, o retorno de uma fun��o
	public function middleware(callable $callback){
		array_push($this->middleware,$callback);
		return $this;
	}
	
	// M�todo para executar todos os middlewares cadastrados
	protected function runMiddleware(){
		//print_r($this->middleware[1]);exit;		

		foreach($this->middleware as $call){
			// Vamos acessar cada fun��o e passar para elas a requisi��o que est� sendo feita, temos um servi�o j� implementado para recuperar todas as requisi��es que s�o feitas na nossa aplica��o
			$result = $call($this->service(RequestInterface::class));
			// Assim se o objeto for for uma instancia de uma resposta a auma requisi��o paramos de executar o foreach e retornamos o objeto para a aplica��o
			// Parando a aplica��o e retornando a resposta obtida, que pode ser uma mensagem de erro ou redicionamento(p�gina de login)
			if($result instanceof ResponseInterface){
				return $result;
			}
		}
		// Se retornar null quer dizer que o middleware n�o retornou nenhuma resposta e aplica��o deve continuar sendo executada normalmente
		return null;
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
	
		// Aqui age o nosso middleware, depois que buscamos no servidor pela rota � retornado um objeto com a rota
		// Executaramos um middleware que pode verificar se o usu�rio est� logado ou se tem permissao para acessar a rota 
		$result = $this->runMiddleware();
		// Caso tenha algum problema emitimos uma resposta(redirecionamento) e encerramos a execu��o do bloco de c�digo
		// Assim se houver algum tipo de problema detectado pelo middleware podemos impedir a execu��o da rota e criar uma a��o alteranativa
		if($result){
			$this->emitResponse($result);
			return;
		}
	
		// Vamos acessar a a��o da rota que vai retornar dados processados
		$callable = $route->handler; 
		// Recebendo os dados processados pela a��o da rota
		$response = $callable($request);
		$this->emitResponse($response);
	}
	
	// Esse m�todo pega os dados retornados pela rota e joga eles na response
	protected function emitResponse(ResponseInterface $response){
		// SAPI =  Server Application Program Interface, uma interface para implementar servi�os do Diacotoros
		$emitter = new SapiEmitter();
		$emitter->emit($response);
	}
}