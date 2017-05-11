<?php
	
	// O comando exec() abre um executável do sistema e manda comandos a serem executados
	// Como cada sistem terá o seu propria linha de comando, este método não funciona para todos os sistemas operacionais, é útil em situações específicas
	
	// Então podemos criar alguns arquivos para automatizar alguns processos, no caso quando executarmos o MigrateSeed.php o nosso banco será zerado, recriado com dados falsos
	exec(__DIR__ . '/vendor/bin/phinx rollback - t=0');
	exec(__DIR__ . '/vendor/bin/phinx migrate');
	exec(__DIR__ . '/vendor/bin/phinx seed:run');
?>