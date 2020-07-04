<?php
	namespace Models; // agrupamento de classes e outros componentes (caminho)

	// Trait implementam métodos que são incluídos em várias classes.
	trait trait__get{

		// O método mágico __get é usado aqui para expor os valores das propriedades private e protected.
		public function __get($property){
			return $this->{substr($property,3)};
		}
	}
?>