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
.Estilo3 {font-size: 9px}
.Estilo4 {font-weight: bold}
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
if(!(empty($_GET[fecha1])) and !(empty($_GET[fecha2])))
	{
		/*$fecha1 = $_GET[fecha1];
		$fecha2 = $_GET[fecha2];
		$hora1 = $_GET[hora1];
		$hora2 = $_GET[hora2];*/
		
//$fecha = $_GET[fecha];
$fecha_get1 = $fecha1.".cdr";
$fecha_get2 = $fecha2.".cdr";
//("090503.cdr","18:00:00","090503.cdr","18:54:00")
$datos_nuevos = new recuperar_archivo($fecha_get1,"00:00:01",$fecha_get2,"23:59:59");
$datos_nuevos->calcular_filas();
$array_datos = $datos_nuevos->mostrar_filas();
  
//inicializo las bases en 0
	$base[] = array();	 

?>

<? 
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
				for($j=1;$j<25;$j++)//base
				{
					if($nuevoarray->RescatarCanalSalida()==$j){	
						for($l=0;$l<25;$l++)//horas
							{	
								if(strlen($l)==1){$cero=0;}else{$cero="";};	
								if(substr($nuevoarray->RescatarTiempoConexion(),8,2)==$cero.$l)
								{
								$base[$j][$l] = $base[$j][$l] + $nuevoarray->RescatarDuracion();
								}
							}
							
					}		
				}
	
			}
		}

?>  
</table>
<? 
$Tiempototal=0;
for($k=1;$k<25;$k++)
	{
		 //$Tiempototal = $base[$k]+$Tiempototal;
		 //$conversion = new MinutosSegundos();
		 //$base[$k] = $conversion->ConversionTiempo($base[$k]);
		 //$base[$k] = round($base[$k]/60);
	}
?>
&nbsp;<br />
<table width="660" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="156" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Horas</strong></div></td>
    <td width="75" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Minutos</strong></div></td>
    <td width="242" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Grafica</strong></div></td>
    <td width="173" bgcolor="#990000"><div align="center" class="Estilo2"><strong>Base</strong></div></td>
  </tr>
  <? for($i=0;$i<25;$i++) //hora
  {
  if(strlen($i)==1){$cero=0;}else{$cero="";};	
  ?>
  <tr>
    <td rowspan="25">Hora <? echo  $cero.$i ?> </td>
    <td> </td>
    <td> </td>
    <td> </td>
  </tr>
 <? for($j=1;$j<25;$j++){ ?>
   <tr>

	<td height="23">
	  <div align="center"><strong>
	    <? 
			if($base[$j][$i]=="")
		{
			echo "0";
			echo "<br>";
		}
		else
		{
			echo round($base[$j][$i]/60);
			echo "<br>";
		}
	?></strong></div></td>
	<td>
	<table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
			 <tr>
				<td bgcolor="#FFFFFF">
					<table width="<?PHP echo ($base[$j][$i]/60)*4; ?>" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFCC00" bgcolor="#0000FF">
					<tr>
				  <td><span class="Estilo4 Estilo3"> </span></td>
				</tr>
				</table></td>
		  </tr>
	  </table>
		
	</td>	
	<td>
	  <strong>
	<? 
	 if(strlen($j)==1){$cero=0;}else{$cero="";};	
	echo "Base ".$cero.$j 
	?></strong></td>
	
  </tr>
<? } ?>
  <? 
  }
  ?>
  <tr>
    <td bgcolor="#990000">&nbsp;</td>
    <td bgcolor="#990000">&nbsp;</td>
    <td bgcolor="#990000">&nbsp;</td>
    <td width="2" bgcolor="#990000">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<br />
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
