<?php
require_once 'm_usuarios/database/db_usuarios.php';
class Usuarios extends CUser
{

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
		$this->time_active = $value;
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
		return $this->time_active;
	}
	
	public function setUsuario($user)
	{
		$this->in_id = $user->usr_in_id;
		$this->in_nivel = $user->usr_in_nivel;
		$this->st_nome = $user->usr_st_nome;
		$this->st_nickname = $user->usr_st_nickname;
		$this->st_username = $user->usr_st_username;
		$this->st_password = $user->usr_st_password;
		$this->st_lembrete_senha = $user->usr_st_lembrete_senha;
		$this->st_email = $user->usr_st_email;
		$this->in_criador = $user->usr_in_criador;
		$this->bo_status = $user->usr_bo_status;
		$this->bo_active = $user->usr_bo_active;
		$this->time_active = $user->usr_time_active;
	}
}
?>