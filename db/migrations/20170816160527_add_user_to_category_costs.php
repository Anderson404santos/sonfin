<?php

use Phinx\Migration\AbstractMigration;

class AddUserToCategoryCosts extends AbstractMigration
{
	//Precisamos criar um relacionamento entre a tabela CategoryCosts e Users
	//Vamos modificar uma tabela que já existe no banco
	//Note que temos uma migration responsável por criar essa tabela, contudo não vamos utiliza-la para fazer a modificação. Isso acontece por que utilizar uma migration vai além de criar o banco via liguagem de programação
	//A grande ideia das migrations é a possibilidade de versionar o banco, assim sempre que você precisar mudar a estrutura do banco você deve criar uma nova migration. Por isso temos os métodos up(criação) e down(reversão). 
	//Não faz sentido utilizar migrações senão não for mantido o conceito de versionamento de banco
    public function up()
	{
		//Quando você dá um table() numa tabela que já existe no banco, o phinx faz alteração da tabela. Em seguita adicionamos uma nova linha na tabela e fazemos o relacionamento com o banco com o comando addForeignKey()
		$this->table('category_costs')
			 ->addColumn('user_id','integer')
			 ->addForeignKey('user_id','users','id')
			 ->save();
	}
	
	public function down(){
		//preste atenção na ordem de remoção no momento de criar um o down()
		//caso seja necessário reverter, lembre-se de ir no Model/CategoryCosts e remover a id do fillable
		$this->table('category_costs')
		     ->dropForeignKey('user_id')
			 ->removeColumn('user_id');
			 //->save();
	}
}