<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 100px;
	font-style: italic;
}
.Estilo2 {font-size: 30px}
-->
</style>
<script>
function Abrir(Url,NombreVentana,width,height,extras) {
var largo = width;
var altura = height;
var adicionales= extras;
var top = (screen.height-altura)/2;
var izquierda = (screen.width-largo)/2; nuevaVentana=window.open(''+ Url + '',''+ NombreVentana + '','Width=' + largo + ',Height=' + altura + ',Top=' + top + ',Left=' + izquierda + ',features=' + adicionales + '');
//nuevaVentana.focus();

}
</script>
</head>
<?PHP 
	function __autoload($class_name) {
		require_once "../clases/".$class_name . '.php';
	}
	
	$NuevaConexion = new BaseDeDatos();
	$NuevaConexion->conectar();
	
	//verificacion de Redistribucion de Chips Post pago

	$contador1 = 0;
	$NuevaConexion->leermysql("select idPLanes,idOperador,idProvedor,Nombre,TipoCobro,Factor,FechaRedistribucion,TipoPlan,Baja from planes where Baja='1' and TipoPlan='Postpago'");

	while($my = mysql_fetch_array($NuevaConexion->arraymysql()))
	{
		if(isset($my['FechaRedistribucion']))	$fRedistribucion=$my['FechaRedistribucion'];else $fRedistribucion="";
		$fecharedistribucion 	=	strtotime(str_replace("/", "-",$fRedistribucion));
		$fechaactual 			= 	strtotime(date("d-m-Y"));
		
		if($fecharedistribucion<$fechaactual)
			{
				$contador1++;
			}
	}
	if($contador1>0)
	{
		$pagina			= "AlertaRedistribucion.php";
		$nombreventana	= "Redistribuir";
		$width			= "370";	//ancho		
		$height			= "300";	//altura
		$adicionales	= "toolbar=no,directories=no,menubar=no,scrollbars=yes,Location=no,Status=no,Titlebar=no";
		?>
		<body onLoad="javascript:Abrir(
		'<? echo $pagina ?>',
		'<? echo $nombreventana ?>',
		'<? echo $width ?>',
		'<? echo $height ?>',
		'<? echo $adicionales ?>')">

		<?
	}
	else
	{
		echo "<body>";
	}	

?>
<div align="center">
  <p class="Estilo1"><span class="Estilo2">&nbsp;</span><br />
    Sistema de Control <br />
    de Chips  </p>
</div>

</body>
</html>
