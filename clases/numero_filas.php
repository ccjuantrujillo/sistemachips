<?PHP
require_once("TimeEvaluacionCadena.php");
/*
	Esta funcion se encarga de decirme la cantidad de filas que tiene
	un determinado archivo entre la hora y fecha seleccionada
	Para hacer un bucle formato -> ->numero_filas("090425.cdr","18:50:00","18:54:00");
	*/
	class numero_filas{
	
	public function __construct($archivo,$horainicio,$horafin){
	$this->horainicio		=	strtotime($horainicio);
	$this->horafin			=	strtotime($horafin);
	$this->array_consecutivo = array();
	$cuenta = fopen ("/home/cdr/192_168_1_3/".$archivo, "r");
	$m =0;
	while (!feof ($cuenta)) {
		$buffer = fgets($cuenta, 4096);
		$NuevaCadenaTiempo = new TimeEvaluacionCadena($buffer);
		if($this->horainicio<$NuevaCadenaTiempo->mostrar() and $this->horafin>$NuevaCadenaTiempo->mostrar())
		{	
			$this->array_consecutivo[] =  str_replace(" ", "",$buffer);
			$m++;	
		}		
		
	}
	fclose ($cuenta);
	$this->Cantidad =  $m;
	
	}
	public function cantidad_objetos(){
	return $this->Cantidad;
	}
	public function devolver_filas(){
	return $this->array_consecutivo;
	}
}	
/*$filas = new numero_filas("090709.cdr","18:00:00","23:59:59");
echo $filas->cantidad_objetos();
echo var_dump($filas->devolver_filas());*/

?>
