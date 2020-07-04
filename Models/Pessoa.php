<?php
namespace Models; // agrupamento de classes (caminho)

// Classe (ou Tipo) de Objeto
// obs.: Pessoa implementa a interface Idados, significando que implementa todos os métodos definidos pela interface.
class Pessoa implements Idados{
	// Propriedades
	protected $id;
	protected $nome;
	protected $telefone;
	// obs.: propriedades protected são acessíveis por subclasses (extend)

	// Método construtor.
	public function __construct($id,$nome,$telefone){
		$this->id=$id;
		$this->nome=$nome;
		$this->telefone=$telefone;
	}

	// Método obrigatório pois é definido na interface
	public function toString(){
		return $this->id.' '.$this->nome.' '.$this->telefone;
	}

	// Método obrigatório pois é definido na interface
	public function toJson() {
		return json_encode(['id'=>$this->id,'nome'=>$this->nome,'telefone'=>$this->telefone]);
	}

	// Métodos estáticos (static) são chamados sem instanciar objetos. Utiliza-se o nome da classe seguido de quatro pontos. Exemplo a seguir.
	// $jp = Pessoa::toJsonEstatico(20,'Maria','2222');
	public static function toJsonEstatico ($id,$nome,$telefone) {
		return json_encode(['id'=>$id,'nome'=>$nome,'telefone'=>$telefone]);
	}

	// Inclui o conteúdo do Trait
	use trait__get;
}