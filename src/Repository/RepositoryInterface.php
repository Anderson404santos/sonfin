<?php
declare(strict_types=1);
namespace SONFin\Repository;


//Repository � um Design patterns que consiste em dividir a responsabilidade do modelo com o reposit�rio
//O modelo se preocupa em fornecer um modelo para os dados de uma entidade, quando o repository vai se preocupar de como isso � feito
//Em outras palavras separamos do modelo a responsabilidade de fazer querys, de qual tipo de banco vamos utilizar, tudo isso passa a ser fun��o do repository enquanto o modelo apenas se preocupa em servir como mapa para o que est� no banco
Interface RepositoryInterface
{
	public function all();
	public function create(array $data);
	public function update(int $id,array $data);
	public function delete(array $data);
	public function find(int $id, bool $failIfNotExists = true);
	public function findByField(string $field,$value);
}