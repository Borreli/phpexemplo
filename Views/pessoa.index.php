<?php
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});
?>

<?php include 'cabecalho.php'; ?>

	<h4>Pessoas</h4>
	<a href="pessoa.create.php" class="btn btn-primary btn-small">Nova Pessoa</a>
	<table class="table table-striped" style="margin-top: 5px">
	<?php
	use Db\Persiste;
	use Models\Pessoa;
	$pessoas = Persiste::GetAllPessoa();

	foreach($pessoas as $p){
		echo "<tr><td>$p->getid</td><td>$p->getnome</td><td>$p->gettelefone</td>"
			."<td><a href='pessoa.edit.php?id=$p->getid' class='btn btn-primary btn-small'>Editar</a></td>"
			."<td><a href='pessoa.delete.php?id=$p->getid' class='btn btn-primary btn-small'>Excluir</a></td></tr>";
	}
	?>
	</table>

<?php include 'rodape.php'; ?>
