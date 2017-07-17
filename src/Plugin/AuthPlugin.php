<?php
declare(strict_types=1);	
namespace SONFin\Plugin;

use SONFin\Model\Auth;
use SONFin\ServiceContainerInterface;
use Interop\Container\ContainerInterface;

// Importando o capsule, precisamos dessa classe para utilizar o ElloquentOrm fora do laravel
use Illuminate\Database\Capsule\Manager as Capsule;


class AuthPlugin implements PluginInterface
{	
	public function register(ServiceContainerInterface $container)
	{
		// Vamos utilizar uma biblioteca de terceiro para implementar o login, então para nós é interessante criar um lazy para 
		$container->addLazy(name:'auth',function(ContainerInterface $container){
			return return new Auth();
		});
	}	

}