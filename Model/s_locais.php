<?php

// RECEBE OS DADOS DA CONEXÃO E EXTEND CONEXAO
//ob_start();

require_once 'conexao.php';


ini_set('default_charset','UTF-8');
class s_locais extends conexao{

	protected $table = 'funcionario';
	protected $table2 = 'locais';
	
	private $nome;
	private $cpf;
	private $email;
	private $senha;
	
	private $idLocal;
	private $nomeLocal;
	private $latitude;
	private $longitude;
	private $coordenadasPoligono;
	
	
	public function setNome($nome){
		$this->nome = $nome;
	}
    public function setCpf($cpf){
		$this->cpf = $cpf;
	}
	public function setEmail($email){
		$this->email = $email;
	}
    public function setSenha($senha){
		$this->senha = $senha;
	}
    
	public function setIdLocal($idLocal){
		$this->idLocal = $idLocal;
	}
	public function setNomeLocal($nomeLocal){
		$this->nomeLocal = $nomeLocal;
	}
    public function setLatitude($latitude){
		$this->latitude = $latitude;
	}
	public function setLongitude($longitude){
		$this->longitude = $longitude;
	}
	public function setCoordenadasPoligono($coordenadasPoligono){
		$this->coordenadasPoligono = $coordenadasPoligono;
	}

		
	public function login(){
		//Criptografia da senha para comparação no banco de dados
		$senhaHash = MD5($this->senha);
		//CONSULTA RESPONSÁVEL POR VERIFICAR SE EXISTE FUNCIONARIO COM O LOGIN E SENHA INFORMADOS
		$sql = "SELECT cpf  FROM $this->table WHERE email = :email AND senha = :senha";
		$stmt = conexao::prepare($sql);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':senha', $senhaHash);
		$stmt->execute();
		// ASSOCIA O RESULTADO DA BUSCA COM O CPF DO FUNCIONARIO
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $item){
			$cpf = $item['cpf'];
			
		}
		// VERIFICA SE HOUVE RESPOSTA DO BANCO
		//ob_start();
		session_start();
		if (count($result) <= 0)
		{
			?>
			<div class='alert alert-danger' id='msg' role='alert'>Usuário ou Senha inválidos</div>
			<?php
			$_SESSION['autenticado'] = 'nao';
		// SE HOUVE RESPOSTA INICIA A SESSÃO E ARMAZENA A MATRICULA DO FUNCIONÁRIO
		}else{
			
			$_SESSION['cpf'] = $cpf;
			$_SESSION['autenticado'] = 'sim';
			header('Location: ./Viewer/locais.php?');
			
			
		}
		//ob_end_flush();
	}
	
	public function recuperSenha(){
		include 'enviarEmailRecupercaoSenha.php';
		function generatePassword($qtyCaraceters){
			//Letras minúsculas embaralhadas
			$smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');
			//Letras maiúsculas embaralhadas
			$capitalLetters = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
			//Números aleatórios
			$numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
			$numbers .= 1234567890;
			//Caracteres Especiais
			$specialCharacters = str_shuffle('!@#$%*-');
			//Junta tudo
			$characters = $capitalLetters.$smallLetters.$numbers.$specialCharacters;
			//Embaralha e pega apenas a quantidade de caracteres informada no parâmetro
			$password = substr(str_shuffle($characters), 0, $qtyCaraceters);
			//Retorna a senha
			return $password;
		}
		$sql = "SELECT email, cpf FROM $this->table WHERE email = :email";
		$stmt = conexao::prepare($sql);
		$stmt->bindParam(':email', $this->email);
		$stmt->execute();
		// ASSOCIA O RESULTADO DA BUSCA COM O CPF DO FUNCIONARIO
		$result = $stmt->fetchAll();

		if (count($result) <= 0)
		{
			?>
			<div class='alert alert-danger' id='msg' role='alert'>email não cadastrado</div>
			
			<?php
			
		// SE HOUVE RESPOSTA INICIA A SESSÃO E ARMAZENA A MATRICULA DO FUNCIONÁRIO
		}else{
			$enviarEmail = new enviarEmailRecupercaoSenha();
			$senhaGerada = generatePassword(6);
			$senha = MD5($senhaGerada);
			$cpfAtualizacao ='0';
			
			foreach ($result as $res => $value) {
				$cpfAtualizacao = $value->cpf;
				$emailAlteracao = $value->email;
			}
			
			if(!($cpfAtualizacao == '0')){
				$sql = "UPDATE funcionario SET senha = :senha WHERE cpf = :cpf";
				$stmt = conexao::prepare($sql);
				$stmt->bindParam(':senha', $senha);
				$stmt->bindParam(':cpf', $cpfAtualizacao);
				if($stmt->execute()){
					
					if($enviarEmail->enviarEmailRecuperacaoSenha($senhaGerada, $emailAlteracao)){
						echo '<!DOCTYPE html>';
   						echo '<html xmlns="http://www.w3.org/1999/xhtml">';
   						echo '<head>';
   						echo '   <meta http-equiv="refresh" content="10; url=index.php">';
   						echo '</head>';
   						echo '<body>';
   						echo "<div class='alert alert-success' id='msg' role='alert'>Senha enviada para o e-mail informado - Você será redirecionado em 10 segundos</div>";
   						//echo '<a href="index.php">Prosseguir</a>';
   						echo '</body>';
   						echo '</html>';
						                           
	
					} else{
						?>
						<div class='alert alert-danger' id='msg' role='alert'>ERRO AO ENVIAR O E-MAIL - NOTIFIQUE O ADMINISTRADOR DO SISTEMA</div>
						<?php  
					}
				}
			}
			
			
		}
		//ob_end_flush();
	}
