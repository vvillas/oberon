<?php
require_once 'sistem/error.php';
class view
{
	private $st_template;
	private $ob_template;
	private $o_config;
	private $o_params;
	private $o_error;
	private $st_view;
	private $st_contents;
	
	function __construct(Control $o_control)
	{
		
		if($st_view != NULL)
			$this->setView($st_view);
			
		if($o_params != NULL)
			$this->setParams($o_params);
		else
			$this->o_params = new Params();

		if($v_error != NULL)
			$this->setErrors($v_error);
		else 
			$this->o_error = new ErrorList();
	}

	public function setParams(Params $o_params)
	{
		$this->o_params = $o_params;
	}
	
	public function setErrors(ErrorList $v_error)
	{
		$this->o_error = $v_error;
	}
	
	
	public function getParams()
	{
		return $this->o_params;
	}
	
	public function getContents()
	{
		$st_view = $this->st_view;
		if(!file_exists($st_view))
			$st_view = '__backend/templates/oberon_std/view/_erro.php';
		
		ob_start();
		include_once $st_view;
		$this->st_contents = ob_get_clean();
		return $this->st_contents;
	}
	
	public function getTemplate()
	{
		$content['view'] = $this->getContents();
		
		ob_start();
		require_once '__backend/templates/oberon_std/view/_html_template.php';
		$this->ob_template = ob_get_clean();
		return $this->ob_template;
	}

	
	public function setView($st_view)
	{
		if(file_exists($st_view))
		{
			$this->st_view = $st_view;
		}
		else
		{
			new ErrorList('arquivo '.$st_view.' n&aacute;o encontrado',ErrorList::FATAL_ERROR);
		}
	}
	
	
	public function printView($output = 'html')
	{
		echo $this->getTemplate();
		exit();
	}
}
?>