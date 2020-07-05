<?php
namespace Models; // agrupamento de classes (caminho)

// Classe (ou Tipo) de Objeto
// obs.: Pessoa implementa a interface Idados, significando que implementa todos os métodos definidos pela interface.
	class Pessoa implements Idados{
	// Propriedades
	protected $id;
	protected $nome_produto;
	protected $data_vencimento_produto;
	protected $valor_produto;
	// obs.: propriedades protected são acessíveis por subclasses (extend)

	// Método construtor.
	public function __construct($id,$nome_produto,$data_vencimento_produto,$valor_produto){
		$this->id=$id;
		$this->nome_produto=$nome_produto;
		$this->data_vencimento_produto=$data_vencimento_produto;
		$this->valor_produto=$valor_produto;
	}

	// Método obrigatório pois é definido na interface
	public function toString(){
		return $this->id.' '.$this->nome_produto.' '.$this->data_vencimento_produto.' '.$this->valor_produto;
	}

	// Método obrigatório pois é definido na interface
	public function toJson() {
		return json_encode(['id'=>$this->id,'nome_produto'=>$this->nome_produto,'data_vencimento_produto'=>$this->data_vencimento_produto, 'valor_produto'=>$this->valor_produto ]);
	}

	// Métodos estáticos (static) são chamados sem instanciar objetos. Utiliza-se o nome da classe seguido de quatro pontos. Exemplo a seguir.
	// $jp = Pessoa::toJsonEstatico(10,'Computador','21/10/2020', '1000.00');
	public static function toJsonEstatico ($id,$nome,$telefone) {
		return json_encode(['id'=>$id,'nome_produto'=>$nome_produto,'data_vencimento_produto'=>$data_vencimento_produto,'valor_produto'=>$valor_produto]);
	}

	// Inclui o conteúdo do Trait
	use trait__get;
}