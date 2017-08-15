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

	// Aqui temos um exemplo de injeção de dependencia. Ao invés de ficar dando 'new ServiceContainer()' sempre que for necessário usar a aplication, faremos com que a nossa Application receba apenas uma instancia do serviceContainer obrigando que ela implemente a interface serviceContainerInterface.
	// Nesse caso estamos injetando a dependencia dentro da nossa classe, cabendo a nós apenas usar
	// Outro beneficio é que se os parametros do serviceContainer mudarem, não é necessário ficar entrando na classe para modifica-la, a menos que seja realmente necessário
	public function __construct(ServiceContainerInterface $serviceContainer){
		$this->serviceContainer = $serviceContainer;
	}

	// Método realiza uma pesquisa no service container e retorna a instancia do objeto solicitado se existir 
	public function service($name){
		return $this->serviceContainer->get($name);
	}
	
	// Guarda um objeto no conainter de serviços, para poder ser acessado atravez de um nome cadastrado
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

	//Esse método cria para nós a rota. precisamos passar para ela a pasta da aplicação. Passamos também a ação(function do controller) a ser executada. Também podemos nomear essa rota para acesso rápido
	//Método para requisições
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
	
	// Faz redirecionamento de página
	public function redirect($path){
		// O Diactoros tem esse método pronto para nós 
		return new \Zend\Diactoros\Response\RedirectResponse($path);
	}
	
	// Método para fazer redirecionamento atravéz de uma roda informada
	public function route(string $name, array $params = [] ){
		$generator  = $this->service('routing.generator');
		// O método recebe uma rota e gera o caminho dela caso exista nos controllers
		$path = $generator->generate($name,$params);
		return $this->redirect($path); 
	}
	
	// Vamos implementar um middleware no nosso sistema de autenticação, ele fica entre a aplicação e a requisição do servidor, assim poderemos processar a requisição antes mesmo dela chegar na nossa aplicação, no caso nas rotas
	// O objeto que receberemos será um callable, ou seja, o retorno de uma função
	public function middleware(callable $callback){
		array_push($this->middleware,$callback);
		return $this;
	}
	
	// Método para executar todos os middlewares cadastrados
	protected function runMiddleware(){
		//print_r($this->middleware[1]);exit;		

		foreach($this->middleware as $call){
			// Vamos acessar cada função e passar para elas a requisição que está sendo feita, temos um serviço já implementado para recuperar todas as requisições que são feitas na nossa aplicação
			$result = $call($this->service(RequestInterface::class));
			// Assim se o objeto for for uma instancia de uma resposta a auma requisição paramos de executar o foreach e retornamos o objeto para a aplicação
			// Parando a aplicação e retornando a resposta obtida, que pode ser uma mensagem de erro ou redicionamento(página de login)
			if($result instanceof ResponseInterface){
				return $result;
			}
		}
		// Se retornar null quer dizer que o middleware não retornou nenhuma resposta e aplicação deve continuar sendo executada normalmente
		return null;
	}
	
	// Esse método executa a rota
	public function start(){
		
		// Obtém a rota acessada
		$route = $this->service('route');
		$request = $this->service(RequestInterface::class);
		
		// Verifica se a tora é válida
		if(!$route)
		{
			echo "Page not found";
			exit;
		}
		
		// Pega os atributos passados junto com a rota
		foreach($route->attributes as $key => $value)
		{			
			// O método withAttribute() pertence a  biblioteca aura, vai fazer uma busca no cabeçalho pelo campo que for requisitado na rota
			$request = $request->withAttribute($key,$value);
		}	
	
		// Aqui age o nosso middleware, depois que buscamos no servidor pela rota é retornado um objeto com a rota
		// Executaramos um middleware que pode verificar se o usuário está logado ou se tem permissao para acessar a rota 
		$result = $this->runMiddleware();
		// Caso tenha algum problema emitimos uma resposta(redirecionamento) e encerramos a execução do bloco de código
		// Assim se houver algum tipo de problema detectado pelo middleware podemos impedir a execução da rota e criar uma ação alteranativa
		if($result){
			$this->emitResponse($result);
			return;
		}
	
		// Vamos acessar a ação da rota que vai retornar dados processados
		$callable = $route->handler; 
		// Recebendo os dados processados pela ação da rota
		$response = $callable($request);
		$this->emitResponse($response);
	}
	
	// Esse método pega os dados retornados pela rota e joga eles na response
	protected function emitResponse(ResponseInterface $response){
		// SAPI =  Server Application Program Interface, uma interface para implementar serviços do Diacotoros
		$emitter = new SapiEmitter();
		$emitter->emit($response);
	}
}