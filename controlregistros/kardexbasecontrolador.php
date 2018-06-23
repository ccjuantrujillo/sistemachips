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
.Estilo4 {font-size: 10px}
-->
</style>
</head>

<body>

<p align="center">
  <?

/*require("recuperar_archivo.php");
require("FormatFecha.php");
require("OrdenLinealArray.php");
require("CausaDesconexion.php");
require("MinutosSegundos.php");*/
if(!(empty($_GET[fecha1])) and !(empty($_GET[fecha1])) and !(empty($_GET[bases])))
	{
		/*$fecha1 = $_GET[fecha1];
		$fecha2 = $_GET[fecha2];
		$hora1 = $_GET[hora1];
		$hora2 = $_GET[hora2];*/
		
//$fecha = $_GET[fecha];
$mybase = $_GET[bases];
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
	
	$hora= array();
  for($i=0;$i<count($array_datos);$i++)
{
	$nuevoarray = new OrdenLinealArray($array_datos[$i]);
	//$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
	$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
	$FinLlamada = new FormatFecha($nuevoarray->RescatarTiempoDesconexion());
	$mensajedesconexion = new CausaDesconexion($nuevoarray->RescatarCausaDesconexion());
	
	if($InicioLlamada->mostrar()<>"invalido" and $nuevoarray->RescatarDuracion()<>0){
	//Datos de La tabla de informacion

	if($nuevoarray->RescatarCanalSalida()==$mybase)
		{	
			$base[$mybase] = $base[$mybase]+$nuevoarray->RescatarDuracion();
			for($m=0;$m<25;$m++)
				{					
					if(strlen($m)==1){$cero=0;}else{$cero="";};			
					if(substr($nuevoarray->RescatarTiempoConexion(),8,2)==$cero.$m)
					{
						//echo substr($nuevoarray->RescatarTiempoConexion(),8,2);
						$hora[$m] = $hora[$m] + $nuevoarray->RescatarDuracion();
					}
				}		
		}
	
	}
}

?>  

<? 
$Tiempototal=0;
for($k=1;$k<25;$k++)
	{
		 $Tiempototal = $base[$mybase];
		 //$conversion = new MinutosSegundos();
		 //$base[$k] = $conversion->ConversionTiempo($base[$k]);
		 $base[$k] = round($base[$k]/60);
	}
$Tiempototal = $base[$mybase];	
?>
&nbsp;
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#990000">
  <tr>
    <td height="24"><div align="center"><span class="Estilo2"><strong>&nbsp;Base <? echo $mybase ?></strong></span></div></td>
  </tr>
</table>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="12" bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Hora</strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Minutos</strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Grafica</strong></span></div></td>
    <td bgcolor="#990000"><div align="center"></div></td>
  </tr>
 
  <? for($i=0;$i<25;$i++)
  	{
		$total =$hora[$i]+$total
   ?>
    <tr>
    <td width="114" height="31" bgcolor="#FBECC8"><div align="center"><strong><?PHP if(strlen($i)==1){$cero=0;}else{$cero="";}; echo $cero.$i ?>
    </strong><strong>Horas</strong></div>      </td>
	<?PHP if($hora[$i]==""){$hora[$i]=0;}?>
    <td width="144" bgcolor="#FBECC8"><div align="center"><? echo  round($hora[$i]/60); ?></div>      </td>
	
    <td width="322" bgcolor="#FBECC8"><table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF">
		<table width="<?PHP echo ($hora[$i]/60)*4; ?>" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFCC00" bgcolor="#0000FF">
            <tr>
              <td><span class="Estilo4">0</span></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="140" bgcolor="#FBECC8"><div align="center"><strong>Base <? echo $mybase ?></strong></div></td>
	 </tr>
	<? } ?>
</table>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#990000"><div align="right" class="Estilo2"><strong>Total Minutos Usados </strong></div></td>
    <td bgcolor="#990000"><div align="center" class="Estilo2"><strong><? echo $base[$mybase] ?></strong></div></td>
  </tr>
</table>
<p align="center">

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