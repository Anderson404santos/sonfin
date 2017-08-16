<?php
exec(__DIR__ . '/vendor/bin/phinx rollback -t=0');
exec(__DIR__ . '/vendor/bin/phinx migrate');
//Agora que adicionamos relacionamentos no nosso banco, não podemos mais executar todas as seeds de uma única vez, precisamos rodar as seeds na ordem correta evitando erros de referência
//exec(__DIR__ . '/vendor/bin/phinx seed:run');
exec(__DIR__ . '/vendor/bin/phinx seed:run -s UsersSeeder');
exec(__DIR__ . '/vendor/bin/phinx seed:run -s CategoryCostsSeeder');