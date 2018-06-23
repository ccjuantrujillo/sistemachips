<?
session_start();
//echo $_SESSION['login'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" src="resources/js/Fecha.js" ></script>
<script type="text/javascript" src="resources/js/Calendario.js" ></script>
<link rel="STYLESHEET" type="text/css" href="resources/css/calendario.css"></link>

<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilocaja{color:#2C3174; background-color:#FBECC8; font-weight: bold;}
a:link {
	color: #000000;
	text-decoration: none;
}
.Estilocaja2{color:#2C3174; background-color:#CCCCCC; font-weight: bold;}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
	color: #000000;
}
a:active {
	text-decoration: none;
	color: #000000;
}
-->
</style>
</head>
<SCRIPT LANGUAGE="JavaScript"> 
function activar() {
if (document.form1.Tcobro.value=="Soles")
	{
		document.form1.Factor.disabled=false;
	}
else
	{
		document.form1.Factor.disabled="enabled";
	}	
}

</script>
<?PHP 
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}

$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();
$NuevaLista = new BaseDeDatos();
$NuevaLista->conectar();
?>

<script language="JavaScript"> 
function alerta(){
		alert('Para registrar datos no puede dejar ningun campo en blanco ');
}
</script>

<p>&nbsp;</p>
<?PHP
//editar planes
if(($_POST[oculto]==1) and !(empty($_POST[idoculto])) and !(empty($_POST[nombres])))
{	
	if(($_POST[operador]<>"n") and ($_POST[provedor]<>"n") and ($_POST[Tcobro]<>"n") and ($_POST[tipoplan]<>"n"))
	{
		echo "<body>";
		
		$operador 				= $_POST[operador];
		$provedor 				= $_POST[provedor];
		$nombre 				= $_POST[nombres];
		$tipocobro 				= $_POST[Tcobro];
		$factor 				= $_POST[Factor];
		$fecharedistribucion 	= $_POST[fecha1];
		
		//$NuevaConexion->leermysql("UPDATE planes SET idOperador='$operador', idProvedor='$provedor', Nombre='$nombre', tipocobro='$tipocobro',Factor='$factor', FechaRedistribucion='$fecharedistribucion' where idPlanes = '$_POST[idoculto]'");
		$NuevaConexion->actualizaRegistro('planes','idOperador,idProvedor,Nombre,tipocobro,Factor,FechaRedistribucion',"$operador,$provedor,$nombre,$tipocobro,$factor,$fecharedistribucion",'idPlanes',"$_POST[idoculto]",'');
		$oculto = 2;
	}
	else
	{
		echo '<body  onload="alerta()">';
	}
	
	
}
elseif(($_POST[oculto]==2) and !(empty($_POST[nombres])))
{
	if(($_POST[operador]<>"n") and ($_POST[provedor]<>"n") and ($_POST[Tcobro]<>"n") and ($_POST[tipoplan]<>"n"))
	{
		if(($_POST[Tcobro]=="Soles"))
		{
		if(!(empty($_POST[Factor])))
			{
				
				echo "<body>";
				$operador 				= $_POST[operador];
				$provedor 				= $_POST[provedor];
				$nombre 				= $_POST[nombres];
				$tipocobro 				= $_POST[Tcobro];
				$factor 				= $_POST[Factor];
				$fecharedistribucion 	= $_POST[fecha1];
				$tipoplan				= $_POST[tipoplan];
				
				$sql = "INSERT INTO planes(idOperador,idProvedor,Nombre,TipoCobro,Factor,FechaRedistribucion,TipoPlan,Baja) VALUES ("; 
				$sql .= "'".$operador."'";
				$sql .= ",'".$provedor."'";
				$sql .= ",'".$nombre."'";
				$sql .= ",'".$tipocobro."'";
				$sql .= ",'".$factor."'";
				$sql .= ",'".$fecharedistribucion."'";
				$sql .= ",'".$tipoplan."'";
				$sql .= ",'1'";
				$sql .= ")";   
				$NuevaConexion->leermysql($sql); 		
			}
		else
			{
				echo '<body  onload="alerta()">';
			}
		}
		elseif(($_POST[Tcobro]<>"Soles"))
		{
			echo "<body>";
			
			$operador 				= $_POST[operador];
			$provedor 				= $_POST[provedor];
			$nombre 				= $_POST[nombres];
			$tipocobro 				= $_POST[Tcobro];
			$fecharedistribucion 	= $_POST[fecha1];
			$tipoplan				= $_POST[tipoplan];
			
			$sql = "INSERT INTO planes(idOperador,idProvedor,Nombre,TipoCobro,Factor,FechaRedistribucion,TipoPlan,Baja) VALUES ("; 
			$sql .= "'".$operador."'";
			$sql .= ",'".$provedor."'";
			$sql .= ",'".$nombre."'";
			$sql .= ",'".$tipocobro."'";
			$sql .= ",''";
			$sql .= ",'".$fecharedistribucion."'";
			$sql .= ",'".$tipoplan."'";
			$sql .= ",'1'";
			$sql .= ")";   
			$NuevaConexion->leermysql($sql);
		}

	}
	else
	{
		echo '<body  onload="alerta()">';
	}
	
}
elseif(($_POST[oculto]==3) and !(empty($_POST[idoculto])))
{
	echo "<body>";
	$nChips=$NuevaConexion->RecuperaRegistro("select count(*) from chip where idPlanes='".$_POST['idoculto']."' and baja='1' and (estado='1' or estado='2')",0);
	if($nChips=='0')
	{
		$NuevaConexion->eliminaregistro('planes','idPlanes',"$_POST[idoculto]",'','');
	}
	else
	{
		$txt2="<script>alert('No se pueden borrar, existen ".$nChips." chips');location.href='iframeplanes.php'</script>";
		echo $txt2;
	}
	$oculto = 2;
}
else
{
	if($_POST[oculto]==2)
	{
		echo '<body  onload="alerta()">';

	}
}

