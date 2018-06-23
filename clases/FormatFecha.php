<? 
class FormatFecha {
	public function __construct($fecha){
		if(strlen($fecha)==14)
			$this->fecha=$fecha;
		else
			$this->fecha ="Invalido";	
	}
	public function conversion(){
		$this->anio 	= substr($this->fecha, 0, 4);
		$this->mes		= substr($this->fecha, 4, 2);
		$this->dia		= substr($this->fecha, 6, 2);
		$this->hora		= substr($this->fecha, 8, 2);
		$this->minuto	= substr($this->fecha, 10, 2);
		$this->segundo	= substr($this->fecha, 12, 2);
	}
	public function conversion1(){
		$this->anio 	= substr($this->fecha, 6, 2);
		$this->mes		= substr($this->fecha, 3, 2);
		$this->dia		= substr($this->fecha, 0, 2);
		$this->hora		= substr($this->fecha, 9, 2);
		$this->minuto	= substr($this->fecha, 12, 2);
		$this->segundo	= "00";
	}

	public function meridiano($hora){	
		if(strlen($this->fecha)==14)
			{
				if($hora<12)
				return "a.m.";
				else
				return "p.m.";
			}
	}
	
	public function mostrar(){
	if($this->fecha =="Invalido")
		{
			return "invalido";
		}
		else
		{
		$this->conversion();
		return  $this->hora.":".$this->minuto.":".$this->segundo." ".$this->meridiano($this->hora)."  ".$this->dia."/".$this->mes;
		}
	}
	public function mostrarFecha(){
	if($this->fecha =="Invalido")
		{
			return "invalido";
		}
		else
		{
		$fecha=$this->anio."".$this->mes."".$this->dia;
		return $fecha; 
		}
	}
	public function mostrarHora(){
	if($this->fecha =="Invalido")
		{
			return "invalido";
		}
		else
		{
		$hora=$this->hora.":".$this->minuto.":".$this->segundo;
		return $hora; 
		}
	}
}

?>


