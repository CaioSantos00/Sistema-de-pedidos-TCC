<?php
	namespace App\Mensagem;

	use App\Interfaces\{ServicoInterno,Model};
	use App\Servicos\Conexao\ConexaoBanco as CB;

	class EnviarMensagem implements Model{
		private ServicoInterno $fotos;
		public string $idMensagem;
		private string $query = "insert into `mensagens`(`parentId`, `conteudo`, `DataEnvio`) values(?,?,?)";
		private string $conteudo;
		private bool $contemFotos;
		private string $idUsuario;
		function __construct(string $idUsuario, string $conteudo, bool $contemFotos, ServicoInterno $fotos){
			$this->idUsuario = $idUsuario;
			$this->conteudo = $conteudo;
			$this->contemFotos = $contemFotos;
			$this->fotos = $fotos;
		}
		private function salvarNoBanco() :bool{
			try{
				$resultado = false;
				$query = (CB::getConexao())->prepare($this->query);
				$resultado = $query->execute([$this->idUsuario, $this->conteudo, date("d.m.y \\ g:i")]);
			}
			catch(\Exception|\PDOException $e){
				$GLOBALS['ERRO']->setErro("Mensagem", $e->getMessage());
				CB::voltaTudo();
				$resultado = false;
			}
			finally{
				return $resultado;
			}
		}
		private function salvarImagens(){
			$this->fotos->setDados($this->idUsuario, $this->idMensagem);
			return $this->fotos->executar();
		}
		function getResposta(){
			if($this->salvarNoBanco()){
				$this->idMensagem = CB::getConexao()->lastInsertId();
				if($this->contemFotos) return $this->salvarImagens();
				return true;
			}
			return false;
		}
	}
