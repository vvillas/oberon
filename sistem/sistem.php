<?
class Sistem
{
	private $st_sis_id;
	private $st_cli_id;
	private $in_timeout;

	private $bo_maintenance;
	private $ts_maintenance_start;
	private $ts_maintenance_final;
	private $st_template;	//Template do Front-End
	private $st_template_be;	//Template do Back-End

	public function setSisId($value)
	{
		$this->st_sis_id = $value;
	}

	public function getSisId()
	{
		return $this->st_sis_id;
	}

	public function setCliId($value)
	{
		$this->st_cli_id = $value;
	}

	public function getCliId()
	{
		return $this->st_cli_id;
	}



	public function setTimeout($in_timeout)
	{
		$this->in_timeout = $in_timeout;
	}

	public function getTimeout()
	{
		return $this->in_timeout;
	}

	public function setMaintenance($bo_maintenance)
	{
		$this->in_maintenance = $in_maintenance;
	}

	public function getMaintenance()
	{
		return $this->in_maintenance;
	}

	public function setMaintenanceStart($ts_maintenance_start)
	{
		$this->ts_maintenance_start = $ts_maintenance_start;
	}

	public function getMaintenanceStart()
	{
		return $this->ts_maintenance_start;
	}

	public function setMaintenanceFinal($ts_maintenance_final)
	{
		$this->ts_maintenance_final = $ts_maintenance_final;
	}

	public function getMaintenanceFinal()
	{
		return $this->ts_maintenance_final;
	}

	public function setFrontend($value)
	{
		$this->st_template = $value;
	}

	public function getFrontend()
	{
		return $this->st_template;
	}

		
	public function setBackend($value)
	{
		$this->st_template_be = $value;
	}

	public function getBackend()
	{
		return $this->st_template_be;
	}
}
?>