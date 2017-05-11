<?php
declare(strict_types=1);	

namespace SONFin\Plugin;

use SONFin\ServiceContainerInterface;
use Aura\Router\RouterContainer;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\ServerRequestFactory;


// Vamos ent�o criar o plugin do nosso router. Ou seja, vamos criar o nosso objeto do aurarouter e configura-lo para uso
class RoutePlugin implements PluginInterface
{	
	public function register(ServiceContainerInterface $container)
	{
		// A classe routerContainer cont�m objetos que n�s utilizaremos para configurar as rotas
		$routerContainer = new RouterContainer();
		// No map registramos as rotas dispon�veis na aplica��o
		$map = $routerContainer->getMap();
		// O matcher identifica a rota que est� tentando ser acessada
		$matcher = $routerContainer->getMatcher();
		// O generator gera links com base nas rotas registradas	
		$generator = $routerContainer->getGenerator();
		$request = $this->getRequest();

		//Como precisaremos das rotas a todo momento na nossa aplica��o, vamos coloc�-las no nosso ServiceContainer
		$container->add('routing',$map);
		$container->add('routing.matcher',$matcher);
		$container->add('routing.generator',$generator);

		// Vamos colocar a requisi��o no formato PSR7 dentro do pimple
		// RequestInterface::class vai retornar uma String com o nome do objeto que gerencia a requisi��o 
		$container->add(RequestInterface::class, $request);
		
		// Vamos criar o carregamento retardado de dados que fizemos com o pimple
		$container->addLazy('route',function(ContainerInterface $container){
			// Ent�o a nossa rota vai esperar por um objeto que implementa a interface ContainerInterface nela teremos os dados da requisi��o e o matcher		
			$matcher = $container->get('routing.matcher');
			$request = $container->get(RequestInterface::class);
			return $matcher->match($request);
		});
		
	}	
	
	protected function getRequest(){
		// Passamos as varivies globais para o m�todo fromGlobals(), o Diactoros passar� a gerenciar as vari�veis globais para n�s 
		return ServerRequestFactory::fromGlobals(
			$_SERVER,$_GET,$_POST,$_COOKIE,$_FILES
		);
	}
}