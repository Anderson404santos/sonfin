<?php

use Phinx\Migration\AbstractMigration;

// A nossa migration vai extender o metodo AbstractMigration, ele possui uma série de métodos que nos ajudara a gerenciar o nosso banco sem a necessidade de mandar QUERY SQL para o banco
class CreateCategoryCosts extends AbstractMigration
{
	// Criar migração
    public function up()
    {
		//Criando uma tabela chamada 'category_costs'. Note que estamos utilizando a notação de métodos aninhados do PHP5
		$this->table('category_costs')			
			// Adicionando as colunas da tabela
			->addColumn('name','string')
			->addColumn('created_at','datetime')
			->addColumn('updated_at','datetime')
			// Com o método save() salvamos as alterações no banco
			->save();
			
		// Para efetuar uma migrate abrir o phinx no console e executar o comando PHINX MIGRATE
    }
	
	// Reverter a migração feita
	public function down()
    {
		// Note que essa reversão não é feita de forma automática, precisamos indicar qual é o caminho
		$this->dropTable('category_costs');
		
		// Para realizar uma reversão basta abrir o PHINX no console e executar o  comando PHINX ROLLBACK
    }
	
	// O phinx efetua os comandos up() ou down() apenas uma vez, se você já efetuou um up() não conseguirá efetuar novamente até efetuar o down()
	// Quando utilizamos o comando MIGRATION ou ROLLBACK todas as migrations ou reversões ainda não efetuadas serão executadas
	// Para fazer uma migration em especifico ou reverte-la uma já feita é necessário utilizar a flag -t passando o código da migration ex: PHINX ROLLBACK -t=2017049164553 
	// Ao cria o arquivo de configuração do phinx podemos criar vários tipos de usuário, mas normalmente criamos DEVELOPMENT ou PRODUCTION. Ainda no arquido de configuração do phinx definimos um tipo de conexão padrão. Para executar um comando selecionando o tipo de conexao via linha de comando podemos utilizar a flag -e . ex: PHINX MIGRATE -eproduction
	// Ainda podemos executar um rollback com a opção -t=0 para fazer o phinx executar todos dos downs de todas as migrations, assim zerando o banco. Ex: PHINX ROLLBACK -t=0
}