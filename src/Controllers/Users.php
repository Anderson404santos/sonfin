<?php

namespace SONFin\Controller;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/users',function() use ($app) {
	$view = $app->service('view.renderer');
	$repository = $app->service('users.repository');
	$users = $repository->all();
	return $view->render('users/list.html.twig',['users'=>$users]);
},'users.list');


$app->get('/users/new',function() use ($app) {
	$view = $app->service('view.renderer');
	return $view->render('users/create.html.twig');
},'users.new');


$app->post('/users/store',function(ServerRequestInterface $request) use ($app) {
	$data = $request->getParsedBody();
	$repository = $app->service('users.repository');
	$repository->create($data);
	return $app->route('users.list');
},'users.store');


$app->get('/users/{id}/edit',function(ServerRequestInterface $request) use ($app) {
	$view = $app->service('view.renderer');
	$id = $request->getAttribute('id');
	$users = \SONFin\Model\users::findOrFail($id);	
	return $view->render('users/edit.html.twig',['users'=>$users]);
},'users.edit');


$app->post('/users/{id}/update',function(ServerRequestInterface $request) use ($app) {
	$id = $request->getAttribute('id');
	$users = \SONFin\Model\Users::findOrFail($id);
	$data = $request->getParsedBody();
	$users->fill($data);
	$users->save();
	return $app->route('users.list');
},'users.update');


$app->get('/users/{id}/warning',function(ServerRequestInterface $request)use($app){
	$view = $app->service('view.renderer');
	$id = $request->getAttribute('id');
	$users = \SONFin\Model\Users::findOrFail($id);
	return $view->render('users/warning.html.twig',['users'=>$users]);
},'users.warning');


$app->get('/users/{id}/delete',function(ServerRequestInterface $request)use($app){
	$id = $request->getAttribute('id');
	$users = \SONFin\Model\Users::findOrFail($id);
	$users->delete();
	return $app->route('users.list');
},'users.delete');