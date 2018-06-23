<?
session_start();
//echo $_SESSION['login'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
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
<?PHP 
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}

//Objetos de Conexion
$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();
$Conexion1 = new BaseDeDatos();
$Conexion1->conectar();
$Conexion2 = new BaseDeDatos();
$Conexion2->conectar();
$Menu = new BaseDeDatos();
$Menu->conectar();
$ManejaDatos = new BaseDeDatos();
$ManejaDatos ->conectar();
$ManejaDatos1 = new BaseDeDatos();
$ManejaDatos1 ->conectar();

//Aqui grabamos y/o actualizamos segun se indique
$idRol=$_GET['rol'];
$tag=$_GET['tag'];
//echo "Idrol".$idRol."<br>";
//echo "TAg".$tag."<br>";
if($tag!="")
{
	$arrtag=explode('/',$tag);
	for($i=1;$i<count($arrtag);$i++)
	{	
	  $valor=explode(':',$arrtag[$i]);
	  $a=substr($valor['0'],3,6);
	  $b=$valor['1'];
	  $ManejaDatos->leermysql("select count(*) from rolmenu where idRol='$idRol' and idMenu='$a'");
	  $rowManejaDatos=mysql_fetch_array($ManejaDatos->arraymysql());
	  if($rowManejaDatos[0]>0)
	  {
	  	 $ManejaDatos1->leermysql("update rolmenu set tagVisible='$b' where idRol='$idRol' and idMenu='$a'");
	  }
	  else
	  {
	  	 $ManejaDatos1->leermysql("insert into rolmenu (idRol,idMenu,tagVisible) values ('$idRol','$a','$b')");
	  	
	  }
	}
}
?>
<p>&nbsp;</p>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td><table width="720" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="718" bgcolor="#990000">

<form name="a" id="a" method="get" action="<?=$_SELF;?>">
            <table width="709" border="0" align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td height="38"><span class="Estilo1">Rol</span></td>
              	<td>
              	  <?
				    $NuevoCombobox1 = new ComboBoxChangue("rol","","idRol","Nombre","Estilocaja",$_GET[rol],"javascript:cargar()");	
				    $NuevoCombobox1->RescatarCombobox();
		  		  ?>
		      </td>
              </tr>
              <tr>
              </tr>
            </table>

		</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="720" name="tablax" id="tablax" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="right">Marcar/Desmarcar: <input type="checkbox" name="chkTotal" id="chkTotal" onclick="marcartodos();"></td>
</tr>
</table>
<table width="720" name="tabla1" id="tabla1" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="50" bgcolor="#990000"><div align="center" class="Estilo1">Codigo</div></td>
    <td width="400" bgcolor="#990000"><div align="center" class="Estilo1">Nombre</div></td>
    <td width="100" bgcolor="#990000"><div align="center" class="Estilo1">Visible</div></td>
  </tr>
<?
//Cuenta la cantidad de registros para ver si actualiza o inserta.
$NuevaConexion->leermysql("select count(*) from rolmenu where idRol='$idRol'");
$rowNuevaConexion=mysql_fetch_array($NuevaConexion->arraymysql());
$exist_reg=$rowNuevaConexion[0];

//Lee cada opcion de la tabla menu
$Conexion1->leermysql("select idMenu,nombre from menu order by idMenu");
while($rowConexion1=mysql_fetch_array($Conexion1->arraymysql()))
{
	$idMenu=$rowConexion1['idMenu'];
	$nombreMenu=$rowConexion1['nombre'];

	//Consulto los permisos para el perfil
	$Conexion2->leermysql("select tagVisible from rolmenu where idMenu='$idMenu' and idRol='$idRol'");
	$rowConexion2=mysql_fetch_array($Conexion2->arraymysql());
	$tagVisible=$rowConexion2['tagVisible'];
	$marcado=($tagVisible=='1' ? "checked='checked'":'');
	$n=explode(".",$idMenu);
?>
  <tr>
    <td bgcolor="#FBECC8"><font color="<?=($n['1']=='00' ? '#FF0000':'#000000');?>">&nbsp;<?=$idMenu;?></font></td>
    <td bgcolor="#FBECC8"><div align="left"><font color="<?=($n['1']=='00' ? '#FF0000':'#000000');?>"><?=$nombreMenu;?></font></div></td>
    <td bgcolor="#FBECC8"><div align="center"><input type="checkbox" name="chk<?=$idMenu;?>" id="chk<?=$idMenu;?>" <?=$marcado;?>></div></td>
  </tr>
<?PHP
}
?>
  <tr>
    <td colspan="3" bgcolor="#990000">&nbsp;</td>
  </tr>
</table>
<input type="hidden" id="tag" name="tag" value="" size="100">
</form>
<br>
<div align="center"><input type="button" name="boton" id="boton" onclick="enviar();" value="Grabar"></div>
<p>&nbsp;
</p>
</body>
</html>

<script>
var valor='';
function enviar()
{
	if(document.a.rol.value!='n')
	{
	var nombre;
	var valor;
	var texto="";
	var cantidad=document.a.elements.length;
	for (i=0;i<document.a.elements.length;i++) 
	{
	   	if(document.a.elements[i].type == "checkbox") 
		{
       		nombre=document.a.elements[i].name;
			valor=document.a.elements[i].checked;
			if(valor)	visible=1;
			if(!valor)	visible=0;
			texto=texto+"/"+nombre+":"+visible;
		}
	}
	document.a.tag.value=texto;
	document.a.submit();
	}
	else
	{
		alert("Debe ingresar un Rol");
	}
}

function cargar()
{
	location.href="iframepermisos.php?rol="+document.a.rol.value;
}

function marcartodos()
{
   		for (i=0;i<document.a.elements.length;i++)
   		{
      	if(document.a.elements[i].type == "checkbox")
      	{
      		if(!document.a.chkTotal.checked)
			{
	      		document.a.elements[i].checked=0;
	      	}
	      	else
	      	{
	      		document.a.elements[i].checked=1;
	      	}
      	}
   	}
} 
</script>