////////////////////////////////////////////////// INICIO FUNÇÕES DA TABELA FUNCIONÁRIO ////////////////////////////////////////////////////////////
    public function inserirFuncionario(){
		try{
			$sql = "INSERT INTO $this->table(nome,cpf,email,senha) VALUES (:nome,:cpf,:email,:senha)";
			$stmt = conexao::prepare($sql);
			$stmt->bindParam(':nome', $this->nome);
			$stmt->bindParam(':cpf', $this->cpf);
			$stmt->bindParam(':email', $this->email);
			$stmt->bindParam(':senha', $this->senha);
			
			return $stmt->execute();
		}
		catch(Exception $e){
		}
    }
    
    public function atualizarFuncionario(){
		try{
			$sql = "UPDATE $this->table SET  nome = :nome,cpf = :cpf, email = :email, senha = :senha WHERE cpf = :cpf";
			$stmt = conexao::prepare($sql);
			$stmt->bindParam(':nome', $this->nome);
			$stmt->bindParam(':cpf', $this->cpf);
			$stmt->bindParam(':email', $this->email);
			$stmt->bindParam(':senha', $this->senha);
			

			return $stmt->execute();
		}
		catch(Exception $e){

		}
	}
	
	public function deleteFuncionario($matricula){
		//DELETE funcionario, solicita FROM funcionario INNER JOIN solicita ON solicita.cpf = funcionario.cpf where funcionario.matricula = 1;
		//DELETE solicita, funcionario FROM solicita INNER JOIN funcionario ON funcionario.cpf = solicita.cpf where funcionario.matricula = 1;
		$consulta="DELETE $this->table4, $this->table FROM $this->table4 INNER JOIN $this->table ON
		$this->table.cpf = $this->table4.cpf where $this->table.matricula = :matricula";
		$stmt = conexao::prepare($consulta);
		$stmt->bindParam(':matricula', $matricula);
		$stmt->execute();

		return 0;
	}
	public function buscarFuncionario($valorF,$buscaF){
		//BUSCA PELO NOME
		if($buscaF == "Nome"){
			$consulta="SELECT * FROM $this->table where $this->table.nome LIKE :valorF";
			$valorF = "%$valorF%";
			$stmt = conexao::prepare($consulta);
			
				if(!empty($valorF)){ $stmt->bindParam(':valorF', $valorF);}
				if(!empty($nome)){ $stmt->bindParam(':nome', $nome);}
				if(!empty($cpf)){ $stmt->bindParam(':cpf', $cpf);}
				if(!empty($email)){$stmt->bindParam(':email', $email);}
				if(!empty($senha)){$stmt->bindParam(':senha', $senha);}

				$stmt->execute();
			return $stmt->fetchAll();
		}
		//BUSCA PELO CPF
		if($buscaF == "CPF"){
			$consulta="SELECT * FROM $this->table where $this->table.cpf = :valorF";
			//$valorF = "%$valorF%";
			$stmt = conexao::prepare($consulta);
			
				if(!empty($valorF)){ $stmt->bindParam(':valorF', $valorF);}
				if(!empty($nome)){ $stmt->bindParam(':nome', $nome);}
				if(!empty($cpf)){ $stmt->bindParam(':cpf', $cpf);}
				if(!empty($email)){$stmt->bindParam(':email', $email);}
				if(!empty($senha)){$stmt->bindParam(':senha', $senha);}
				$stmt->execute();
			return $stmt->fetchAll();
		}
		//BUSCA PELO USUÁRIO
		if($buscaF == "USUARIO"){
			$consulta="SELECT * FROM $this->table where $this->table.email = :valorF";
			//$valorF = "%$valorF%";
			$stmt = conexao::prepare($consulta);
			
				if(!empty($valorF)){ $stmt->bindParam(':valorF', $valorF);}
				if(!empty($nome)){ $stmt->bindParam(':nome', $nome);}
				if(!empty($cpf)){ $stmt->bindParam(':cpf', $cpf);}
				if(!empty($email)){$stmt->bindParam(':email', $email);}
				if(!empty($senha)){$stmt->bindParam(':senha', $senha);}
				$stmt->execute();
			return $stmt->fetchAll();
		}
		

	}
