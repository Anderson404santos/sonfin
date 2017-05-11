<?php

// A biblioteca phinx necessita localizar um arquivo do configuração
// O phinx vai buscar esse arquivo de configuração na raiz do projeto
// Esse arquivo pode ser phinx.php ou phinx.json

// Então chamamos o autoload 
require __DIR__ . '/vendor/autoload.php';

// E incluimos o arquivo com os dados do banco que configuramos em separado
$db = include __DIR__ . '/config/db.php';

// O método list() é um modificado no php, esse método recebe um array por atribuição, e de acordo com a chaves do array podemos criar variáveis   
// Com ele criamos variáveis puxando os dados de um array. A diferença que o PHP7 traz é a capacidade de se criar a variável com o nome desejado, em outras versões somos obrigados  a utilizar o nome da variavel de acordo com a chave do array
// Como essa implementação só é possivel na versão 7.1 do php, que não temos, vamos comentar e fazer manualmente
/*
list(
	'driver' => $adapter,
	'host' => $host,
	'database' => $name,
	'username' => $user,
	'password' => $pass,
	'charset' => $charset,
	'colation' = $collation
)=$db['development'];
*/

$config_defalt = 'development';

$adapter = $db[$config_defalt]['driver'];
$host =$db[$config_defalt]['host'];
$name=$db[$config_defalt]['database'];
$user=$db[$config_defalt]['username'];
$pass=$db[$config_defalt]['password'];
$charset=$db[$config_defalt]['charset'];
$collation=$db[$config_defalt]['collation'];

// Retornamos para ao phinx a configuraçao de pastas
return [
	// Definindo as pastas onde serão armazenadas nossas classes de migrations e seeds
	'paths' =>[		
		'migrations' => [
			__DIR__ . '/db/migrations'
		],
		'seeds' => [
			__DIR__ . '/db/seeds'
		]
	],
	// E algumas variaveis de ambiente
	'environments'=>[
		// Configura uma tabela no banco que será responsável por gerir as migrações já feitas, com isso não haverá o risco de uma mesma migration ser executada duas vezes
		'default_migration_table' => 'migrations',
		'default_database' => 'development',
		'development' => [
			'adapter' => $adapter,
			'host' => $host,
			'name' => $name, //Name se refere ao nome da tabela no banco
			'user' => $user,
			'pass' => $pass,
			'charset' => $charset,
			'collation' => $collation
		]
	]
];