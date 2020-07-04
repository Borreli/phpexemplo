<?php
header('location: pessoa.index.php');
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});

use Models\Pessoa;
use Db\Persiste;

if ( isset($_POST['nome']) && isset($_POST['telefone']))
{
	// id foi colocado 0 pois será gerado automaticamente pelo banco de dados
	$novaPessoa = new Pessoa(0,$_POST['nome'],$_POST['telefone']);
	Persiste::AddPessoa($novaPessoa);
}

?>
