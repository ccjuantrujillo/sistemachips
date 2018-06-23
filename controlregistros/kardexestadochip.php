<?
include "funcionFecha.php";
if(!(empty($_GET[idfecha1])) and !(empty($_GET[idfecha2])) and !(empty($_GET[fhora])) and !(empty($_GET[ihora])) and !(empty($_GET[chip])))
{
$fecha1 = $_GET[idfecha1];
$fecha2 = $_GET[idfecha2];
//echo $fecha2."<br>";
$hora1 = $_GET[ihora].":".$_GET[iminuto];
$hora2 = $_GET[fhora].":".$_GET[fminuto];	
$chip = $_GET['chip'];
//inicializo las bases en 0
	$base[1] = 0;	$base[2] = 0;	$base[3] = 0;	$base[4] = 0;	$base[5] = 0;	$base[6] = 0;	$base[7] = 0;	$base[8] = 0;
	$base[9] = 0;	$base[10] = 0;	$base[11] = 0;	$base[12] = 0;	$base[13] = 0;	$base[14] = 0;	$base[15] = 0;	$base[16] = 0;
	$base[17] = 0;	$base[18] = 0;	$base[19] = 0;	$base[20] = 0;	$base[21] = 0;	$base[22] = 0;	$base[23] = 0;	$base[24] = 0;  

$cadena="select 
		FechaInicio as inicio,
		FechaFin as fin,
		Estado as estado,
		idDatosCliente as base 
		from usuariochip 
		where Chip_idChip='".$chip."' 
		and Baja='1' 
		and FechaInicio>='".dateformato1($fecha1,$hora1)."' 
		and FechaInicio<='".dateformato1($fecha2,$hora2)."'
		and (Estado='1' or Estado='0' or Estado='2')
		";
//echo $cadena."<br>";
$NuevaConexion->leermysql($cadena);
$actual=date('d/m/y h:m',time());
$w=0;
$nfilas=mysql_num_rows($NuevaConexion->arraymysql());
if($nfilas!='0')
{
while($row=mysql_fetch_array($NuevaConexion->arraymysql()))
{
	$inicio=$row[inicio];
	//echo $row[fin]."<br>";
	$estado=$row[estado];
	//$arrEstado[$w]=($row[fin]=='' ? 'Libre':($estado=='2' ? 'En uso cliente':(($estado=='0' && $w==($nfilas-1)) ? 'En uso base':'Usado')));
	if($row[fin]=='')
	{
		$fin=$actual;
		if($estado=='0')
		{
			$arrEstado[$w]='Libre';
		}
		elseif($estado=='1')
		{
			$arrEstado[$w]='Libre';
		}
		elseif($estado=='2')
		{
			$arrEstado[$w]='Libre';
		}
	}
	else
	{
		$freq2=dateformato1($fecha2,$hora2);
		if($row[fin]>$freq2)
		{
			$fin=$freq2;
		}
		else
		{
			$fin=$row[fin];
		}
	}
	//$fin=($row[fin]=='' ? $actual:$row[fin]);
	//echo $fin."<br>";
	$Base=$row[base];
	$NuevoObjeto=new FormatFecha($inicio);
	$NuevoObjeto->conversion1();
	$finicio=$NuevoObjeto->mostrarFecha();
	$hinicio=$NuevoObjeto->mostrarHora();
	$NuevoObjeto=new FormatFecha($fin);
	$NuevoObjeto->conversion1();
	$ffin=$NuevoObjeto->mostrarFecha();
	$hfin=$NuevoObjeto->mostrarHora();
	//$hfin='00:00:00';
	//echo "$finicio  $hinicio   $ffin    $hfin<br>";
	$fecha_get1 = $finicio.".cdr";
	$fecha_get2 = $ffin.".cdr";
	$hora_get1=$hinicio;
	$hora_get2=$hfin;
	$datos_nuevos = new recuperar_archivo($fecha_get1,$hora_get1,$fecha_get2,$hora_get2);
	$datos_nuevos->calcular_filas();
	$array_datos = $datos_nuevos->mostrar_filas();
	
	for($i=0;$i<count($array_datos);$i++)
	{
		$nuevoarray = new OrdenLinealArray($array_datos[$i]);
		//$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
		$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
		$FinLlamada = new FormatFecha($nuevoarray->RescatarTiempoDesconexion());
		//$mensajedesconexion = new CausaDesconexion($nuevoarray->RescatarCausaDesconexion());
	
		if($InicioLlamada->mostrar()<>"invalido" and $nuevoarray->RescatarDuracion()<>0)
		{
		//Datos de La tabla de informacion
		for($j=1;$j<25;$j++)
		{
			if($nuevoarray->RescatarCanalSalida()==$j){
			$base[$j] = $base[$j]+$nuevoarray->RescatarDuracion();
			}		
		}

		}
	}
	$arrDuracion[$w]=$base[$Base];
	$arrInicio[$w]=$inicio;
	$arrFin[$w]=$fin;
	$arrBase[$w]=$Base;
	$w=$w+1;
}
}
}
else
{
echo "Por Favor envie los datos completos";
}
?>


<html>
<style type="text/css">
<!--
.Estilo2 {color: #FFFFFF}
.Estilo4 {font-size: 10px}
-->
</style>
<table width="690" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td height="12" bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Fecha Inicial </strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Fecha Final </strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Base</strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Estado Base</strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Consumo(min)</strong></span></div></td>
  </tr>
<? 
if($nfilas!='0')  
{
for($i=0;$i<count($arrDuracion);$i++)
{
?>
  <tr>
    <td width="151" height="31" bgcolor="#FBECC8">
	<div align="center">
		<strong><?=$arrInicio[$i];?></strong>	</div>	</td>
    <td width="185" bgcolor="#FBECC8">
	<div align="center">
		<strong><?=$arrFin[$i];?></strong>	</div>	</td>
    <td width="197" bgcolor="#FBECC8">
	<div align="center">
		<strong>
		<?
//		echo "select base from id_base='".$arrBase[$i]."'";
		$NuevaConexion->leermysql("select base from bases where id_base='".$arrBase[$i]."'");
		$row1=mysql_fetch_array($NuevaConexion->arraymysql());
		echo $row1[0];
		?>
		</strong>	</div>	</td>
    <td width="187" bgcolor="#FBECC8"><div align="center"> <strong>
      <?=$arrEstado[$i];?>
    </strong> </div></td>
    <td width="187" bgcolor="#FBECC8">
	<div align="center">
		<strong><?=(number_format(($arrDuracion[$i]/60),0));?></strong>	</div>	</td>
  </tr>
  <? 
  } 
}
else
{
?>
<tr>
    <td width="151" height="31" bgcolor="#FBECC8" colspan='5'>
		<div align="center">No existen registros</div>
	</td>
  </tr>
<?
}
  ?>
</table>
</html>