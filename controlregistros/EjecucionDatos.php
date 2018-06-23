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
.Estilo2 {font-family:"Times New Roman";color: #FFFFFF;font-size:13}
.Estilo3 {font-family:"Times New Roman";font-weight:normal;color: #000000;font-size:11}
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

?></p>
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
	<tr><td align="right"><input type="button" value="Recargar" onclick="form1.submit();"></td></tr>
</table>
<br>
<table width="690" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="97" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Base </strong></div></td>
    <td width="118" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Numero</strong></div></td>
    <td width="159" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Inicio Llamada </strong></div></td>
    <td width="155" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Fin llamada </strong></div></td>
    <td width="135" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Duracion</strong></div></td>
  <!--  <td width="220" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Tipo de llamada </strong></div></td>-->
  </tr>
<? 
//Promedio de llamadas
	
$cantidad=count($array_datos);
for($i=$cantidad;$i>=0;$i--)
{
	$nuevoarray = new OrdenLinealArray($array_datos[$i]);
	//$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
	$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
	$FinLlamada = new FormatFecha($nuevoarray->RescatarTiempoDesconexion());
	$mensajedesconexion = new CausaDesconexion($nuevoarray->RescatarCausaDesconexion());
	
	if($InicioLlamada->mostrar()<>"invalido" and $nuevoarray->RescatarDuracion()<>0){
	//Datos de La tabla de informacion
	?>
	  <tr>
    <td bgcolor="#FBECC8" class="Estilo3">Base <? echo $nuevoarray->RescatarCanalSalida(); ?></td>
    <td bgcolor="#FBECC8" class="Estilo3"><? echo $nuevoarray->RescatarNumero(); ?></td>
    <td bgcolor="#FBECC8" class="Estilo3"><? echo	$InicioLlamada->mostrar();	?></td>
    <td bgcolor="#FBECC8" class="Estilo3"><? echo $FinLlamada->mostrar(); ?></td>
    <td bgcolor="#FBECC8" class="Estilo3"><? echo $nuevoarray->RescatarDuracion(); ?> Segundos </td>
    <!--  <td bgcolor="#FFFFFF"><?// echo $mensajedesconexion->MostrarMensaje(); ?><td width="9"></td>-->
  	</tr>
	<? 
	for($j=1;$j<25;$j++)
	{
		if($nuevoarray->RescatarCanalSalida()==$j){
		$base[$j] = $base[$j]+$nuevoarray->RescatarDuracion();
		}		
	}

	?>
	
<?
	}
}

?>  
</table>
<? 
$Tiempototal=0;
for($k=1;$k<25;$k++)
	{
		 $Tiempototal = $base[$k]+$Tiempototal;
		 //$conversion = new MinutosSegundos();
		 //$base[$k] = $conversion->ConversionTiempo($base[$k]);
		 $base[$k] = round($base[$k]/60);
	}
?>
&nbsp;<br />
<!--table width="397" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#1871B1">
  <tr>
    <td colspan="2" bgcolor="#1871B1"><div align="center" class="Estilo2"><strong>Calculo de Promedio de minutos </strong></div></td>
  </tr>
  <tr>
    <td width="185" height="23" bgcolor="#FBECC8"><strong>&nbsp;Total de Minutos </strong></td>
    <td width="196" bgcolor="#FBECC8"><? echo round($Tiempototal/60)/count($array_datos) ?></td>
  </tr>
</table-->
<br>
<!--table width="621" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000033" bgcolor="#1871B1">
  <tr>
    <td colspan="5"><div align="center" class="Estilo1">Consumo de Bases </div></td>
  </tr>
  <tr>
    <td width="126"><span class="Estilo2">Base 01 </span></td>
    <td width="140"><span class="Estilo2"><strong><? echo $base[1] ?> min</strong></span></td>
    <td width="20"><span class="Estilo2"></span></td>
    <td width="156"><span class="Estilo2">Base 13 </span></td>
    <td width="145"><span class="Estilo2"><strong><? echo $base[13] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 02</span></td>
    <td><span class="Estilo2"><strong><? echo $base[2] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 14 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[14] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 03 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[3] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 15 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[15] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 04 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[4] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 16 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[16] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 05 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[5] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 17 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[17] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 06</span></td>
    <td><span class="Estilo2"><strong><? echo $base[6] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 18 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[18] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 07</span></td>
    <td><span class="Estilo2"><strong><? echo $base[7] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 19 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[19] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 08</span></td>
    <td><span class="Estilo2"><strong><? echo $base[8] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 20 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[20] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 09</span></td>
    <td><span class="Estilo2"><strong><? echo $base[9] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 21 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[21] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 10 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[10] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 22 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[22] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 11 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[11] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 23 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[23] ?> min</strong></span></td>
  </tr>
  <tr>
    <td><span class="Estilo2">Base 12 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[12] ?> min</strong></span></td>
    <td><span class="Estilo2"></span></td>
    <td><span class="Estilo2">Base 24 </span></td>
    <td><span class="Estilo2"><strong><? echo $base[24] ?> min</strong></span></td>
  </tr>
    <tr>
    <td colspan="5"><span class="Estilo2"></span></td>
  </tr>
    <tr>
    <td colspan="2"><span class="Estilo2">Minutos Totalizados </span></td>
    <td><span class="Estilo2"></span></td>
    <td colspan="2"><span class="Estilo2">Desde el Dia: </span></td>
  </tr>
    <tr>
    <td colspan="2"><div align="right" class="Estilo2"><strong>Total  
      <? 
		echo round($Tiempototal/60);
		//round($Tiempototal/60)/count($array_datos)
		/*$sumatoriatiempo = new MinutosSegundos();
		echo $sumatoriatiempo->ConversionTiempo($Tiempototal);
	*/
	?> Minutos 
    </strong></div></td>
    <td><span class="Estilo2"></span></td>
    <td colspan="2"><span class="Estilo2">Hasta el Dia: </span></td>
  </tr>
</table-->
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