if(!(empty($_GET[id])))
{
	$id = $_GET[id];
	$NuevaConexion->leermysql("select * from planes where idPlanes = '$id'");
	$Cadena_actualizar = mysql_fetch_array($NuevaConexion->arraymysql());
	$mensajeboton = "Actualizar Registro";
	$estado = "Actualizando Registros  de Planes";
	$oculto = 1;
}
else
{
	$mensajeboton = "Grabar Nuevo Plan";
	$estado = "Registrando Nuevos Planes";
	$oculto = 2;
}

?>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td bgcolor="#990000"><span class="Estilo1">&nbsp;&nbsp;<? echo $estado ?></span></td>
  </tr>
  <tr>
    <td><table width="720" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="718" bgcolor="#990000">
		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <table width="709" border="0" align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td width="124" height="16"><span class="Estilo1">Operador</span></td>
                <td colspan="3"><label>
			<?PHP $NuevoCombobox1 = new ComboBox("operador","","idOperador","Nombre","Estilocaja",$Cadena_actualizar[idOperador]);	
						$NuevoCombobox1->RescatarCombobox();
				?>
				</label></td>				
                <td width="199" rowspan="6"><label>
                    <div align="center">
                      <input type="submit" name="Submit" value="<?PHP echo $mensajeboton ?>">
                    </div>
                  </label></td>
              </tr>
              <tr>
                <td height="17"><span class="Estilo1">Provedor</span></td>
                <td>
		   <?PHP $NuevoCombobox2 = new ComboBox("provedor","","idProvedor","Nombres,Apellidos","Estilocaja","$Cadena_actualizar[idProvedor]");								
		   		$NuevoCombobox2->RescatarCombobox();
					?>				</td>
                <td><span class="Estilo1">Tipo</span></td>
                <td><label>
                  <select name="tipoplan" id="tipoplan" class="Estilocaja" onchange="validafecha();">
                    <option value="n">:: Seleecionar ::</option>
                    <option value="Postpago">Postpago</option>
                    <option value="Prepago">Prepago</option>
					<?PHP 
					if(!(empty($Cadena_actualizar[TipoPlan]))) 
					{
					echo '<option value="'.$Cadena_actualizar[TipoPlan].'" selected="selected">'.$Cadena_actualizar[TipoPlan].'</option>';
					}

					?>
                  </select>
                </label></td>
              </tr>
              <tr>
                <td height="36"><span class="Estilo1">Nombre</span></td>
                <td colspan="3"><input name="nombres" type="text" class="Estilocaja" id="nombres" value="<?PHP echo $Cadena_actualizar[Nombre] ?>" size="45" /></td>
              </tr>
              <tr>
                <td height="33"><span class="Estilo1">Tipo De Cobro </span></td>
                <td width="143"><label>
                  <select onchange="javascript:activar()" name="Tcobro" class="Estilocaja" id="Tcobro" >
                    <option value="n"> :: Seleccionar :: </option>
                    <option value="Minutos">Minutos</option>
                    <option value="Soles">Soles</option>
					<?PHP 
					if(!(empty($Cadena_actualizar[TipoCobro]))) 
					{
					echo '<option value="'.$Cadena_actualizar[TipoCobro].'" selected="selected">'.$Cadena_actualizar[TipoCobro].'</option>';
					}

					?>
                  </select>
                </label></td>
                <td width="46"><span class="Estilo1">Factor</span></td>
                <td width="149"><input name="Factor" type="text" class="Estilocaja" id="Factor" value="<?PHP echo $Cadena_actualizar[Factor] ?>" size="15"  /></td>
              </tr>
              <tr>
                <td height="36" colspan="3"><span class="Estilo1">Fecha de Redistribucion Mensual de Chips </span></td>
                <td><span style="display:inline;width:100;">
                  <input readonly='true' type='Text' id="idfecha1" name="fecha1" value="<? echo $Cadena_actualizar[FechaRedistribucion	] ?>" size="15" onfocus="muestrafecha();"  class="Estilocaja">
                </span>
                  <div id="idfecha1CalendarContiner" style='display:none;' class='calendario' ></div>
                  <input name="oculto" type="hidden" id="oculto" value="<?PHP echo $oculto ?>" />
                  <input name="idoculto" type="hidden" id="idoculto" value="<?PHP echo $Cadena_actualizar[idPlanes] ?>" /></td>
              </tr>
            </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>


