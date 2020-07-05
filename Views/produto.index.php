<?php
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});
?>

<?php include 'cabecalho.php'; ?>

	<h4>Produto</h4>
	<a href="produto.create.php" class="btn btn-primary btn-small">Novo Produto</a>
	<table class="table table-striped" style="margin-top: 5px">
	<?php
	use Db\Persiste;
	use Models\Produto;
	$persiste = new Persiste();
	$produtos = $persiste->GetAllProduto();
	if(! is_null($produtos)) {
		foreach($produtos as $p){
		echo "<tr><td>$p->getid</td><td>$p->getnome_produto</td><td>$p->getdata_vencimento_produto</td><td>$p->getvalor_produto</td>"
			."<td><a href='produto.edit.php?id=$p->getid' class='btn btn-primary btn-small'>Editar</a></td>"
			."<td><a href='produto.delete.php?id=$p->getid' class='btn btn-primary btn-small'>Excluir</a></td></tr>";
		}	
	}
	
	?>
	</table>

<?php include 'rodape.php'; ?>