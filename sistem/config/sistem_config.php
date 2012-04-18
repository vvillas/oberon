<?php
require_once 'sistem/sistem.php';
require_once 'sistem/params.php';
class SistemConfig extends Sistem
{
	public $o_Params;

	function __construct()
	{
		$this->o_Params = new Params();
		$this->o_Params->SetParam('sistem_name','Oberon');
		$this->o_Params->SetParam('sistem_description','Enterprise Manager');
		$this->o_Params->SetParam('client_name','Merc&uacute;rio Telecom');
		$this->o_Params->SetParam('template_frontend','mercurio');
		$this->o_Params->setParam('template_backend','oberon_std');
		$this->o_Params->setParam('in_maintenance',0);
		$this->o_Params->setParam('in_timeout',900);
	}

	public function getConfig()
	{
		return $this->o_Params;
	}
}
?>