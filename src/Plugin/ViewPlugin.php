<?php
declare(strict_types=1);	

namespace SONFin\Plugin;

use SONFin\ServiceContainerInterface;
use SONFin\View\ViewRender;
use Interop\Container\ContainerInterface;

class ViewPlugin implements PluginInterface
{	

	public function register(ServiceContainerInterface $container)
	{
		$container->addLazy('twig',function (ContainerInterface $container){					
			// Define a pasta do twig
			$loader = new \Twig_Loader_Filesystem(__DIR__.'/../../templates');				
			// Inicia o serviçp do twig 
			$twig = new \Twig_Environment($loader);
			
			// Vamos pegar o generator do container de serviços
			$generator = $container->get('routing.generator');
			
			// Precisamos implementar uma função para criaçao automatica de rotas, como ela será diretamente usada dentro do twig, usamos o método addFunction() do twig com ele podemos criar alguns métodos que serão reconhecidos pelo twig
			$twig->addFunction(new \Twig_SimpleFunction('route',function(string $name, array $params = []) use($generator){
				return $generator->generate($name,$params);
			}));
			
			return $twig;
		});
		
		$container->addLazy('view.renderer',function(ContainerInterface $container){
			$twigEnvironment = $container->get('twig');
			return new ViewRender($twigEnvironment);
		});
		
	}	

}