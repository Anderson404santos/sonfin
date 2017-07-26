<?php 

// Booststrap � um arquivo para copiar a estrutura da nossa aplica��o para dentro do contexto da seeder. 

use SONFin\Application;
use SONFin\Plugin\AuthPlugin;
use SONFin\Plugin\DbPlugin;
use SONFin\ServiceContainer;

$serviceContainer = new ServiceContainer();
$app =  new Application($serviceContainer);

$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

// Vamos retornar o $app. Quando a nossa seeder der um require para no bootstrap ele poder� receber o $app como retorno. Isso nos livra de ter que fazer ajustes para utilizar as vari�veis que criamos aqui.
return $app;