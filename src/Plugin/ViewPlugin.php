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
		$container->addLazy('twig',function (ContainerInterface $containter){					
			$loader = new \Twig_Loader_Filesystem(__DIR__.'/../../templates');				
			$twig = new \Twig_Environment($loader);
			return $twig;
		});
		
		$container->addLazy('view.renderer',function(ContainerInterface $container){
			$twigEnvironment = $container->get('twig');
			return new ViewRender($twigEnvironment);
		});
		
	}	

}