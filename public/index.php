<?php
use Psr\Http\Message\ResposeInterface;
use Psr\Http\Message\ServerRequestInterface;
use SONFin\ServiceContainer;
use SONFin\Application;
use SONFin\Plugin\RoutePlugin;
use SONFin\Plugin\ViewPlugin;
use SONFin\ServiceContainerInterface;
	
//A pasta public conter� a parte da nossa aplica��o que ser� acess�vel via web
// Vamos importar o autoload, o index ser� o ponto de partida da aplica
require_once __DIR__ . '/../vendor/autoload.php';


// Lembre-se que tudo que chamarmos na index ficar� globlal na aplica��o, por que estamos utilizando o conceito de front-controller, onde todas as requisi��es ser�o centralizadas para o index.php que ficar� respons�vel por montar a aplica��o e carregar todas as dependencias necess�rias para execu��o da aplica��o, bem como prover as respostas para o cliente.
$serviceContainer = new ServiceContainer();
// Precisamos passar para aplica��o a nossa configura��o de container de servi�os
$app =  new Application($serviceContainer);

// Vamos tamb�m criar o nosso plugin de rotas
$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());

// Definimos no application que o m�todo get() cria uma rota 
/*// ISSO FOI ANTES DE DEFINIR QUE AS NOSSAS ROTAS PRECISAM RETORNAR RESPONSES
$app->get("/inicio",function(){
	echo "hello world";
});
*/

// Definindo uma rota que recebe os atributos da requisi��o. No caso vamos pegar os atributos do GET. Portanto quando a rota for acessada ela faz uma requisi��o ao servidor e espera uma resposta que vir� atrav�s de um objeto ServerRequestInterface
// Note que essa request s� responde se o endere�o for corretamente inclu�do, ou seja, uma barra fora de lugar e o servidor n�o ser� capaz de localizar a rota
/*// ISSO FOI ANTES DE DEFINIR QUE AS NOSSAS ROTAS PRECISAM RETORNAR RESPONSES

$app->get("/home/{name}/{id}",function(ServerRequestInterface $request){
	echo "mostrando a home <br>";
	echo $request->getAttribute('name');
	echo "<br>";
	echo $request->getAttribute('id');
});
*/

//
$app->get('/teste/{name}',function(ServerRequestInterface $request) use ($app){
	$view = $app->service('view.renderer');
	return $view->render('teste.html.twig',['name'=>$request->getAttribute('name')]);
});




// Agora ao inv�s de pegar os dados direto da interface vamos pegar os dados da resposta
$app->get("/response",function(ServerRequestInterface $request){
	// Note que vamos acessar diretamente os ultimos dados contidos nas resposta
	$response = new \Zend\Diactoros\Response();
	$response->getBody()->write("Resposta com emmiter do diactores");
	return $response;
});

$app->start();