<?php
declare(strict_types=1);	

namespace SONFin\Plugin;

use SONFin\ServiceContainerInterface;
use SONFin\View\ViewRender;
use Interop\Container\ContainerInterface;
use SONFin\View\Twig\TwigGlobals;

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

			// Então vamos passar os dados da sessão para o twig, e será utilizada por uma extensão que criamos com o intuito de instanciar os dados da autenticação dentro dos templates, assim não precisaremos ficar passando manualmente a sessão pára cada template que for exercutado.
			
			$auth = $container->get('auth');
			$twig->addExtension(new TwigGlobals($auth));
			
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