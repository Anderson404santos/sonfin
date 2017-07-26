<?php
exec(__DIR__ . '/vendor/bin/phinx rollback -t=0');
exec(__DIR__ . '/vendor/bin/phinx migrate');
print_r(exec(__DIR__ . '/vendor/bin/phinx seed:run -s UsersSeeder') );
exec(__DIR__ . '/vendor/bin/phinx seed:run -s CategoryCostsSeeder');
	