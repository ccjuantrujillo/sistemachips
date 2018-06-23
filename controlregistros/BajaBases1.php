<?
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}
function convertir($fecha){
$arrfecha=explode("/",$fecha);
$fx=$arrfecha[2].$arrfecha[1].$arrfecha[0];
return $fx;
}
$NuevaConexion=new BaseDeDatos();
$NuevaConexion->conectar();

if(!(empty($_POST[mybase])))
{
	$mynumero 		= $_POST[mynumero];
	$mybase 		= $_POST[mybase];
	$myidusuario	= $_POST[myidusuario];

	$mychip=$NuevaConexion->recuperaRegistro("select * from usuariochip where idUsuarioChip='".$myidusuario."' order by idUsuarioChip desc",Chip_idChip);
	$myplan=$NuevaConexion->recuperaRegistro("select * from chip where idChip='".$mychip."'",idPlanes);
	$fecharedistribucion=$NuevaConexion->recuperaRegistro("select * from planes where idPlanes='".$myplan."'",FechaRedistribucion);
	$fechaactual = date("d/m/Y",time());
	if(convertir($fecharedistribucion) < convertir($fechaactual))
	{
		?>
		<script>
		alert("No se puede dar de baja al chip \n hasta que no se redistribuya");
		window.opener.location.reload();
		window.close();
		</script>
		<?
	}
	else
	{
		$BajaBase = new BajaBasesIdChip($mybase,$mychip,""); // Numero Base Numero de Chip
		$BajaBase->Baja();
		?>
		<script>
		window.opener.location.reload();
		window.close();
		</script>
		<?
	}
}

?>
