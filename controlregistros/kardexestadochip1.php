<?
if(!(empty($_GET[chip])))
{
$fecha1 = $_GET[idfecha1];
$fecha2 = $_GET[idfecha2];
//echo $fecha2."<br>";
$hora1 = $_GET[ihora].":".$_GET[iminuto];
$hora2 = $_GET[fhora].":".$_GET[fminuto];	
$chip = $_GET['chip'];
//echo $chip."<br>";
$cadena="select * from usuariochip where Chip_idChip='".$chip."' and idTipoCliente='1' order by idUsuarioChip";
//echo $cadena."<br>";
$NuevaConexion->leermysql($cadena);
$fila="";
$numerox=0;
while($row1=mysql_fetch_array($NuevaConexion->arraymysql()))
{
	$numerox=$numerox+1;
	$fechaActual=date("d/m/y H:i",time());
	$fechaInicio=$row1[FechaInicio];
	$fechaFin=($row1[FechaFin]=='' ? $fechaActual:$row1[FechaFin]);
	$base=$row1[idDatosCliente];
	$NuevoObjeto=new ConsumoBase($fechaInicio,$fechaFin,$base);
	$duracion=$NuevoObjeto->Consumo();
   $fila.="<tr height='12'>";
   $fila.="<td bgcolor='#FBECC8' width='8'><div align='center'>".$numerox."</div></td>";
   $fila.="<td bgcolor='#FBECC8'><div align='center'><span class=''>".$duracion."</span></div></td>";
   $fila.="<td bgcolor='#FBECC8'><div align='center'><span class=''>".$base."</span></div></td>";
   $fila.="<td bgcolor='#FBECC8'><div align='center'><span class=''>".$fechaInicio."</span></div></td>";
   $fila.="<td bgcolor='#FBECC8'><div align='center'><span class=''>".$fechaFin."</span></div></td>";
   $fila.="</tr>";
}
}
?>
<html>
<style type="text/css">
<!--
.Estilo2 {color: #FFFFFF}
.Estilo4 {font-size: 10px}
-->
</style>
<table width="720" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td height="12" width="8" bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>No</strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Consumo</strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Base</strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Fecha Inicio </strong></span></div></td>
    <td bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Fecha Fin </strong></span></div></td>
  </tr>
	<?=$fila;?>
  <tr>
    <td width="151" height="31" bgcolor="#FBECC8"><div align="center"><strong></strong>	</div>	</td>
    <td width="197" bgcolor="#FBECC8"><div align="center"><strong></strong>	</div>	</td>
    <td width="187" bgcolor="#FBECC8"><div align="center"> <strong></strong> </div></td>
    <td width="187" bgcolor="#FBECC8"><div align="center"> <strong></strong> </div></td>
    <td width="189" bgcolor="#FBECC8"><div align="center"><strong></strong>	</div>	</td>
  </tr>
</table>
</html>
