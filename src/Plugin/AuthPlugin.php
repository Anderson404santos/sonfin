<?php
declare(strict_types=1);	
namespace SONFin\Plugin;

use SONFin\Auth\Auth;
use SONFin\Auth\JasnyAuth;
use SONFin\ServiceContainerInterface;
use Interop\Container\ContainerInterface;

class AuthPlugin implements PluginInterface
{	
	public function register(ServiceContainerInterface $container)
	{
		$container->addLazy('jasny.auth',function(ContainerInterface $container){
			return new JasnyAuth($container->get('users.repository'));
		});
		
		// Vamos utilizar uma biblioteca de terceiro para implementar o login, então para nós é interessante criar um lazy para 
		$container->addLazy('auth',function(ContainerInterface $container){
			return new Auth($container->get('jasny.auth'));
		});
	}	
}