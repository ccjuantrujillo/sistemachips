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
<link rel="STYLESHEET" type="text/css" href="resources/css/estilo.css"></link>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style></head>

<?PHP 
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}

$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();
$NuevaLista = new BaseDeDatos();
$NuevaLista->conectar();
?>
<body>
<?
$idoculto=$_REQUEST['idoculto'];
$accion=$_REQUEST['accion'];
$modo=$_REQUEST['modo'];
//echo "Modo:$modo Accion:$accion Idoculto:$idoculto";
?>
<?
$datoscliente=$_POST['datoscliente'];
$provedor=$_POST['provedor'];
$operador=$_POST['operador'];
$planes=$_POST['planes'];
$chip=$_POST['chip'];
$fecha1=$_POST['fecha1'];
$monto=$_POST['monto'];
$fecha1x=$_POST['fecha1']." ".date("H:i");
if($modo=='grabar')
{
	if($accion=='new')
	{

		$NuevaConexion->leermysql("select max(idUsuarioChip) from usuariochip");
		$row2Conexion=mysql_fetch_array($NuevaConexion->arraymysql());
		$id_usuariochip=$row2Conexion['0']+1;
		//echo "IdUsuario".$id_usuariochip."<br>";
		////////////////////
		$NuevaConexion->insertaRegistro("usuariochip","idTipoCliente,idDatosCliente,Chip_idChip,FechaInicio,Estado,Baja,FechaFin","2,$datoscliente,$chip,$fecha1x,2,1,","");
		$NuevaConexion->actualizaRegistro('chip','estado',2,'idChip',$chip,'');
		$NuevaConexion->insertaRegistro("ticketpago","idUsuarioChip,Monto,Estado","$id_usuariochip,$monto,0",'');
		$NuevaConexion->insertaRegistro("generadortickets","Chip_idChip,Monto,Fecha,Estado,Baja","$chip,$monto,$fecha1x,0,0","");
		$datoscliente="";
		$provedor="";
		$operador="";
		$planes="";
		$chip="";
		$fecha1="";
		$modo='n';
		$monto='';
	}
	elseif($accion=='update')
	{
		//No aplica
		//$NuevaConexion->actualizaRegistro('usuariochip','idTipoCliente,idDatosCliente,Chip_idChip,FechaInicio,Estado,Baja',"2,$datoscliente,$chip,$fecha1,2,1",'idUsuarioChip',"$idoculto",'');
	}
	elseif($accion=='delete')
	{
		$NuevaConexion->actualizaRegistro('usuariochip','Baja,Estado',"0,1",'idUsuarioChip',$idoculto,'');
		$NuevaConexion->leermysql("select * from usuariochip where idUsuarioChip='".$idoculto."'");
		$row2=mysql_fetch_array($NuevaConexion->arraymysql());
		$NuevaConexion->actualizaRegistro('chip','estado','1','idChip',$row2[Chip_idChip],'');
		//Se da de baja en generador de tickets.
		$NuevaConexion->actualizaRegistro('generadortickets','Baja',"1",'Chip_idChip',$row2[Chip_idChip],'');
		
	}
}
elseif($modo=='n')
{
		$datoscliente=$_POST['datoscliente'];
		$provedor=$_POST['provedor'];
		$operador=$_POST['operador'];
		$planes=$_POST['planes'];
		$chip=$_POST['chip'];
		$fecha1=$_POST['fecha1'];
		$monto=$_POST['monto'];
}
else
{
		$datoscliente=$_POST['datoscliente'];
		$provedor=$_POST['provedor'];
		$operador=$_POST['operador'];
		$planes=$_POST['planes'];
		$chip=$_POST['chip'];
		$fecha1=$_POST['fecha1'];
		$monto=$_POST['monto'];
		if($accion=='update')
		{
			$NuevaConexion->leermysql("select * from usuariochip where idUsuarioChip='".$idoculto."'");
			$row1=mysql_fetch_array($NuevaConexion->arraymysql());
			$datoscliente=$row1['idDatosCliente'];
			$tipocliente=$row1['idTipoCliente'];
			$chip=$row1['Chip_idChip'];
			$fecha1=$row1['FechaInicio'];
			$NuevaConexion->leermysql("select * from chip where idChip='".$chip."'");
			$row2=mysql_fetch_array($NuevaConexion->arraymysql());
			$planes=$row2['idPlanes'];
			$NuevaConexion->leermysql("select * from planes where idPlanes='".$planes."'");
			$row3=mysql_fetch_array($NuevaConexion->arraymysql());
			$provedor=$row3['idProvedor'];
			$operador=$row3['idOperador'];	
			$NuevaConexion->leermysql("select * from generadortickets where Chip_idChip='".$chip."'");
			$row4=mysql_fetch_array($NuevaConexion->arraymysql());
			$monto=$row4['Monto'];
			$modo='n';
		}

}

