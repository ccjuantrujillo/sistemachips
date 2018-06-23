
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
          <td colspan="5" bgcolor="#990000"><div align="center"><span class="Estilo2 Estilo1"><strong>Historial  de Chips </strong></span></div></td>
          </tr>
		<tr>
		  <td bgcolor="#FBECC8"><strong>N&uacute;mero : </strong></td>
		  <td bgcolor="#FBECC8">
		  <?PHP 
			  //echo "Condicion".$condicion."<br>";
			  function __autoload($class_name) {
			    require_once "../clases/".$class_name . '.php';
			  }
			  $NuevaConexion = new BaseDeDatos();
			  $NuevaConexion->conectar();
			  $NuevoCombobox1 = new ComboBoxChangue("chip","baja='1' group by Numero","idChip","Numero","Estilocaja",$_GET[chip],"");	
			  $NuevoCombobox1->RescatarCombobox();
		  ?>
			  </td>
		  <td bgcolor="#FBECC8">&nbsp;</td>
		  <td bgcolor="#FBECC8">&nbsp;</td>
		  <td bgcolor="#FBECC8">&nbsp;</td>
		  </tr>
		<tr>
          <td width="144" bgcolor="#FBECC8"><strong>Fecha de inicio: </strong></td>
          <td width="145" bgcolor="#FBECC8"><span style="display:inline;width:100;">
          <input readonly='true' type='Text' id="idfecha1" name="idfecha1" value="<? echo $_GET[idfecha1] ?>" size="10" onFocus='idfecha1Calendar.showCalendar();'>
            </span>
           <div id="idfecha1CalendarContiner" style='display:none;' class='calendario' ></div>
          <script> 
		idfecha1Calendar = createCalendario( "idfecha1", "idfecha1CalendarContiner", "resources/img/", "yyMMdd", "spanish" );
         </script>		 </td>
          <td width="24" bgcolor="#FBECC8">&nbsp;</td>
          <td width="165" bgcolor="#FBECC8"><strong>Fecha de Fin: </strong></td>
          <td width="168" bgcolor="#FBECC8">
		  <span style="display:inline;width:100;">
          <input readonly='true' type='Text' id="idfecha2" name="idfecha2" value="<? echo $_GET[idfecha2] ?>" size="10" onFocus='idfecha2Calendar.showCalendar();'>
            </span>
           <div id="idfecha2CalendarContiner" style='display:none;' class='calendario' ></div>
          <script> 
		idfecha2Calendar = createCalendario( "idfecha2", "idfecha2CalendarContiner", "resources/img/", "yyMMdd", "spanish" );
         </script>		</td>
        </tr>
        <tr>
          <td bgcolor="#FBECC8"><strong>Hora de inicio: </strong></td>
          <td bgcolor="#FBECC8">
          <select name="ihora" id="ihora">
		  <option value="<? echo $_GET[ihora] ?>"  selected="selected"><? echo $_GET[ihora] ?></option>
		  <option value="00">00</option>
            <option value="01">01</option>
            <option value="02">02</option>
			<option value="03">03</option>
			<option value="04">04</option>
			<option value="05">05</option>
			<option value="06">06</option>
			<option value="07">07</option>
			<option value="08">08</option>
			<option value="09">09</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
            </select>
           :
           <select name="iminuto" id="iminuto">
		   <option value=<? echo $_GET[iminuto] ?>  selected="selected"><? echo $_GET[iminuto] ?></option>
             <option value="00">00</option>
             <option value="01">01</option>
			 <option value="02">02</option>
			 <option value="03">03</option>
			 <option value="04">04</option>
			 <option value="05">05</option>
			 <option value="06">06</option>
			 <option value="07">07</option>
			 <option value="08">08</option>
			 <option value="09">09</option>
			 <option value="10">10</option>
			 <option value="11">11</option>
			 <option value="12">12</option>
			 <option value="13">13</option>
			 <option value="14">14</option>
			 <option value="15">15</option>
			 <option value="16">16</option>
			 <option value="17">17</option>
			 <option value="18">18</option>
			 <option value="19">19</option>
			 <option value="20">20</option>
			 <option value="21">21</option>
			 <option value="22">22</option>
			 <option value="23">23</option>
			 <option value="24">24</option>
			 <option value="25">25</option>
			 <option value="26">26</option>
			 <option value="27">27</option>
			 <option value="28">28</option>
			 <option value="29">29</option>
			 <option value="30">30</option>
			 <option value="31">31</option>
			 <option value="32">32</option>
			 <option value="33">33</option>
			 <option value="34">34</option>
			 <option value="35">35</option>
			 <option value="36">36</option>
			 <option value="37">37</option>
			 <option value="38">38</option>
			 <option value="39">39</option>
			 <option value="40">40</option>
			 <option value="41">41</option>
			 <option value="42">42</option>
			 <option value="43">43</option>
			 <option value="44">44</option>
			 <option value="45">45</option>
			 <option value="46">46</option>
			 <option value="47">47</option>
			 <option value="48">48</option>
			 <option value="49">49</option>
			 <option value="50">50</option>
			 <option value="51">51</option>
			 <option value="52">52</option>
			 <option value="53">53</option>
			 <option value="54">54</option>
			 <option value="55">55</option>
			 <option value="56">56</option>
			 <option value="57">57</option>
			 <option value="58">58</option>
			 <option value="59">59</option>
              </select>          </td>
          <td bgcolor="#FBECC8">&nbsp;</td>
          <td bgcolor="#FBECC8"><strong>Hora de Fin: </strong></td>
          <td bgcolor="#FBECC8"><select name="fhora" id="fhora">
            <option value=<? echo $_GET[fhora] ?>  selected="selected"><? echo $_GET[fhora] ?></option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
          </select>
            :
            <select name="fminuto" id="fminuto">
			<option value=<? echo $_GET[fminuto] ?>  selected="selected"><? echo $_GET[fminuto] ?></option>
              <option value="00">00</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
              <option value="32">32</option>
              <option value="33">33</option>
              <option value="34">34</option>
              <option value="35">35</option>
              <option value="36">36</option>
              <option value="37">37</option>
              <option value="38">38</option>
              <option value="39">39</option>
              <option value="40">40</option>
              <option value="41">41</option>
              <option value="42">42</option>
              <option value="43">43</option>
              <option value="44">44</option>
              <option value="45">45</option>
              <option value="46">46</option>
              <option value="47">47</option>
              <option value="48">48</option>
              <option value="49">49</option>
              <option value="50">50</option>
              <option value="51">51</option>
              <option value="52">52</option>
              <option value="53">53</option>
              <option value="54">54</option>
              <option value="55">55</option>
              <option value="56">56</option>
              <option value="57">57</option>
              <option value="58">58</option>
              <option value="59">59</option>
            </select>
            <input name="oculto" type="hidden" id="oculto" value="valor" /></td>
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
//echo "oculto".$_GET[oculto]."<br>";
//if(!(empty($_GET[oculto])))
//{
if(!(empty($_GET[chip])) and !(empty($_GET[idfecha1])) and !(empty($_GET[idfecha2])) and !(empty($_GET[ihora])) and !(empty($_GET[fhora])))
	{
		$fecha1 = $_GET[idfecha1];
		$fecha2 = $_GET[idfecha2];
		$hora1 = $_GET[ihora].":".$_GET[iminuto].":00";
		$hora2 = $_GET[fhora].":".$_GET[fminuto].":00";
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
			include("kardexestadochip.php");
		//}
		/*else
		{
			echo "La fecha Final no puede ser menor que la inicial";
		}*/
	}
	else
//}	
?></p>
</body>
</html>
<script>
function validar()
{
	if(document.form1.idfecha1.value!='' && document.form1.idfecha2.value!='' && document.form1.chip.value!='n')
	{
		var fecha1="20"+document.form1.idfecha1.value;
		var fecha2="20"+document.form1.idfecha2.value;
		var ihora=document.form1.ihora.value;
		var iminuto=document.form1.iminuto.value;
		var fhora=document.form1.fhora.value;
		var fminuto=document.form1.fminuto.value;
		var Fecha1=parseInt(fecha1); 
		var Fecha2=parseInt(fecha2); 
		if(Fecha1<=Fecha2)
		{
			cadena=ihora+''+iminuto+''+fhora+''+fminuto;
			if(cadena.length=='8')
			{
				document.form1.submit();
			}
			else
			{
				alert('Debe ingresar las horas de inicio y fin');
			}
		}
		else
		{
			alert('La Fecha de fin no puede se menor que la Fecha de inicio');
			document.form1.idfecha2.value='';
		}
	}
	else
	{
		alert("Debe ingresar un numero de chip, \n una Fecha de inicio y Fecha de fin");
	}
}
</script>