
<?php
require_once("TimeEvaluacionCadena.php");
require_once("ColectorDiasMultiples.php");
require_once("numero_filas.php");
class recuperar_archivo {

		public function __construct($ArchivoInicio,$horainicio,$ArchivoFin,$horafin){
		if((file_exists("/home/cdr/192_168_1_3/".$ArchivoInicio)) and (file_exists("/home/cdr/192_168_1_3/".$ArchivoFin))){			
			$this->ArchivoInicio 	=	$ArchivoInicio;
			$this->ArchivoFin 		= 	$ArchivoFin;	
			$this->horainicio_sn	=	$horainicio;
			$this->horafin_sn		=	$horafin;
			$this->horainicio		=	strtotime($horainicio);
			$this->horafin			=	strtotime($horafin);
						
			/*$numero_de_filas = $this->numero_filas($this->ruta);
			"10/01/2008","10/01/2008";  090425.cdr
			$this->numero_de_filas = $numero_de_filas;
			$this->archivo_nuevo = file($ArchivoInicio);
			$this->ruta = $archivo;*/
			}
		else
			{
			//echo $ArchivoInicio;
			echo "Faltan archivos CDRs entre las fechas<br> $ArchivoInicio  $ArchivoFin";
			exit();	
			}
	}
	/*
	Esta funcion se encarga de transformar el formato original de 
	090425.cdr a -> 09/04/2009 para que nuestra funcion Date lo entienda
	*/
	public function ArchivoFecha($archivo){
	$anio = "20".substr($archivo,0,2);
	$mes = substr($archivo,2,2);
	$dia = substr($archivo,4,2);
	return $dia."/".$mes."/".$anio;
	}
		/*
	Aquie usamos las otras funciones para mostrar el contenido de uno o mas dias por fichero
	De acuerdo a la hora inicil y final;
	El $this->ArchivoInicio Iniciara a las $this->horainicio
	El $this->Archivofin terminara a las $this->horaFin
	Todos los archivos que se encuentren en medio de ellos se tomara desde las 00:00:00 horas hasta las 23:59:59
	*/
	public function calcular_filas(){	
		$dias_totales = new ColectorDiasMultiples($this->ArchivoFecha($this->ArchivoInicio),$this->ArchivoFecha($this->ArchivoFin));
		$NuevoArrayDias = $dias_totales->RescatarArray();
		//Si los dias son igual a 1 entonces
		if($dias_totales->RescatarCantidad()==1)
		{
			$filas = new numero_filas($NuevoArrayDias[0].".cdr",$this->horainicio_sn,$this->horafin_sn);
			$fila_array = $filas->devolver_filas();				
			for($i=0;$i<$filas->cantidad_objetos();$i++){					
				$captura[] = str_replace(" ", "",$fila_array[$i]);
			}
			$this->captura = $captura;	
		}
		else
		//si son mas dias entonces
		{
			for($k=0;$k<$dias_totales->RescatarCantidad();$k++)
			{
				//Selecciona el primer dia
				if($k==0)
				{				
					//echo $NuevoArrayDias[$k]; 
					//echo "<br>";
					//esta cadena nos devuelve la cantidad de filas desde la hora de inicio en el dia de inico hasta las 23:59:59
					$filas = new numero_filas($NuevoArrayDias[$k].".cdr",$this->horainicio_sn,"23:59:59");
					$fila_array = $filas->devolver_filas();
					
					for($i=0;$i<$filas->cantidad_objetos();$i++){
					
						$captura[] = str_replace(" ", "",$fila_array[$i]);	
					}			
				}
				//selecciona el ultimo dia
				elseif($k==$dias_totales->RescatarCantidad()-1)
				{
					//echo $NuevoArrayDias[$k]; 
					//echo "<br>";
					//esta cadena nos devuelve la cantidad de filas desde la hora de 00:00:01 en el dia de inico hasta las 23:59:59
					$filas = new numero_filas($NuevoArrayDias[$k].".cdr","00:00:01",$this->horafin_sn);
					$fila_array = $filas->devolver_filas();
					for($i=0;$i<$filas->cantidad_objetos();$i++){
					
						$captura[] = str_replace(" ", "",$fila_array[$i]);	
					}
				}
				//selecciona el resto de dias
				else
				{
					//echo $NuevoArrayDias[$k]; 
					//echo "<br>";
					//esta cadena nos devuelve la cantidad de filas desde la hora de 00:00:01 en el dia de inico hasta las 23:59:59
					//$this->numero_filas($NuevoArrayDias[$k].".cdr","00:00:01",$this->horafin_sn);
					$filas = new numero_filas($NuevoArrayDias[$k].".cdr","00:00:01","23:59:59");
					$fila_array = $filas->devolver_filas();
					for($i=0;$i<$filas->cantidad_objetos();$i++){
					
						$captura[] = str_replace(" ", "",$fila_array[$i]);	
					}
				}
				$this->captura = $captura;
				
			}
		
		}
	
		}
			public function mostrar_filas() {
		return $this->captura;
	}
	
}
/*$a = new recuperar_archivo("090505.cdr","10:00:00","090505.cdr","15:00:00"); //recibe la informacion
$a->calcular_filas();	//Calcula la informacion 
echo var_dump($a->mostrar_filas());	//devuelve la informacion en un array*/
?>
