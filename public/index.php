<?php

use Psr\Http\Message\ResposeInterface;
use Psr\Http\Message\ServerRequestInterface;
use SONFin\ServiceContainer;
use SONFin\Application;
use SONFin\Plugin\RoutePlugin;
use SONFin\Plugin\ViewPlugin;
use SONFin\Plugin\DbPlugin;
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
$app->plugin(new DbPlugin());


// J� temos o plugin do twig pronto, retornando a view e dos dados da p�gina no formato de response
// Como se trata de uma closure, podemos utilizar o comando use() para importar vari�veis do escolo logo acima
$app->get('/teste/{name}',function(ServerRequestInterface $request) use ($app){
	$view = $app->service('view.renderer');
	return $view->render('teste.html.twig',['name'=>$request->getAttribute('name')]);
});


// Rota para tela de listagem de categoria de custo
$app->get('/category-costs',function() use ($app) {
	$view = $app->service('view.renderer');
	// vamos instanciar o modelo e utulizar os m�todos que s�o extendidos do eloquent
	$meuModel = new \SONFin\Model\CategoryCost();
	// all() retorna todas as entradas da tabela
	$categories = $meuModel->all();
	return $view->render('category-costs/list.html.twig',['categories'=>$categories]);
},'category-costs.list');


// Rota para formul�rio de cadastro de categoria de custo
$app->get('/category-costs/new',function() use ($app) {
	$view = $app->service('view.renderer');
	return $view->render('category-costs/create.html.twig');
},'category-costs.new');


// Rota para cadastrar categoria de custo
$app->post('/category-costs/store',function(ServerRequestInterface $request) use ($app) {
	// A request vem do Server request interface
	// Vamos utilizar o m�todo getParsedBody() do diactoros para receber os dados da requisi��o POST
	$data = $request->getParsedBody();
	// Utilizamos o model para pegar esses dados e incluir no banco
	\SONFin\Model\CategoryCost::create($data);
	return $app->route('category-costs.list');
},'category-costs.store');


// Rota pata formul�rio de edi��o de categoria de custo
// Como vamos pegar um dado do get, precisamos receber uma request no callback
$app->get('/category-costs/{id}/edit',function(ServerRequestInterface $request) use ($app) {
	$view = $app->service('view.renderer');
	
	//Pegando o valor do por get na request
	$id = $request->getAttribute('id');
	
	//Agora vamos utilizar o eloquent para fazer uma busca no banco a partir de uma id
	$category = \SONFin\Model\CategoryCost::findOrFail($id);
	
	//Agora renderizamos a view passando o valor buscado 
	return $view->render('category-costs/edit.html.twig',['category'=>$category]);
},'category-costs.edit');


// Rota para atualizar categoria de custo
$app->post('/category-costs/{id}/update',function(ServerRequestInterface $request) use ($app) {
	$id = $request->getAttribute('id');
	$category = \SONFin\Model\CategoryCost::findOrFail($id);
	$data = $request->getParsedBody();
	// Com o m�todo fill() do eloquent podemos popular um modelo com dados vindos de um array, chamado de massive assigment fazemos a atribui��o de valores no modelo, se no modelo tem o campo ID, troca pelo valor ID do array e etc
	$category->fill($data);
	$category->save();
	return $app->route('category-costs.list');
},'category-costs.update');


// Rota para aviso de dele��o
$app->get('/category-costs/{id}/warning',function(ServerRequestInterface $request)use($app){
	$view = $app->service('view.renderer');
	$id = $request->getAttribute('id');
	$category = \SONFin\Model\CategoryCost::findOrFail($id);
	return $view->render('category-costs/warning.html.twig',['category'=>$category]);
},'category-costs.warning');


// Rota para deletar categoria de custo
$app->get('/category-costs/{id}/delete',function(ServerRequestInterface $request)use($app){
	$id = $request->getAttribute('id');
	$category = \SONFin\Model\CategoryCost::findOrFail($id);
	$category->delete();
	return $app->route('category-costs.list');
},'category-costs.delete');


$app->start();


/*
// Definimos no application que o m�todo get() cria uma rota 
// ISSO FOI ANTES DE DEFINIR QUE AS NOSSAS ROTAS PRECISAM RETORNAR RESPONSES
$app->get("/inicio",function(){
	echo "hello world";
});


// Definindo uma rota que recebe os atributos da requisi��o. No caso vamos pegar os atributos do GET. Portanto quando a rota for acessada ela faz uma requisi��o ao servidor e espera uma resposta que vir� atrav�s de um objeto ServerRequestInterface
// Note que essa request s� responde se o endere�o for corretamente inclu�do, ou seja, uma barra fora de lugar e o servidor n�o ser� capaz de localizar a rota
// ISSO FOI ANTES DE DEFINIR QUE AS NOSSAS ROTAS PRECISAM RETORNAR RESPONSES

$app->get("/home/{name}/{id}",function(ServerRequestInterface $request){
	echo "mostrando a home <br>";
	echo $request->getAttribute('name');
	echo "<br>";
	echo $request->getAttribute('id');
});

// Agora ao inv�s de pegar os dados direto da interface vamos pegar os dados da resposta
$app->get("/response",function(ServerRequestInterface $request){
	// Note que vamos acessar diretamente os ultimos dados contidos nas resposta
	$response = new \Zend\Diactoros\Response();
	$response->getBody()->write("Resposta com emmiter do diactores");
	return $response;
});
*/