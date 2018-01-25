<?php
require("header.php");
$noticia= new noticia();
$usua=new Usuario();
if(isset($_REQUEST['enviar3'])){
	$noticia_texto =  $_COOKIE["descripcion"];
	setcookie("descripcion","",time()-3600);
		$noticia->titulo=$_REQUEST['titulo'];
		$noticia->foto=$_FILES['imagen']['name'];
		$noticia->texto=$noticia_texto;
		$noticia->id_usuario=$usua->consultarid();
		$sw=$noticia->anadir_noticia();
		if($sw==true){	
			$error="¡Registro guardado satisfactoriamente!";
			setcookie("error",$error);
			header("Location: noticias.php");
		}else{
			$error="La noticia no se ha podido añadir.";
			setcookie("error",$error);
			header("Location: noticias.php");
		} 
}else{
	echo "<form enctype='multipart/form-data' method='POST' action='anadir_noticia.php' id=formu_seta>";
	echo '<div class="form-group col-xs-12 col-md-5 col-lg-5"><label id="reg_setas">titulo<input type="text" class="form-control" name="titulo" placeholder="Introduce el titulo"></label></div>';
	echo '<div class="form-group col-xs-12 col-md-7 col-lg-7 col-md-offset-3 foto"><label id="reg_setas2">Foto<input type="file" class="form-control" name="imagen"/></label></div>';
?>
			<div class="grid-width-100 col-xs-12 col-md-12 col-lg-12">
				<div id="editor">
					
				</div>
			</div>

<?php
	echo '<div class="form-group col-xs-12 col-md-12 col-lg-12" style="margin-top:20px"><input type="submit" name="enviar3" value="Añadir" class="btn btn-success btn-lg enviar_seta" style="margin-right:15px" /></form>';
	echo'<a href="noticias.php" class="btn btn-lg btn-primary" name="volv">Volver</a></div>';
	
}
require("footer.php");
?>
