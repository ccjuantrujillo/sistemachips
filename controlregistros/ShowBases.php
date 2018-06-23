<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo3 {color: #990000; font-weight: bold; }
body {
	background-color: #CCCCCC;
}
-->
</style>
</head>

<body>
<?PHP 
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}
$numerobase=$_GET['base'];
$numero=$_GET['numero'];

if($numero!='')
{
$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();
$sql="select * from chip where Numero='".$numero."' and estado='0'and baja ='1'";
$NuevaConexion->leermysql($sql);
$my = mysql_fetch_array($NuevaConexion->arraymysql());
$minutos_totales=$my[Minutos];
$minutoActual=$my[MinutoActual];
$base=array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
//$minutos_totales = $my[MinutoActual];
$chip = $my[idChip];

$NuevaConexion->leermysql("select base from bases where id_base='".$numerobase."'");
$my = mysql_fetch_array($NuevaConexion->arraymysql());
$nombreBase = $my[base];

$sql4="select * from usuariochip where idTipoCliente='1' and idDatosCliente='$numerobase' and Estado = '1' and Baja ='1' order by IdUsuarioChip desc limit 1";
//echo $sql4;
$NuevaConexion->leermysql($sql4);
$myfecha = mysql_fetch_array($NuevaConexion->arraymysql());
$FechaInicio = $myfecha[FechaInicio];
//$FechaInicio;//formato 11/05/09 16:30
$dia	=	substr($FechaInicio,0,2);
$mes	=	substr($FechaInicio,3,2);
$anio	=	substr($FechaInicio,6,2);
$fecha1 =	$anio.$mes.$dia;
$hora	=	substr($FechaInicio,9,5);

$fecha_get1 	= 	$fecha1.".cdr";
$hora1			=	$hora.":00";
$fecha_get2 	= 	date("ymd").".cdr";
$hora2 		= 	(date("H")).date(":i:s");

//echo "$fecha_get1 $hora1 $fecha_get2 $hora2";
//("090503.cdr","18:00:00","090503.cdr","18:54:00")
$datos_nuevos = new recuperar_archivo($fecha_get1,$hora1,$fecha_get2,$hora2);
$datos_nuevos->calcular_filas();
$array_datos = $datos_nuevos->mostrar_filas();
?>
</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
<tr>
<td align="center"><strong><? echo "$nombreBase : $numero";?></strong></td>
</tr>
</table>
<table width="690" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
<? 
//Promedio de llamadas
for($i=0;$i<count($array_datos);$i++)
{
	$nuevoarray = new OrdenLinealArray($array_datos[$i]);
	$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
	if($InicioLlamada->mostrar()<>"invalido" and $nuevoarray->RescatarDuracion()<>0)
	{
	//Datos de La tabla de informacion
	for($j=1;$j<25;$j++)
	{
		if($nuevoarray->RescatarCanalSalida()==$j)
		{
			$base[$j] = $base[$j]+$nuevoarray->RescatarDuracion();
		}		
	}
}
}
$consumo=round($base[$numerobase]/60);
$minutos_usados=$consumo+($minutos_totales-$minutoActual);
$restan = $minutos_totales-$minutos_usados;
?>  

</table>
<table width="221" height="137" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="221" height="137"><table width="210" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td height="24" colspan="2">
		<div align="center">
		<?
		$ProgressBar = new ProgressBar("10","150","#0000F0",$minutos_totales,$minutos_usados);
		echo $ProgressBar->mostrar();
		?>
	    </div></td>
        </tr>
      <tr>
        <td width="100" height="26"><strong>Restanes: </strong></td>
        <td width="110"><span class="Estilo3"><? echo $restan ?></span></td>
        </tr>
      <tr>
        <td height="22"><strong> Usados:</strong></td>
        <td height="22"><span class="Estilo3"><? echo $minutos_usados ?></span></td>
        </tr>
      <tr>
        <td height="23"><strong>Totales:</strong></td>
        <td height="23"><span class="Estilo3"><? echo $minutos_totales ?></span></td>
        </tr>
      <tr>
        <td height="23"><strong>Fecha:</strong></td>
        <td height="23"><span class="Estilo3"><? echo $myfecha[FechaInicio] ?></span></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
<?
}
else
{
	echo "No existe chip para esta Base";
}
?>
</html>
