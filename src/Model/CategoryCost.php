<?php

namespace SONFin\Model;

use Illuminate\Database\Eloquent\Model;

// Na pasta model colocaremos todos os nossas classes que representar�o os modelos do banco
// Cada tabela do banco dever� ser mapeada por uma respectiva classe
// Para integrar o eloquent com as nossas classes de modelo basta extender as nossas classes de modelo � classe Model do Eloquent 
class CategoryCost extends Model
{
	// O Eloquent trabalha com entradas de dados segura, significa que ele s� salva dados se esse dado for mapeado na classe
	// Contudo o Eloquent tamb�m trabalha com um mecanismo de massive assigment, assim qualquer dado que se passa para os m�todos de controle do banco, voc� passa apenas o dado que o Eloquent se vira
	// Posto isso, podemos criar um atributo $fillable, o que voc� colocar aqui o eloquent vai conseiderar dado seguro e o passar� diretamente para o model
	protected $fillable = [
			'name'
	];
} 