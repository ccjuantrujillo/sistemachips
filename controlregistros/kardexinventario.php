<?
if($_GET[operador]<>'n')
{
	//Si proveedor es vacio, mostramos los resultados para todos los proveedores
	if($_GET[provedor]=='n')
	{
		$sql1="
			select 
			planes.idProvedor,
			concat(provedor.Nombres,' ',provedor.Apellidos)
			from planes 
			inner join provedor on planes.idProvedor=provedor.idProvedor
			where idOperador='".$_GET[operador]."' 
			group by planes.idProvedor
			";	
			//echo $sql1."<br>";
			$NuevaConexion->leermysql($sql1);
			$numProvedor=0;
			while($row1=mysql_fetch_array($NuevaConexion->arraymysql()))
			{
				$arridProvedor[]=$row1[0];
				$arrProvedor[]=$row1[1];
				$numProvedor=$numProvedor+1;
			}
	}
	else
	{
		$arridProvedor[0]=$_GET['provedor'];
		$arrProvedor[0]=$NuevaConexion->recuperaRegistro("select concat(Nombres,' ',Apellidos) from provedor where idProvedor='".$arridProvedor[0]."'",'0');
		$numProvedor=1;
	}

///////Mostramos los planes para cada proveedor.////////////////////////////
//echo "$arridProvedor[0]   $arrProvedor[0]";
$fechaActual=date("d/m/Y",time());
$horaActual=date("H:i:s",time());
$tabla="";
$tabla.="<table width='750' border='0' align='center' cellpadding='0' cellspacing='0'>";
$tabla.="<tr>";
$tabla.="<td height='25'><div align='right'><strong>Lima ".$fechaActual."</strong></div></td>";
$tabla.="</tr>";
$tabla.="<tr>";
$tabla.="<td height='25'><div align='right'><strong>
".$horaActual."</strong></div></td>";
$tabla.="</tr>";
$tabla.="</table>";
	
for($j=0;$j<$numProvedor;$j++){
$idProvedor=$arridProvedor[$j];
$sql="
	select 
	idPlanes,
	Nombre,
	idProvedor 
	from planes 
	where idProvedor='".$idProvedor."' 
	and idOperador='".$_GET[operador]."'
	and Baja='1'
	";
//echo $sql."<br>";
//Recuperamos los planes	
$numeroPlanes=0;
$NuevaConexion->leermysql($sql);
while($rowNueva1=mysql_fetch_array($NuevaConexion->arraymysql()))
{
	$arridPlanes[$numeroPlanes]=$rowNueva1[idPlanes];
	$arrNombre[$numeroPlanes]=$rowNueva1[Nombre];
	$numeroPlanes++;
}
//echo "provedor".$arrProvedor[0];
//echo "Numero Planes: $arridPlanes[0]  $arrNombre[0] $arridPlanes[1] $arrNombre[0] $numeroPlanes<br>";

if($numeroPlanes<>0)
{
	$tabla.="<table width='750' border='0' align='center' cellpadding='0' cellspacing='0'>";
	$tabla.="<tr>";
	$nombreProveedor=strtoupper($arrProvedor[$j]);
	$tabla.="<td height='25'><div align='center'><strong>".$nombreProveedor."</strong></div></td>";
	$tabla.="</tr>";
	$tabla.="</table>";
}

for($i=0;$i<$numeroPlanes;$i++){
//$idplan=$NuevaConexion->recuperaRegistro($sql,'idPlanes');
$idplan=$arridPlanes[$i];
$nombrePlan=$arrNombre[$i];

$tabla.="<p align='center'>";
$tabla.="<table width='750' border='0' align='center' cellpadding='0' cellspacing='0'>";
$tabla.="<tr>";
$tabla.="<td height='25'><div align='left'><strong>".$nombrePlan."</strong></div></td>";
$tabla.="</tr>";
$tabla.="</table>";
$tabla.="<table width='750' border='1' align='center' cellpadding='0' cellspacing='0'>";
$tabla.="<tr>";
$tabla.="<td width='28' bgcolor='#990000'><div align='center'><span class='Estilo2'><strong>No</strong></span></div></td>";
$tabla.="<td width='134' height='25' bgcolor='#990000'><div align='center'><span class='Estilo2'><strong>Numero</strong></span></div></td>";
$tabla.="<td width='113' bgcolor='#990000'><div align='center'><span class='Estilo2'><strong>Minutos Iniciales</strong></span></div></td>";
//$tabla.="<td width='113' bgcolor='#990000'><div align='center'><span class='Estilo2'><strong>Cant. Inicial</strong></span></div></td>";
//$tabla.="<td bgcolor='#990000'><div align='center'><span class='Estilo2'><strong>Consumo</strong></span></div></td>";
$tabla.="<td bgcolor='#990000'><div align='center'><span class='Estilo2'><strong>Consumo</strong></span></div></td>";
$tabla.="<td bgcolor='#990000'><div align='center'><span class='Estilo2'><strong>Saldo Actual </strong></span></div></td>";
$tabla.="<td bgcolor='#990000'><div align='center'><span class='Estilo2'><strong>Ubicacion</strong></span></div></td>";
$tabla.="<td bgcolor='#990000'><div align='center'><span class='Estilo2'><strong>Observacion</strong></span></div></td>";
$tabla.="</tr>";

$sql1="select * from chip where idPlanes='".$idplan."' and baja='1' order by Numero";
//echo $sql1."<br>";
$consumoTotalTotal=0;
$Tminutos=0;
$TminutosIniciales=0;
$Tduracion=0;
$Tsaldo=0;
$n=0;
$NuevaConexion->leermysql($sql1);
while($row1=mysql_fetch_array($NuevaConexion->arraymysql()))
{
	$numero=$row1[Numero];
	$minutosIniciales=$row1[Minutos];
	$minutos=$row1[MinutoActual];
	$idChip=$row1[idChip];
	$observacion=$row1[Atributo2];
	$sql3="
			select 
			idDatosCliente,
			idTipoCliente,
			FechaInicio,
			FechaFin,
			Estado 
			from usuariochip 
			where Chip_idChip='".$idChip."' 
			and Baja='1' 
			order by idUsuarioChip desc limit 1";
	//
//echo $sql3."<br>";die();
	$tipocliente=$NuevaConexion2->recuperaRegistro($sql3,'idTipoCliente');
	$fechainicio=$NuevaConexion2->recuperaRegistro($sql3,'FechaInicio');
	$fechafin=$NuevaConexion2->recuperaRegistro($sql3,'FechaFin');
	$fechaactual=date("d/m/y H:i",time());
	//echo "Fecha Final".$fechafin."<br>";die();
	//echo $fechaactual."<br>";
if($tipocliente=='1')
{
	$Base[$base]=0;	
	if($fechafin=='')						
	{
	//El chip se encuentra en las bases
		$fechafin=$fechaactual;
		$base=$NuevaConexion2->recuperaRegistro($sql3,'idDatosCliente');
		$ubicacion=$NuevaConexion2->recuperaRegistro("select * from bases where id_base='".$base."'",'base');
		$NuevoObjeto=new ConsumoBase($fechainicio,$fechafin,$base);
		$duracion=$NuevoObjeto->Consumo();
	}
	else
	{
	//El chip se encuentra fuera de las bases
		$fechafin=$fechafin;
		$ubicacion="Libre";
		$duracion=0;
	}
}
elseif($tipocliente=='2')
{
	//El chip se encuentra con un cliente
	$idusuario=$NuevaConexion2->recuperaRegistro($sql3,'idDatosCliente');
	$duracion=0;
	$ubicacion="Con cliente";
}
elseif($tipocliente=='')
{
	//El chip no se encuentra registrado en la tabla usuariochip
	$duracion=0;
	$ubicacion='Libre';
}
//echo "$base $fechainicio $fechafin $duracion $saldoactual<br>";

$saldoactual=$minutos-$duracion;
$Tminutos=$Tminutos+$minutos;
$Tduracion=$Tduracion+$duracion;
$Tsaldo=$Tsaldo+$saldoactual;
$TminutosIniciales=$TminutosIniciales+$minutosIniciales;
$n=$n+1;
$consumoTotal=$duracion+$minutosIniciales-$minutos;
$consumoTotalTotal=$consumoTotalTotal+$consumoTotal;
$tabla.="<tr>";
$tabla.="<td width='28' bgcolor='#FBECC8'><div align='center'>".$n."</div></td>";
$tabla.="<td width='134' height='31' bgcolor='#FBECC8'><div align='center'>".$numero."</div></td>";
$tabla.="<td width='113' bgcolor='#FBECC8'><div align='center'>".$minutosIniciales."</div></td>";
//$tabla.="<td width='113' bgcolor='#FBECC8'><div align='center'>".$minutos."</div></td>";
//$tabla.="<td width='110' bgcolor='#FBECC8'><div align='center'>".$duracion."</div></td>";
$tabla.="<td width='110' bgcolor='#FBECC8'><div align='center'>".$consumoTotal."</div></td>";
$tabla.="<td width='104' bgcolor='#FBECC8'><div align='center'>".$saldoactual."</div></td>";
$tabla.="<td width='111' bgcolor='#FBECC8'><div align='center'>".$ubicacion."</div></td>";
$tabla.="<td width='120' bgcolor='#FBECC8'><div align='center'>".$observacion."</div></td>";
$tabla.="</tr>";

}

$tabla.="</table>";
$tabla.="<table width='750' border='1' align='center' cellpadding='0' cellspacing='0'>";
$tabla.="<tr>";
$tabla.="<td width='28' bgcolor='#990000'><div align='center'>&nbsp;</div></td>";
$tabla.="<td width='134' bgcolor='#990000'><div align='right' class='Estilo2'><strong>TOTAL</strong></div></td>";
$tabla.="<td width='113' bgcolor='#990000'><div align='center' class='Estilo2'><strong>".$TminutosIniciales."</strong></div></td>";
//$tabla.="<td width='113' bgcolor='#990000'><div align='center' class='Estilo2'><strong>".$Tminutos."</strong></div></td>";
//$tabla.="<td width='110' bgcolor='#990000'><div align='center' class='Estilo2'><strong>".$Tduracion."</strong></div></td>";
$tabla.="<td width='110' bgcolor='#990000'><div align='center' class='Estilo2'><strong>".$consumoTotalTotal."</strong></div></td>";
$tabla.="<td width='104' bgcolor='#990000'><div align='center' class='Estilo2'><strong>".$Tsaldo."</strong></div></td>";
$tabla.="<td width='111' bgcolor='#990000'><div align='right' class='Estilo2'><strong></strong></div></td>";
$tabla.="<td width='120' bgcolor='#990000'><div align='center' class='Estilo2'><strong></strong></div></td>";
$tabla.="</tr>";
$tabla.="</table>";
//$tabla.="<p align='center'>";
}
$tabla.="<p>&nbsp;</p>";
}
}
?>
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
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
<tr height="30" valign="middle">
	<td align="right"><input type='button' value='Exportar Excel' name='boton' onclick='exportaexcel()'></td>
</tr>
</table>

<?=$tabla;?>
</body>
</html>
<script>
function exportaexcel()
{
	<?
		$numeroaleatorio=$numerorand=rand(1,1000);
		$archivo="archivos/excel".$numeroaleatorio.".xls"; 
		$fp=fopen($archivo,"w");
		fwrite($fp,$tabla);
		fclose($fp);
	?>
	location.href="<?=$archivo;?>";
}
</script>
