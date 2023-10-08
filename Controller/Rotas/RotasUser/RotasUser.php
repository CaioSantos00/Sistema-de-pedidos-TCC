<?php
	namespace Controladores\Rotas\RotasUser;	
	use Controladores\Rotas\Controlador;	
	
	class RotasUser extends Controlador{		
		
		function __construct(){
			parent::__construct();	
		}		
		public function home($data){
			parent::renderizar('pages/index.html');
		}
		public function login($data){
			parent::renderizar('pages/login.html');
		}
		public function cadastro($data){
			parent::renderizar('pages/cadastro.html');
		}
		public function sobre($data){
			parent::renderizar('pages/sobre.html');
		}
		public function estilos($data){
			header('Content-type: text/css');
			parent::renderizar('RecursosEstaticos/css/style.css');
		}
		public function img($data){
			parent::renderizar('RecursosEstaticos/imgs/'.$data['qual']);
		}
		public function script($data){
			header('Content-type: application/javascript');			
			parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/{$data['nome']}");
		}
		public function scriptModularizado($data){
			header('Content-type: application/javascript');			
			$scripts = explode(',',$data['nomesDosModulosSeparadosPorVirgula']);			
			foreach($scripts as $script){
				parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/Modulos/{$script}.js");
			}
			parent::renderizar("RecursosEstaticos/js/{$data['contexto']}/{$data['scriptPrincipal']}.js");
		}
	}