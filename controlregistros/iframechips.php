<?
session_start();
$login=$_SESSION['login'];
//echo $login;
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
.Estilo2 {
	color: #FFFFFF;
	font-size: 13px;
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
<p><?PHP
//editar planes
//echo $_POST[minsol];
if(($_POST[oculto]==1)  and !(empty($_POST[numero])) and ($_POST[minsol]!='') and  !(empty($_POST[minicodigo])))
{	
	if(($_POST[planes]<>"n"))
		{		
		$planes				= $_POST[planes];
		$numero 			= $_POST[numero];
		$minsol				= $_POST[minsol];
		$minicodigo 		= $_POST[minicodigo];
		$atributo1			= $_POST[atributo1];
		$atributo2			= $_POST[atributo2];
		//echo "2 $atributo2";
		$calcularminutos 	= $_POST[calcularminutos];

		$NuevaConexion->leermysql("select * from planes where idPlanes='$planes'"); 
		$factores = mysql_fetch_array($NuevaConexion->arraymysql());
		if($factores[TipoCobro]=="Soles")
		{

			$totalmin = round($minsol/$factores[Factor]);
			
			$NuevaConexion->leermysql("select * from chip where idChip = '$_POST[idoculto]'");
			$DatosChip = mysql_fetch_array($NuevaConexion->arraymysql());
			
			$restoSaldo = $totalmin-$DatosChip[Minutos];
			$minutoactual = $DatosChip[MinutoActual]+$restoSaldo;
			
			$NuevaConexion->leermysql
			("UPDATE chip SET idPlanes='$planes', Numero ='$numero', Minutos='$totalmin', Atributo1='$atributo1',Atributo2='$atributo2', MinutoActual='$totalmin',minicodigo='$minicodigo' where idChip = '$_POST[idoculto]'");
			$oculto = 2;
		}
		elseif($factores[TipoCobro]=="Minutos")
		{

			$NuevaConexion->leermysql("select * from chip where idChip = '$_POST[idoculto]'");
			$DatosChip = mysql_fetch_array($NuevaConexion->arraymysql());
			
			$restoSaldo = $minsol-$DatosChip[Minutos];
			$minutoactual = $DatosChip[MinutoActual]+$restoSaldo;
			
			$sql1="UPDATE chip SET idPlanes='$planes', Numero ='$numero', Minutos='$minsol', Atributo1='$atributo1',Atributo2='$atributo2', MinutoActual='$minutoactual',minicodigo='$minicodigo' where idChip = '$_POST[idoculto]'";
			//echo $sql1."<br>";
			$NuevaConexion->leermysql($sql1);
			$oculto = 2;
			//echo $numero."<br>";							
		}	
	}
}
elseif(($_POST[oculto]==2) and !(empty($_POST[numero])) and ($_POST[minsol]!='') and  !(empty($_POST[minicodigo])))
{	
	if(($_POST[planes]<>"n"))
	{		
		$planes		= $_POST[planes];
		$numero 	= $_POST[numero];
		$minsol		= $_POST[minsol];
		$minicodigo = $_POST[minicodigo];
		$atributo1	= $_POST[atributo1];
		$atributo2	= $_POST[atributo2];	
		$NuevaConexion->leermysql("select * from chip where Numero='$numero' and baja='1'"); 
		if($factores = mysql_fetch_array($NuevaConexion->arraymysql()))
		{
			echo '<body  onload="alertaregistrado()">';
		}
		else
		{
		$NuevaConexion->leermysql("select * from planes where idPlanes='$planes'"); 
		$factores = mysql_fetch_array($NuevaConexion->arraymysql());
		if($factores[TipoCobro]=="Soles")
		{
			$totalmin = $minsol/$factores[Factor];
			//Colocamos el factor de soles
			$sql = "INSERT INTO chip(idPlanes,Numero,Minutos,Atributo1,Atributo2,MinutoActual,minicodigo,estado,baja,login) VALUES ("; 
			$sql .= "'".$planes."'";
			$sql .= ",'".$numero."'";
			$sql .= ",'".round($totalmin)."'";
			$sql .= ",'".$atributo1."'";
			$sql .= ",'".$atributo2."'";
			$sql .= ",'".round($totalmin)."'";
			$sql .= ",'".$minicodigo."'";
			$sql .= ",'1'";
			$sql .= ",'1'";
			$sql .= ",'".$login."'";
			$sql .= ")";   
			$NuevaConexion->leermysql($sql); 		
		
		}
		elseif($factores[TipoCobro]=="Minutos")
		{
			
			$sql = "INSERT INTO chip(idPlanes,Numero,Minutos,Atributo1,Atributo2,MinutoActual,minicodigo,estado,baja,login) VALUES ("; 
			$sql .= "'".$planes."'";
			$sql .= ",'".$numero."'";
			$sql .= ",'".$minsol."'";
			$sql .= ",'".$atributo1."'";
			$sql .= ",'".$atributo2."'";
			$sql .= ",'".$minsol."'";
			$sql .= ",'".$minicodigo."'";
			$sql .= ",'1'";
			$sql .= ",'1'";
			$sql .= ",'".$login."'";
			$sql .= ")";   
			$NuevaConexion->leermysql($sql); 		
		} 
	}			
	}
}
elseif(($_POST[oculto]==3) and !(empty($_POST[idoculto])))
{
	echo "<body>";
	$NuevaConexion->actualizaRegistro('chip','baja',"0",'idChip',"$_POST[idoculto]",'');
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
</p>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td bgcolor="#990000"><span class="Estilo1">&nbsp;&nbsp;<? echo $estado ?></span></td>
  </tr>
  <tr>
    <td><table width="720" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr bgcolor="#990000">
        <td width="718">
		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return validar(this)">
            <table width="709" border="0" align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td width="128"><span class="Estilo1">Plan</span></td>
                <td colspan="3"><label>
			<?PHP 
			$NuevoCombobox1 = new ComboBox("planes","Baja='1' order by Nombre","idPlanes","Nombre","Estilocaja",$Cadena_actualizar[idPlanes]);	
			$NuevoCombobox1->RescatarCombobox();
			//echo $_POST['oculto'];
			?>
				</label></td>				
                <td width="199" rowspan="5"><label>
                    <div align="center">
                      <input type="button" name="Submit2" style="<?=($_POST[oculto]==1 ? 'display:anone':'display:none');?>" value="Grabar nuevo chip" onclick="location.href='iframechips.php'">
                      <br />
                      <br />
                      <br />
                    </div>
                    <div align="center">
                      <input type="submit" name="Submit" value="<?PHP echo $mensajeboton ?>">
                    </div>
                  </label></td>
              </tr>
              
              <tr>
                <td height="36"><span class="Estilo1">Numero</span></td>
                <td><input name="numero" type="text" class="Estilocaja" id="numero" value="<?PHP echo $Cadena_actualizar[Numero] ?>" size="15" /></td>
                <td class="Estilo1">Minicodigo</td>
                <td><input name="minicodigo" type="text" class="Estilocaja" id="minicodigo" value="<?PHP echo $Cadena_actualizar[minicodigo] ?>" size="15" maxlength="15" /></td>
              </tr>
              <tr>
                <td height="33"><span class="Estilo1">Minutos o Soles </span></td>
                <td width="121"><label>
                  <input name="minsol" type="text" class="Estilocaja" id="minsol" value="<?PHP $NuevaConexion->leermysql("select * from planes where idPlanes='$Cadena_actualizar[idPlanes]'"); 
					$factores = mysql_fetch_array($NuevaConexion->arraymysql());
					if ($factores[TipoCobro]=="Soles")
					{
					 echo round($Cadena_actualizar[Minutos]*$factores[Factor]);
					}
					elseif ($factores[TipoCobro]=="Minutos")					
					{
						echo $Cadena_actualizar[Minutos];
					}	
				  
				  ?>" size="15" />
                </label></td>
                <td colspan="2" class="Estilo2">
				<?
				if($_GET[id]!='')
				{
				echo $NuevaConexion->recuperaRegistro("select TipoCobro from planes where idPlanes='".$Cadena_actualizar[idPlanes]."'","TipoCobro");
				}
				?>
				(De Acuerdo al Plan) 
				</td>
                </tr>
              <tr>
                <td height="36"><span class="Estilo1">Atributo 1 </span></td>
                <td height="36">
                  <select name="atributo1" class="Estilocaja" id="atributo1" >
                    <option value="Normal">Normal</option>
                    <option value="Rpc">Rpc</option>
                    <?PHP 
					if(!(empty($Cadena_actualizar[Atributo1]))) 
					{
					echo '<option value="'.$Cadena_actualizar[Atributo1].'" selected="selected">'.$Cadena_actualizar[Atributo1].'</option>';
					}

					?>
                  </select>
                </td>
                <td width="88" height="36"><span class="Estilo1">Comentario </span></td>
                <td width="125">
                  <input name="atributo2" type="text" class="Estilocaja" id="atributo2" value="<?PHP echo $Cadena_actualizar[Atributo2] ?>" size="15" />
                  <input name="oculto" type="hidden" id="oculto" value="<?PHP echo $oculto ?>" />
                  <input name="idoculto" type="hidden" id="idoculto" value="<?PHP echo $Cadena_actualizar[idChip] ?>" /></td>
              </tr>
            </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
<tr height="30" valign="middle">
	<td align="right">
	<?
	$cadena="select * from chip where baja = '1'";
	$tabla=new ListaDatos($cadena,'xls','');
	$tabla->recuperaLista();
	?>
	</td>
</tr>
</table>



<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="29" bgcolor="#990000"><div align="center" class="Estilo1">No</div></td>
    <td width="199" height="25" bgcolor="#990000"><div align="center" class="Estilo1">Plan</div></td>
    <td width="88" bgcolor="#990000"><div align="center" class="Estilo1">Numero</div></td>
    <td width="62" bgcolor="#990000"><div align="center"><span class="Estilo1">Minutos</span></div></td>
    <td width="68" bgcolor="#990000"><div align="center"><span class="Estilo1">Atributo 1 </span></div></td>
    <td width="99" bgcolor="#990000"><div align="center"><span class="Estilo1">Estado</span></div></td>
    <!--td width="77" bgcolor="#990000"><div align="center"><span class="Estilo1">Min Actual </span></div></td-->
    <td width="81" bgcolor="#990000"><div align="center"><span class="Estilo1">Minicodigo</span></div></td>
    <td width="76" bgcolor="#990000"><div align="center" class="Estilo1">Eliminar</div></td>
  </tr>
<?PHP
$total=$NuevaLista->recuperaRegistro("select count(*) from chip where baja = '1'",0);
$porhoja=20;
if(isset($_GET[pagina]))
{
	if($_GET[pagina]=='n')
	{
		$pagina=$_GET['pagina'];
		$iteminicial="0";
		$itemfinal=$total;
	}
	else
	{
		$pagina=$_GET['pagina'];
		$iteminicial=($pagina-1)*$porhoja+0;
		$itemfinal=$porhoja;
	}
}
else
{
	$pagina=1;
	$iteminicial=0;
	$itemfinal=$porhoja;
}
$z=$iteminicial;
$sql="select * from chip where baja = '1' limit $iteminicial,$itemfinal";
//echo $sql;
$NuevaLista->leermysql($sql);
while($lista = mysql_fetch_array($NuevaLista->arraymysql()))
{
$z=$z+1;
?>
  <tr>
    <td bgcolor="#FBECC8"><div align="center"><? echo $z; ?></div></td>
    <td height="24" bgcolor="#FBECC8" title="Comentario :<?=($lista[Atributo2]=='' ? 'vacio':$lista[Atributo2]);?>">&nbsp;
	<a href="iframechips.php?id=<? echo $lista[idChip];?>&pagina=<?=$pagina;?>">
	<? 
	$NuevaConexion->leermysql("select * from planes where idPlanes = '$lista[idPlanes]'"); 
	$arrayprovedor = mysql_fetch_array($NuevaConexion->arraymysql());
	echo $arrayprovedor[Nombre]; 
	?>
	
	<img src="imagenes/b_edit.png" alt="Editar" width="16" height="16" border="0" /></a></td>
    <td bgcolor="#FBECC8" title="Comentario :<?=($lista[Atributo2]=='' ? 'vacio':$lista[Atributo2]);?>">
		<div align="center"><? echo $lista[Numero]; ?></div>    </td>
    <td bgcolor="#FBECC8"><div align="center"><? echo $lista[Minutos]; ?></div>    </td>
    <td bgcolor="#FBECC8"><div align="center"><? echo $lista[Atributo1]; ?></div>    </td>
    <td bgcolor="#FBECC8"><div align="center">
	<?
	
	 if($lista[estado]==0){
		$base = $NuevaConexion->recuperaRegistro("select * from usuariochip where Chip_idChip='".$lista[idChip]."' and Estado='1' order by idUsuarioChip desc limit 1",idDatosCliente);
		$nombreBase=$NuevaConexion->recuperaRegistro("select * from bases where id_base='".$base."'",base);
		echo "En uso $nombreBase";
	 }
	 elseif($lista[estado]==1)
	 echo "Libre";
	 elseif($lista[estado]==2)
	 echo "En uso cliente";
	 ?>
    </div></td>
	<!--td bgcolor="#FBECC8"><div align="center"><? //echo $lista[MinutoActual]; ?></div></td-->
    <td bgcolor="#FBECC8"><div align="center"><? echo $lista[minicodigo]; ?></div>    </td>
    <td bgcolor="#FBECC8"><div align="center"><a href="javascript:mensaje(<? echo $lista[idChip];?>,<?=$lista[estado];?>)">
	<img src="imagenes/borrar.gif" width="16" height="16" border="0" /></a></div></td>
  </tr>

<?PHP
}
  ?>
  <tr>
    <td colspan="9" bgcolor="#990000">&nbsp;</td>
  </tr>
</table>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
<tr height="30" valign="middle">
	<td align="center">
<?
$paginacion=new Pagina($total,$porhoja);
$paginacion->muestraPaginas();
?>
	</td>
</tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script>
function mensaje(id,estado)
{
if(estado=='0')
{
	error();
}
else
{
  if(confirm("Esta seguro que desea borrar"))
  {
    document.form1.oculto.value='3';
    document.form1.idoculto.value=id;    
    document.form1.submit();
  }
}
}
</script>
<script language="JavaScript"> 
function alerta()
{
	alert('Para registrar datos no puede dejar ningun campo en blanco ');
}
function error()
{
	alert('Lo Sentimos no puede dar de baja este chip por estar en uso ');		
}
function alertaregistrado()
{
	alert('El numero que intenta registrar ya esta en uso ');		
}
function validar(form1)
{
	var minsoles=document.form1.minsol.value;
	var oculto=document.form1.oculto.value;
	if(minsoles>0)
	{
		return true;
	}
	else
	{
		alert("La cantidad de minutos o soles no puede ser 0");
		document.form1.numero.value='';
		document.form1.minsol.value='';
		document.form1.atributo2.value='';
		document.form1.minicodigo.value='';
		return false;
	}
}
</script>
