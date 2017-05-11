<?php
	
	// O comando exec() abre um execut�vel do sistema e manda comandos a serem executados
	// Como cada sistem ter� o seu propria linha de comando, este m�todo n�o funciona para todos os sistemas operacionais, � �til em situa��es espec�ficas
	
	// Ent�o podemos criar alguns arquivos para automatizar alguns processos, no caso quando executarmos o MigrateSeed.php o nosso banco ser� zerado, recriado com dados falsos
	exec(__DIR__ . '/vendor/bin/phinx rollback - t=0');
	exec(__DIR__ . '/vendor/bin/phinx migrate');
	exec(__DIR__ . '/vendor/bin/phinx seed:run');
?>