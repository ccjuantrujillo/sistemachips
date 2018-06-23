<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style></head>
<script>
function closed()
{
	window.close();
}
</script>
<body>
  <?PHP
	function __autoload($class_name) {
		require_once "../clases/".$class_name . '.php';
	}
	
	$NuevaConexion = new BaseDeDatos();
	$NuevaConexion->conectar();
	$NuevaConexion2 = new BaseDeDatos();
	$NuevaConexion2->conectar();
	?>

<form id="form1" name="form1" method="post" action="iframeredistribucion.php" target="interframe" onsubmit="javascript:closed()">
<table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="44">
		  <div align="center">
		  	  <?PHP 
		  	  $nuevocalculo 	= 	new SumaMeses($myplan[FechaRedistribucion], "1");
			  $nuevafecha 		=	$nuevocalculo->mostrar();
			  
			  $NuevaConexion->leermysql("select * from chip where Baja='1' and idPlanes='$_GET[id]'");
			  if($verificarplan = mysql_fetch_array($NuevaConexion->arraymysql()))
			  {			  
			  
			   ?>
		  	  <strong>		  	Registro de distribucion de numeros de Chips:</strong><br />
&nbsp;          </div>
		  
		  <table width="255" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
              <tr>
                <td width="143" bgcolor="#990000"><div align="center" class="Estilo1">Numero</div></td>
                <td width="112" bgcolor="#990000"><div align="center" class="Estilo1">Minutos</div></td>
              </tr>
			  
			  	  <?PHP		
				  
				  $NuevaConexion->leermysql("select * from chip where Baja='1' and idPlanes='$_GET[id]'");
				  while($mychip = mysql_fetch_array($NuevaConexion->arraymysql()))
				  {
				  ?>
				  <tr>
					<td height="29" bgcolor="#FBECC8"><?PHP echo $mychip[Numero]; ?></td>
					<td bgcolor="#FBECC8"><div align="center">
					  <input name="txt<?PHP echo $mychip[idChip]; ?>" type="text" value="<?PHP echo $mychip[Minutos]; ?>" size="8" />
				    </div></td>
				  </tr>
				  <?PHP
				  }
				  ?>
		    </table>				 
		    <div align="center"><br />
		      <input name="idplan" type="hidden" id="idplan" value="<? echo $_GET[id] ?>" />
		      <input type="submit" name="Submit" value="Grabar Cambios" />
		    </div>
		    <label></label>
					  <?PHP
			   }
				?>
                  <br /></td>
		</tr>
      </table>
</form>
</body>
</html>
