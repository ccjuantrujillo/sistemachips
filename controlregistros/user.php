<?php
session_start();
require_once "../clases/Login.php";
$usuario=$_REQUEST['user'];
$contrasena1=$_REQUEST['password'];
$tabla="administradores";
$Conexion2=new Login($usuario,$contrasena1,$tabla);
$loginCorrecto=$Conexion2->loguear();
echo $loginCorrecto;
if($loginCorrecto==true) //si es correcto
{ 
	include "index.php";
	//include "menu/menu_items.php";
}
else
{
	//Crea las cookies
	$nickN = $_REQUEST["user"]; 
	$passN = $_REQUEST["password"]; 
	$Conexion1=new BaseDeDatos();
	$Conexion1->conectar();	
	$cadena ="SELECT contrasena from administradores where login='$nickN'";
	$Conexion1->leermysql($cadena);
	$rowConexion1 = mysql_fetch_array($Conexion1->arraymysql());
	print_r($rowConexion1);
	if($rowConexion1['contrasena']) 
	{ 
		$valor=md5($rowConexion1[contrasena]);
		//echo $valor;die();
		if($valor == $passN) 
		{ 
			//90 dias dura la cookie 
			setcookie("usNick",$nickN,time()+7776000); 
			setcookie("usPass",$passN,time()+7776000); 
			//Redirecciona al mismo archivo
			echo '<SCRIPT LANGUAGE="javascript"> location.href = "user.php?<?=SID;?>";</SCRIPT>'; 
		}
		else
		{
			echo "Password incorrecto";
			$Conexion2->logout('',true); 
		}
	}
	else
	{
		echo "Este usuario no esta registrado en el sistema";
		$Conexion2->logout('',true); 
	}
}
$titulo=$_SESSION['login'];
?>
<head>
<title><?=$titulo;?></title>
</head>