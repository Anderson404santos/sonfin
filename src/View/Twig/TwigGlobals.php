<?php 

namespace SONfin\View\Twig;

use SONfin\Auth\AuthInterface;

// Precisamos colocar a sessão numa variável global do twig, assim não será necessário sempre ficar passando dados de sessao para rotas ou para templates
class TwigGlobals extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
	
	private $auth;
	
	public function __construct(AuthInterface $auth)
	{
		$this->auth = $auth;
	}
	
	public function getGlobals()
	{
		return [
			'Auth' => $this->auth
		];
	}
}