//echo "Idoculto:$idoculto   Accion:$accion Modo:$modo";
?>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td bgcolor="#990000"><span class="Estilo1">&nbsp;&nbsp;Alquiler de Chips</span></td>
  </tr>
  <tr>
    <td><table width="720" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="720" bgcolor="#990000">
		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table width="100%" border="0" align="center" cellpadding="2" cellspacing="3">
            <tr>
              <td width="12%"><span class="Estilo1">Cliente</span></td>
              <td width="39%">
			  <?PHP 
			  $NuevoCombobox1 = new ComboBoxChangue("datoscliente","","idDatosCliente","Nombre,Apellido","Estilocaja",$datoscliente,"");	
			  $NuevoCombobox1->RescatarCombobox();
			  ?>
			  </td>
              <td width="12%" class="Estilo1">Fecha</td>
              <td width="37%"><span style="display:inline;width:100;">
                <?PHP
				 $NuevoCombobox1 = new InputBox("fecha1",$fecha1,"Estilocaja","onFocus","fecha1Calendar.showCalendar();","readonly='true'");	
				 $NuevoCombobox1 ->RescatarInputbox();
			  ?>
                <div id="fecha1CalendarContiner" style='display:none;' class='calendario'></div>
              </span></td>
              </tr>
            <tr>
              <td><span class="Estilo1">Proveedor</span></td>
              <td><?PHP 
			  $NuevoCombobox1 = new ComboBoxChangue("provedor","","idProvedor","Nombres,Apellidos","Estilocaja",$provedor,"javascript:validaProvedor()");	
			  $NuevoCombobox1->RescatarCombobox();
			  ?></td>
              <td class="Estilo1">Operador</td>
              <td><?PHP 
			  $NuevoCombobox1 = new ComboBoxChangue("operador","","idOperador","Nombre","Estilocaja",$operador,"javascript:validaOperador()");	
			  $NuevoCombobox1->RescatarCombobox();
			  ?></td>
              </tr>
            <tr>
              <td class="Estilo1">Plan</td>
              <td><?PHP 
			  $NuevoCombobox1 = new ComboBoxChangue("planes","idProvedor='".$provedor."' and idOperador='".$operador."'","idPlanes","Nombre","Estilocaja",$planes,"javascript:validaOperador()");	
			  $NuevoCombobox1->RescatarCombobox();
			  ?></td>
              <td class="Estilo1">Chip</td>
              <td><?PHP 
			  //Muestra los chips libres y activos
			  if($accion=='update')
			  {
			  	$condicion="idPlanes='".$planes."' and idChip='".$chip."'";
			  }
			  else
			  {
			  	$condicion="idPlanes='".$planes."' and baja='1' and estado='1'";
			  }
			  //echo $condicion."<br>";
			  //echo "Condicion".$condicion."<br>";
			  $NuevoCombobox1 = new ComboBoxChangue("chip",$condicion,"idChip","Numero","Estilocaja",$chip,"");	
			  $NuevoCombobox1->RescatarCombobox();
			  ?></td>
            </tr>
            <tr>
              <td height="23" class="Estilo1">Monto</td>
              <td><span style="display:inline;width:100;">
                <?PHP
				 $NuevoCombobox1 = new InputBox("monto",$monto,"Estilocaja","","","");	
				 $NuevoCombobox1 ->RescatarInputbox();
				?>
              </span>
			  </td>
              <td colspan="2" class="Estilo1">
			  <div align="center">
			    <label>
				<?
				if($accion!='update')
				{
				?>
			    <input type="button" name="Submit" value="Grabar" onclick="validaformulario();">
			    <?
				}
				?>
				</label>
			    <input name="modo" type="hidden" id="modo" />
			    <input name="accion" type="hidden" id="accion" />
			  </div></td>
              </tr>
          </table>
          </form>
		  </td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
<tr height="30" valign="middle">
	<td align="right">
	<?
	  $cadena="
  		   select
		   a.idUsuarioChip as idUsuarioChip,
		   concat(b.Nombre,' ',b.Apellido) as Nombres,
		   a.FechaInicio as FechaInicio,
		   a.Chip_idChip as Chip_idChip,
		   a.estado as estado
		   from usuariochip as a
		   inner join datoscliente as b on a.idDatosCliente=b.idDatosCliente
		   inner join chip as c on a.Chip_idChip=c.idChip
		   where a.Baja='1'
		   and a.idTipoCliente='2'
		   and c.baja='1'
		   order by Nombres
  		  ";
		  //echo $cadena;
	$tabla=new ListaDatos($cadena,'xls','');
	$tabla->recuperaLista();
	?>
	</td>
</tr>
</table>


