<?php
	namespace Controladores\Rotas\RotasAdm\AdmRequests;	
	
	use App\Administracao\Produtos\CadastroProduto;
	class AdmRequests{
		function __construct(){
			if(!isset($_COOKIE['TipoConta'])) exit("sai fora, Hacker!");
		}
		function cadastrarProduto($data){
			$cadastro = new CadastroProduto(
				$_POST['nome'],
				json_decode($_POST['classificacoes']),
				$_POST['descricaoGeral']
			);
			$cadastro->setDadosSecundarios($_POST['dadosSecundarios']);
			
			$cadastro->executar();
		}
	}