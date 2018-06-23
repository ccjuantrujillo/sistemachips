<?
function comparar($x, $y)
{ 
	if ( $x == $y) 
	return 0; 
	else if ( $x > $y) 
	return 1; 
	else
	return -1; 
}

$resultados = array
			 (
				array('id' => 9,'nombre' => 'Martin', 'apellido' => 'Trujillo','edad'=>'21'), 
				array('id' => 11,'nombre'  => 'Angela', 'apellido'  => 'Bustamante','edad'=>'19'),
				array('id' => 3,'nombre'  => 'Humberto', 'apellido'  => 'Montesinos','edad'=>'32')
			 );

$indice='edad';
foreach($resultados as $ind1=>$valor1) 
{
	foreach($valor1 as $ind2=>$valorReal) 
	{	
		if($ind2==$indice)
		{
			$matriz[$ind1]=$valorReal;
		}
	};
};

asort($matriz);
foreach($matriz as $ind1=>$valor)
{
	foreach($resultados[$ind1] as $ind2 => $valorReal)
	{
		echo $valorReal." ";
	}
	echo "<br>";
}
?>