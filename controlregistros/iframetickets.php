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
</head>

<?PHP 
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}

$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();
$NuevaLista = new BaseDeDatos();
$NuevaLista->conectar();
$idoculto=$_REQUEST['idoculto'];
$accion=$_REQUEST['accion'];
$modo=$_REQUEST['modo'];
$estado=$_POST['estado'];
$numero=$_POST['numero'];
$fecha=$_POST['fecha'];
$comentario=$_POST['comentario'];
$monto=$_POST['monto'];
//echo "Id usuariochip: ".$idoculto;
if($modo=='grabar')
{
	if($accion=="update")
	{
		//Cancelo el ticket
		$NuevaConexion->actualizaRegistro('ticketpago','Estado,FechaPago,Monto,NumOperacion,Comentario',"$estado,$fecha,$monto,$numero,$comentario",'idUsuarioChip',$idoculto,'');
		//Cambia el estado a pagado en la tabla generadortickets
		$NuevaConexion->leermysql("select Chip_idChip from usuariochip where idUsuarioChip='".$idoculto."'");
		$row3=mysql_fetch_array($NuevaConexion->arraymysql());
		$NuevaConexion->actualizaRegistro('generadortickets','Estado',"1",'Chip_idChip',$row3[0],'');

		//$modo="";
		$modo="";
		$monto="";
		$actividad="";
		$comentario="";
		$estado="";
		$numero="";
		$fecha="";
		$nombres="";
		$modo="";
		$idoculto="";
	}
}
else
{
	if($accion=='update')
	{
		$NuevaConexion->leermysql("select * from ticketpago where idUsuarioChip='".$idoculto."'");
		$row1=mysql_fetch_array($NuevaConexion->arraymysql());	
		$monto=$row1['Monto'];
		$actividad=$row1['actividad'];
		$comentario=$row1['Comentario'];
		$estado=$row1['Estado'];
		$numero=$row1['NumOperacion'];
		$fecha=$row1['FechaPago'];
		$NuevaLista->leermysql("select idDatosCliente from usuariochip where idUsuarioChip='".$row1['idUsuarioChip']."'");
		$rowLista1=mysql_fetch_array($NuevaLista->arraymysql());
		$idDatosCliente=$rowLista1['0'];
		$NuevaLista->leermysql("select concat(Nombre,' ',Apellido) from datoscliente where idDatosCliente='".$idDatosCliente."'");
		$rowLista2=mysql_fetch_array($NuevaLista->arraymysql());
		$nombres=$rowLista2['0'];
		$atributo=($estado=='1' ? "readonly='readonly'":'');
	}
}
//echo "Idoculto:$idoculto   Accion:$accion Modo:$modo";
?>
<body>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td bgcolor="#990000"><span class="Estilo1"> &nbsp;Cancelacion de tickets de Pago</span></td>
  </tr>
  <tr>
    <td><table width="720" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="720" bgcolor="#990000">
		<table width="720" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="720" bgcolor="#990000">
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="3">
        <tr>
          <td><span class="Estilo1">Nombres</span></td>
          <td><span style="display:inline;width:100;">
            <?PHP
				 $NuevoCombobox1 = new InputBox("nombres",$nombres,"Estilocaja","","","readonly='readonly'");	
				 $NuevoCombobox1 ->RescatarInputbox();
			  ?>
          </span></td>
          <td class="Estilo1">Fecha</td>
          <td><span style="display:inline;width:100;">
            <?PHP
				 $NuevoCombobox1 = new InputBox("fecha",$fecha,"Estilocaja","onFocus","fecha1Calendar.showCalendar();","readonly='true'");	
				 $NuevoCombobox1 ->RescatarInputbox();
			  ?>
              <div id="fecha1CalendarContiner" style='display:none;' class='calendario' ></div>
			  <script>fecha1Calendar=createCalendario( "fecha", "fecha1CalendarContiner", "resources/img/", "dd/MM/yy", "spanish" );</script>
          </span></td>
        </tr>
        <tr>
          <td width="13%"><span class="Estilo1">N.Operacion</span></td>
          <td width="37%"><span style="display:inline;width:100;">
            <?PHP
				 $NuevoCombobox1 = new InputBox("numero",$numero,"Estilocaja","","",$atributo);	
				 $NuevoCombobox1 ->RescatarInputbox();
			  ?>
          </span></td>
          <td width="13%" class="Estilo1">Monto</td>
          <td width="37%"><span style="display:inline;width:100;">
            <div id="fecha1CalendarContiner" style='display:none;' class='calendario' ></div>
            <?PHP
				 $NuevoCombobox1 = new InputBox("monto",$monto,"Estilocaja","","","readonly='readonly'");	
				 $NuevoCombobox1 ->RescatarInputbox();
			  ?>
          </span></td>
          </tr>
        <tr>
          <td valign="top"><span class="Estilo1">Comentario</span></td>
          <td valign="top"><label></label>            <label>
            <textarea name="comentario" id="comentario" class="Estilocaja" <?=$atributo;?>><?=$comentario;?></textarea>
            </label></td>
          <td colspan="2" class="Estilo1" align="center"><label>
            <input type="button" name="Submit" value="Cancelar Ticket" onclick="cancelar();" <?=($estado=='1' ? "disabled='disabled'":'');?>>
            <input name="estado" type="hidden" id="estado" value='1'>
            <input name="accion" type="hidden" id="accion" value='1' />
            <input name="modo" type="hidden" id="modo" value='1' />
          </label></td>
          </tr>
      </table>
    </form></td>
  </tr>
