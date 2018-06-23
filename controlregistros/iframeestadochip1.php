<?
session_start();
?>
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
.Estilo1 {color: #FFFFFF}
-->
</style></head>
<script type="text/javascript" src="resources/js/Fecha.js" ></script>
<script type="text/javascript" src="resources/js/Calendario.js" ></script>
<link rel="STYLESHEET" type="text/css" href="resources/css/calendario.css"></link>
<body>
<table width="690" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="625" height="35">
	<form id="form1" name="form1" method="get" action="">
      <table width="690" border="0" align="center" cellpadding="3" cellspacing="2">

        <tr>
          <td colspan="5" bgcolor="#990000"><div align="center"><span class="Estilo2 Estilo1"><strong>Historial  de Chips</strong></span></div></td>
          </tr>
		<tr>
		  <td bgcolor="#FBECC8"><strong>Operador : </strong></td>
		  <td bgcolor="#FBECC8">
		  	<?PHP 
			  $NuevoCombobox1 = new ComboBoxChangue("operador","","idOperador","Nombre","Estilocaja",$_GET[operador],'document.form1.submit();');	
			  $NuevoCombobox1->RescatarCombobox();
			?>
			</td>
		  <td bgcolor="#FBECC8">&nbsp;</td>
		  <td bgcolor="#FBECC8">&nbsp;</td>
		  <td bgcolor="#FBECC8">&nbsp;</td>
		  </tr>
		<tr>
		  <td width="144" bgcolor="#FBECC8"><strong>N&uacute;mero : </strong></td>
		  <td width="145" bgcolor="#FBECC8">
		  <?PHP 
			  //echo "Condicion".$condicion."<br>";
			  function __autoload($class_name) {
			    require_once "../clases/".$class_name . '.php';
			  }
			  $NuevaConexion = new BaseDeDatos();
			  $NuevaConexion->conectar();
			$cadena="
						select 
						b.idChip as chip,
						b.Numero as numero
						from usuariochip as a
						inner join chip as b on a.Chip_idChip=b.idChip
						inner join planes as c on b.idPlanes=c.idPlanes
						where a.Baja='1' 
						and b.baja='1'
						and a.idTipoCliente='1'
						and c.idOperador='".$_GET['operador']."'
						group by a.Chip_idChip
						";
			//echo $cadena;
			$combo="<option value='n'>::Seleccione::</option>";
			$NuevaConexion->leermysql($cadena);
			while($row2=mysql_fetch_array($NuevaConexion->arraymysql()))
			{
				$numero=$row2[numero];
				$chip=$row2[chip];
				$selected=($chip==$_GET['chip'] ? 'selected':'');
				$combo.="<option value='".$chip."' ".$selected.">".$numero."</option>";
			}
		  ?>			  
			<select name="chip" id="chip" class="EstiloCaja">
				<?=$combo;?>
			</select>			</td>
		  <td width="24" bgcolor="#FBECC8"><input type="hidden" name="accion" id="accion" value=""></td>
		  <td width="165" bgcolor="#FBECC8">&nbsp;</td>
		  <td width="168" bgcolor="#FBECC8">&nbsp;</td>
		  </tr>
        <tr>
          <td bgcolor="#FBECC8">&nbsp;</td>
          <td colspan="3" bgcolor="#FBECC8"><label>
            <div align="center">
              <input type="button" name="Submit" value="Visualizar resultado" onclick="validar();">
              </div>
          </label></td>
          <td bgcolor="#FBECC8">&nbsp;</td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table>
<p align="center">
<? 
if(!(empty($_GET[chip])) and $_GET['accion']=='mostrar')
{
		$fecha1 = $_GET[idfecha1];
		$fecha2 = $_GET[idfecha2];
		$hora1 = $_GET[ihora].":".$_GET[iminuto].":00";
		$hora2 = $_GET[fhora].":".$_GET[fminuto].":00";
		$FechaTime1 = strtotime($fecha1);
		$FechaTime2 = strtotime($fecha2);
		include("kardexestadochip1.php");
}
//}	
?>
</p>
</body>
</html>
<script>
function validar()
{
	if(document.form1.chip.value!='n' && document.form1.operador.value!='n')
	{
		document.form1.accion.value="mostrar";
		document.form1.submit();
	}
	else
	{
		alert("Debe seleccionar un operar, \n y un numero de telefono");
	}
}
</script>
