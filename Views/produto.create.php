<?php include 'cabecalho.php'; ?>

<h3>Criar Produto</h3>
<div class=container>
	<div class="row">
		<div class="col-sm-6">
			<form action="produto.store.php" method="post">
				<div class="form-group">
					<label for="nome">Nome</label>
					<input type="text" name="nome_produto" class="form-control" maxlength="100" required />
				</div>
				<div class="form-group">
					<label for="data_vencimento_produto">Data de Vencimento</label>
					<input type="date" name="data_vencimento_produto" class="form-control" required/>
				</div>
				<div class="form-group">
					<label for="valor_produto">Valor</label>
					<input type="text" name="valor_produto" class="form-control" maxlength="20" required/>
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