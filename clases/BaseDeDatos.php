<?php
class BaseDeDatos{
	private $patch;
	private $host;
	private $user;
	private $password;
	private $database;
	function __construct(){
		$this->patch = dirname(dirname(__FILE__))."/controlador/DataBase.txt";
		if(file_exists($this->patch)){
			$vconexion = file($this->patch);
			$this->host = str_replace("\n","",$vconexion[0]);
			$this->user = str_replace("\n","",$vconexion[1]);
			$this->password = str_replace("\n","",$vconexion[2]);
			$this->database = str_replace("\n","",$vconexion[3]);
		}
		else
		{
			echo "Error el archivo".$this->patch."/DataBase.txt no existe";
		}
	}
	function conectar(){
		echo $this->password ."<br>";
		if($this->host=="" and $this->user==""and $this->database==""){
			echo "Ingrese Valores Validos en DataBase.txt";			
			}
		else 
			{
			$vierror = mysql_connect($this->host,$this->user,$this->password);
			echo $vierror;
			if(!($vierror = mysql_connect($this->host,$this->user,$this->password))){
			echo"Error Conectandose a la Base de datos";
			exit();	
			}
			if(!(mysql_select_db($this->database,$vierror))){
			echo "Error seleccionando la base de datos.";	
			exit();			 
			}						
		}	
	}

	function leermysql($sql){
		//echo $sql;
		$this->cadena_array = mysql_query($sql);		
	}
	function arraymysql(){
		return $this->cadena_array;
	}
	function eliminaregistro($tabla,$campo,$id,$tablafk,$fk){
		$this->tabla=$tabla;
		$this->tablafk=$tablafk;
		$this->fk=$fk;
		if($this->tablafk!='' && $this->fk!='')
		{
			$sql="select count(*) from $this->tablafk where $this->fk='".$id."'";
			$this->leermysql($sql);
			$this->cantidad=$rowNuevaConexion=mysql_fetch_array($this->arraymysql());
			if($this->cantidad['0']==0)
			{
				$this->leermysql("delete from $this->tabla where $campo=$id");
			}
			else
			{
				$txtmensaje="<script>alert('No se puede eliminar,existen ".$this->cantidad['0']." registros en la tabla ".$this->tablafk."');</script>";
				echo $txtmensaje;
			}
		}
		else
		{
			$this->leermysql("delete from $this->tabla where $campo=$id");
		}
		//$sql="delete from $tabla where $campo='".$id."'";
		//$this->leermysql($sql);
	}
	
	function actualizaRegistro($tabla,$campo,$valor,$key,$id,$url){
		$arraycampo=explode(",",$campo);
		$arrayvalor=explode(",",$valor);
		if(count($arraycampo)==count($arrayvalor))
		{
			$cadena="";
			for($i=0;$i<count($arraycampo);$i++)
			{
				$cadena.="$arraycampo[$i]='".$arrayvalor[$i]."',";
			}
			$this->longitud=strlen($cadena);
			$this->ncadena=substr($cadena,0,$this->longitud-1);
			$sql1="update $tabla set $this->ncadena where $key='".$id."'";
			//echo $sql1;
			$this->leermysql($sql1);
		}
	}
	
	function insertaRegistro($tabla,$campo,$valor,$url){
		$this->tabla=$tabla;
		$arraycampo=explode(",",$campo);
		$arrayvalor=explode(",",$valor);
		if(count($arraycampo)==count($arrayvalor))
		{
			$cadenacampo="";
			$cadenavalor="";
			for($i=0;$i<count($arraycampo);$i++)
			{
				$cadenacampo.="$arraycampo[$i],";
				$cadenavalor.="'".$arrayvalor[$i]."',";
			}
			$this->longitud1=strlen($cadenacampo);
			$this->longitud2=strlen($cadenavalor);
			$this->ncadenacampo=substr($cadenacampo,0,$this->longitud1-1);
			$this->ncadenavalor=substr($cadenavalor,0,$this->longitud2-1);
			$sql="insert into $this->tabla (".$this->ncadenacampo.") values (".$this->ncadenavalor.")";
			//echo $sql;
			$this->leermysql($sql);
		}
		else
		{
			echo "La cantidad de campos no coinciden";
		}
	}

	function recuperaRegistro($sql,$campo){
		$this->sql=$sql;
		//echo $sql;
		$arrrsql=$this->leermysql($this->sql);
		if(!$arrsql)
		{
			$this->row=mysql_fetch_array($this->arraymysql());
			return $this->row[$campo];
		}
	}
}
?>