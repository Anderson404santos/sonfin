<?php

namespace SONFin\Repository;
use SONFin\Repository\RepositoryInterface;

class DefaultRepository implements RepositoryInterface
{
	private $modelClass;
	private $model;
		
	public function __construct(string $modelClass)
	{
		$this->modelClass = $modelClass;
		$this->model = new $modelClass;
	}
	
	public function all()
	{
		// Para fazer a listagem basta utilizar o m�todo elloquent::all() para retornar todos os dados do modelo  
		return $this->model->all()->toArray();	
	}
	public function create(array $data)
	{
		// Para fazer a inser��o basta usar o metodo::fill() para mapear o objeto de acordo com o modelo. O m�todo eloquent::fill() pega um array e compara suas chaves com o modelo e cria um objeto mapeando as chaves do array de acordo com o banco. � o que � chamado de inser��o massiva
		// Feito isso utilizamos o m�todo elloquent::all() para criar um novo registro no banco.
		$model = $this->model->fill($data);
		$model->save();
		return $this->model;
	}
	public function update(int $id,array $data)
	{
		// Para fazer a atualiza��o de dados utilizando o m�todo elloquent::find($id) ele vai retornar um objeto com os dados banco, caso encontre
		// Feito isso utilzamos o m�todo elloquent::fill() vai mapear o objeto recebido com o modelo
		// Por fim utilizamos o m�todo elloquent::save() para alterar o registro no banco. Como realizamos uma busca antes, ao executar o m�todo eloquent::fill() o eloquent vai determinar que se trata de uma atualiza�ao e n�o de uma inser��o
		// Retornamos array com os dados inseridos, poderia ser o modelo n�o faz diferen�a
		$model = $this->find($id);
		$model->fill($data);
		$model->save();
		return $model;
	}
	public function delete(array $data){
		// Para deletar fazemos a busca utilizamos o m�todo eloquent::find($id) e caso encontre utilizamos o m�todo eloquent::delete() para remover o registro do banco
		$model = $this->find($id);
		$model->delete();
	}
	public function find(int $id, bool $failIfNotExists = true){
		// Para buscar pelo id apenas utilizamos o metodo Eloquent:find(id)
		return $failIfNotExists? $this->model->findOrFail($id) : $this->model->find($id);
	}
	
	public function findByField(string $field,$value){
		return $this->model->where($field,'=',$value)->get();
	}
}