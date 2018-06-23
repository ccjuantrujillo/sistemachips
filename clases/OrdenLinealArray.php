<? 
/**Objeto3
*
* Buscando la perfeccion
*
**/
class OrdenLinealArray {
public function __construct($superArray)
	{
		$filas = explode(",", $superArray);
		$this->filas=$filas;	
	}
/**
*La funcion RescatarNumero se Encarga de devolvernos el numero
*telefonico al que se marco
**/	
public function RescatarNumero(){	
return $this->filas[1];
}
/**
*La funcion RescatarDuracion se Encarga de devolvernos el tiempo
*que duro la llamada
**/	
public function RescatarDuracion(){	
return $this->filas[2];
}
/**
*La funcion RescatarDuracion se Encarga de devolvernos el tiempo
*que tardo la llamada desde que empezo a timbrar hasta que se inicio la conversacion, el cual pueden darle un
*mejor formato con FormatFecha.php
**/	
public function RescatarTiempoPreconexion(){	
return $this->filas[3];
}
/**
*La funcion RescatarTiempoConexion se Encarga de devolvernos el tiempo
*en que se conecto la llamada formato 20090430184807, el cual pueden darle un
*mejor formato con FormatFecha.php
**/	
public function RescatarTiempoConexion(){	
return $this->filas[4];
}
/**
*La funcion RescatarTiempoConexion se Encarga de devolvernos el tiempo
*en que se termino la llamada formato 20090430184807, el cual pueden darle un
*mejor formato con FormatFecha.php
**/	
public function RescatarTiempoDesconexion(){	
return $this->filas[5];
}
/**
*Nos devuleve un codigo numerico con el error del mensaje para manipularlopuede trabajar con 
*el archivo CausaDesconexion.php que nos devuelve un mensaje, los codigos son:
*16->llamada cancelada por el usuario
*34->Canal no encontrado para realizar llamada
**/	
public function RescatarCausaDesconexion(){	
return $this->filas[6];
}
public function RescatarIpOriginal(){	
return $this->filas[7];
}
public function RescatarIpRemota(){	
return $this->filas[8];
}
public function RescatarTrunk(){	
return $this->filas[9];
}
public function RescatarTipoLlamada(){	
return $this->filas[10];
}
public function RescatarTipoNumero(){	
return $this->filas[11];
}
public function RescatarLineaEntrada(){	
return $this->filas[12];
}
public function RescatarCanalEntrada(){	
return $this->filas[13];
}
/**
*La funcion RescatarLineaSalida se Encarga de devolvernos el numero
*de base por donde se efectuo la llamada
**/
public function RescatarLineaSalida(){	
return $this->filas[14];
}
public function RescatarCanalSalida(){	
return $this->filas[15];
}
public function RescatarTiempoSwitch(){	
return $this->filas[16];
}
public function RescatarCorteSwitch(){	
return $this->filas[17];
}
public function RescatarBadIp(){	
return $this->filas[18];
}
public function RescatarFlag(){	
return $this->filas[19];
}

}
?>
