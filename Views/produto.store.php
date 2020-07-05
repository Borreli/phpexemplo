<?php
header('location: produto.index.php');
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});

use Models\Produto;
use Db\Persiste;

if ( isset($_POST['nome_produto']) && isset($_POST['data_vencimento_produto']) && isset($_POST['valor_produto']))
{
	$persiste = new Persiste();
	// id foi colocado 0 pois será gerado automaticamente pelo banco de dados
	$novoProduto = new Produto(0,$_POST['nome_produto'],$_POST['data_vencimento_produto'], $_POST['valor_produto']);
	$persiste->AddProduto($novoProduto);
}

?>