<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form2" id="form2" method="post">
<tr height="30" valign="middle">
	<td width="52" height="36"><div align="left"><span style="font-weight: bold">Plan : </span></div></td>
	<td width="595">
		<?PHP 
		$NuevoCombobox = new ComboBox("planes","Baja='1' order by Nombre","idPlanes","Nombre","Estilocaja",'');	
		$NuevoCombobox->RescatarCombobox();
		?>
		<input type="button" name="boton" value="Eliminar Total" onclick="eliminaplan();">
	</td>
	<td width="73" align="right">
	<?
	$cadena="select * from planes where Baja ='1' order by idProvedor,Nombre";
	$tabla=new ListaDatos($cadena,'xls','');
	$tabla->recuperaLista();
	?>	
	</td>
</tr>
</form>
</table>
<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="134" bgcolor="#990000"><div align="center" class="Estilo1">Nombre</div></td>
    <td width="77" bgcolor="#990000"><div align="center"><span class="Estilo1">Operador</span></div></td>
    <td width="88" bgcolor="#990000"><div align="center" class="Estilo1">Tipo Cobro </div></td>
    <td width="65" bgcolor="#990000"><div align="center"><span class="Estilo1">Factor</span></div></td>
    <td width="76" bgcolor="#990000"><div align="center"><span class="Estilo1">Fecha </span></div></td>
    <td width="112" bgcolor="#990000"><div align="center"><span class="Estilo1">Proveedor</span></div></td>
    <td width="74" bgcolor="#990000"><div align="center" class="Estilo1">Tipo</div></td>
    <td width="76" bgcolor="#990000"><div align="center" class="Estilo1">Eliminar</div></td>
  </tr><?PHP
