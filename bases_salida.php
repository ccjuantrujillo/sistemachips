<?php
include_once "clases/BaseDeDatos.php";
include_once "clases/recuperar_archivo.php";
$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();

$a = new recuperar_archivo("090714.cdr","00:00:00","090714.cdr","23:59:59");
$a->calcular_filas();
//echo var_dump($a->mostrar_filas());	
echo "fddsass";
?>
