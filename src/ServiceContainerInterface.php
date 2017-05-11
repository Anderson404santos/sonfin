<?php 
// Definindo que utilizaremos a notaчуo estrita do PHP, com ela podemos ativar a tipagem de variaveis, que щ uma novidade do PHP7
declare(strict_types=1);
namespace SONFin;

interface ServiceContainerInterface{
	// Com o PHP7 podemos tipar o tipo de variсvel. Observe que nуo щ como no java, se quisermos simplesmente nуo tipar o tipo de variсvel tambщm temos essa opчуo
	public function add(string $name,$service);
	public function addLazy(string $name, callable $callable);
	public function get(string $name);
	public function has(string $name);
}