<?php
require_once 'sistem/DDDatabase/DDDatabase.php';
class UserDatabase extends DDDatabase
{
	private $o_db;
	
	function __construct(DDDatabase $o_db)
	{
		$this->o_db = $o_db;
	}
		
	/**
	 * Metodo que busca o usuario no banco
	 * @param int/str $param se receber um valor int busca pelo id e se receber uma string busca pelo username
	 * @return vetor com os dados do usuario
	 */
	public function getUser($param)
	{
		if(is_numeric($param))
			$q1 = " WHERE usr_in_id = $param";
		else
			$q1 = " WHERE usr_st_username = '$param'";
		$st_query = "SELECT * FROM oberon.tbl_usuarios $q1;";
		
		try
		{
			$o_data = $this->o_db->execQuery('oberon', $st_query);
			$v_user = $o_data->getData();
		}
		catch (Exception $e)
		{
		}

		return $v_user[0];
	}
	
	public function updateUserAtivo($usr_in_id , $bo_active) 
	{
		$st_query = "UPDATE oberon.tbl_usuarios
						SET
							usr_bo_active = $bo_active,
							usr_ts_interaction = now()
						WHERE usr_in_id = $usr_in_id;";

		try
		{
			$o_data = $this->o_db->execQuery('oberon', $st_query);
		}
		catch (Exception $e)
		{
			return FALSE;
		}
		return TRUE;
	}
	
	public function saveLog() 
	{
		$st_query = "SELECT * FROM oberon.tbl_usuarios WHERE usr_st_username = '$st_username';";
		
	}
}
?>