<?

	class Params
	{
		private $v_params;
		
		function __construct($v_params = NULL)
		{
			if($v_params)
				$this->v_params = $v_params;
			else
				$this->v_params = array();
		}
		
		public function count()
		{
			return count($this->v_param);
		}
		
		public function SetParams($v_params)
		{
			$this->v_params = $v_params;
		}
		
		public function GetParams()
		{
			return $this->v_params;
		}
		
		public function SetParam($st_param,$value)
		{
			$this->v_params[$st_param] = $value;
		}
 
		public function GetParam($st_param)
		{
			return $this->v_params[$st_param];
		}
		
		public function UnsetParam($st_param)
		{
			unset($this->v_params[$st_param]);
		}
		
		public function IssetParam($st_param)
		{
			return isset($this->v_params[$st_param]);
		}
		
		public function ParamsToString()
		{
			foreach($this->v_params as $chave => $valor)
				$str.= "[$chave]=>$valor;\n";
			return($str);
		}
		
		public function ParamToString($st_param)
		{
			if($this->IssetParam($st_param))
				return "[$st_param]=>".$this->GetParam($st_param);
		}
  }
?>
