<?php include 'cabecalho.php'; ?>

<h3>Criar Pessoa</h3>
<div class=container>
	<div class="row">
		<div class="col-sm-6">
			<form action="pessoa.store.php" method="post">
				<div class="form-group">
					<label for="nome">Nome</label>
					<input type="text" name="nome" class="form-control" maxlength="100" required />
				</div>
				<div class="form-group">
					<label for="telefone">Telefone</label>
					<input type="text" name="telefone" class="form-control" maxlength="20" required/>
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
