<?php
use SONFin\ServiceContainer;
use SONFin\Application;
use SONFin\Plugin\RoutePlugin;
	
//A pasta public conter� a parte da nossa aplica��o que ser� acess�vel via web
// Vamos importar o autoload, o index ser� o ponto de partida da aplica
require_once __DIR__ . '/../vendor/autoload.php';

// Lembre-se que tudo que chamarmos na index ficar� globlal na aplica��o, por que estamos utilizando o conceito de front-controller, onde todas as requisi��es ser�o centralizadas para o index.php que ficar� respons�vel por montar a aplica��o e carregar todas as dependencias necess�rias para execu��o da aplica��o, bem como prover as respostas para o cliente.
$serviceContainer = new ServiceContainer();
// Precisamos passar para aplica��o a nossa configura��o de container de servi�os
$app =  new Application($serviceContainer);

// Vamos tamb�m criar o nosso plugin de rotas
$app->plugin(new RoutePlugin());

// Definimos no application que o m�todo get() cria uma rota.
$app->get("/",function(){
	echo "hello world";
});

$app->start();