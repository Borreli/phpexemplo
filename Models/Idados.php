<?php
namespace Models; // agrupamento de classes/interfaces (caminho)

// Interfaces estabelecem os métodos públicos que devem existir nas classes que as implementam, ou seja, métodos que interfaceiam com outras partes de código.
interface Idados{
	public function toJson();
	public function toString();
}
?>