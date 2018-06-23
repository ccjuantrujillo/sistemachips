<?
session_start();
//echo $_SESSION['login'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script>
function activar(){
	if(document.form1.provedor.value!="n" & document.form1.operador.value!="n")
	{
		window.open("iframeajustechips.php?idprovedor="+document.form1.provedor.value+"&idoperador="+document.form1.operador.value, "interframe"); 
		//alert(document.form1.provedor.value);
	}

}
function plan(){
	if(document.form1.provedor.value!="n" & document.form1.operador.value!="n" & document.form1.planes.value!="n")
	{
		window.open("iframeajustechips.php?idprovedor="+document.form1.provedor.value+"&idoperador="+document.form1.operador.value+"&idplanes="+document.form1.planes.value, "interframe"); 
		//alert(document.form1.provedor.value);
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

if(!(empty($_GET[id])))
{
	$id = $_GET[id];
	$NuevaConexion->leermysql("select * from chip where idChip = '$id'");
	$Cadena_actualizar = mysql_fetch_array($NuevaConexion->arraymysql());
	$mensajeboton = "Actualizar Registro";
	$estado = "Actualizando Ajustes Chips";
	$oculto = 1;	

}
else
{
	$mensajeboton = "Grabar Nuevo Chips";
	$estado = "Ajustar Chips";
	$oculto = 2;
}
?>

<style type="text/css">
<!--
.Estilo1 {	color: #FFFFFF;
	font-weight: bold;
}
.Estilo2 {	color: #FFFFFF;
	font-size: 13px;
}
.Estilocaja {color:#2C3174; background-color:#FBECC8; font-weight: bold;}
-->
</style>
</head>

<body>
<?PHP
if(!(empty($_POST[idplan])) && $_POST['cantidad']>0)
{
	$idenplan = $_POST[idplan];
	$NuevaConexion->leermysql("select * from chip where idPlanes = '$idenplan'");
	while($Cadena_actualizar = mysql_fetch_array($NuevaConexion->arraymysql()))
	{
		$idenChip=$Cadena_actualizar[idChip];
		$valor_caja =  $_POST["caja".$Cadena_actualizar[idChip]];
		if($valor_caja!='')
		{
			//echo "$idenChip $valor_caja"."<br>";
			$NuevaLista->actualizaRegistro('chip','MinutoActual',$valor_caja,'idChip',$Cadena_actualizar[idChip],'');		
		}
	}
}

?>
<p>&nbsp;</p>
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
              <td width="128"><span class="Estilo1">Provedor</span></td>
              <td><label>
                <?PHP
														 $NuevoCombobox1 = new ComboBoxChangue("provedor","","idProvedor","Nombres,Apellidos","Estilocaja",$_GET[idprovedor],"javascript:activar()");	
															$NuevoCombobox1->RescatarCombobox();
															?>
              </label></td>
              <td><span class="Estilo1">Operador </span></td>
              <td>
														<?PHP
													$NuevoCombobox2 = new ComboBoxChangue("operador","","idOperador","Nombre","Estilocaja",$_GET[idoperador],"javascript:activar()");	
													$NuevoCombobox2->RescatarCombobox();
													?>
													</td>
              <td width="199" rowspan="3"><div align="center">
                        <input style="display:none;" type="submit" name="Submit" value="<?PHP echo $mensajeboton ?>" />
                      </div>
                </label></td>
            </tr>
            <tr>
              <td width="128" height="25"><span class="Estilo1">Plan</span></td>
              <td><?PHP 
			$NuevoCombobox3 = new ComboBoxChangue
			("planes","idOperador=".$_GET[idoperador]." and idProvedor=".$_GET[idprovedor]." and Baja='1'","idPlanes","Nombre","Estilocaja",$_GET[idplanes],"javascript:plan()");	
			$NuevoCombobox3->RescatarCombobox();
			?>              </td>
              <td><span class="Estilo1">Chip</span></td>
              <td><span class="Estilo1"><span class="Estilo2">
                <input name="oculto" type="hidden" id="oculto" value="<?PHP echo $oculto ?>" />
                <input name="idoculto" type="hidden" id="idoculto" value="<?PHP echo $Cadena_actualizar[idChip] ?>" />
                </span></span></td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
<form id="form2" name="form2" method="post" action="">
  <table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
    <tr>
      <td width="252" height="25" bgcolor="#990000"><div align="center" class="Estilo1">Numero Chip </div></td>
      <td width="317" bgcolor="#990000"><div align="center" class="Estilo1">Saldo inicial </div></td>
      <td width="143" bgcolor="#990000"><div align="center" class="Estilo1">Saldo Actual </div></td>
    </tr>
				<?PHP
				$NuevaConexion->leermysql("select * from chip where idPlanes='$_GET[idplanes]' and baja='1' and estado='1'");
				$cantidad=0;
				while($ListadoChips = mysql_fetch_array($NuevaConexion->arraymysql()))
				{	
				$cantidad++;		
				?>
    <tr>
      <td height="26" bgcolor="#FBECC8"><div align="center"><?PHP echo $ListadoChips[Numero] ?></div></td>
      <td bgcolor="#FBECC8"><div align="center"><?PHP echo $ListadoChips[Minutos] ?></div></td>
      <td bgcolor="#FBECC8"><div align="center">
        <input name="caja<?PHP echo $ListadoChips[idChip] ?>" type="text" id="caja" value="<?PHP echo $ListadoChips[MinutoActual] ?>" size="8" />
      </div></td>
    </tr>
    <?PHP
				}
				?>
	<tr>
      <td colspan="3" bgcolor="#990000">&nbsp;</td>
    </tr>
  </table>
  <input name="idplan" type="hidden" id="idplan" value="<?PHP echo $_GET[idplanes] ?>" />
  <input name="cantidad" type="hidden" id="cantidad" value="<?=$cantidad;?>">
  <div align="center"><br />  
    <input type="submit" name="Submit2" value="Actualizar Datos" />
  </div>
  <label></label>
</form>
</body>
</html>
