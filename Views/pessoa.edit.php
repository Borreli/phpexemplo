<?php include 'cabecalho.php'; ?>

<?php
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});

use Models\Pessoa;
use Db\Persiste;

$p = Persiste::GetPessoaById($_GET['id']);

?>

<h3>Editar Pessoa</h3>
<div class=container>
	<div class="row">
		<div class="col-sm-6">
			<form action="pessoa.update.php" method="post">
				<input type="hidden" name="id" value="<?= $p->getid ?>">
				<div class="form-group">
					<label for="nome">Nome</label>
					<input type="text" value="<?= $p->getnome ?>" name="nome" class="form-control" maxlength="100" required />
				</div>
				<div class="form-group">
					<label for="telefone">Telefone</label>
					<input type="text" value="<?= $p->gettelefone ?>" name="telefone" class="form-control" maxlength="20" required/>
				</div>
				<div class="form-group">
					<input type="submit" value="Salvar" class="btn btn-primary btn-small"/>
					<a href="pessoa.index.php" class="btn btn-primary btn-small">Voltar</a>
				</div>
			</form>		
		</div>
	</div>
</div>

<?php include 'rodape.php'; ?>
