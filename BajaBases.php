<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
body {
	background-color: #990000;
}
-->
</style>
</head>
<? 
function __autoload($class_name) {
    require_once "clases/".$class_name . '.php';
}
if(!(empty($_POST[mybase])))
{
	$mynumero 		= $_POST[mynumero];
	$mybase 		= $_POST[mybase];
	$myidusuario	= $_POST[myidusuario];
	/*Para dar de baja devemos realizar los siguientes pasoa
	*Devemos cambiar el estado de la base en  la tabla bases a 0
	*Devemos cambiar el estado en la tabla usuariochip  a 0
	*Devemos cambiar el estado en la tabla chip a 1 y colocar la cantidad actual de minutos
	*/
	//Iniciamos conexiones
	$NuevaConexion = new BaseDeDatos();
	$NuevaConexion->conectar();
	
	//paso 01  ... El mas largo	
	
	//Esto deve ser un objeto MARTIN si lees esto despues lo vonvertimos aqui y en showbases.php
	$NuevaConexion->leermysql("select * from chip where Numero='$mynumero'");
	$my = mysql_fetch_array($NuevaConexion->arraymysql());
	$minutos_totales = $my[MinutoActual];
	
	$NuevaConexion->leermysql
	("select * from usuariochip where idTipoCliente='1' and idDatosCliente='$mybase' and Estado = '1' and Baja ='1'");
	$myfecha = mysql_fetch_array($NuevaConexion->arraymysql());
	$FechaInicio = $myfecha[FechaInicio];
	$FechaInicio;//formato 11/05/09 16:30
	$dia	=	substr($FechaInicio,0,2);
	$mes	=	substr($FechaInicio,3,2);
	$anio	=	substr($FechaInicio,6,2);
	$fecha1 =	$anio.$mes.$dia;
	$hora	=	substr($FechaInicio,9,5);
	
	$fecha_get1 	= 	$fecha1.".cdr";
	$hora1			=	$hora.":00";
	$fecha_get2 	= 	date("ymd").".cdr";
	$hora2 		= 	(date("H")-1).date(":i:s");
	
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
	
		for($j=1;$j<25;$j++)
		{
			if($nuevoarray->RescatarCanalSalida()==$j){
			$base[$j] = $base[$j]+$nuevoarray->RescatarDuracion();
			}		
		}
		}
	
	}
	$minutos_usados =round($base[$mybase]/60);
	$restan = $minutos_totales-$minutos_usados;
	$tiempoactual = date("d/m/y ").(date("H")-1).date(":i");
	//$minutos_totales <-- variables con los minutos iniciales
	//aqui acaba el futuro objeto
	$NuevaConexion->leermysql("UPDATE chip SET estado='1', MinutoActual='$restan' where  Numero = '$mynumero'");	
	//paso 02	
	$NuevaConexion->leermysql("UPDATE bases SET estado='0' where id_base = '$mybase'");
	//paso 03
	$NuevaConexion->leermysql("UPDATE usuariochip SET estado='0', FechaFin='$tiempoactual' where  idUsuarioChip = '$myidusuario'");		
	
	?>
	<script>
	window.opener.location.reload();
	window.close();
	</script>
	<?
}

$base 		= $_GET[base];
$numero 	= $_GET[numero];
$idusuario 	= $_GET[idusuario];
?>

<body>
<form id="form1" name="form1" method="post" action="">
  <p class="Estilo1">Esta seguro que desea dar de baja la base <? echo $base ?>    Para realizar la baja debe primero dejar la
    base sin Chip  
    <input name="mynumero" type="hidden" id="mynumero" value="<? echo $numero ?>" />
    <input name="mybase" type="hidden" id="mybase" value="<? echo $base ?>" />
	<input name="myidusuario" type="hidden" id="myidusuario" value="<? echo $idusuario ?>" />
  </p>
  <p>
  <label>
    <div align="center">
        <div align="center">
          <input type="submit" name="Submit" value="Estoy de Acuerdo Dar de Baja" />
              </div>
  </label>
</form>
</body>
</html>
