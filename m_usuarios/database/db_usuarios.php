<?php
require_once 'sistem/DDDatabase/DDDatabase.php';
class CUser extends DDDatabase
{
	private $o_db;
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
	private $time_active;
	
	function __construct(DDDatabase $o_db)
	{
		$this->o_db = $o_db;
	}
	
	/**
	 * Funcao que testa o login 
	 * @param string $user_name
	 * @return CUser 
	 * @return erro caso nao encontre 
	 */
	public function getUsuarioUsername($user_name)
	{
		$st_query = "SELECT * FROM tbl_usuarios ";
		$st_query .= "WHERE usr_bo_status = TRUE ";
		$st_query .= "AND usr_st_username = '$user_name'";
		
		try
   		{
   			$o_data = $this->o_db->execQuery('obr', $st_query);
   			
   			if($o_data->getNRows() > 0 )
   			{
   				$o_user = $o_data->getData();
   				return $o_user[0];
   			}
   			else	
   				return false;
   		}
   		catch (DDDException $e)
   		{
   			throw $e;
   		}
	}

}
?>