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
.Estilo2 {
	color: #FFFFFF;
	font-size: 13px;
}
.Estilo3 {
	color: #990000;
	font-weight: bold;
}
.Estilo4 {color: #000033}
.Estilo6 {color: #003366}
-->
</style>

</head>
<script language="JavaScript"> 
function activar(){
	if(document.form1.provedor.value!="n" & document.form1.operador.value!="n")
	{
		window.open("iframebases1.php?idprovedor="+document.form1.provedor.value+"&idoperador="+document.form1.operador.value, "interframe"); 
		//alert(document.form1.provedor.value);
	}

}
function plan(){
	if(document.form1.provedor.value!="n" & document.form1.operador.value!="n" & document.form1.planes.value!="n")
	{
		window.open("iframebases1.php?idprovedor="+document.form1.provedor.value+"&idoperador="+document.form1.operador.value+"&idplanes="+document.form1.planes.value, "interframe"); 
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
<p>&nbsp;</p>
<?PHP
if(($_POST[oculto]==2) and  !(empty($_POST[fecha1])) and  !(empty($_POST[fhora])) and  ($_POST[fminuto]!='') and  ($_POST[meridiano]!=''))
{	
	if(($_POST[planes]<>"n") and ($_POST[provedor]<>"n") and ($_POST[operador]<>"n") and ($_POST[chip]<>"n") and ($_POST[bases]<>"n") and ($_POST[fhora]<>"") and ($_POST[fminuto]<>"") and ($_POST[meridiano]<>""))
	{		
			$provedor	= $_POST[provedor];
			$planes		= $_POST[planes];
			$operador	= $_POST[operador];
			$chip		= $_POST[chip];
			$bases		= $_POST[bases];
			$fecha1		= $_POST[fecha1];
			$fhora		= $_POST[fhora];
			$fminuto	= $_POST[fminuto];	
			$meridiano  = $_POST[meridiano];	
			if($meridiano==1)	$fhora=$fhora;
			if($meridiano==2)	$fhora=$fhora+12;
			$fecha_actual = $fecha1." ".$fhora.":".$fminuto; 		
			//echo $fecha_actual;	
			//Colocamos el factor de soles
			
			
			$sql = "INSERT INTO usuariochip(idTipoCliente,idDatosCliente,Chip_idChip,FechaInicio,FechaFin,Estado,Baja) VALUES ("; 
			$sql .= "'1'";
			$sql .= ",'".$bases."'";			
			$sql .= ",'".$chip."'";			
			$sql .= ",'".$fecha_actual."'";
			$sql .= ",''";			
			$sql .= ",'1'";
			$sql .= ",'1'";
			$sql .= ")";   
			$NuevaConexion->leermysql($sql); 	
			$NuevaConexion->leermysql("UPDATE bases SET estado='1' where id_base = '$bases'");	
			$NuevaConexion->leermysql("UPDATE chip SET estado='0' where idChip = '$chip'");
	}
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
	$NuevaConexion->leermysql("select * from chip where idChip = '$id'");
	$Cadena_actualizar = mysql_fetch_array($NuevaConexion->arraymysql());
	$mensajeboton = "Actualizar Registro";
	$estado = "Actualizando Registros  de chips";
	$oculto = 1;	

}
else
{
	$mensajeboton = "Grabar Nuevo Chips";
	$estado = "Registrando Nuevos Chips";
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
        <td width="718" bgcolor="#990000"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <table width="709" border="0" align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td width="128"><span class="Estilo1">Provedor</span></td>
                <td><label>
			<?PHP $NuevoCombobox1 = new ComboBoxChangue("provedor","","idProvedor","Nombres,Apellidos","Estilocaja",$_GET[idprovedor],"javascript:activar()");	
						$NuevoCombobox1->RescatarCombobox();
				?>
				</label></td>				
                <td><span class="Estilo1">Operador </span></td>
                <td><?PHP $NuevoCombobox2 = new ComboBoxChangue("operador","","idOperador","Nombre","Estilocaja",$_GET[idoperador],"javascript:activar()");	
						$NuevoCombobox2->RescatarCombobox();
				?></td>
                <td width="140" rowspan="5" valign="bottom"><label>
                    <div align="center">
                      <input type="submit" name="Submit" value="<?PHP echo $mensajeboton ?>">
                    </div>
                  </label></td>
              </tr>
              
            <tr>
            <td width="128"><span class="Estilo1">Plan</span></td>
            <td colspan="3"><?PHP 
			$NuevoCombobox3 = new ComboBoxChangue
			("planes","idOperador=".$_GET[idoperador]." and idProvedor=".$_GET[idprovedor]." and Baja='1'","idPlanes","Nombre","Estilocaja",$_GET[idplanes],"javascript:plan()");	
			$NuevoCombobox3->RescatarCombobox();
			?>			</td>
            </tr>
              
              <tr>
                <td height="28"><span class="Estilo1">Chip</span></td>
                <td><?PHP 
			$NuevoCombobox4 = new ComboBox
			("chip","idPlanes=".$_GET[idplanes]." and estado='1' and baja='1'","idChip","Numero","Estilocaja",$_GET[idChip]);	
			$NuevoCombobox4->RescatarCombobox();
			?></td>
                <td class="Estilo1">Fecha </td>
                <td><span class="Estilo2">
                  <span style="display:inline;width:100;">
          <input name="fecha1" type='Text' class="Estilocaja" id="idfecha1" onFocus='idfecha1Calendar.showCalendar();' value="<? echo $_GET[fecha1] ?>" size="16" readonly='true'>
            </span>
           <div id="idfecha1CalendarContiner" style='display:none;' class='calendario' ></div>
          <script> 
		idfecha1Calendar = createCalendario( "idfecha1", "idfecha1CalendarContiner", "resources/img/", "dd/MM/yy", "spanish" );
         </script>		
                </span></td>
              </tr>
              <tr>
                <td><span class="Estilo1">Base</span></td>
                <td width="118"><label>
                  <?PHP 
			$NuevoCombobox5 = new ComboBox
			("bases","estado=0","id_base","base","Estilocaja","");	
			$NuevoCombobox5->RescatarCombobox();
			?>
                </label></td>
                <td width="68" class="Estilo1">Hora<span class="Estilo2">
                  <input name="oculto" type="hidden" id="oculto" value="<?PHP echo $oculto ?>" />
                  <input name="idoculto" type="hidden" id="idoculto" value="<?PHP echo $Cadena_actualizar[idChip] ?>" />
                </span></td>
                <td width="160" class="Estilo2"><select name="fhora" class="Estilocaja" id="fhora">
                    <option value="<? echo $_GET[fhora] ?>"  selected="selected"><? echo $_GET[fhora] ?></option>
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
                  </select>
:
<select name="fminuto" class="Estilocaja" id="fminuto">
  <option value="<? echo $_GET[fminuto] ?>"  selected="selected"><? echo $_GET[fminuto] ?></option>
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
&nbsp;
<select name="meridiano" class="Estilocaja" id="select">
  <option value="<? echo $_GET['meridiano'] ?>"  selected="selected"><? echo $_GET['meridiano'] ?></option>
  <option value="1">a.m.</option>
  <option value="2">p.m.</option>
</select>

</td>
              </tr>
            </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
 <br />
<table width="720" border="2" cellpadding="0"  align="center" cellspacing="0" bordercolor="#990000">
<?PHP
	$NuevaConexion->leermysql("select * from bases"); 
	
	
		for($i=0;$i<3;$i++)
		{	?>	
		<tr>
		<? for($j=0;$j<8;$j++)
		{
		$arrayprovedor = mysql_fetch_array($NuevaConexion->arraymysql());
		
		$imagen = new ImagenBase($arrayprovedor[estado],$arrayprovedor[id_base]);
		?>
    	<td bgcolor="#FFFFFF"><div align="center">
		<a href="
		javascript:Abrir('ShowBases.php?
		base=<? echo $arrayprovedor[id_base] ?>&
		numero=<? echo $imagen->numero() ?>','bases','300','200','scrollbars=NO,Status=NO') ">
		<? 
		echo '<img src="'.$imagen->imagen().'" width="65" height="80" border="0" />';
		?>
		</a><br />
		<span class="Estilo3">
		<?
		echo $arrayprovedor[base];
		?>
		<?
		if($imagen->numero()=="")
		{
		}
		else
		{
		?>
		<a href="javascript:Abrir('BajaBases.php?
		base=<? echo $arrayprovedor[id_base] ?>&
		numero=<? echo $imagen->numero() ?>&
		idusuario=<? echo $imagen->idusuario() ?> ','bases','250','150','scrollbars=NO,Status=NO')">
		<img src="imagenes/borrar.gif" alt="Borrar" width="16" height="16" border="0" /></a>
		<?
		}
		?>
		</span><br />
		<strong>
		<span class="Estilo4">
		<span class="Estilo6">
		<?
		echo $imagen->numero(); 
		?>
		</span></span></strong>		
		<br />
    	</div></td>
  		<?
		}	?>
		</tr>
		<? 
		}
		?>
</table>
<p>&nbsp;</p>
</body>
</html>
<script language="JavaScript"> 
function alerta(){
	alert('Para registrar datos no puede dejar ningun campo en blanco ');
}
function error(){
	alert('Lo Sentimos no puede dar de baja este chip por estar en uso ');		
}
function alertaregistrado(){
	alert('El numero que intenta registrar ya esta en uso ');		
}
</script>