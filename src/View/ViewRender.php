<?php
declare(strict_types=1);

namespace SONFin\View;

use Zend\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;

class ViewRender implements ViewRenderInterface
{
	private $twigEnvironment;
	
	// Aqui vamos injetar uma dependencias do ViewPlugin
	public function __construct(\Twig_Environment $twigEnvironment)
	{
		$this->twigEnvironment = $twigEnvironment;
	}
	
	// O esse método cria uma response com a view e os dados da view 
	public function render(string $template, array $context = []):ResponseInterface
	{
		$result = $this->twigEnvironment->render($template,$context);	
		$response = new Response(); 
		$response->getBody()->write($result);
		return $response;
	}
}