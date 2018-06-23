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
.Estilo2 {font-weight: bold}
-->
<?
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
	}
?>
</style></head>
<script type="text/javascript" src="resources/js/Fecha.js" ></script>
<script type="text/javascript" src="resources/js/Calendario.js" ></script>
<link rel="STYLESHEET" type="text/css" href="resources/css/calendario.css"></link>
<body>
<table width="690" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="625" height="35"><form id="form1" name="form1" method="get" action="">
      <table width="690" border="0" align="center" cellpadding="3" cellspacing="2">

        <tr>
          <td colspan="5" bgcolor="#990000"><div align="center"><span class="Estilo2 Estilo1"><strong>Consumo de Bases por dia </strong></span></div></td>
          </tr>
		<tr>
          <td width="175" bgcolor="#FBECC8"><strong>Fecha de Seguimiento: </strong></td>
          <td width="114" bgcolor="#FBECC8"><span style="display:inline;width:100;">
          <input readonly='true' type='Text' id="fecha1" name="fecha1" value="<? echo $_GET[fecha1] ?>" size="10" onFocus='fecha1Calendar.showCalendar();'>
            </span>
           <div id="fecha1CalendarContiner" style='display:none;' class='calendario' ></div>
          <script> 
		fecha1Calendar = createCalendario( "fecha1", "fecha1CalendarContiner", "resources/img/", "yyMMdd", "spanish" );
         </script>		 </td>
          <td width="91" bgcolor="#FBECC8">&nbsp;</td>
          <td width="98" bgcolor="#FBECC8"><strong>Base</strong></td>
          <td width="170" bgcolor="#FBECC8">
      <?PHP 
      if(isset($_GET['bases']))	$bases=$_GET['bases'];else $bases="";
			$NuevoCombobox5 = new ComboBox("bases","","id_base","base","Estilocaja",$bases);	
			$NuevoCombobox5->RescatarCombobox();
			?>
            <input name="oculto" type="hidden" id="oculto" value="1" /></td>
        </tr>


        <tr>
          <td bgcolor="#FBECC8">&nbsp;</td>
          <td colspan="3" bgcolor="#FBECC8"><label></label></td>
          <td bgcolor="#FBECC8">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FBECC8">&nbsp;</td>
          <td colspan="3" bgcolor="#FBECC8"><div align="center">
            <input type="button" name="Submit" value="Calcular Llamadas Realizadas" onclick="validar();">
          </div></td>
          <td bgcolor="#FBECC8">&nbsp;</td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
<p align="center">
<?php
if(isset($_GET['oculto']))	$oculto=$_GET['oculto'];else $oculto="";
if(isset($_GET['fecha1']))	$fecha1=$_GET['fecha1'];else $fecha1=""; 
if(!(empty($oculto)))
{
if(!(empty($fecha1)))
	{
		$fecha1 = $fecha1;
		$fecha2 = $fecha1;
		$hora1 = "00:00:01";
		$hora2 = "23:59:00";
		$FechaTime1 = strtotime($fecha1);
		$FechaTime2 = strtotime($fecha2);
		
		/*echo $fecha1;
		echo "<br>";
		echo $fecha2;
		echo "<br>";
		echo $hora1;
		echo "<br>";
		echo $hora2;*/
		//if($FechaTime1<$FechaTime2){
			//("090503.cdr","18:00:00","090503.cdr","18:54:00")
			include("kardexbasecontrolador.php");
		//}
		/*else
		{
			echo "La fecha Final no puede ser menor que la inicial";
		}*/
	}
	else
	{
	echo "Error, Por favor ingrese Los datos en todos los campos";
	}	
}	
?></p>
</body>
</html>
<script>
function completar(numero)
{
	var numero;
	if(numero<10)
	{
		numero=0+''+numero;
	}
	return numero;
}

function validar()
{
	if(document.form1.fecha1.value!='' && document.form1.bases.value!='n')
	{
		var fecha1="20"+document.form1.fecha1.value;
		var Fecha1=parseInt(fecha1); 
		factual=new Date();
		var anio=factual.getFullYear();
		var mes=completar(factual.getMonth()+1);
		var dia=completar(factual.getDate());
		var fecha2=anio+''+mes+''+dia;
		Fecha2=parseInt(fecha2);
		alert(Fecha2);
		if(Fecha1>Fecha2)
		{
			alert("La fecha ingresada es superior a la fecha actual");
		}
		else
		{
			document.form1.submit();
		}
	}
	else
	{
		alert('Debe ingresar una Fecha de seguimiento y Base');
	}
}
</script>
