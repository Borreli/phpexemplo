<?php
namespace Models; // agrupamento de classes (caminho)

// Classe (ou Tipo) de Objeto
// obs.: Projeto implementa a interface Idados, significando que implementa todos os métodos definidos pela interface.
class Projeto implements Idados{
	// Propriedades
	protected $id;
	protected $descricao;
	protected $orcamento;
	protected $colaboradores;
	// obs.: propriedades protected são acessíveis por subclasses (extend)

	// Método construtor.
	public function __construct($id,$descricao,$orcamento,$colaboradores){
		$this->id=$id;
		$this->descricao=$descricao;
		$this->orcamento=$orcamento;
		$this->colaboradores=$colaboradores;
	}

	// Método obrigatório pois é definido na interface
	public function toString(){
		return $this->id.' '.$this->descricao.' '.$this->orcamento;
	}

	// Método obrigatório pois é definido na interface
	public function toJson() {
		return json_encode(['id'=>$this->id,'descricao'=>$this->descricao,'orcamento'=>$this->orcamento]);
	}

	// Métodos estáticos (static) são chamados sem instanciar objetos. Utiliza-se o descricao da classe seguido de quatro pontos. Exemplo a seguir.
	// $jp = Projeto::toJsonEstatico(20,'Maria','2222');
	public static function toJsonEstatico ($id,$descricao,$orcamento) {
		return json_encode(['id'=>$id,'descricao'=>$descricao,'orcamento'=>$orcamento]);
	}

	// Inclui o conteúdo do Trait
	use trait__get;
}