<?php
require_once 'sistem/database/UserDatabase.php';
class User extends UserDatabase
{
	public $o_user;
	
	private $in_id;
	private $in_nivel;
	private $st_nome;
	private $st_nickname;
	private $st_username;
	private $st_password;
	private $st_lembrete_senha;
	private $st_email;
	private $in_criador;
	private $bo_status;
	private $bo_active;
	private $session_time;
	
	function __construct(DDDatabase $o_db)
	{
		$this->o_user = new UserDatabase($o_db);
	}
	
	
	public function setID ($value){
		$this->in_id = $value;
	}
	public function setNivel ($value){
		$this->in_nivel = $value;
	}
	public function setNome ($value){
		$this->st_nome = $value;
	}
	public function setNick ($value){
		$this->st_nickname = $value;
	}
	public function setUsername ($value){
		$this->st_username = $value;
	}
	public function setPassword ($value){
		$this->st_password = $value;
	}
	public function setLebreteSenha ($value){
		$this->st_lembrete_senha = $value;
	}
	public function setEmail ($value){
		$this->st_email = $value;
	}
	public function setCriador ($value){
		$this->in_criador = $value;
	}
	public function setStatus ($value){
		$this->bo_status = $value;
	}
	public function setActive ($value){
		$this->bo_active = $value;
	}
	public function setActiveTime ($value){
		$this->ts_interaction = $value;
	}


	public function getID (){
		return $this->in_id;
	}
	public function getNivel (){
		return $this->in_nivel;
	}
	public function getNome (){
		return $this->st_nome;
	}
	public function getNick (){
		return $this->st_nickname;
	}
	public function getUsername (){
		return $this->st_username;
	}
	public function getPassword (){
		return $this->st_password;
	}
	public function getLebreteSenha (){
		return $this->st_lembrete_senha;
	}
	public function getEmail (){
		return $this->st_email;
	}
	public function getCriador (){
		return $this->in_criador;
	}
	public function getStatus (){
		return $this->bo_status;
	}
	public function getActive (){
		return $this->bo_active;
	}
	public function getActiveTime (){
		return $this->ts_interaction;
	}
	
	private function setUsuario($user_data)
	{
		$this->in_id = $user_data->usr_in_id;
		$this->in_nivel = $user_data->usr_in_nivel;
		$this->st_nome = $user_data->usr_st_nome;
		$this->st_nickname = $user_data->usr_st_nickname;
		$this->st_username = $user_data->usr_st_username;
		$this->st_password = $user_data->usr_st_password;
		$this->st_lembrete_senha = $user_data->usr_st_lembrete_senha;
		$this->st_email = $user_data->usr_st_email;
		$this->in_criador = $user_data->usr_in_criador;
		$this->bo_status = $user_data->usr_bo_status;
		$this->bo_active = $user_data->usr_bo_active;
		$this->ts_interaction = $user_data->usr_ts_interaction;
	}
	
	public function authUser($st_username, $st_password) 
	{
		$st_password = md5($st_password);
		if($user_data = $this->o_user->getUser($st_username))
		{
			if($user_data->usr_st_password == $st_password)
			{
				$this->o_user->updateUserAtivo($user_data->usr_in_id, 'TRUE');
				$user_data = $this->o_user->getUser($user_data->usr_in_id);
				$this->setUsuario($user_data);
				return TRUE;
			}
			else 
				return FALSE;
		}
	}
}