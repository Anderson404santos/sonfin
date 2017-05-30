<?php
declare(strict_types=1);	

namespace SONFin\Plugin;

use SONFin\ServiceContainerInterface;
use Interop\Container\ContainerInterface;

// Importando o capsule, precisamos dessa classe para utilizar o ElloquentOrm fora do laravel
use Illuminate\Database\Capsule\Manager as Capsule;


class DbPlugin implements PluginInterface
{	

	public function register(ServiceContainerInterface $container)
	{
		// A classe capsule é o nucleo do eloquent
		$capsule = new Capsule();
		
		// Pegando os dados de configuração do banco
		$config = include __DIR__ . '/../../config/db.php';
		
		// Criando a conexao com eloquent
		$capsule->addConnection($config['development']);

		// No caso do elloquent não será necessário coloca-lo na camada de serviços, por que o eloquent já trabalha de forma estática, podendo ser utilizado em qualquer parte da aplicação desde que seja corretamente 
		$capsule->bootEloquent();		
	}	

}