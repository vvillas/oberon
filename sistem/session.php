<?php
require_once 'sistem/user.php';
require_once 'sistem/database/SessionDatabase.php';

class Session
{
	private $ses_in_id;
	
	public $o_user;
	public $o_control;
	public $o_session;
	

	function __construct(Control $o_control)
	{
		$this->o_control = $o_control;
		$this->o_session = new SessionDatabase($this->o_control->o_db);
		$this->o_user = new User($this->o_control->o_db);
		
		if($sess = $this->o_session->buscaSession($session_id))
			$this->ses_in_id = $sess->ses_in_id;
			
	}

	public function isLogged()
	{
		return $this->ses_in_id;
	}
	
	public function checkTimeSession() 
	{
			$ts_now = time();
			$ts_expira = strtotime($o_session->ses_ts_interaction) + $this->o_control->o_sis_cfg->GetParam('in_timeout');
			
			if($ts_expira >= $ts_now)
				return TRUE;
	}

	public function updateSession()
	{
		$this->o_session->updateSessionTime($this->ses_in_id);
	}

	public function login($st_username, $st_password)
	{
		if($this->o_user->authUser($st_username, $st_password))
		{
			$this->o_control->o_error->newErro($st_username.' logado com sucesso', ErrorList::SIS_INFO);
			return TRUE;
		}
		else
		return FALSE;
	}
}
?>