<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="279" height="23" bgcolor="#990000"><div align="center" class="Estilo1">Cliente</div></td>
    <td width="107" bgcolor="#990000"><div align="center" class="Estilo1">Fecha</div></td>
    <td width="150" bgcolor="#990000"><div align="center" class="Estilo1">Plan</div></td>
    <td width="107" bgcolor="#990000"><div align="center" class="Estilo1">Chip</div></td>
    <td width="65" bgcolor="#990000"><div align="center" class="Estilo1">Eliminar</div></td>
  </tr>
<?PHP
//echo $cadena;
$NuevaConexion->leermysql($cadena);
while($lista = mysql_fetch_array($NuevaConexion->arraymysql()))
{
$cadena2="
		select 
		* 
		from chip 
		left join planes on chip.idPlanes=planes.idPlanes
		where idChip='".$lista['Chip_idChip']."'
		";
$NuevaLista->leermysql($cadena2);
$listado = mysql_fetch_array($NuevaLista->arraymysql());
$arrayfecha=explode(" ",$lista['FechaInicio']);
?>
  <tr>
    <td bgcolor="#FBECC8">&nbsp;<a href="iframealquiler.php?idoculto=<? echo $lista[idUsuarioChip];?>&accion=update"><? echo $lista[Nombres]; ?><img src="imagenes/b_edit.png" alt="Editar" width="16" height="16" border="0" /></a></td>
    <td bgcolor="#FBECC8" align="center"><? echo $arrayfecha[0]; ?></td>
    <td align="left" bgcolor="#FBECC8"><? echo $listado[Nombre];?></td>
    <td align="center" bgcolor="#FBECC8"><? echo $listado[Numero]; ?></td>
    <td bgcolor="#FBECC8"><div align="center"> <a href="javascript:mensaje(<? echo $lista[idUsuarioChip];?>);"><img src="imagenes/borrar.gif" width="16" height="16" border='0' /></a> </div></td>
  </tr>
<?PHP
}
?>
  <tr>
    <td colspan="5" bgcolor="#990000">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script language="JavaScript"> 
function activar(){
	if(document.form1.provedor.value!="n" & document.form1.operador.value!="n")
	{
		window.open("iframealquiler.php?idcliente="+document.form1.datoscliente.value+"&idprovedor="+document.form1.provedor.value+"&idoperador="+document.form1.operador.value+"&fecha1="+document.form1.fecha1.value, "interframe"); 
		//alert(document.form1.datoscliente.value);		
	}

}
function plan(){
	if(document.form1.provedor.value!="n" & document.form1.operador.value!="n" & document.form1.planes.value!="n")
	{
		window.open("iframealquiler.php?idcliente="+document.form1.datoscliente.value+"&idprovedor="+document.form1.provedor.value+"&idoperador="+document.form1.operador.value+"&idplanes="+document.form1.planes.value+"&fecha1="+document.form1.fecha1.value, "interframe"); 
		//alert(document.form1.provedor.value);
	}

}
function Abrir(Url,NombreVentana,width,height,extras) {
var largo = width;
var altura = height;
var adicionales= extras;
var top = (screen.height-altura)/2;
var izquierda = (screen.width-largo)/2; nuevaVentana=window.open(''+ Url + '',''+ NombreVentana + '','width=' + largo + ',height=' + altura + ',top=' + top + ',left=' + izquierda + ',features=' + adicionales + '');
nuevaVentana.focus();
}

function alerta()
{
	alert('Debe ingresar todos los campos');
}
function enviar()
{
	document.form1.submit();
}
function validaProvedor()
{
	if(document.form1.provedor.value!='n' && document.form1.operador.value!='n')
	{
		enviar();
	}
}
function validaOperador()
{
	if(document.form1.provedor.value!='n' && document.form1.operador.value!='n')
	{
		enviar();
	}
}
function validadatoscliente()
{
	enviar();
}
fecha1Calendar = createCalendario( "fecha1", "fecha1CalendarContiner", "resources/img/", "dd/MM/yy", "spanish" );
function mensaje(id)
{
  if(confirm("Esta seguro que desea borrar"))
  {
  	var url="iframealquiler.php?idoculto="+id+"&accion=delete&modo=grabar";
    location.href=url;
  }
}
function validaformulario()
{
	var modo="<?=$modo;?>";
	var accion="<?=$accion;?>";
	//if(accion!='new')
//	{
//	document.form1.modo.value='grabar';
//	document.form1.accion.value='new';/
//	document.form1.submit();
//	}
	if(document.form1.datoscliente.value!='n' && document.form1.provedor.value!='n' && document.form1.operador.value!='n' && document.form1.planes.value!='n' && document.form1.chip.value!='n' && document.form1.monto.value!='')
	{
		document.form1.modo.value='grabar';
		document.form1.accion.value='new';
		document.form1.submit();
	}
	else
	{
		alert("Para enviar el formulario debe ingresar \ntodos los campos");
	}
}
</script>