////////////////////////////////////////////////// FIM FUNÇÕES DA TABELA FUNCIONÁRIO ////////////////////////////////////////////////////////////	
////////////////////////////////////////////////// INÍCIO DAS FUNÇÕES DA TABELA LOCAIS ////////////////////////////////////////////////////////////	
public function inserirLocais(){
		try{
			$sql = "INSERT INTO $this->table2(nomeLocal,latitude,longitude,coordenadasPoligono) VALUES (:nomeLocal,:latitude,:longitude,:coordenadasPoligono)";
			$stmt = conexao::prepare($sql);
			$stmt->bindParam(':nomeLocal', $this->nomeLocal);
			$stmt->bindParam(':latitude', $this->latitude);
			$stmt->bindParam(':longitude', $this->longitude);
			$stmt->bindParam(':coordenadasPoligono', $this->coordenadasPoligono);
			
			return $stmt->execute();
		}
		catch(Exception $e){
		}
}
    
public function atualizarLocais(){
		try{
			$sql = "UPDATE $this->table2 SET idLocal=:idLocal, nomeLocal = :nomeLocal,latitude = :latitude, longitude = :longitude, coordenadasPoligono = :coordenadasPoligono WHERE idLocal = :idLocal";
			$stmt = conexao::prepare($sql);
			$stmt->bindParam(':idLocal', $this->idLocal);
			$stmt->bindParam(':nomeLocal', $this->nomeLocal);
			$stmt->bindParam(':latitude', $this->latitude);
			$stmt->bindParam(':longitude', $this->longitude);
			$stmt->bindParam(':coordenadasPoligono', $this->coordenadasPoligono);
			
			return $stmt->execute();
		}
		catch(Exception $e){

		}
}
	
	public function deleteLocal($id){
		try{
			
			$consulta="DELETE FROM $this->table2 where $this->table2.idLocal = $id";
			$stmt = conexao::prepare($consulta);
			$stmt->bindParam(':idLocal', $idLocal);
			$stmt->execute();

			return $stmt->execute();

		} catch(Exception $e){

		}

	}
	public function buscarLocal($valorF,$buscaF){
		//BUSCA PELO ID
		if($buscaF == "ID"){
			$consulta="SELECT * FROM $this->table2 where $this->table2.idLocal LIKE :valorF";
			$valorF = "%$valorF%";
			$stmt = conexao::prepare($consulta);
			
				if(!empty($valorF)){ $stmt->bindParam(':valorF', $valorF);}
				if(!empty($idLocal)){ $stmt->bindParam(':idLocal', $idLocal);}
				if(!empty($nomeLocal)){ $stmt->bindParam(':nomeLocal', $nomeLocal);}
				if(!empty($latitude)){$stmt->bindParam(':latitude', $latitude);}
				if(!empty($longitude)){$stmt->bindParam(':longitude', $longitude);}
				if(!empty($coordenadasPoligono)){$stmt->bindParam(':coordenadasPoligono', $coordenadasPoligono);}
				$stmt->execute();
			return $stmt->fetchAll();
		}
		//BUSCA PELO CPF
		if($buscaF == "nomeLocal"){
			$consulta="SELECT * FROM $this->table2 where $this->table2.nomeLocal = :valorF";
			//$valorF = "%$valorF%";
			$stmt = conexao::prepare($consulta);
			
				if(!empty($valorF)){ $stmt->bindParam(':valorF', $valorF);}
				if(!empty($idLocal)){ $stmt->bindParam(':idLocal', $idLocal);}
				if(!empty($nomeLocal)){ $stmt->bindParam(':nomeLocal', $nomeLocal);}
				if(!empty($latitude)){$stmt->bindParam(':latitude', $latitude);}
				if(!empty($longitude)){$stmt->bindParam(':longitude', $longitude);}
				if(!empty($coordenadasPoligono)){$stmt->bindParam(':coordenadasPoligono', $coordenadasPoligono);}
				$stmt->execute();
			return $stmt->fetchAll();
		}
		if($buscaF == "all"){
			$consulta="SELECT * FROM $this->table2";
			$stmt = conexao::prepare($consulta);
			
				if(!empty($idLocal)){ $stmt->bindParam(':idLocal', $idLocal);}
				if(!empty($nomeLocal)){ $stmt->bindParam(':nomeLocal', $nomeLocal);}
				if(!empty($latitude)){$stmt->bindParam(':latitude', $latitude);}
				if(!empty($longitude)){$stmt->bindParam(':longitude', $longitude);}
				if(!empty($coordenadasPoligono)){$stmt->bindParam(':coordenadasPoligono', $coordenadasPoligono);}
				$stmt->execute();
			return $stmt->fetchAll();
		}
		
		
		

	}
////////////////////////////////////////////////// FIM FUNÇÕES DA TABELA LOCAIS ////////////////////////////////////////////////////////////	


}