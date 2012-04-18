<?php
require_once 'm_usuarios/usuarios.php';
require_once 'sistem/error.php';

class master 
{
	private $o_control;
	private $o_login;
	private $o_user;
	
	function __construct(Control $o_control)
	{
		$this->o_control = $o_control;
	}
	
	public function inicio()
	{
		$this->o_control->view()->setView('__backend/templates/'.BETPL.'/view/v_login.php');
	}
	
	public function login()
	{
		$o_params = new Params();
		if(isset($_POST['action']))
			if($_POST['action'] == 'login')
			{
				if(!strlen($_REQUEST['usuario']) || !strlen( $_REQUEST['senha']))
					$o_params->setParam('erro', 'Usu&aacute;rio e senha devem ser preenchidos');
				else
				{	
					$o_user = $this->o_DanteAuthDB->login($_REQUEST['usuario'], $_REQUEST['senha']);
					if($o_user)
					{
						if($_SERVER['HTTP_HOST'] == $this->o_control->o_config->getParam('st_host_externo'))
						{
							if($this->o_DanteAuthDB->verificaAcessoExterno($o_user->usua_in_id))
							{
								$this->o_control->session()->setId($o_user->sess_in_id);
								$this->o_control->session()->getUser()->setId($o_user->usua_in_id);
								$this->o_control->session()->getUser()->setLogin($o_user->usua_st_login);
								$this->o_control->session()->getUser()->setNome($o_user->usua_st_nome);
								$this->o_control->session()->getUser()->setEmail($o_user->usua_st_email);
								$this->startSistens();					
								$this->Inicial();		
							}
							else
								$o_params->setParam('erro', 'Voc&ecirc; n&atilde;o tem permiss&atilde;o para efetuar o login de fora da rede da Universidade');
						}
						else
						{
							$this->o_control->session()->setId($o_user->sess_in_id);
							$this->o_control->session()->getUser()->setId($o_user->usua_in_id);
							$this->o_control->session()->getUser()->setLogin($o_user->usua_st_login);
							$this->o_control->session()->getUser()->setNome($o_user->usua_st_nome);
							$this->o_control->session()->getUser()->setEmail($o_user->usua_st_email);
							$this->startSistens();					
							$this->Inicial();	
						}						
					}
					else
					{
						$in_user = $this->o_DanteAuthDB->locateLogin($_REQUEST['usuario'], $_REQUEST['senha']);
						if($in_user > 0)
						{
							if($_SERVER['HTTP_HOST'] == $this->o_control->o_config->getParam('st_host_externo'))
							{
								if($this->o_DanteAuthDB->verificaAcessoExterno($in_user))
								{
									$this->o_control->session()->getUser()->setId($in_user);
									$this->definirLogin();
								}
								else
									$o_params->setParam('erro', 'Voc&ecirc; n&atilde;o tem permiss&atilde;o para efetuar o login de fora da rede da Universidade');
							}
							else
							{
								$this->o_control->session()->getUser()->setId($in_user);
								$this->definirLogin();
							}							
						}
						else
							$o_params->setParam('erro', 'Login e senha inv&aacute;lidos');	
					}
				}	
			}
			elseif($_POST['action'] == 'definirsenha')
				$this->DefinirLogin();
			
		$this->o_control->view()->setView('__backend/templates/'.BETPL.'/view/v_login.php');
	}
	
	public function definirLogin()
	{
		$o_params = new Params();
		if(isset($_POST['action']))
			if($_POST['action'] == 'definirsenha')
			{
				if(isset($_POST['usuario']))
				{
					if(strlen(trim($_POST['usuario'])) > 3)
					{
						if(isset($_POST['senha']) && isset($_POST['senha_2']))
						{
							if(strlen(trim($_POST['senha'])) > 3 && strlen(trim($_POST['senha_2'])) > 3)
							{
								if($_POST['senha'] === $_POST['senha_2'])
								{
									$in_user = $this->o_control->session()->getUser()->getId();
									$bo_changed = $this->o_login->changeLogin($in_user, $_POST['usuario'], $_POST['senha']);
									if(!$bo_changed)
										$o_params->setParam('erro', 'Erro ao salvar credenciais de usu&aacute;rio');
									else
									{
										$o_user = $this->o_login->login($_REQUEST['username'], $_REQUEST['password']);
										if($o_user)
										{
											$this->o_control->session()->setId($o_user->sess_in_id);
											$this->o_control->session()->getUser()->setId($o_user->usua_in_id);
											$this->o_control->session()->getUser()->setLogin($o_user->usua_st_login);
											$this->o_control->session()->getUser()->setNome($o_user->usua_st_nome);
											$this->o_control->session()->getUser()->setEmail($o_user->usua_st_email);
											
											$this->Inicial();
										}
									}		
								}
								else
									$o_params->setParam('erro', 'As Senhas digitadas n&atilde;o s&atilde;o iguais');																		
							}
							else
								$o_params->setParam('erro', 'Campo "Senha" deve possuir no m&iacute;nimo 4 d&iacute;gitos');
						}
						else
							$o_params->setParam('erro', 'Campo "Senha" &eacute; de preenchimento obrigat&oacute;rio');
					}
					else
						$o_params->setParam('erro', 'Campo "Usu&aacute;rio" deve possuir no m&iacute;nimo 4 d&iacute;gitos');
				}
				else
					$o_params->setParam('erro', 'Campo "Usu&aacute;rio" &eacute; obrigat&oacute;rio');
			}
		
		$this->o_control->view()->setView('modulo_auth/view/DefinirLogin.php',$o_params);
	}
	

	public function logout()
	{
		
		$FinanceiroAuth = new FinanceiroAuth($this->o_control);
		$FinanceiroAuth->finishLogin();	
			
		$SkynetAuth = new SkynetAuth($this->o_control);
		$SkynetAuth->finishLogin();
			
		$AcademicoAuth = new AcademicoAuth($this->o_control);
		$AcademicoAuth->finishLogin();	
		
		$this->login();
	}
	
	public function inicial()
	{
		$v_sistemas = $this->o_login->getSistemas($this->o_control->Session()->GetUser()->GetId());
		$view = new view('modulo_auth/view/Inicial.php');
		$view->getParams()->setParam('v_sistemas', $v_sistemas);
		$view->show(TRUE);
	}
	
	
	
	
	/*
	private function GetConsole("__backend/templates/".BETPL."/view/")
	{
		// Metodo QUE INSERE AS VARS DE SESSAO NO CONSOLE
		for($c = 0; $c < count($_SESSION); $c++)
		{
			//$this->o_control->o_error->newErro("Session [".key($_SESSION)."]",current($_SESSION));
			next($_SESSION);
		}
		
		$v_params = $this->o_params->GetParams();
		
		// Metodo QUE INSERE AS VARS DE SESSAO NO CONSOLE
		for($c = 0; $c < count($v_params); $c++)
		{
			;//$this->o_control->o_error->newErro(1,1,"Request [". key($v_params). "]",current($v_params));
			next($v_params);
		}
		
	
		$ALERT_MSG = $this->o_control->o_error->listErrors();
		
		// CHAMADA DO CONTEUDO
		ob_start();
		//CHAMA A PAGINA SELECIONADA
		include "__backend/templates/".BETPL."/view/".'_console.php';
		$CONSOLE = ob_get_contents();
		ob_end_clean();
		
		return $CONSOLE;
	}
	*/
}
?>