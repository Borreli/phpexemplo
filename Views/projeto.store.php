
<?php
header('location: projeto.index.php');
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});

use Models\Projeto;
use Db\Persiste;

if ( isset($_POST['descricao']) && isset($_POST['orcamento']))
{
	$persiste = new Persiste();
	$colaboradores = $_POST['colaboradores'];
	echo(var_dump($colaboradores));
	// id foi colocado 0 pois será gerado automaticamente pelo banco de dados
	$novoProjeto = new Projeto(0,$_POST['descricao'],$_POST['orcamento']);
	$projeto_id = $persiste->AddProjeto($novoProjeto);
	foreach ($colaboradores as $key => $colaborador) {
		$pessoa = $persiste->getPessoaByNome($colaborador);
		if($pessoa != null) {
			$persiste->AddPessoaProjeto($pessoa->getid, $projeto_id);
		}
	}
	
}

?>