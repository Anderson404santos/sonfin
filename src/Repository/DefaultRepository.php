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
		// Para fazer a listagem basta utilizar o método elloquent::all() para retornar todos os dados do modelo  
		return $this->model->all()->toArray();	
	}
	public function create(array $data)
	{
		// Para fazer a inserção basta usar o metodo::fill() para mapear o objeto de acordo com o modelo. O método eloquent::fill() pega um array e compara suas chaves com o modelo e cria um objeto mapeando as chaves do array de acordo com o banco. É o que é chamado de inserção massiva
		// Feito isso utilizamos o método elloquent::all() para criar um novo registro no banco.
		$model = $this->model->fill($data);
		$model->save();
		return $this->model;
	}
	public function update(int $id,array $data)
	{
		// Para fazer a atualização de dados utilizando o método elloquent::find($id) ele vai retornar um objeto com os dados banco, caso encontre
		// Feito isso utilzamos o método elloquent::fill() vai mapear o objeto recebido com o modelo
		// Por fim utilizamos o método elloquent::save() para alterar o registro no banco. Como realizamos uma busca antes, ao executar o método eloquent::fill() o eloquent vai determinar que se trata de uma atualizaçao e não de uma inserção
		// Retornamos array com os dados inseridos, poderia ser o modelo não faz diferença
		$model = $this->find($id);
		$model->fill($data);
		$model->save();
		return $model;
	}
	public function delete(array $data){
		// Para deletar fazemos a busca utilizamos o método eloquent::find($id) e caso encontre utilizamos o método eloquent::delete() para remover o registro do banco
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