</table>
		
		</td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
<tr height="30" valign="middle">
	<td align="right">
	<?
	$tabla="ticketpago";
	$where=" where estado='0'";
	$campos="idUsuarioChip,FechaPago,Estado,Monto,actividad,NumOperacion,Comentario,idTicketPago";
	$arraycampos=explode(",",$campos);
	$valor0=$arraycampos[0];
	$valor1=$arraycampos[1];
	$valor2=$arraycampos[2];
	$valor3=$arraycampos[3];
	$valor4=$arraycampos[4];
	$valor5=$arraycampos[5];
	$valor7=$arraycampos[7];
	$cadena="select $campos from $tabla $where order by estado asc,FechaPago";
	$cantidad=count($arraycampos);
	$tabla=new ListaDatos($cadena,'xls','');
	$tabla->recuperaLista();
	?>
	</td>
</tr>
</table>

<?
function muestraCampos($tabla,$campo,$columna,$valor)
{
	$NuevaLista = new BaseDeDatos();
	$NuevaLista->conectar();
	$cad="select $campo from $tabla where $columna='".$valor."'";
	//echo $cad."<br>";
	$NuevaLista->leermysql($cad);
	$row2=mysql_fetch_array($NuevaLista->arraymysql());
	return $row2['0'];
}
?>
<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="339" bgcolor="#990000"><div align="center" class="Estilo1">
      Apellidos y Nombres
    </div></td>
    <td width="100" bgcolor="#990000"><div align="center" class="Estilo1">Fecha Pago</div></td>
    <td width="97" bgcolor="#990000"><div align="center" class="Estilo1">Estado</div></td>
    <td width="107" bgcolor="#990000"><div align="center" class="Estilo1">Monto</div></td>
    <td width="65" bgcolor="#990000"><div align="center" class="Estilo1">Pagar</div></td>
  </tr>


<?
$NuevaConexion->leermysql($cadena);
while($row1=mysql_fetch_array($NuevaConexion->arraymysql()))
{
$idusuariochip=$row1[$valor0];
$NuevaLista->leermysql("select idDatosCliente from usuariochip where idUsuarioChip='".$idusuariochip."'");
$rowLista1=mysql_fetch_array($NuevaLista->arraymysql());
$idDatosCliente=$rowLista1['0'];
$NuevaLista->leermysql("select concat(Nombre,' ',Apellido) from datoscliente where idDatosCliente='".$idDatosCliente."'");
$rowLista2=mysql_fetch_array($NuevaLista->arraymysql());
$nombres=$rowLista2['0'];

$columna0=muestraCampos('datoscliente',"concat(Nombre,' ',Apellido)",'idDatosCliente',$row1[$valor0]);
//$columna2=muestraCampos('datoscliente','Nombre','idDatosCliente',$row1[$valor2]);
//$columna3=muestraCampos('datoscliente','Nombre','idDatosCliente',$row1[$valor3]);
//$columna4=muestraCampos('datoscliente','Nombre','idDatosCliente',$row1[$valor4]);
//$columna5=muestraCampos('datoscliente','Nombre','idDatosCliente',$row1[$valor5]);
?>
  <tr>
    <td bgcolor="#FBECC8">&nbsp;<a href="iframetickets.php?idoculto=<? echo $row1[$valor0];?>&accion=update"><? echo $nombres;?><img src="imagenes/b_edit.png" alt="Editar" width="16" height="16" border="0" /></a></td>
    <td align="center" bgcolor="#FBECC8"><? echo $row1[$valor1];?></td>
    <td align="center" bgcolor="#FBECC8"><?=($row1[$valor2]==0 ? 'Pendiente':'Pagado');?></td>
    <td align="center" bgcolor="#FBECC8"><? echo $row1[$valor3];?></td>
    <td bgcolor="#FBECC8"><div align="center"> <a href="iframetickets.php?idoculto=<? echo $row1[$valor0];?>&accion=update"><img src="imagenes/celular.gif" width="20" height="20" border='0' /></a> </div></td>
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
function mensaje(id)
{
  if(confirm("Esta seguro que desea borrar"))
  {
  	var url="iframealquiler.php?idoculto="+id+"&accion=delete&modo=grabar";
    location.href=url;
  }
}
function cancelar()
{
	if(document.form1.fecha.value!='' && document.form1.numero.value!='')
	{
		if(confirm('¿Los datos estan ingresador correctamente?'))
		{
			document.form1.accion.value='update';
			document.form1.modo.value='grabar'
			document.form1.submit();
		}
	}
	else
	{
		alert("Debe ingresar una fecha de pago \n y un numero de operacion");
	}
}
</script>
