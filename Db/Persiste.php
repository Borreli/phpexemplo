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

	// Método para adicionar um objeto da classe Pessoa ao banco de dados
	// Nome da tabela será "pessoas": create table pessoas (id int not null primary key AUTO_INCREMENT, nome varchar (100) not null, telefone varchar(20) not null)
	public static function AddPessoa(Pessoa $obj){
		
		try {
			// Cria objeto PDO
			$pdo = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Não emula comandos preparados, usa nativo do driver do banco
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

			$stmt = $pdo->prepare('insert into pessoas (nome,telefone) values (:nome,:telefone)');
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
		} finally {
			$pdo=null;
		}

		return $retorno;
	}

	public static function GetAllPessoa() //($inicioPagina,$tamanhoPagina)
	{
		try {
			// Cria objeto PDO
			$pdo = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Não emula comandos preparados, usa nativo do driver do banco
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

			//$stmt = $pdo->prepare('select id, nome, telefone from pessoas order by id limit :inicioPagina, :tamanhoPagina');
			// $stmt->bindParam(':inicioPagina',$inicioPagina);
			// $stmt->bindParam(':tamanhoPagina',$tamanhoPagina);

			$stmt = $pdo->prepare('select id, nome, telefone from pessoas order by id');

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
		} finally {
			$pdo=null;
		}

		return $retorno;
	}

	public static function GetPessoaById($id)
	{
		try {
			// Cria objeto PDO
			$pdo = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Não emula comandos preparados, usa nativo do driver do banco
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

			// Cria objeto comando preparado
			$stmt = $pdo->prepare('select id, nome, telefone from pessoas where id=:i');

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
		} finally {
			$pdo=null;
		}

		return $retorno;
	}

	public static function UpdatePessoa(Pessoa $obj)
	{
		// sql: update pessoas set nome=:nnome, telefone=:ntel where id=:id

		try {
			// Cria objeto PDO
			$pdo = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Não emula comandos preparados, usa nativo do driver do banco
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

			$stmt = $pdo->prepare('update pessoas set nome=:nnome, telefone=:ntel where id=:id');

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
		} finally {
			$pdo=null;
		}

		return $retorno;

	}

	public static function DeletePessoa($id)
	{
		// sql: delete from pessoa where id=:id
		try {
			// Cria objeto PDO
			$pdo = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Não emula comandos preparados, usa nativo do driver do banco
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

			$stmt = $pdo->prepare('delete from pessoas where id=:id');

			$stmt->bindParam(':id',$id);

			// Executa comando SQL
			$stmt->execute();

			$retorno = true;

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY	
		} finally {
			$pdo=null;
		}

		return $retorno;
	}

}
?>