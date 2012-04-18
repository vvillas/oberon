<?php
class DatabaseConfig
{
	private $DataBases;
	
	function __construct()
	{
		$this->DataBases = array();
		
		$this->DataBases[DBNAME] = new DDConnectSettings();
		$this->DataBases[DBNAME]->setApplication(DDConnectSettings::MYSQL);
		$this->DataBases[DBNAME]->setDatabase(DBNAME);
		$this->DataBases[DBNAME]->setHost('127.0.0.1');
		$this->DataBases[DBNAME]->setUser('root');
		$this->DataBases[DBNAME]->setPassword('z010203');
		
	}
	
	public function listDataBases()
	{
		return $this->DataBases;
	}
}
?>
