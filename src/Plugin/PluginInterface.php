<?php
namespace SONFin\Plugin;

use SONFin\ServiceContainerInterface;

Interface PluginInterface{
	public function register(ServiceContainerInterface $container);
}