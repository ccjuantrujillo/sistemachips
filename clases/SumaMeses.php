<?PHP
class SumaMeses{
public function __construct($fechainicio,$meses){
	$this->dia=substr($fechainicio,0,2);
 	$this->mes=substr($fechainicio,3,2);
	$this->anio=substr($fechainicio,6,4);
	$this->meses = $meses;
}
public function calcular(){

 	$this->anionuevo=$this->anio+(floor($this->meses/12));
 	$this->mesnuevo=$this->mes+$this->meses%12;
	
	if ($this->mesnuevo>12)
 	{
	  	$this->mesnuevo=$this->mesnuevo-12;
	  	if ($this->mesnuevo<10)
	   		$this->mesnuevo="0".$this->mesnuevo;
	  	$this->anionuevo=$this->anionuevo+1;
 	}
}
public function mostrar(){
	$this->calcular(); 
	return date( "d/m/Y", mktime(0,0,0,$this->mesnuevo,$this->dia,$this->anionuevo) );
}
}

//El formato de fecha que pasamos a la función debe ser DD/MM/YYYY
/*$fecha="27/03/2009";
$meses=1;
$nuevocalculo = new SumaMeses($fecha, $meses);
echo $nuevocalculo->mostrar();
*/
?>