$cadena2="select * from planes where Baja ='1' order by idOperador,Nombre";
$NuevaLista->leermysql($cadena2);
while($lista = mysql_fetch_array($NuevaLista->arraymysql()))
{
$tabla=new Chips($lista[idPlanes],'text');
?>
  <tr>
    <td height="24" bgcolor="#FBECC8" title="<?=$tabla->recuperaChips();?>">
	<a href="iframeplanes.php?id=<? echo $lista[idPlanes];?>">
		<? echo $lista[Nombre]; ?><img src="imagenes/b_edit.png" alt="Editar" width="16" height="16" border="0" />	</a>	</td>
    <td bgcolor="#FBECC8"><div align="center">
      <? 
	$NuevaConexion->leermysql("select * from operador where idOperador = '$lista[idOperador]'"); 
	$arrayprovedor = mysql_fetch_array($NuevaConexion->arraymysql());
	echo $arrayprovedor[Nombre]; 
	?>
    </div></td>
    <td bgcolor="#FBECC8">
    <div align="center"><? echo $lista[TipoCobro]; ?></div>    </td>
    <td bgcolor="#FBECC8"><div align="center"><? echo $lista[Factor]; ?></div>    </td>
    <td bgcolor="#FBECC8"><div align="center">
	<? 
	if($lista[TipoPlan]=="Postpago")
	echo $lista[FechaRedistribucion];
	?>
	</div>    </td>
    <td bgcolor="#FBECC8">
	  <div align="left">
	    <? 
	$NuevaConexion->leermysql("select concat(Nombres,' ',Apellidos) from provedor where idProvedor = '$lista[idProvedor]'"); 
	$arrayprovedor = mysql_fetch_array($NuevaConexion->arraymysql());
	echo $arrayprovedor[0]; 
	?>	
    </div></td>
    <td bgcolor="#FBECC8">
	  <div align="center"><? echo $lista[TipoPlan]; ?></div></td>
    <td bgcolor="#FBECC8">
	<div align="center">
		<a href="javascript:mensaje(<? echo $lista[idPlanes];?>);"><img src="imagenes/borrar.gif" width="16" height="16" border='0'></a>	</div>	</td>
  </tr>

<?PHP
}
  ?>
  <tr>
    <td colspan="8" bgcolor="#990000">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script>
function mensaje(id)
{
  if(confirm("Esta seguro que desea borrar"))
  {
    document.form1.oculto.value='3';
    document.form1.idoculto.value=id;    
    document.form1.submit();
  }
}

function muestrafecha()
{
var tipoplan2=document.form1.tipoplan.value;
if(tipoplan2=='Postpago')
{
	idfecha1Calendar = createCalendario( "idfecha1", "idfecha1CalendarContiner", "resources/img/", "dd/MM/yyyy", "spanish" );
	idfecha1Calendar.showCalendar();
}
}
function validafecha()
{
	document.form1.fecha1.value='';
}
function Abrir(Url,NombreVentana,width,height,extras) {
var largo = width;
var altura = height;
var adicionales= extras;
var top = (screen.height-altura)/2;
var izquierda = (screen.width-largo)/2; 
var nuevaVentana=window.open(''+ Url + '',''+ NombreVentana + '','width=' + largo + ',height=' + altura + ',top=' + top + ',left=' + izquierda + ',features=' + adicionales + '');
nuevaVentana.focus();
}
function eliminaplan()
{
	
	var planes =document.form2.planes.value;
	if(planes!='n')
	{
		Abrir('eliminaplan.php?planes='+planes,'','450','200','scrollbars=no')
	}
}
function recargar()
{
	location.href="iframeplanes.php";
}
</script>