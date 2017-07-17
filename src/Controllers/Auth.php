<?php

namespace SONFin\Model;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/login',function() use ($app) {
	$view = $app->service('view.renderer');
	return $view->render('auth/login.html.twig');
},'auth.login_form');

$app->post('/login',function(ServerRequestInterface $request) use ($app) {
	$app->service(name: 'auth')->login();
	$view = $app->service('view.renderer');
	return $view->render('auth/login.html.twig',['auth'=>$auth]);
},'auth.login');*/

