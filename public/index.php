<?php
use SONFin\ServiceContainer;
use SONFin\Application;
use SONFin\Plugin\RoutePlugin;
	
//A pasta public conterá a parte da nossa aplicação que será acessível via web
// Vamos importar o autoload, o index será o ponto de partida da aplica
require_once __DIR__ . '/../vendor/autoload.php';

// Lembre-se que tudo que chamarmos na index ficará globlal na aplicação, por que estamos utilizando o conceito de front-controller, onde todas as requisições serão centralizadas para o index.php que ficará responsável por montar a aplicação e carregar todas as dependencias necessárias para execução da aplicação, bem como prover as respostas para o cliente.
$serviceContainer = new ServiceContainer();
// Precisamos passar para aplicação a nossa configuração de container de serviços
$app =  new Application($serviceContainer);

// Vamos também criar o nosso plugin de rotas
$app->plugin(new RoutePlugin());

// Definimos no application que o método get() cria uma rota.
$app->get("/",function(){
	echo "hello world";
});

$app->start();