<?php
//function __autoload($class_name) {
//    require_once "../clases/".$class_name . '.php';
//}
$fila="[";
$Conexionmenu = new BaseDeDatos();
$Conexionmenu->conectar();

//Recupera el Rol
$login=$_SESSION['login'];
$rol=$_SESSION['rol'];

//Lee todas las opciones del visibles para ese Rol
$cMenu=new BaseDeDatos();
$cMenu->conectar();
$Conexionmenu->leermysql("select idMenu from rolmenu where idRol = '$rol' and tagVisible='1' order by idMenu");
while($row_menu = mysql_fetch_array($Conexionmenu->arraymysql()))
{
  $cad_menu="select * from menu where idMenu='".$row_menu['0']."'";
  $cMenu->leermysql($cad_menu);
  $row_cMenu=mysql_fetch_array($cMenu->arraymysql());
  $idMenu=$row_cMenu['idMenu'];
  $nombre=$row_cMenu['nombre'];
  $url=$row_cMenu['url'];
  $atributos=$row_cMenu['atributos'];

  if($idMenu=='1.00')	
  {
  	$fila.="['".$nombre."','".$url."',".$atributos."";
  }
  elseif($idMenu=='2.00' || $idMenu=='3.00' || $idMenu=='4.00' || $idMenu=='5.00' || $idMenu=='6.00')
  {
  	$fila.="],['".$nombre."','".$url."',".$atributos."";
  }
  else
  {
  	$fila.=",['".$nombre."','".$url."',".$atributos."]";  
  }
}
$fila.="],['', null, null";
$fila.="],['', null, null";
$fila.="],['', null, null";
//$fila.="],['', null, null";
$fila.="]];";
?>
