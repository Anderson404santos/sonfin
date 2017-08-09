<?php 

namespace SONfin\View\Twig;

use SONfin\Auth\AuthInterface;

// Precisamos colocar a sess�o numa vari�vel global do twig, assim n�o ser� necess�rio sempre ficar passando dados de sessao para rotas ou para templates
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