<?php
use Psr\Http\Message\ResposeInterface;
use Psr\Http\Message\ServerRequestInterface;
use SONFin\ServiceContainer;
use SONFin\Application;
use SONFin\Plugin\RoutePlugin;
use SONFin\Plugin\ViewPlugin;
use SONFin\ServiceContainerInterface;
	
//A pasta public conterá a parte da nossa aplicação que será acessível via web
// Vamos importar o autoload, o index será o ponto de partida da aplica
require_once __DIR__ . '/../vendor/autoload.php';


// Lembre-se que tudo que chamarmos na index ficará globlal na aplicação, por que estamos utilizando o conceito de front-controller, onde todas as requisições serão centralizadas para o index.php que ficará responsável por montar a aplicação e carregar todas as dependencias necessárias para execução da aplicação, bem como prover as respostas para o cliente.
$serviceContainer = new ServiceContainer();
// Precisamos passar para aplicação a nossa configuração de container de serviços
$app =  new Application($serviceContainer);

// Vamos também criar o nosso plugin de rotas
$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());

// Definimos no application que o método get() cria uma rota 
/*// ISSO FOI ANTES DE DEFINIR QUE AS NOSSAS ROTAS PRECISAM RETORNAR RESPONSES
$app->get("/inicio",function(){
	echo "hello world";
});
*/

// Definindo uma rota que recebe os atributos da requisição. No caso vamos pegar os atributos do GET. Portanto quando a rota for acessada ela faz uma requisição ao servidor e espera uma resposta que virá através de um objeto ServerRequestInterface
// Note que essa request só responde se o endereço for corretamente incluído, ou seja, uma barra fora de lugar e o servidor não será capaz de localizar a rota
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




// Agora ao invés de pegar os dados direto da interface vamos pegar os dados da resposta
$app->get("/response",function(ServerRequestInterface $request){
	// Note que vamos acessar diretamente os ultimos dados contidos nas resposta
	$response = new \Zend\Diactoros\Response();
	$response->getBody()->write("Resposta com emmiter do diactores");
	return $response;
});

$app->start();