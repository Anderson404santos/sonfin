<?php

namespace SONFin\Controller;
use Psr\Http\Message\ServerRequestInterface;

// Rota para tela de listagem de categoria de custo
$app->get('/category-costs',function() use ($app) {
	// Pegando o serviço de views
	$view = $app->service('view.renderer');
	// pegando o serviço de repository
	$repository = $app->service('category-costs.repository');
	// O comando CategoryCost::class retona apenas o nome da classe
	$categories = $repository->all();
	return $view->render('category-costs/list.html.twig',['categories'=>$categories]);
},'category-costs.list');


// Rota para formulário de cadastro de categoria de custo
$app->get('/category-costs/new',function() use ($app) {
	$view = $app->service('view.renderer');
	return $view->render('category-costs/create.html.twig');
},'category-costs.new');


// Rota para cadastrar categoria de custo
$app->post('/category-costs/store',function(ServerRequestInterface $request) use ($app) {
	// Vamos utilizar o método getParsedBody() do diactoros para receber os dados da requisição POST
	$data = $request->getParsedBody();
	$repository = $app->service('category-costs.repository');
	$repository->create($data);
	return $app->route('category-costs.list');
},'category-costs.store');


// Rota pata formulário de edição de categoria de custo
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
	// Com o método fill() do eloquent podemos popular um modelo com dados vindos de um array, chamado de massive assigment fazemos a atribuição de valores no modelo, se no modelo tem o campo ID, troca pelo valor ID do array e etc
	$category->fill($data);
	$category->save();
	return $app->route('category-costs.list');
},'category-costs.update');


// Rota para aviso de deleção
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

