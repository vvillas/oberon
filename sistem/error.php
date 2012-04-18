<?php
/**
 * Classe de controle da Lista de Erros
 * @author Victor
 */
class ErrorList extends ErrorException
{
	private $v_alert = array();
	
	const 	FATAL_ERROR =	1, 
			ERROR = 		2,
			ALERT = 		3,
	 		SIS_INFO = 		4,
	 		CONFIRM = 		5;
	
	/**
	 * Metodo que insere objetos CErro na Lista de Erros
	 * @param 	string 	$message	//mensagem de erro
	 * @param 	int 	$code		//código do erro
	 * @param 	int 	$severity	//nivel de severidade do erro 
	 * Use
	 *	[1]FATAL_ERROR (redireciona para a pagina de erro), 
	 *	[2]ERROR,
	 *	[3]ALERT,
	 *	[4]SIS_INFO,
	 *	[5]CONFIRM
	 * @param 	string 	$filename
	 * @param 	int		$lineno
	 */
	public function newErro($message, $severity, $code = NULL, $filename = NULL, $lineno = NULL)
	{
		$o_error = new ErrorException($message, $code, $severity, $filename, $lineno);
		/*
		$o_error->getCode();
		$o_error->getFile();
		$o_error->getLine();
		$o_error->getMessage();
		$o_error->getSeverity();
		$o_error->getTrace();
		$o_error->getTraceAsString();
		*/
		array_push($this->v_alert,$o_error);
	}
	
	/**
	 * Enter description here ...
	 * @return alert vector
	 */
	public function listErrors($severity = NULL)
	{
		if(!$severity)
			return $this->v_alert;
		
		$v_selection = array();
		foreach ($this->v_alert as $value) 
		{
			if($value->getSeverity() == $severity)
				array_push($v_selection, $value);
		}
		return $v_selection;
	}
}
?>