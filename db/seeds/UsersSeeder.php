<?php

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{	
    public function run()
    {
		$app = require(__DIR__ . '/../bootstrap.php');		
		$auth = $app->service('auth');
		$aa = 'teste';
		
		$faker = \Faker\Factory::create('pt_BR');
	 	$users = $this->table('users');
		$users->insert([
			'first_name' => $faker->firstName,
			'last_name' => $faker->lastName,
			'email' => 'admin@user.com',
			'password' =>  $auth->hashPassword('123546'),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')			
		])->save();
		$data = [];
		foreach(range(1,3) as $value){
			$data[] = [
					'first_name' => $faker->firstName,
					'last_name' => $faker->lastName,
					// Evita inserção duplicada
					'email' => $faker->unique()->email,
					'password' =>  $auth->hashPassword('123546'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')					
			];
		}		
		$users->insert($data)->save();
    }
}