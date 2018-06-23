<?
session_start();
$login=$_SESSION['login'];
//echo $login;
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
body {
	background-color: #990000;
}
-->
</style>
</head>
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
	$mytipoplan=$NuevaConexion->recuperaRegistro("select * from planes where idPlanes='".$myplan."'",'TipoPlan');
	$fecharedistribucion=$NuevaConexion->recuperaRegistro("select * from planes where idPlanes='".$myplan."'",FechaRedistribucion);
	$fechaactual = date("d/m/Y",time());
	if($mytipoplan=='Postpago')
	{
		if(convertir($fecharedistribucion) < convertir($fechaactual))
		{
			?>
			<script>
			alert("No se puede dar de baja al chip \n hasta que no se redistribuya");
			window.opener.recargar();
			window.close();
			</script>
			<?
		}
		else
		{
			//echo "hoLA";
			$BajaBase = new BajaBasesIdChip($mybase,$mychip,""); // Numero Base Numero de Chip
			$BajaBase->Baja();
			?>
			<script>
			window.opener.location.reload();
	  		window.opener.recargar();
			window.close();
			</script>
			<?
		}
	}
	elseif($mytipoplan=='Prepago')
	{
		$BajaBase = new BajaBasesIdChip($mybase,$mychip,""); // Numero Base Numero de Chip
		$BajaBase->Baja();
		?>
		<script>
		window.opener.location.reload();
  		window.opener.recargar();
		window.close();
		</script>
		<?
	}
}

$base 		= $_GET[base];
$numero 	= $_GET[numero];
$idusuario 	= $_GET[idusuario];
?>

<body>
<form id="form1" name="form1" method="post" action="">
  <p class="Estilo1">Esta seguro que desea dar de baja la base <? echo $base ?>    Para realizar la baja debe primero dejar la
    base sin Chip  
    <input name="mynumero" type="hidden" id="mynumero" value="<? echo $numero ?>" />
    <input name="mybase" type="hidden" id="mybase" value="<? echo $base ?>" />
	<input name="myidusuario" type="hidden" id="myidusuario" value="<? echo $idusuario ?>">
  </p>
  <p>
  <label>
    <div align="center">
        <div align="center">
          <input type="submit" name="Submit" value="Estoy de Acuerdo Dar de Baja" />
              </div>
  </label>
</form>
</body>
</html>
