<?
session_start();
function __autoload($class_name) {
  require_once "../clases/".$class_name . '.php';
}
?>
<html>
<head>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo2 {color: #FFFFFF}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="">
<table width="690" border="1" align="center" cellpadding="3" cellspacing="2" bordercolor="#FFFFFF">
 <tr>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2 Estilo1"><strong>Inventario de Bases </strong></span></div></td>
  </tr>
  <tr>
    <td height="51" bgcolor="#FBECC8"><input type="hidden" name="accion" id="accion" value="mostrar">
      <label>
      <div align="center"> <input type="submit" name="Submit" value="Mostrar">
      </div>      </label></td>
    </tr>
</table>
</form>
<p>
  <?
$accion=$_POST['accion'];
if($accion=="mostrar")
{
$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();
$NuevaConexion1 = new BaseDeDatos();
$NuevaConexion1->conectar();
$fechaActual=date("d/m/Y H:i:s",time());
$cadena0="
			select * from
			(
				select * from 									
				(	
						SELECT 			
		a.idUsuarioChip,a.idTipoCliente,a.idDatosCliente,a.Chip_idChip,a.FechaInicio,a.FechaFin,a.Estado,a.Baja
						FROM usuariochip AS a
						LEFT JOIN chip AS b ON a.Chip_idChip = b.idChip
						WHERE a.Baja = '1'
						AND a.idTipoCliente = '1'
						AND b.estado = '0'
						ORDER BY a.idDatosCliente, a.idUsuarioChip DESC 
				) 
				as tabla group by tabla.idDatosCliente
				having tabla.FechaFin=''
			) 
			as tabla1
			";
//echo $cadena0;
$NuevaConexion->leermysql($cadena0);
$fila="";
$n=0;
$consumoTotalClaro=0;
$consumoTotalMovistar=0;
while($row1=mysql_fetch_array($NuevaConexion->arraymysql()))
{
	$n++;
	$chip=$row1[Chip_idChip];
	$base=$row1[idDatosCliente];
	$fechaInicio=$row1[FechaInicio];
	$fechaFin=$row1[FechaFin];
	$cadena1="
				select
				chip.Numero as numero,
				chip.Minutos as minutos,
				chip.MinutoActual as minutoActual,
				operador.Nombre as operador,
				operador.idOperador as idOperador,
				planes.TipoPlan as tipoplan
				from chip
				left join planes on chip.idPlanes=planes.idPlanes
				left join operador on planes.idOperador=operador.idOperador
				where chip.idChip='".$chip."'
				";
	//echo $cadena1;
	$NuevaConexion1->leermysql($cadena1);
	$row2=mysql_fetch_array($NuevaConexion1->arraymysql());
	$numero=$row2[numero];
	$minutos=$row2[minutos];
	$minutoActual=$row2[minutoActual];
	$operador=$row2[operador];
	$tipoplan=$row2[tipoplan];
	$idOperador=$row2[idOperador];

	//Formateadmos las fechas
	$dia1=substr($fechaInicio,0,2);
	$mes1=substr($fechaInicio,3,2);
	$anio1=substr($fechaInicio,6,2);
	$fecha1=$anio1.$mes1.$dia1.".cdr";
	$hora1=substr($fechaInicio,9,5).":00";
	$fecha2=date("ymd",time()).".cdr";
	$hora2=date("H:i:s",time());
	
	//Calculamos el consumo por base en el intervalo de fecha requerido
	$arrbase=array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
	$datos_nuevos = new recuperar_archivo($fecha1,$hora1,$fecha2,$hora2);
	$datos_nuevos->calcular_filas();
	$array_datos = $datos_nuevos->mostrar_filas();
	for($i=0;$i<count($array_datos);$i++)
	{
		$nuevoarray = new OrdenLinealArray($array_datos[$i]);
		$InicioLlamada = new FormatFecha($nuevoarray->RescatarTiempoConexion());
		if($InicioLlamada->mostrar()<>"invalido" and $nuevoarray->RescatarDuracion()<>0 and $nuevoarray->RescatarCanalSalida()==$base)
		{
			$arrbase[$base] = $arrbase[$base]+$nuevoarray->RescatarDuracion();
		}
	}
	
	$a=$minutos-$minutoActual;
	$consumo=number_format(($a+$arrbase[$base]/60),0,'.','');
	$saldo=$minutos-$consumo;
	$fila.="<tr height='25'>";	
	$fila.="<td bgcolor='#FBECC8'>".$operador."</td>";	
	$fila.="<td bgcolor='#FBECC8' align='center'>".$tipoplan."</td>";
	$fila.="<td bgcolor='#FBECC8' align='center'>".$numero."</td>";
	$fila.="<td bgcolor='#FBECC8' align='right'>".$minutos."</td>";
	$fila.="<td bgcolor='#FBECC8' align='right'>".$consumo."</td>";
	$fila.="<td bgcolor='#FBECC8' align='right'>".$saldo."</td>";
	$fila.="<td bgcolor='#FBECC8' align='center'>".$base."</td>";
	$fila.="<td bgcolor='#FBECC8'>".$fechaInicio."</td>";
	$fila.="</tr>";
	
	//Calculamos el consumo total por operador
	if($idOperador=='1')
	{
		$consumoTotalClaro=$consumoTotalClaro+$consumo;
	}
	elseif($idOperador=='2')
	{
		$consumoTotalMovistar=$consumoTotalMovistar+$consumo;
	}
	$consumoTotalTotal=$consumoTotalClaro+$consumoTotalMovistar;
}
?>
</p>
<table width="720" border="0" align="center" cellspacing="0" cellpadding="1">
<tr height="30">
	<td align="center"><strong>Inventario de Bases al <?=$fechaActual;?></strong></td>
</tr>
	<tr height="30"> 
		<!--td align="right"><input type="button" name="boton2" value="Exporta Excell" onclick="exportaexcel()"></td-->
	</tr>
</table>
<table width="720" border="1" align="center" cellspacing="0" cellpadding="1">
	<tr bgcolor="#990000" height="15">
		<td width="81" height="30" bgcolor="#990000"><div align="center"><strong><font color="#ffffff">Operador</font></strong></div></td>				
		<td width='94' bgcolor="#990000"><div align="center"><strong><font color="#ffffff">Tipo Plan</font></strong></div></td>
		<td width='100' bgcolor="#990000"><div align="center"><strong><font color="#ffffff">Numero</font></strong></div></td>		
		<td width="103" bgcolor="#990000"><div align="center"><strong><font color="#ffffff">Min.Iniciales</font></strong></div></td>
		<td width="73" bgcolor="#990000"><div align="center"><strong><font color="#ffffff">Consumo</font></strong></div></td>
		<td width="98" bgcolor="#990000"><div align="center"><strong><font color="#ffffff">Saldo Actual</font></strong></div></td>
		<td width="40" bgcolor="#990000"><div align="center"><strong><font color="#ffffff">Base</font></strong></div></td>
		<td width="97" bgcolor="#990000"><div align="center"><strong><font color="#ffffff">Fecha Inicio</font></strong></div></td>
	</tr>
	<?=$fila;?>
</table>
<br>
<table width="370" border="1" align="center" cellpadding="4" cellspacing="0" bordercolor="#FFFFFF">
      <tr bgcolor="#990000" height="15">
        <td height="31" colspan="2" bgcolor="#990000"><div align="center"><span class="Estilo1">Consumo Total por operador (minutos)</span></div></td>
      </tr>
      <tr>
        <td width="96" bgcolor="#FBECC8" ><div align="left"><strong>Claro</strong></div></td>
        <td width="281" bgcolor="#FBECC8" >
          
          <div align="right">
            <?=$consumoTotalClaro;?>
          </div></td>
      </tr>
      <tr>
        <td bgcolor="#FBECC8" ><div align="left"><strong>Movistar</strong></div></td>
        <td bgcolor="#FBECC8" >
          
          <div align="right">
            <?=$consumoTotalMovistar;?>
          </div></td>
      </tr>
      <tr>
        <td bgcolor="#FBECC8" ><div align="left"><strong>Total</strong></div></td>
        <td bgcolor="#FBECC8" >
          
          <div align="right">
            <?=$consumoTotalTotal;?>
          </div></td>
      </tr>
</table>

<?
}
?>
</body>
</html>
<script>
function exportaexcel()
{
	<?
		$numeroaleatorio=$numerorand=rand(1,1000);
		$archivo=getcwd()."archivos/inventariobases.xls"; 
		$fp=fopen($archivo,"w");
		$tabla="<table border='1' width='720'>";
		$tabla.=$fila;
		$tabla.="</table>";
		fwrite($fp,$tabla);
		fclose($fp);
	?>
	location.href="<?=$archivo;?>";
}
</script>
