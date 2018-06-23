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
-->
</style>
</head>

<body>
<script>
function Abrir(Url,NombreVentana,width,height,extras) {
var largo = width;
var altura = height;
var adicionales= extras;
var top = (screen.height-altura)/2;
var izquierda = (screen.width-largo)/2; nuevaVentana=window.open(''+ Url + '',''+ NombreVentana + '','width=' + largo + ',height=' + altura + ',top=' + top + ',left=' + izquierda + ',features=' + adicionales + '');
nuevaVentana.focus();
}

</script>
<div align="center">
  <?PHP
	function __autoload($class_name) {
		require_once "../clases/".$class_name . '.php';
	}
	
	$NuevaConexion = new BaseDeDatos();
	$NuevaConexion->conectar();
	$NuevaConexion2 = new BaseDeDatos();
	$NuevaConexion2->conectar();
	$NuevaConexion3 = new BaseDeDatos();
	$NuevaConexion3->conectar();
	$NuevaConexion->leermysql("select * from planes where Baja='1' and TipoPlan='Postpago'");
	$matriz = array();
	$identificador = array();
	$contador1 = 0;
	while($my = mysql_fetch_array($NuevaConexion->arraymysql()))
	{
		 
		$fecharedistribucion 	=	strtotime(str_replace("/", "-", $my[FechaRedistribucion]));
		$fechaactual 			= 	strtotime(date("d-m-Y"));
		if($fecharedistribucion<$fechaactual)
		{
		$matrizBoton[] 			=	$_POST["rb".$my[idPlanes]];//$my[idPlanes]
		$identificador[] 	=	$my[idPlanes];
		$contador1++;
		}
	}
	?>
