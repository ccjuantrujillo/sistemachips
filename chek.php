<!--
Código de un menú desplegable. Cada botón principal llama a la función Menu con sus respectivos parámetros y cambia la clase de su DIV correspondiente a NOMBREVisible o NOMBREOculto. Éstos manejan a su vez la separación con el menú superior.
Éstos datos deben ser modificados en relación a la cantidad de items que tenga cada menú.
-->
<html>
<style type="text/css">
<!--
.Estilo1 {color: #1A4D81}
.Estilo2 {color: #990000}
.Estilo3 {color: #2C5F93}
-->
</style>
<body>
<script language="JavaScript">

function AbrirCentrado(Url,NombreVentana,width,height,extras) {
var largo = width;
var altura = height;
var adicionales= extras;
var top = (screen.height-altura)/2;
var izquierda = (screen.width-largo)/2; nuevaVentana=window.open(''+ Url + '',''+ NombreVentana + '','width=' + largo + ',height=' + altura + ',top=' + top + ',left=' + izquierda + ',features=' + adicionales + '');
nuevaVentana.focus();
}

</script>
<form>
<p align="center"><input type="button"
value=" PULSE AQUÍ "
onclick="alert(' ¿No estaría bien uno de estos en su página? Diga aquí lo que quiera ')"></p>
</form> 

<a href="JavaScript:alert(' ¿No estaría bien uno de estos en su página? Diga aquí lo que quiera ')">Código</a> a incluir en e<span class="Estilo3">l cuer</span>po (entre <body> 
<span class="Estilo2">y</span> <span class="Estilo1">ss 
</span><a href="090502.cdr" target="_blank">fff
</a>
</body>


<input type="button" value="Abrir ventana" onClick="javascript:AbrirCentrado('pagina.html','Pagina','720','500','fullscreen=1,scrollbars=NO');"> 

</body>
</html>