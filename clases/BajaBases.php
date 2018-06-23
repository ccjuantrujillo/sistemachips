
<?PHP

class BajaBases{
	/*
	*Devemos cambiar el estado de la base en  la tabla bases a 0
	*Devemos cambiar el estado en la tabla usuariochip  a 0
	*Devemos cambiar el estado en la tabla chip a 1 y colocar la cantidad actual de minutos
	*/
	public function __construct($numerobase,$numero,$fecha){
		$this->numerobase 	= 	$numerobase;
		$this->numero 		= 	$numero;
		$this->fecha		=	$fecha;
	}
	public function Baja(){

		$NuevaConexion = new BaseDeDatos();
		$NuevaConexion->conectar();
		
		$NuevaConexion->leermysql("select * from chip where Numero='$this->numero' and estado='0' and  baja ='1'");///
		$ArrayChips = mysql_fetch_array($NuevaConexion->arraymysql());
		$minutos_totales = $ArrayChips[MinutoActual];
		
		$NuevaConexion->leermysql
		("select * from usuariochip where 
		idTipoCliente	=	'1' 					and 
		idDatosCliente	=	'$this->numerobase' 	and 
		Estado 			= 	'1' 					and 
		Baja 			=	'1'");
		
		$ArrayUsuariochip = mysql_fetch_array($NuevaConexion->arraymysql());
		
		$FechaInicio 			= $ArrayUsuariochip[FechaInicio]; //formato 11/05/09 16:30
		$this->identificadorusuario	= $ArrayUsuariochip[ idUsuarioChip];

		$dia	=	substr($FechaInicio,0,2);
		$mes	=	substr($FechaInicio,3,2);
		$anio	=	substr($FechaInicio,6,2);		
		$hora	=	substr($FechaInicio,9,5);
		$fecha1 =	$anio.$mes.$dia;
	
		$fecha_get1 	= 	$fecha1.".cdr";
		$hora1			=	$hora.":00";
		
		if($this->fecha=="")
		{
		$fecha_get2 	= 	date("ymd").".cdr";
		$hora2 		= 	(date("H")-1).date(":i:s");
		$tiempoactual = date("d/m/y ").(date("H")-1).date(":i");
		echo $fecha_get2;
		echo $hora2;
		}
		else
		{
		$diab	=	substr($this->fecha,0,2);
		$mesb	=	substr($this->fecha,3,2);
		$aniob	=	substr($this->fecha,8,2);
		$fecha2 =	$aniob.$mesb.$diab;
		
		$fecha_get2 	= 	$fecha2.".cdr";
		$hora2 			= 	"23:59:00";
		$tiempoactual 	= 	$diab."/".$mesb."/20".$aniob." 23:59";
		echo $fecha_get2;
		echo $hora2; 
		}
		
		
		//("090503.cdr","18:00:00","090503.cdr","18:54:00")		
		$datos_nuevos = new recuperar_archivo($fecha_get1,$hora1,$fecha_get2,$hora2);
		$datos_nuevos->calcular_filas();
		$array_datos = $datos_nuevos->mostrar_filas();
		
		for($i=0;$i<count($array_datos);$i++)
			{
				$nuevoarray = new OrdenLinealArray($array_datos[$i]);
				$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());		
		
				if($InicioLlamada->mostrar()<>"invalido" and $nuevoarray->RescatarDuracion()<>0){
				//Datos de La tabla de informacion
	
				if($nuevoarray->RescatarCanalSalida()==$this->numerobase){
				$base[$this->numerobase] = $base[$this->numerobase]+$nuevoarray->RescatarDuracion();
				}
				}
			}

	$minutos_usados =round($base[$this->numerobase]/60);	
	$restan = $minutos_totales-$minutos_usados;	

	$NuevaConexion->leermysql("UPDATE chip SET estado='1', MinutoActual='$restan' where  Numero = '$this->numero'");	
	//paso 02	
	$NuevaConexion->leermysql("UPDATE bases SET estado='0' where id_base = '$this->numerobase'");
	//paso 03
	$NuevaConexion->leermysql("UPDATE usuariochip SET estado='0', FechaFin='$tiempoactual' where  idUsuarioChip = '$this->identificadorusuario'");		

	}
}
/*
Clase Ejemplo
$BajaBase = new BajaBases("1","989119302"); // Numero Base Numero de Chip
echo $BajaBase->Baja();
*/	

?>

	
	 