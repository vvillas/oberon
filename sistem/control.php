<?php
require_once 'sistem/config/sistem_config.php';
require_once 'sistem/config/database_config.php';
require_once 'sistem/bootstrap.php';
require_once 'sistem/session.php';
require_once 'sistem/error.php';
require_once 'sistem/view.php';
require_once 'sistem/DDDatabase/DDDatabase.php';

final class Control
{
	public $o_bootstrap;	
	public $o_sis_cfg;
	public $o_session;
	public $o_db;
	public $o_error;
	public $o_view;
	

	function __construct()
	{

		// CONFIGURAÇÂO E PARAMETRIZACAO DO SISTEMA
		$this->loadConfigs();
		
		//Define de caminho da raiz do server
		define(RTPTH, "http://".$_SERVER['HTTP_HOST']);
		
		//Define o template do sitema
		define(BETPL, $this->o_sis_cfg->GetParam('template_backend'));
		
		//Define o nome do banco usado pelo sitema
		define(DBNAME, 'oberon');
					
		// CONFIGURA E CONECTA COM O BD
		$this->connectDB();
		
		//INSTANCIA O CONTROLADOR DA SESSAO
		$this->session();
			
		//Intanciando os parametros de modulo, submodulo, comando e ação
		$this->o_bootstrap = new Bootstrap($this);
		
		// OBJETO DE MANIPULAÇÂO DE ERROS
		$this->o_error = new ErrorList();

	}//TERMINO DA CONSTRUCAO
	

	/**
	 * Método resposável pela execução do sistema
	 */
	public function run()
	{
		//ob_start();
	
		if($_POST['action'] == 'acessar')
			$this->login();
		else if($this->o_session->isLogged())
		{
			if($this->o_session->updateSession())
				print "sessao valida";
		}
		else 
		{
			print "sessao invalida";
			
			if($this->o_bootstrap->getModulo() != 'master')
				header('Location: '.RTPTH.'/admin/');
			$this->o_bootstrap->setModulo('master');
			if($this->o_bootstrap->getComando() != 'logout')
				$this->o_bootstrap->setComando('login');

		}
		
		
		
		
		$st_modulo = $this->o_bootstrap->getModulo();
		
		if(!is_dir('m_'.$st_modulo))
			$this->o_error->newErro("M&oacute;dulo 'm_".$st_modulo."' n&atilde;o encontrado",ErrorList::FATAL_ERROR);
		else
		{
			if($st_submodulo = $this->o_bootstrap->getSubmodulo() != '')
				$st_arquivo = 'm_'.$st_modulo.'/'.$st_submodulo.'.php';
			else 
				$st_arquivo = 'm_'.$st_modulo.'/'.$st_modulo.'.php';
				
			
			if(!file_exists($st_arquivo))
			{
				$this->o_error->newErro("Subm&oacute;dulo ".$st_arquivo." n&atilde;o encontrado",ErrorList::FATAL_ERROR);
			}
			else
			{
				require_once $st_arquivo;
				if(!class_exists($st_submodulo))
				{
					$o_classe = new $st_modulo($this);
					$st_comando = $this->o_bootstrap->getComando();
					
					if(method_exists($o_classe, $st_comando))
					{
						$o_classe->$st_comando();
					}
				}
				else
				{
					$o_classe = new $st_submodulo($this);
					$st_comando = $this->o_bootstrap->getComando();
					if(!method_exists($o_classe, $st_comando))
						$o_classe->$st_comando();
				}
			}
		}
	
		
		
		if($v_error = $this->o_error->listErrors())
		{
			foreach ($v_error  as $value) 
			{
				print $value->getMessage();
			}
		}
		
		//*$output = ob_get_clean();
		
		$this->view()->printView();
		exit();
	}
	
	
	
	/**
	 * Método que carrega as configurações do sistema
	 */
	private function loadConfigs()
	{ 
		$o_ConfigGlobal = new SistemConfig();
		$this->o_sis_cfg = $o_ConfigGlobal->getConfig();
	}
	

	/**
	 * Método que configura o conector do banco de dados
	 */
	private function connectDB()
	{
		$o_dbconfig = new DatabaseConfig();
		$v_dbconfig = $o_dbconfig->listDataBases();
		if(count($v_dbconfig))
		{
			$this->o_db = new DDDatabase();
			foreach($v_dbconfig AS $key => $value)
			{
				try
				{
					$this->o_db->setConnectSettings($key, $value);
				}
				catch (DDDException $e)
				{
					$this->o_error->newErro($e->getMessage());
				}	
			}
		}
	}
	
	public function login() 
	{
		if(strlen($_REQUEST['username']) < 4 || strlen($_REQUEST['password']) < 4 )
		{
			if(strlen($_REQUEST['username']) < 4)
				$this->o_error->newErro('Preencha corretamente o campo Usu&aacute;rio', ErrorList::ERROR);

			if(strlen($_REQUEST['password']) < 4)
				$this->o_error->newErro('Preencha corretamente o campo Senha', ErrorList::ERROR);
		}
		else 
		{
			if($this->session()->login($_REQUEST['username'], $_REQUEST['password']))
				;//header("Location:".RTPTH."/painel/");
		}
	}
	
	
	public function session()
	{
		if(!is_a($this->o_session,'Session'))
			$this->o_session = new Session($this);
		return $this->o_session;
	}
	
	public function view()
	{
		if(!is_a($this->o_view, 'view'))
			$this->o_view = new view($this);
		return $this->o_view;
	}
	
	function __destruct()
	{
		//$_SESSION['session'] = NULL;
	}
}
?>