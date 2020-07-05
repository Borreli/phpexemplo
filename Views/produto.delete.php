<?php
header('location: produto.index.php'); // redireciona para o local indicado

spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});

use Db\Persiste;

if ( isset($_GET['id']) )
{
	$persiste = new Persiste();
	// id foi colocado 0 pois será gerado automaticamente pelo banco de dados
	$persiste->DeleteProduto($_GET['id']);
}

?>
