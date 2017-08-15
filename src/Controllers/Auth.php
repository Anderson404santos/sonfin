<?php

namespace SONFin\Controller;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/login',function() use ($app) {
	$view = $app->service('view.renderer');
	return $view->render('auth/login.html.twig');
},'auth.login_form');

$app->post('/login',function(ServerRequestInterface $request) use ($app) {
	$view = $app->service('view.renderer');
	$auth = $app->service('auth');
	$data = $request->getParsedBody();
	$result = $auth->login($data);		
	if(!$result){
		return $view->render('auth/login.html.twig');
	}
	return $app->route('category-costs.list');
},'auth.login');

$app->get('/logout',function() use ($app) {
	$app->service('auth')->logout();
	return $app->route('auth.login_form');
},'auth.logout');

// Caso seja necessário processar qualquer outra coisa antes de acessar uma rota, basta criar outro middleware
$app->middleware(function() use($app){
	$route = $app->service('route');
	$auth = $app->service('auth');
	// Aqui fica as rotas que não necessitam de verificação, funciona como se fosse uma whitelist
	$routes = [
		'auth.login_form',
		'auth.login'
	];
	// Se a rota acessada não estiver na nossa white list ou e usuário não estiver logado, se as duas condições não forem verdadeiras então fazemos o um redirecionamento para a tela de login, sem que a aplicação da rota seja executada.
	// Assim colocamos uma barreira na nossa rota para pessoas autenticadas
	if(!in_array($route->name,$routes) && !$auth->check()){
		return $app->route('auth.login_form');
	}
});