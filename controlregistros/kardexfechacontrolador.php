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
.Estilo2 {color: #FFFFFF}
.Estilo3 {
	color: #000000;
	font-weight: bold;
}
-->
</style>
</head>

<body>

<p align="center">
  <?
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}
/*require("recuperar_archivo.php");
require("FormatFecha.php");
require("OrdenLinealArray.php");
require("CausaDesconexion.php");
require("MinutosSegundos.php");*/
$NuevaConexion=new BaseDeDatos();
$NuevaConexion->conectar();
if(!(empty($_GET[fecha1])) and !(empty($_GET[fecha2])) and !(empty($_GET[fhora])) and !(empty($_GET[ihora])))
	{
		/*$fecha1 = $_GET[fecha1];
		$fecha2 = $_GET[fecha2];
		$hora1 = $_GET[hora1];
		$hora2 = $_GET[hora2];*/
		
//$fecha = $_GET[fecha];
$fecha_get1 = $fecha1.".cdr";
$fecha_get2 = $fecha2.".cdr";
//("090503.cdr","18:00:00","090503.cdr","18:54:00")
$datos_nuevos = new recuperar_archivo($fecha_get1,$hora1,$fecha_get2,$hora2);
$datos_nuevos->calcular_filas();
$array_datos = $datos_nuevos->mostrar_filas();
  
//inicializo las bases en 0
	$base[1] = 0;	$base[2] = 0;	$base[3] = 0;	$base[4] = 0;	$base[5] = 0;	$base[6] = 0;	$base[7] = 0;	$base[8] = 0;
	$base[9] = 0;	$base[10] = 0;	$base[11] = 0;	$base[12] = 0;	$base[13] = 0;	$base[14] = 0;	$base[15] = 0;	$base[16] = 0;
	$base[17] = 0;	$base[18] = 0;	$base[19] = 0;	$base[20] = 0;	$base[21] = 0;	$base[22] = 0;	$base[23] = 0;	$base[24] = 0;  

	//Promedio de llamadas

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
		for($j=1;$j<25;$j++)
		{
			if($nuevoarray->RescatarCanalSalida()==$j){
			$base[$j] = $base[$j]+$nuevoarray->RescatarDuracion();
			}		
		}
	
		//Muestra solo las Bases activas 
		//$NuevaConexion->leermysql("select id_base from bases where estado='1'");
		//while($row1=mysql_fetch_array($NuevaConexion->arraymysql()))
		//{
		//	$idmuestra=$row1[0];
		//	if($nuevoarray->RescatarCanalSalida()==$idmuestra){
		//	$base[$idmuestra] = $base[$idmuestra]+$nuevoarray->RescatarDuracion();
		//	}
		//}
	}
}

$Tiempototal=0;
for($k=1;$k<25;$k++)
{
		 $Tiempototal = $base[$k]+$Tiempototal;
		 //$conversion = new MinutosSegundos();
		 //$base[$k] = $conversion->ConversionTiempo($base[$k]);
		 $base[$k] = round($base[$k]/60);
}


?>
&nbsp;

<table width="621" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
  <tr>
    <td colspan="5" bgcolor="#990000"><div align="center" class="Estilo1">Consumo de Bases en Minutos </div></td>
  </tr>
  <tr>
    <td width="129" height="25" bgcolor="#990000"><span class="Estilo1">Base 01 </span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[1] ?></span></div></td>
    <td width="156" bgcolor="#990000"><span class="Estilo1">Base 13 </span></td>
    <td width="159" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[13] ?></span></div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#990000"><span class="Estilo1">Base 02</span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[2] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 14 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[14] ?></span></div></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#990000"><span class="Estilo1">Base 03 </span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[3] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 15 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[15] ?></span></div></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#990000"><span class="Estilo1">Base 04 </span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[4] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 16 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[16] ?></span></div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#990000"><span class="Estilo1">Base 05 </span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[5] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 17 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[17] ?></span></div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#990000"><span class="Estilo1">Base 06</span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[6] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 18 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[18] ?></span></div></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#990000"><span class="Estilo1">Base 07</span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[7] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 19 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[19] ?></span></div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#990000"><span class="Estilo1">Base 08</span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[8] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 20 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[20] ?></span></div></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#990000"><span class="Estilo1">Base 09</span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[9] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 21 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[21] ?></span></div></td>
  </tr>
  <tr>
    <td height="24" bgcolor="#990000"><span class="Estilo1">Base 10 </span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[10] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 22 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[22] ?></span></div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#990000"><span class="Estilo1">Base 11 </span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[11] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 23 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[23] ?></span></div></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#990000"><span class="Estilo1">Base 12 </span></td>
    <td colspan="2" bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[12] ?></span></div></td>
    <td bgcolor="#990000"><span class="Estilo1">Base 24 </span></td>
    <td bgcolor="#FBECC8"><div align="center"><span class="Estilo3"><? echo $base[24] ?></span></div></td>
  </tr>
    <tr>
    <td colspan="5" bgcolor="#FBECC8"><span class="Estilo2"></span></td>
  </tr>
    <tr>
    <td height="25" colspan="2" bgcolor="#990000"><span class="Estilo1">Minutos Totalizados </span></td>
    <td width="8" bgcolor="#990000">&nbsp;</td>
    <td bgcolor="#990000"><span class="Estilo1">Desde el Dia:  </span></td>
    <td bgcolor="#990000"><span class="Estilo1">
<?PHP echo substr($_GET[fecha1],4,2)."/".substr($_GET[fecha1],2,2)."/".substr($_GET[fecha1],0,2)." ".$_GET[ihora].":".$_GET[iminuto] ?></span></td>
  </tr>
    <tr>
    <td colspan="2" bgcolor="#990000"><div align="right" class="Estilo2"><strong>Total  
      <? 
		echo round($Tiempototal/60);
		//round($Tiempototal/60)/count($array_datos)
		/*$sumatoriatiempo = new MinutosSegundos();
		echo $sumatoriatiempo->ConversionTiempo($Tiempototal);
	*/
	?> Minutos 
    </strong></div></td>
    <td bgcolor="#990000">&nbsp;</td>
    <td bgcolor="#990000"><span class="Estilo1">Hasta el Dia: </span></td>
    <td bgcolor="#990000"><span class="Estilo1">
<?PHP echo substr($_GET[fecha2],4,2)."/".substr($_GET[fecha2],2,2)."/".substr($_GET[fecha2],0,2)." ".$_GET[fhora].":".$_GET[fminuto] ?></span></td>
  </tr>
</table>
<?
}
else
{
echo "Por Favor envie los datos completos";
}
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
