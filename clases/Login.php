<?php
include_once("BaseDeDatos.php");
class Login
{
	public function __construct($user,$password,$tabla)
	{
		$this->user=$user;
		$this->password=$password;
		$this->tabla=$tabla;
		$Conexion1= new BaseDeDatos();
		$Conexion1->conectar();
		$this->cadena="SELECT * from ".$this->tabla." where login='$this->user' and contrasena='".$this->password."'";
		$Conexion1->leermysql($this->cadena);
		$this->ArrayCadena = $Conexion1->arraymysql();
	}

	public function loguear()
	{	
		if($listaopciones = mysql_fetch_array($this->ArrayCadena))
		{
			if(isset($_COOKIE["usNick"])) $usNick=$_COOKIE["usNick"];else $usNick="";
			if(isset($_COOKIE["usPass"])) $usPass=$_COOKIE["usPass"];else $usPass="";
			setcookie("usNick",$usNick,time()+36000); 
			setcookie("usPass",$usPass,time()+36000); 
			$loginCorrecto = true; 
			$_SESSION['login'] = $listaopciones["login"];
			$_SESSION['contrasena'] = $listaopciones["contrasena"];
			$_SESSION['rol'] = $listaopciones["idRol"];
			$_SESSION['titulo'] = "Sistema de Control de Chips";
			$_SESSION['idAdministrador'] = $listaopciones["idAdministrador"];
			$_SESSION['Administrador'] = $listaopciones['nombre']." ".$listaopciones['apellidos'];
		}
		else
		{
			$loginCorrecto=false;
			//Destruimos las cookies. 
			setcookie("usNick","x",time()-3600); 
			setcookie("usPass","x",time()-3600); 
		} 
		return $loginCorrecto;
	}
	public function logout($archivo,$cierraventana)
	{
		if ($_COOKIE["usNick"]) 
		{ 
			//Esto lo unico que hace es borrar el cookie
			setcookie("usPass","x",time()-3600); 
			setcookie("usNick","x",time()-3600); 
			setcookie ("usPass");
		}
		if($cierraventana)
		{
			$txt1="<script>window.close()</script>";
			echo $txt1;
		}
		else
		{
			header("location:$archivo");
		}
	}
}
?>