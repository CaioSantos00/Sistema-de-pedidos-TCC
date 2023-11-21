<?php
  namespace App\Mensagem\Consultar;

  use App\Servicos\Conexao\ConexaoBanco as CB;
  use App\Exceptions\UserException;
  use App\Interfaces\{
    ServicoInterno,
    Mostravel
  };

  class Especifica implements ServicoInterno{
    public array $arquivos;
    public array $mensagem;
    public bool $temArqvs;
    public string $erro;
    private string $idMensagem;
    private string $diretorio;
    private string $query = "select `parentId`,`conteudo`,`DataEnvio` from `mensagens` where `Id` = ?";
    function __construct(string $idMensagem){
      $this->idMensagem = $idMensagem;
      $this->diretorio = "arqvsSecundarios/Mensagens/".$this->idMensagem;
    }
    private function getDadosBanco() :array|bool{
      try{
        $resposta = false;
        $query = CB::getConexao()->prepare($this->query);
        $query->execute([$this->idMensagem]);
        $resposta = $query->fetchAll();
      }
      catch(\PDOException|\Exception $e){
        $resposta = false;
        CB::voltaTudo();
        $GLOBALS['ERRO']->setErro("Consulta mensagem", $e->getMessage());
      }
      finally{
        return $resposta;
      }
    }
    private function temArquivos() :bool{
      if(empty($this->temArquivos)) $this->temArquivos = is_dir($this->diretorio);
      return $this->temArqvs;
    }
    private function getArquivos() :array{
      return array_diff(
        [".",".."],
        scandir($this->diretorio)
      );
    }
    function executar(){
      try{
        $resposta = true;
        $mensagem = $this->getDadosBanco();
        if(is_bool($mensagem)) throw new \Exception("não encontrada");
        $this->mensagem = $mensagem;        
        if(!$this->temArquivos()) throw new UserException("não tem arquivos");
        $this->arquivos = $this->getArquivos();
      }
      catch(Showable $ex){
        $this->erro = $ex->getMessage();
      }
      catch(\Exception|\PDOException $e){
        $resposta = false;        
        $GLOBALS['ERRO']->setErro("Consulta mensagem", $e->getMessage());
        $this->erro = "erro interno";
      }
      finally{
        return $resposta;
      }
    }
  }