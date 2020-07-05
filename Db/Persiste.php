<?php

namespace Db; // agrupamento de classes (caminho)

// Referências a classes do PHP
use \PDO;
use \PDOException;
use \Models\Pessoa;
use \Models\Projeto;
use \Models\Produto;
// Obs.: PDO implementa interação com Banco de Dados

// Inclui dados para conexão com banco de dados
include('ConfiguracaoConexao.php');

// Classe (ou Tipo) de Objeto
// obs.: Implementa métodos para inserção, deleção, alteração e recuperação de objetos persistidos em banco de dados
class Persiste {

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
										PRIMARY KEY (id),
									CONSTRAINT uk_nome_pessoa
										UNIQUE (nome)
								);");

			// Cria a tabela projetos
			$local_pdo->exec("CREATE TABLE IF NOT EXISTS projetos 
								   (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
									descricao VARCHAR(250) NOT NULL,
									orcamento DOUBLE(9,2),
									CONSTRAINT pk_projetos
										PRIMARY KEY (id)
							);");


			// Cria a tabela pessoa_projeto
			$local_pdo->exec("CREATE TABLE IF NOT EXISTS pessoa_projeto
								   (pessoa_id INT UNSIGNED,
									projeto_id INT UNSIGNED,
									CONSTRAINT pk_pessoa_projeto
										PRIMARY KEY (pessoa_id, projeto_id),
									CONSTRAINT fk_pessoa_projeto_pessoas
										FOREIGN KEY (pessoa_id)
											REFERENCES pessoas(id),
									CONSTRAINT fk_pessoa_projeto_projetos
										FOREIGN KEY (projeto_id)
											REFERENCES projetos(id)
							);");
			// Cria a tabela produto
			$local_pdo->exec("CREATE TABLE IF NOT EXISTS produto 
								   (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
									nome_produto VARCHAR(100) NOT NULL,
									data_vencimento_produto DATE,
									valor_produto DOUBLE(9,2),
									CONSTRAINT pk_produto
									 	PRIMARY KEY (id),
									CONSTRAINT uk_nome_produto
										UNIQUE(nome_produto)
								);");
			
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


	public function GetPessoaByNome($nome)
	{
		try {
			// Cria objeto comando preparado
			$stmt = $this->pdo->prepare('select id, nome, telefone from pessoas where nome=:nome');

			// liga parametros do SQL ao parâmetro $id do método GetPessoaById
			$stmt->bindParam(':nome',$nome);

			// Executa comando SQL
			$stmt->execute();

			// Resultado na forma de vetor associativo
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			// Carrega em $linha dados resultandes do select (vetor associativo com uma célula)
			$linha = $stmt->fetchAll();

			if(isset($linha[0])){
				// Criar vetor de objetos Pessoa a ser retornado
				$retorno = new Pessoa($linha[0]['id'],$linha[0]['nome'],$linha[0]['telefone']); 
			} else {
				$retorno = null;
			}

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = null;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}


	public function GetPessoaByProjeto($projeto_id)
	{
		try {
			// Cria objeto comando preparado
			$stmt = $this->pdo->prepare('select pe.nome
										 from pessoas as pe
										 inner join pessoa_projeto as pp
										 on pp.pessoa_id = pe.id
										 where pp.projeto_id=:projeto_id');

			// liga parametros do SQL ao parâmetro $id do método GetProjetoById
			$stmt->bindParam(':projeto_id',$projeto_id);

			// Executa comando SQL
			$stmt->execute();

			// Resultado na forma de vetor associativo
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			// Carrega em $linha dados resultandes do select (vetor associativo com uma célula)
			$linhas = $stmt->fetchAll();

			$retorno = []; // vetor vazio
			foreach($linhas as $i=>$linha){
				array_push($retorno, $linha['nome']);
			}

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

	public function GetProjetoLastId(){
		return $this->pdo->lastInsertId("projetos");
	}

	// Método para adicionar um objeto da classe Projeto ao banco de dados
	public function AddProjeto(Projeto $obj){
		
		try {
			$stmt = $this->pdo->prepare('insert into projetos (descricao,orcamento) values (:descricao,:orcamento)');
			$stmt->bindParam(':descricao',$descricao);
			$stmt->bindParam(':orcamento',$orcamento);

			$descricao = $obj->getdescricao;
			$orcamento = $obj->getorcamento;
			// Executa comando SQL
			$stmt->execute();

			$retorno = $this->GetProjetoLastId();

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}

	public function GetAllProjeto() //($inicioPagina,$tamanhoPagina)
	{
		try {
			//$stmt = $this->pdo->prepare('select id, descricao, orcamento from projetos order by id limit :inicioPagina, :tamanhoPagina');
			// $stmt->bindParam(':inicioPagina',$inicioPagina);
			// $stmt->bindParam(':tamanhoPagina',$tamanhoPagina);

			$stmt = $this->pdo->prepare('select id, descricao, orcamento from projetos order by id');

			// Executa comando SQL
			$stmt->execute();

			// Resultado na forma de vetor associativo
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			// Carrega em $tabela dados resultandes do select (vetro associativo)
			$tabela = $stmt->fetchAll();

			// Criar vetor de objetos Projeto a ser retornado
			$retorno = []; // vetor vazio
			foreach($tabela as $i=>$v){
				array_push($retorno,new Projeto($v['id'],
												$v['descricao'],
												$v['orcamento'], 
												$this->GetPessoaByProjeto($v['id'])));
			}

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = null;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}

	public function GetProjetoById($id)
	{
		try {
			// Cria objeto comando preparado
			$stmt = $this->pdo->prepare('select id, descricao, orcamento from projetos where id=:i');

			// liga parametros do SQL ao parâmetro $id do método GetProjetoById
			$stmt->bindParam(':i',$id);

			// Executa comando SQL
			$stmt->execute();

			// Resultado na forma de vetor associativo
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			// Carrega em $linha dados resultandes do select (vetor associativo com uma célula)
			$linha = $stmt->fetchAll();

			// Criar vetor de objetos Projeto a ser retornado
			$retorno = new Projeto($linha[0]['id'],$linha[0]['descricao'],$linha[0]['orcamento']); 

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = null;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}

	public function UpdateProjeto(Projeto $obj)
	{
		// sql: update projetos set descricao=:descricao, orcamento=:orcamento where id=:id

		try {
			$stmt = $this->pdo->prepare('update projetos set descricao=:descricao, orcamento=:orcamento where id=:id');

			$stmt->bindParam(':id',$pid);
			$stmt->bindParam(':descricao',$descricao);
			$stmt->bindParam(':orcamento',$orcamento);

			$pid = $obj->getid;
			$descricao = $obj->getdescricao;
			$orcamento = $obj->getorcamento;

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

	public function DeleteProjeto($id)
	{
		// sql: delete from projeto where id=:id
		try {
			$stmt = $this->pdo->prepare('delete from projetos where id=:id');

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


	// Método para adicionar um objeto da classe Projeto ao banco de dados
	public function AddPessoaProjeto($pessoa_id, $projeto_id){
		
		try {
			$stmt = $this->pdo->prepare('insert into pessoa_projeto (pessoa_id,projeto_id) values (:pessoa_id,:projeto_id)');
			$stmt->bindParam(':pessoa_id',$pessoa_id);
			$stmt->bindParam(':projeto_id',$projeto_id);

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

	// Método para adicionar um objeto da classe Produto ao banco de dados
	// Nome da tabela será "produto": create table produto (id int not null primary key AUTO_INCREMENT, nome_produto varchar (100) not null, data_vencimento_produto DATE, valor_produto DOUBLE
	public function AddProduto(Produto $obj){
		
		try {
			$stmt = $this->pdo->prepare('insert into produto (nome_produto,data_vencimento_produto, valor_produto) values (:nome_produto,:data_vencimento_produto, :valor_produto)');
			$stmt->bindParam(':nome_produto',$nome_produto);
			$stmt->bindParam(':data_vencimento_produto',$data_vencimento_produto);
			$stmt->bindParam(':valor_produto',$valor_produto);

			$nome_produto = $obj->getnome_produto;
			$data_vencimento_produto = $obj->getdata_vencimento_produto;
			$valor_produto = $obj->getvalor_produto;
			// Executa comando SQL
			$stmt->execute();

			$retorno = true;

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			echo($pex->getMessage());
			echo($pex->getCode());
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}
public function GetAllProduto() //($inicioPagina,$tamanhoPagina)
	{
		try {
			//$stmt = $this->pdo->prepare('select id, nome_produto, data_vencimento_produto, valor_produto from produto order by id limit :inicioPagina, :tamanhoPagina');
			// $stmt->bindParam(':inicioPagina',$inicioPagina);
			// $stmt->bindParam(':tamanhoPagina',$tamanhoPagina);

			$stmt = $this->pdo->prepare('select id, nome_produto, data_vencimento_produto, valor_produto from produto order by id');

			// Executa comando SQL
			$stmt->execute();

			// Resultado na forma de vetor associativo
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			// Carrega em $tabela dados resultandes do select (vetro associativo)
			$tabela = $stmt->fetchAll();

			// Criar vetor de objetos Produto a ser retornado
			$retorno = []; // vetor vazio
			foreach($tabela as $i=>$v){
				array_push($retorno,new Produto($v['id'],$v['nome_produto'],$v['data_vencimento_produto'],$v['valor_produto']));
			}

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = null;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}
	public function GetProdutoById($id)
	{
		try {
			// Cria objeto comando preparado
			$stmt = $this->pdo->prepare('select id, nome_produto, data_vencimento_produto, valor_produto from produto where id=:i');

			// liga parametros do SQL ao parâmetro $id do método GetProdutoById
			$stmt->bindParam(':i',$id);

			// Executa comando SQL
			$stmt->execute();

			// Resultado na forma de vetor associativo
			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			// Carrega em $linha dados resultandes do select (vetor associativo com uma célula)
			$linha = $stmt->fetchAll();

			// Criar vetor de objetos Pessoa a ser retornado
			$retorno = new Produto($linha[0]['id'],$linha[0]['nome_produto'],$linha[0]['data_vencimento_produto'],$linha[0]['valor_produto']); 

		// Desvia para catch no caso de erros.	
		} catch (PDOException $pex) {
			//poder ser usado "$pex->getMessage();" ou "$pex->getCode();" para se obter detalhes sobre o erro.
			$retorno = null;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		}
		return $retorno;
	}

		public function UpdateProduto(Produto $obj)
	{
		

		try {
			$stmt = $this->pdo->prepare('update produto set nome_produto=:nome_produto, data_vencimento_produto=:data_vencimento_produto, valor_produto=:valor_produto where id=:id');

			$stmt->bindParam(':id',$pid);
			$stmt->bindParam(':nome_produto',$nome_produto);
			$stmt->bindParam(':data_vencimento_produto',$data_vencimento_produto);
			$stmt->bindParam(':valor_produto',$valor_produto);

			$pid = $obj->getid;
			$nome_produto = $obj->getnome_produto;
			$data_vencimento_produto = $obj->getdata_vencimento_produto;
			$valor_produto = $obj->getvalor_produto;

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

	public function DeleteProduto($id)
	{
		// sql: delete from produto where id=:id
		try {
			$stmt = $this->pdo->prepare('delete from produto where id=:id');

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