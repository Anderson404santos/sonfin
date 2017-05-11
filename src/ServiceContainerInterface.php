<?php 
// Definindo que utilizaremos a nota��o estrita do PHP, com ela podemos ativar a tipagem de variaveis, que � uma novidade do PHP7
declare(strict_types=1);
namespace SONFin;

interface ServiceContainerInterface{
	// Com o PHP7 podemos tipar o tipo de vari�vel. Observe que n�o � como no java, se quisermos simplesmente n�o tipar o tipo de vari�vel tamb�m temos essa op��o
	public function add(string $name,$service);
	public function addLazy(string $name, callable $callable);
	public function get(string $name);
	public function has(string $name);
}