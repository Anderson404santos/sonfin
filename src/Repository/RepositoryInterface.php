<?php
declare(strict_types=1);
namespace SONFin\Repository;


//Repository й um Design patterns que consiste em dividir a responsabilidade do modelo com o repositуrio
//O modelo se preocupa em fornecer um modelo para os dados de uma entidade, quando o repository vai se preocupar de como isso й feito
//Em outras palavras separamos do modelo a responsabilidade de fazer querys, de qual tipo de banco vamos utilizar, tudo isso passa a ser funзгo do repository enquanto o modelo apenas se preocupa em servir como mapa para o que estб no banco
Interface RepositoryInterface
{
	public function all();
	public function create(array $data);
	public function update(int $id,array $data);
	public function delete(array $data);
	public function find(int $id, bool $failIfNotExists = true);
	public function findByField(string $field,$value);
}