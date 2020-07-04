<?php
header('location: pessoa.index.php'); // redireciona para o local indicado

spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});

use Models\Pessoa;
use Db\Persiste;

if ( isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['telefone']))
{
	// id foi colocado 0 pois será gerado automaticamente pelo banco de dados
	$p = new Pessoa($_POST['id'],$_POST['nome'],$_POST['telefone']);
	Persiste::UpdatePessoa($p);
}

?>
