<?php

use Phinx\Seed\AbstractSeed;

// Seeder é o conceito de se criar de forma automatizada dados para se popular o banco de dados

class CategoryCostsSeeder extends AbstractSeed
{
	
	// Vamos customizar os nomes das categorias de custos, para isso vamos montar uma lista a ser inserida de forma randonica na criação da seed
	const NAMES = [
		'Telefone',
		'Supermercado',
		'Escola',
		'Agua',
		'Cartao',
		'Luz',
		'IPVA',
		'Imposto de Renda',
		'Gasolina',
		'Vertuario',
		'Entretenimento',
		'Reparos'
	];
	
    public function run()
    {
		// Vamos utilizar uma outra biblioteca para trabalhar junto com a seed, é o faker. É uma popular biblioteca do php para criação de dados falsos de teste. Com ela podemos criar datas, valores, cpf e até nomes em portugues para popular o nossos banco
		$faker = \Faker\Factory::create('pt_BR');

		// Para gerar a nossa coleção de dado vamos adicionar a propria classe de seed como provedor de dados, assim o faker será capaz de utilizar o método categoryName()  
		$faker->addProvider($this);

		// Para usar o seeder criamos um variável para receber a tabela no banco a qual queremos fazer inclusões
		$categoryCosts = $this->table('category_costs');
		
		// Para utilizar o faker vamos acessar a factory do faker e executar o método create, passando o idioma que será gerado os testes. A documentação do faker pode ser encontrada em: https://github.com/fzaninotto/Faker
		$data=[];		
		
		// Agora vamos colocar os nosso valores falsos dentro do array
		foreach(range(1,10) as $value){
			$data[] = [
					'name' => $faker->categoryName(),
					'user_id' => rand(1,4),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
			];
		}
			
		// Passamos para o método insert as entradas que queremos fazer no banco, criamos um array e dentro do array subArrays onde cada subarray representa uma entrada que queremos incluir no banco
		$categoryCosts->insert($data);
		
		// O método save() aplica inclusões no banco
		$categoryCosts->save();
    }
	
	// Método para retornar a coleção de nomes de forma randonica
	public function categoryName()
	{
		return Faker\Provider\Base::randomElement(self::NAMES);
	}
	
	//Feito a configuração, podemos então via terminal incluir os dados no banco
	// 'PHINX SEED:RUN'  esse comando executa todas as seeds criadas
	// Para executar numa seed em específico executamos o comando com a flag -s: 'PHINX SEED:RUN -sNOME_DA_SEED' 
	
}
