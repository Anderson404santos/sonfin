<?php
declare(strict_types=1);

namespace SONFin\View;
use Psr\Http\Message\ResponseInterface;

// Vamos criar uma interface para padronizar as entradas de views
interface ViewRenderInterface
{
	// O método render deve passar uma String com o código fonte da view, e um array com todas as variáveis vindas do modelo
	// Também padronizamos o retorno do método(PHP7.1) que precisa ser uma instancia do ResponseInterface
	public function render(string $template, array $context = []):ResponseInterface;
}