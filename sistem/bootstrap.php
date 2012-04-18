<?php
class Bootstrap
{
	private $st_modulo;
	private $st_submodulo;
	private $st_comando;
	private $st_action;
	private $o_control;	
	
	function __construct()
	{
		$this->load();
	}
	
	public function setModulo( $st_modulo )
	{
		$this->st_modulo = $st_modulo;
	}
	
	public function getModulo()
	{
		return $this->st_modulo;
	}
	
	public function setSubmodulo( $st_submodulo )
	{
		$this->st_submodulo = $st_submodulo;
	}
	
	public function getSubmodulo()
	{
		return $this->st_submodulo;
	}
	
	public function setComando( $st_comando )
	{
		$this->st_comando = $st_comando;
	}
	
	public function getComando()
	{
		return $this->st_comando;
	}
	
	public function setAction($st_action)
	{
		$this->st_action = $st_action;
	}
	
	public function getAction()
	{
		return $this->st_action;
	}
	
	public function load()
	{
			
		$pageURL = explode('/', trim($_SERVER["REQUEST_URI"]));		
		
		if($pageURL[1] == 'admin')
		{	

			if($pageURL[2] != '')
				$this->setModulo($pageURL[2]);
			else 
				$this->setModulo('master');
				
			if($pageURL[3] != '')
				$this->setSubmodulo($pageURL[3]);
				
			if($pageURL[4] != '')
				$this->setComando($pageURL[4]);
			else
				$this->setComando('inicio');
				
			if(isset($_REQUEST['action']))
				$this->setAction($_REQUEST['action']);
				
		}
	}	
}
?>