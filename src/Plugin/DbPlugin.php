<?php
declare(strict_types=1);	

namespace SONFin\Plugin;

use SONFin\Model\CategoryCost;
use SONFin\Model\Users;
use SONFin\Model\Repository\RepositoryFactory;
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
		
		// Vamos colocar dentro do container a nossa fábrica de repositorios de modelos
		$container->add('repository.factory', new RepositoryFactory());
		
		// Vamos ciar um serviço para chamar o repository para category costs. Antes ele estava no front-controller mas isso criar intancia desnecessária do objeto enxendo a memoria com repositories que não estão em uso. Vamos coloca-la no serviço e chamar a medida que for necessário
		$container->addLazy('category-costs.repository',function(ContainerInterface $container){
			return $container->get('repository.factory')->factory(CategoryCost::class);
		});
		$container->addLazy('users.repository',function(ContainerInterface $container){
			return $container->get('repository.factory')->factory(Users::class);
		});
	}	

}