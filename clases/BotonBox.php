<?PHP 
class BotonBox{
	public function __construct($nombreaccion,$nombreid,$accion,$idoculto,$txtgrabar,$txtactualizar,$estilo){
		$this->nombreaccion 	= $nombreaccion;		
		$this->nombreid 		= $nombreid;			
		$this->accion			= $accion;
		$this->idoculto			= $idoculto;
		$this->temporal			= $temporal;
		$this->estilo			= $estilo;
		$this->txtgrabar		= $txtgrabar;
		$this->txtactualizar	= $txtactualizar;
		$this->mensaje			=((($this->accion == "new" || $this->accion == "delete" || $this->accion=='')) ? $this->txtgrabar:$this->txtactualizar);
	}
	public function RescatarBotonbox(){
		//echo $this->estilo;
		echo "<input type='button' name='botones1' class='".$this->estilo."' value='".$this->mensaje."' onclick='send();'>";
		echo "<input type='hidden' name='".$this->nombreaccion."' id='".$this->nombreaccion."' value=''>";
		echo "<input type='hidden' name='".$this->nombreid."' id='".$this->nombreid."' value='".$this->idoculto."'>";
		echo "<input type='hidden' name='modo' id='modo' value='grabar'>";
?>
<script>
var id="<?=$this->idoculto;?>";
var accion="<?=$this->accion;?>";
function send()
{
if((id==''))
{
	eval("document.form1." + "<?=$this->nombreaccion;?>" +".value='new'");
	eval("document.form1." + "<?=$this->nombreid;?>" +".value=''");
	document.form1.submit();
}
else
{
	//if(accion=='update')
	//{
		eval("document.form1." + "<?=$this->nombreaccion;?>" +".value='update'");
		eval("document.form1." + "<?=$this->nombreid;?>" +".value="+id);
	//}
	document.form1.submit();
}
}
</script>	
<?

	}
}
?>


<!--form name='form1' id='form1' method="post"-->
<?
//$NuevoBotonbox1 = new BotonBox("accion","id",'new',"3","Grabar Registro","Actualizar Registro",'Estilocaja');	
//$NuevoBotonbox1 ->RescatarBotonbox();
?>
<!--/form-->