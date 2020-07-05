<?php
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});
?>

<?php include 'cabecalho.php'; ?>

	<h4>Projetos</h4>
	<a href="projeto.create.php" class="btn btn-primary btn-small">Novo Projeto</a>
	<table class="table table-striped" style="margin-top: 5px">
	<?php
	use Db\Persiste;
	use Models\Projeto;
	$persiste = new Persiste();
	$projetos = $persiste->GetAllProjeto();
	if(! is_null($projetos)) {
		foreach($projetos as $p){
		$colaboradores = implode('; ', $p->getcolaboradores);
		echo "<tr><td>$p->getid</td><td>$p->getdescricao</td><td>$p->getorcamento</td><td>$colaboradores</td>"
			."<td><a href='projeto.edit.php?id=$p->getid' class='btn btn-primary btn-small'>Editar</a></td>"
			."<td><a href='projeto.delete.php?id=$p->getid' class='btn btn-primary btn-small'>Excluir</a></td></tr>";
		}	
	}
	
	?>
	</table>

<?php include 'rodape.php'; ?>
