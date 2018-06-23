<?PHP
include_once("recuperar_archivo.php");
include_once("FormatFecha.php");
include_once("OrdenLinealArray.php");
include_once("CausaDesconexion.php");
class ConsumoBase{
public function __construct($Fecha1,$Fecha2,$base)
{
	$arrFecha1=explode(' ',$Fecha1);
	$arrfecha1=explode('/',$arrFecha1[0]);
	$fecha1=$arrfecha1[2].''.$arrfecha1[1].''.$arrfecha1[0];
	$hora1=$arrFecha1[1].":00";
	
	$arrFecha2=explode(' ',$Fecha2);
	$arrfecha2=explode('/',$arrFecha2[0]);
	$fecha2=$arrfecha2[2].''.$arrfecha2[1].''.$arrfecha2[0];
	$hora2=$arrFecha2[1].":00";
	//echo "$fecha1  $hora1    $fecha2     $hora2";die();
	$fecha_get1 = $fecha1.".cdr";
	$fecha_get2 = $fecha2.".cdr";
	$hora1=$hora1;
	$hora2=$hora2;
	//("090503.cdr","18:00:00","090503.cdr","18:54:00")
	$datos_nuevos = new recuperar_archivo($fecha_get1,$hora1,$fecha_get2,$hora2);
	$datos_nuevos->calcular_filas();
	$array_datos = $datos_nuevos->mostrar_filas();
	//echo "Cantidad".count($array_datos)."<br>";
	$total=0;
	for($i=0;$i<count($array_datos);$i++)
	{
		$nuevoarray = new OrdenLinealArray($array_datos[$i]);
		//$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
		$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
		$FinLlamada = new FormatFecha($nuevoarray->RescatarTiempoDesconexion());
		$mensajedesconexion = new CausaDesconexion($nuevoarray->RescatarCausaDesconexion());

		if($InicioLlamada->mostrar()<>"invalido" and $nuevoarray->RescatarDuracion()<>0)
		{
		//Datos de La tabla de informacion
			if($nuevoarray->RescatarCanalSalida()==$base)
			{	
				$cantidad1=$nuevoarray->RescatarDuracion();
				$total = $total+$cantidad1;
			}
		}
	}	
	$this->consumo=number_format($total/60,0);
}
public function Consumo()
{
	return $this->consumo;
}			
}
?>
<?
//Duracion por base en un intervalo de tiempo
//$NuevoObjeto=new ConsumoBase("11/05/09 13:00","15/05/09 15:40","2");
//echo $NuevoObjeto->Consumo();
?>
