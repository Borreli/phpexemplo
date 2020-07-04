<?php

namespace Db; // agrupamento de classes (caminho)

// Referências a classes do PHP
use \PDO;
use \PDOException;
use \Models\Pessoa;
// Obs.: PDO implementa interação com Banco de Dados

// Inclui dados para conexão com banco de dados
include('ConfiguracaoConexao.php');

// Classe (ou Tipo) de Objeto
// obs.: Implementa métodos para inserção, deleção, alteração e recuperação de objetos persistidos em banco de dados
class Persiste{

	protected $pdo;

	function __construct() {
		$this->InicializarBancoDados();
		try {

			// Cria objeto PDO
			$this->pdo = new PDO(HOST_DB,USER,PASSWORD);

			// Configura o comportamento no caso de erros: levanta exceção.
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Não emula comandos preparados, usa nativo do driver do banco
			$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			echo $pex->getMessage();
			echo $pex->getCode();
		}
	}

	function __destruct() {
		$this->pdo = null;
	}

	public function InicializarBancoDados() {
		try {
			$local_pdo = new PDO('mysql:host='.HOST, USER, PASSWORD);
			$local_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// $local_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

			// Cria a database lp4
			$local_pdo->exec("CREATE DATABASE IF NOT EXISTS ".DB." CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");

			$local_pdo = new PDO(HOST_DB, USER, PASSWORD);
			$local_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// $local_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);			

			// Cria a tabela pessoas
			$local_pdo->exec("CREATE TABLE IF NOT EXISTS pessoas 
								   (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
									nome VARCHAR(150) NOT NULL,
									telefone VARCHAR(25),
									CONSTRAINT pk_pessoas
										PRIMARY KEY (id));");
			
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			echo $pex->getMessage();
			echo $pex->getCode();
		}
		
	}

	// Método para adicionar um objeto da classe Pessoa ao banco de dados
	// Nome da tabela será "pessoas": create table pessoas (id int not null primary key AUTO_INCREMENT, nome varchar (100) not null, telefone varchar(20) not null)
	public function AddPessoa(Pessoa $obj){
		
		try {
			$stmt = $this->pdo->prepare('insert into pessoas (nome,telefone) values (:nome,:telefone)');
			$stmt->bindParam(':nome',$pnome);
			$stmt->bindParam(':telefone',$ptelefone);

			$pnome = $obj->getnome;
			$ptelefone = $obj->gettelefone;

			// Executa comando SQL
			$stmt->execute();

			$retorno = true;

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}

	public function GetAllPessoa() //($inicioPagina,$tamanhoPagina)
	{
		try {
			//$stmt = $this->pdo->prepare('select id, nome, telefone from pessoas order by id limit :inicioPagina, :tamanhoPagina');
			// $stmt->bindParam(':inicioPagina',$inicioPagina);
			// $stmt->bindParam(':tamanhoPagina',$tamanhoPagina);

			$stmt = $this->pdo->prepare('select id, nome, telefone from pessoas order by id');

			// Executa comando SQL
			$stmt->execute();

			// Resultado na forma de vetor associativo
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			// Carrega em $tabela dados resultandes do select (vetro associativo)
			$tabela = $stmt->fetchAll();

			// Criar vetor de objetos Pessoa a ser retornado
			$retorno = []; // vetor vazio
			foreach($tabela as $i=>$v){
				array_push($retorno,new Pessoa($v['id'],$v['nome'],$v['telefone']));
			}

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = null;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}

	public function GetPessoaById($id)
	{
		try {
			// Cria objeto comando preparado
			$stmt = $this->pdo->prepare('select id, nome, telefone from pessoas where id=:i');

			// liga parametros do SQL ao parâmetro $id do método GetPessoaById
			$stmt->bindParam(':i',$id);

			// Executa comando SQL
			$stmt->execute();

			// Resultado na forma de vetor associativo
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			// Carrega em $linha dados resultandes do select (vetor associativo com uma célula)
			$linha = $stmt->fetchAll();

			// Criar vetor de objetos Pessoa a ser retornado
			$retorno = new Pessoa($linha[0]['id'],$linha[0]['nome'],$linha[0]['telefone']); 

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = null;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}

	public function UpdatePessoa(Pessoa $obj)
	{
		// sql: update pessoas set nome=:nnome, telefone=:ntel where id=:id

		try {
			$stmt = $this->pdo->prepare('update pessoas set nome=:nnome, telefone=:ntel where id=:id');

			$stmt->bindParam(':id',$pid);
			$stmt->bindParam(':nnome',$pnome);
			$stmt->bindParam(':ntel',$ptelefone);

			$pid = $obj->getid;
			$pnome = $obj->getnome;
			$ptelefone = $obj->gettelefone;

			// Executa comando SQL
			$stmt->execute();

			$retorno = true;

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY	
		}

		return $retorno;

	}

	public function DeletePessoa($id)
	{
		// sql: delete from pessoa where id=:id
		try {
			$stmt = $this->pdo->prepare('delete from pessoas where id=:id');

			$stmt->bindParam(':id',$id);

			// Executa comando SQL
			$stmt->execute();

			$retorno = true;

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY	
		}

		return $retorno;
	}

}
?>