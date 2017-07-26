<?php 
declare(strict_types=1);
namespace SONFin\Auth;

interface AuthInterface
{
	public function login(array $credentials);
	public function check();
	public function logout();
}