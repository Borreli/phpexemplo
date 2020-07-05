<?php
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});
?>

<?php 
	include 'cabecalho.php'; 
	use Db\Persiste;
	$persiste = new Persiste();
?>
<h3>Criar Projeto</h3>
<div class=container>
	<div class="row">
		<div class="col-sm-6">
			<form action="projeto.store.php" method="post">
				<div class="form-group">
					<label for="descricao">Descrição</label>
					<input type="text" name="descricao" class="form-control" maxlength="100" required />
				</div>
				<div class="form-group">
					<label for="orcamento">Orçamento</label>
					<input type="number" name="orcamento" step="0.01" class="form-control" maxlength="9" max="9999999" required/>
				</div>
				<div class=" form-group">
					<label for="colaboradores[]">Colaboradores</label>
					<div class="input-group control-group after-add-more">
						<input type="text" name="colaboradores[]" class="form-control" list="colab"/>
						<div class="input-group-btn"> 
				            <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
				          </div>
					</div>
					
				</div>

				<div class="copy invisible">
					<div class="control-group input-group" style="margin-top:10px">
			            <input type="text" name="colaboradores[]" class="form-control" list="colab">
			            <div class="input-group-btn"> 
			              <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
			            </div>
		          	</div>
				</div>

				<datalist id="colab">
					<?php foreach ($persiste->GetAllPessoa() as $key => $pessoa) {
						echo "<option value=".$pessoa->getnome.">";
					} ?>
				</datalist>


				<script type="text/javascript">


				    $(document).ready(function() {


				      $(".add-more").click(function(){ 
				          var html = $(".copy").html();
				          $(".after-add-more").after(html);
				      });


				      $("body").on("click",".remove",function(){ 
				          $(this).parents(".control-group").remove();
				      });


				    });


				</script>


				<div class="form-group">
					<input type="submit" value="Salvar" class="btn btn-primary btn-small"/>
					<a href="projeto.index.php" class="btn btn-primary btn-small">Voltar</a>
				</div>
			</form>		
		</div>
	</div>
</div>

<?php include 'rodape.php'; ?>
