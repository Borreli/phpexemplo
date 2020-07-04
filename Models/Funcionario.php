<?php
namespace Models; // agrupamento de classes (caminho)

// Classe (ou Tipo) de Objeto
// obs.: Funcionario extende Pessoa e herda suas propriedades e métodos. Funcionario representa uma categoria específica de Pessoa.
class Funcionario extends Pessoa{
	// Propriedades
	private $salario;
	private $atividades=[];
	// obs.: propriedades private não são acessíveis por subclasses

	// Método construtor.
	public function __construct($id,$nome,$telefone,$salario){
		// Executa o construtor da classe pai
		parent::__construct($id,$nome,$telefone);
		$this->salario=$salario;
	}

	// Esta versão do método sobrescreve o herdado, pois é necessário adicionar outros dados ao json gerado.
	public function toJson() {
		$va = [];
		foreach($this->atividades as $v){
			array_push($va,$v->toArray());
		}
		//$va = json_encode($va);
		return stripslashes(json_encode(['id'=>$this->id,'nome'=>$this->nome,'telefone'=>$this->telefone,'salario'=>$this->salario,'atividades'=>$va]));
	}

	// Esta versão do método sobrescreve o herdado, pois é necessário adicionar outros dados ao json gerado.
	public function toString(){
		return parent::toString().' '.$this->salario;
		// parent refere-se a classe pai
	}

	// Método que adiciona atividades a funcionários
	public function adAtividade(Atividade $a){
		array_push($this->atividades,$a);
		// array_push insere novo valor no final do vetor
	}

	// Inclui o conteúdo do Trait
	use trait__get;
}
?>