<strong>Administracion de Planes Vencidos</strong></div>
<p>
  <?PHP
	for($i=0;$i<$contador1;$i++)
	{
		$NuevaConexion->leermysql("select * from planes where Baja='1' and idPlanes='$identificador[$i]'");
		$myplan = mysql_fetch_array($NuevaConexion->arraymysql());
		if($matrizBoton[$i]==3)
		{
		?>
</p>
<table width="350" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td colspan="2" bgcolor="#990000"><span class="Estilo1">El plan <? echo $myplan[Nombre]; ?></span></td>
  </tr>
  <tr>
    <td height="43" colspan="2" bgcolor="#FBECC8"><table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="320">Se encuentra pendiente de Redistribucion, se le recordara en su proximo ingreso.</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="236" bgcolor="#990000"><span class="Estilo1">Fecha de Vencimiento </span></td>
    <td width="94" bgcolor="#990000"><span class="Estilo1"><?PHP echo $myplan[FechaRedistribucion];  ?></span></td>
  </tr>
</table> 
<p> 
  <?PHP
		}
		elseif($matrizBoton[$i]==2)
		{
			?></p>
<table width="350" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td colspan="2" bgcolor="#990000"><span class="Estilo1">El plan <? echo $myplan[Nombre]; ?></span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FBECC8"><table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="44">
		  <?PHP 
		  	  $nuevocalculo 	= 	new SumaMeses($myplan[FechaRedistribucion], "1");
			  $nuevafecha 		=	$nuevocalculo->mostrar();
			  
			  $NuevaConexion->leermysql("select * from chip where Baja='1' and idPlanes='$myplan[idPlanes]'");
			  if($verificarplan = mysql_fetch_array($NuevaConexion->arraymysql()))
			  {			  
			  
			   ?>
		  	Acaba de ser Distribuido Correctamente el plan<br />
            La nueva distribuion de chips es:<br />
            &nbsp;
            <table width="255" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
              <tr>
                <td width="143" bgcolor="#990000"><div align="center" class="Estilo1">Numero</div></td>
                <td width="112" bgcolor="#990000"><div align="center" class="Estilo1">Minutos</div></td>
              </tr>
			  
			  	  <?PHP					  
				  
				  
				  	
					
					
				  $NuevaConexion->leermysql("UPDATE planes SET FechaRedistribucion='$nuevafecha' 
				  where idPlanes = '$myplan[idPlanes]'");	  
				  
				  $NuevaConexion->leermysql("select * from chip where baja='1' and idPlanes='$myplan[idPlanes]'");
				  while($mychip = mysql_fetch_array($NuevaConexion->arraymysql()))
				  {
				  if($mychip[estado] == 0)
				  {				  
				  	
					$NuevaConexion3->leermysql("select * from usuariochip where Chip_idChip='$mychip[idChip]' and idTipoCliente ='1'  and Baja='1' and Estado='1'");
					$UsuarioChip = mysql_fetch_array($NuevaConexion3->arraymysql());
					
					//Damos de baja a la base		  
					$BajaBase = new BajaBases($UsuarioChip[idDatosCliente],$mychip[Numero],$myplan[FechaRedistribucion]); // Numero Base Numero de Chip
					$BajaBase->Baja();
					//Damos de alta a la base
					$fecha_distribucion1 	= substr($myplan[FechaRedistribucion],0,6);
					$fecha_distribucion2 	= substr($myplan[FechaRedistribucion],8,2);
					$fecha_distribucion		= $fecha_distribucion1.$fecha_distribucion2;
					$sql = "INSERT INTO usuariochip(idTipoCliente,idDatosCliente,Chip_idChip,FechaInicio,FechaFin,Estado,Baja) VALUES ("; 
					$sql .= "'1'";
					$sql .= ",'".$UsuarioChip[idDatosCliente]."'";			
					$sql .= ",'".$mychip[idChip]."'";			
					$sql .= ",'".$fecha_distribucion." 23:59"."'";
					$sql .= ",''";			
					$sql .= ",'1'";
					$sql .= ",'1'";
					$sql .= ")";   
					$NuevaConexion3->leermysql($sql); 	
					
					$NuevaConexion3->leermysql("UPDATE bases SET estado='1' where id_base = '$UsuarioChip[idDatosCliente]'");	
					$NuevaConexion3->leermysql("UPDATE chip SET estado='0' where idChip = '$mychip[idChip]'");					
					
				  }
				  $NuevaConexion2->leermysql("UPDATE chip SET MinutoActual='$mychip[Minutos]' where idChip = '$mychip[idChip]'");
				  }
				  
				  $NuevaConexion->leermysql("select * from chip where Baja='1' and idPlanes='$myplan[idPlanes]'");
				  while($mychip = mysql_fetch_array($NuevaConexion->arraymysql()))
				  {
				  ?>
				  <tr>
					<td><?PHP echo $mychip[Numero]; ?></td>
					<td><?PHP echo $mychip[Minutos]; ?></td>
				  </tr>
				  <?PHP
				  }
				  ?>
		    </table>				 
				  <?PHP
			   }
			   else
			   {
			   	?>
					No tiene Chips activos. La fecha de Distribucion<br />
					se actualizo correctamente
			<?PHP				
					
					$NuevaConexion->leermysql("UPDATE planes SET FechaRedistribucion='$nuevafecha' 
					where idPlanes = '$myplan[idPlanes]'");	
			   }  
			  ?>
          <br /></td>
		</tr>  
      </table></td>
  </tr>
  <tr>
    <td width="250" bgcolor="#990000"><span class="Estilo1">Nueva Fecha de Vencimiento </span></td>
    <td width="94" bgcolor="#990000"><span class="Estilo1">
	<?PHP 		
	echo $nuevocalculo->mostrar();	
	?>
	</span></td>
  </tr>
</table>
<p>  <?PHP 
		}
		elseif($matrizBoton[$i]==1)
		{
			?>
</p>
<table width="350" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td colspan="2" bgcolor="#990000"><span class="Estilo1">El plan <? echo $myplan[Nombre]; ?></span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FBECC8">
    
<table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="44">
		  <div align="center">
		  	  <?PHP 
		  	  $nuevocalculo 	= 	new SumaMeses($myplan[FechaRedistribucion], "0");
			  $nuevafecha 		=	$nuevocalculo->mostrar();
			  
			  $NuevaConexion->leermysql("select * from chip where Baja='1' and idPlanes='$myplan[idPlanes]'");
			  if($verificarplan = mysql_fetch_array($NuevaConexion->arraymysql()))
			  {			  
			  
			   ?>
		  	Registro de distribucion de numeros de Chips del plan <br />
		  	Favor siga el link para ingresar nueva cantidad:
		  	<br />
		  	<br />
		  	<a href="javascript:Abrir('iframeredistribucionmanual.php?id=<? echo $myplan[idPlanes] ?>','bases','350','400','scrollbars=yes,Status=NO')">Realizar Distribucion Manual</a> <br />
&nbsp;
          </div>
		  	<?PHP
			}
			else
		  	{
			?>
			  No tiene Chips activos. La fecha de Distribucion<br />
					se actualizo correctamente
			    <?PHP				
					
					$NuevaConexion->leermysql("UPDATE planes SET FechaRedistribucion='$nuevafecha' 
					where idPlanes = '$myplan[idPlanes]'");	
			   }  
			  ?>
                    <br />
		    </p></td>
		</tr>
		  
      </table>

    
    </td>
  </tr>
  <tr>
    <td width="250" bgcolor="#990000"><span class="Estilo1"> Fecha actual de Vencimiento</span></td>
    <td width="94" bgcolor="#990000"><span class="Estilo1">
	<?PHP 		
	echo $nuevocalculo->mostrar();	
	?>
	</span></td>
  </tr>
</table>
<p>  
			<?PHP
		}

	}	
?>
	<?PHP
	if(!(empty($_POST[idplan])))
	{
		//registrar cambios	
		$NuevaConexion->leermysql("select * from planes where Baja='1' and idPlanes='$_POST[idplan]'");
		$myplan =	mysql_fetch_array($NuevaConexion->arraymysql());
		$NuevaConexion->leermysql("select * from chip where Baja='1' and idPlanes='$_POST[idplan]'");
		while($mychip = mysql_fetch_array($NuevaConexion->arraymysql()))
			 {
			 	if($mychip[estado] == 0)
				  {				  
				  	/////////////////////////////////////
					$NuevaConexion3->leermysql("select * from usuariochip where Chip_idChip='$plandatos[idChip]' and idTipoCliente ='1'  and Baja='1' and Estado='1'");
					$UsuarioChip = mysql_fetch_array($NuevaConexion3->arraymysql());
					
					//Damos de baja a la base		  
					$BajaBase = new BajaBases($UsuarioChip[idDatosCliente],$mychip[Numero],$myplan[FechaRedistribucion]); // Numero Base Numero de Chip
					$BajaBase->Baja();
					//Damos de alta a la base
					$fecha_distribucion1 	= substr($myplan[FechaRedistribucion],0,6);
					$fecha_distribucion2 	= substr($myplan[FechaRedistribucion],8,2);
					$fecha_distribucion		= $fecha_distribucion1.$fecha_distribucion2;
					$sql = "INSERT INTO usuariochip(idTipoCliente,idDatosCliente,Chip_idChip,FechaInicio,FechaFin,Estado,Baja) VALUES ("; 
					$sql .= "'1'";
					$sql .= ",'".$UsuarioChip[idDatosCliente]."'";			
					$sql .= ",'".$mychip[idChip]."'";			
					$sql .= ",'".$fecha_distribucion." 23:59"."'";
					$sql .= ",''";			
					$sql .= ",'1'";
					$sql .= ",'1'";
					$sql .= ")";   
					$NuevaConexion3->leermysql($sql); 	
					
					$NuevaConexion3->leermysql("UPDATE bases SET estado='1' where id_base = '$UsuarioChip[idDatosCliente]'");	
					$NuevaConexion3->leermysql("UPDATE chip SET estado='0' where idChip = '$mychip[idChip]'");					
					////////////////////////////////////////////////
				  }
				$minutos	=	$_POST["txt".$plandatos[idChip]];				
				$NuevaConexion2->leermysql("UPDATE chip SET Minutos='$minutos', MinutoActual='$minutos' where idChip = '$plandatos[idChip]'");
			 }	
		$NuevaConexion->leermysql("select * from planes where idPlanes = '$_POST[idplan]'");	
		$arrayplanes 		=  mysql_fetch_array($NuevaConexion->arraymysql());
		 
		$nuevocalculo 		= 	new SumaMeses($arrayplanes[FechaRedistribucion], "1");
		$nuevafecha 		=	$nuevocalculo->mostrar();	 
		$NuevaConexion->leermysql("UPDATE planes SET FechaRedistribucion='$nuevafecha' where idPlanes = '$_POST[idplan]'");	
		?>
sss</p>
<table width="350" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td colspan="2" bgcolor="#990000"><span class="Estilo1"><? echo $arrayplanes[Nombre];	 ?></span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FBECC8"><table width="344" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="344" height="47">Los Datos de Redistribucion fueron actualizados satisfactoraimente </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="262" bgcolor="#990000"><span class="Estilo1">Nueva Fecha de Vencimiento </span></td>
    <td width="88" bgcolor="#990000"><? echo $nuevafecha ?></td>
  </tr>
</table>
<p>
  <?PHP	 
	}
	?>
</p>
<p>&nbsp; </p>
</body>
</html>
