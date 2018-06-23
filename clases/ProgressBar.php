<? 
class ProgressBar{
/*
*La clase ProgressBar interactua con una cantidad total y cantidad avanzada
*Para calcular el porcentaje divide cantidad total entre cantidad avanzada 
* y lo devuelve graficamente, el formato es el siguiente:
*$ProgressBar = new ProgressBar("100","45","#0000FF","500","50");
*/
	public function __construct($alto,$ancho,$color,$cantidadtotal,$cantidadavanzada){
	$this->alto					=	$alto;
	$this->ancho				=	$ancho;
	$this->color				=	$color;
	$this->cantidadtotal		=	$cantidadtotal;
	$this->cantidadavanzada		=	$cantidadavanzada;
	$this->calcular();
	$this->css();
	}
	public function calcular(){
	if ($this->cantidadavanzada>$this->cantidadtotal)
		{
		$this->porcentaje = "Error";
		}
	else
		{
		$this->porcentaje = round(($this->cantidadavanzada*100)/ $this->cantidadtotal);
		}			
	}
	public function css(){
	echo '<style type="text/css">';

	echo '
	.Tamanio {font-size: '.$this->alto.'px}
	#MylayerPorcentaje {
		position:absolute;
		left:498px;
		top:'.($this->alto/2).'px;
		width:43px;
		height:20px;
		z-index:1;
	}
	.porcentaje {
		color: #FFCC00;
		font-weight: bold;
		font-size:14px
	}';

	echo '</style>';
	
	}
	public function mostrar(){
	$cadena  = 	'<div class="porcentaje" id="MylayerPorcentaje">'.$this->porcentaje.'%</div>';
	$cadena .=	'<table width="'.$this->ancho.'" height="1" border="1" align="center"'; 
	$cadena .=	'cellpadding="0" cellspacing="0" bordercolor="'.$this->color.'">';
	$cadena .=	'<tr>';
	$cadena .=	'<td bgcolor="#FFFFFF"><table width="'.$this->porcentaje.'%" height="100%" border="0" cellpadding="0"'; 
	$cadena .=	'cellspacing="0" bgcolor="'.$this->color.'">';
	$cadena .=	'<tr>';
	$cadena .=	'<td><span class="Tamanio">&nbsp;</span></td>';
	$cadena .=	'</tr>';
	$cadena .=	'</table></td>';
	$cadena .=	'</tr>';
	$cadena .=	'</table>';
	$cadena .=	$this->porcentaje.'%'	;
	return $cadena;
	}
}

?>

<?
//order; $alto,$ancho,$color,$cantidadtotal,$cantidadavanzada
//$ProgressBar = new ProgressBar("20","100","#0000F0","500","480");
//echo $ProgressBar->mostrar();
?>