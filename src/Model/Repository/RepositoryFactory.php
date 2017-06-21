<?php
declare(strict_types=1);
namespace SONFin\Model\Repository;

// Sempre que for necess�rio instanciar uma classe RepositoryDefault passamos para ela apenas o nome do modelo para ser e ela tem que se virar para criar o objeto.
// Nesses casos podemos utilizar a pattern factory, que num m�todo est�tico numa unica linha j� retorna toda a nossa classe com todas as dependencias resolvidas
class RepositoryFactory
{
	public static function factory(string $modelClass)
	{
		return new DefaultRepository($modelClass);
	}
}