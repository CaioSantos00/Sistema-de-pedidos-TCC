<?php
    namespace App\Servicos\Arquivos\Variacoes;

    use App\Interfaces\ServicoInterno;

    class Consultar implements ServicoInterno{
        public string $idVariacao;
        public string $idProduto;
        public array $imagens;
        public bool $ok;
        private function buscarImagens() :bool|array{
            $dir = "arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/Secundarias/{$this->idVariacao}";
            if(!is_dir($dir)) return false;
            $fotos = array_values(
                array_diff(
                    scandir($dir),
                    ['.','..']
                )
            );
            return $fotos;
        }
        private function setDiretorios(array $imagens){            
            $dir = "arqvsSecundarios/Produtos/Fotos/{$this->idProduto}/Secundarias/{$this->idVariacao}/";
            foreach($imagens as $img){
                $img = array_values(
                array_diff(
                    scandir($dir.$img),
                    ['.','..']
                )
            );
            }
            return $imagens;
        }
        function executar(){
             $fotos = $this->buscarImagens();
             if($fotos){
                 $this->imagens = $fotos;
                 $this->ok = true;
                 return;
             }
             $this->ok = false;
             $this->imagens = [];
        }
    }