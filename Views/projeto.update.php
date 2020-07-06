<?php
header('location: projeto.index.php');
spl_autoload_register(function ($class_name) {
    include '..\\'.$class_name . '.php';
});

use Models\Projeto;
use Db\Persiste;

if ( isset($_POST['id']) && isset($_POST['descricao']) && isset($_POST['orcamento']))
{
	$persiste = new Persiste();
	$colaboradores = $_POST['colaboradores'];
	echo(var_dump($colaboradores));
	// id foi colocado 0 pois será gerado automaticamente pelo banco de dados
	$projeto = new Projeto((int)$_POST['id'],$_POST['descricao'],$_POST['orcamento'], null);
	$persiste->UpdateProjeto($projeto);
	$persiste->DeletePessoaProjetoByProjeto($projeto->getid);
	foreach ($colaboradores as $key => $colaborador) {
		$pessoa = $persiste->getPessoaByNome($colaborador);
		if($pessoa != null) {
			$persiste->AddPessoaProjeto($pessoa->getid, $projeto->getid);
		}
	}
	
}

?>