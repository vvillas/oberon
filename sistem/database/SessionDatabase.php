<?php
require_once 'sistem/DDDatabase/DDDatabase.php';
class SessionDatabase extends DDDatabase
{
	private $o_db;
	
	function __construct(DDDatabase $o_db)
	{
		$this->o_db = $o_db;
	}
	
	public function buscaSession($session_id) 
	{
		$st_query = "SELECT sess.* FROM oberon.tbl_session AS sess
						INNER JOIN (SELECT usr_in_id FROM oberon.tbl_usuarios WHERE usr_bo_status = TRUE) AS usr ON usr.usr_in_id = sess.usr_in_id
					WHERE ses_st_id = '$session_id'";
		try
		{
			$o_data = $this->o_db->execQuery('oberon', $st_query);
			$v_session = $o_data->getData();
		}
		catch (Exception $e)
		{
		}

		return $v_session[0];
	}
	
	public function updateSessionTime($session_id) 
	{
		$st_query = "UPDATE oberon.tbl_session
						SET ses_ts_interaction = now()
						WHERE ses_st_id = '$session_id'";
		print $st_query;
		try
		{
			$o_data = $this->o_db->execQuery('oberon', $st_query);
		
		}
		catch (Exception $e)
		{
		}
		//var_dump($o_data);

		//return $v_session[0];
		
	}
}
?>