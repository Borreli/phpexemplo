<?php include 'cabecalho.php'; ?>

<?php
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});

use Models\Produto;
use Db\Persiste;

$persiste = new Persiste();
$p = $persiste->GetProdutoById($_GET['id']);

?>

<h3>Editar Produto</h3>
<div class=container>
	<div class="row">
		<div class="col-sm-6">
			<form action="produto.update.php" method="post">
				<input type="hidden" name="id" value="<?= $p->getid ?>">
				<div class="form-group">
					<label for="nome_produto">Nome</label>
					<input type="text" value="<?= $p->getnome_produto ?>" name="nome_produto" class="form-control" maxlength="100" required />
				</div>
				<div class="form-group">
					<label for="data_vencimento_produto">Data de Vencimento</label>
					<input type="date" value="<?= $p->getdata_vencimento_produto ?>" name="data_vencimento_produto" class="form-control" required/>
				</div>
				<div class="form-group">
					<label for="valor_produto">Valor</label>
					<input type="text" value="<?= $p->getvalor_produto ?>" name="valor_produto" class="form-control" maxlength="20" required/>
				</div>
				<div class="form-group">
					<input type="submit" value="Salvar" class="btn btn-primary btn-small"/>
					<a href="produto.index.php" class="btn btn-primary btn-small">Voltar</a>
				</div>
			</form>		
		</div>
	</div>
</div>

<?php include 'rodape.php'; ?>
