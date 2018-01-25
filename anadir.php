<?php
if(isset($_REQUEST['enviar3'])){
session_start();
require("class.php");
$usu= new Usuario();
$seta= new Seta();
$foto= new Foto();
$id_usu=$usu->consultarid();
	$id=$_REQUEST['nombre'];
	$descripcion =  $_COOKIE["descripcion"];
	setcookie("descripcion","",time()-3600);
	if($seta->consultar_exist($id)==true){
		$error="La seta ya existe.";
		setcookie("error",$error);
		header("Location: catalogoprop.php");
	}else {		
		$seta->id_usuario=$id_usu;
		$seta->catglob="no";
		$seta->nombre=$_REQUEST['nombre'];
		$seta->familia=$_REQUEST['familia'];
		$seta->estacion=$_REQUEST['Estacion'];
		$seta->nompopu=$_REQUEST['NomPopu'];
		$seta->mortal=$_REQUEST['mortal'];
		$seta->comestible=$_REQUEST['comestible'];
		$seta->descripcion=$descripcion;
		if($seta->anadir_seta()==true){
			$seta_anadida=$seta->consultar_unid($id_usu);			
			if($_FILES['imagen0']['name']!=""){
				$foto->subir_foto($seta_anadida['ID']);
			}
			$error="¡Registro guardado satisfactoriamente!";
			setcookie("error",$error);
			header("Location: catalogoprop.php");
		}else{
			$error="La seta no se ha podido añadir.";
			setcookie("error",$error);
			header("Location: catalogoprop.php");
		} 
	}
}else{
	require("header.php");
	echo "<form enctype='multipart/form-data' method='POST' action='anadir.php' id=formu_seta>";
	echo '<div class="form-group col-xs-12 col-md-5 col-lg-5"><label id="reg_setas">Nombre<input type="text" class="form-control" name="nombre" placeholder="Introduce tu nombre"></label></div>';
	echo '<div class="form-group col-xs-12 col-md-5 col-lg-5 col-md-offset-2"><label id="reg_setas">Familia<input type="text" class="form-control" name="familia" placeholder="Introduce la familia"></label></div>';
	echo '<div class="form-group col-xs-12 col-md-5 col-lg-5"><label id="reg_setas">Estacion<select name="Estacion" class="form-control"><option value="otono">Otoño</option><option value="primavera">Primavera</option><option value="anual">Anual</option></select></label></div>';
	echo '<div class="form-group col-xs-12 col-md-5 col-lg-5 col-md-offset-2"><label id="reg_setas">Nombre Popular<input type="text" class="form-control" name="NomPopu" placeholder="Introduce Nombre Popular"></label></div>';
	echo '<div class="form-group col-xs-6 col-md-2 col-lg-2"><label id="reg_setas">Mortal <input type="checkbox" name="mortal" id="checkbox" value="1"></label></div>';
	echo '<div class="form-group col-xs-6 col-md-2 col-lg-2"><label id="reg_setas">Comestible <input type="checkbox"  name="comestible" id="checkbox" value="1"></label></div>';

	echo '<div class="form-group col-xs-12 col-md-8 col-lg-8 fotos0"><label id="reg_setas2">Foto<input type="file" class="form-control" name="imagen0"/></label><a id="plus" style="color: #276a02;" name="mas" class="btn btn-success glyphicon glyphicon-plus"></a><a id="menos" style="color: #760505;display:none;" name="menos" class="btn btn-danger glyphicon glyphicon-minus"></a></div>';
	echo '<div class="form-group col-xs-12 col-md-12 col-lg-12" id="nuevos_input"></div>';
?>
			<div class="grid-width-100 col-xs-12 col-md-12 col-lg-12">
				<div id="editor">
					
				</div>
			</div>

<?php
	echo '<div class="form-group col-xs-12 col-md-12 col-lg-12" style="margin-top:20px"><input type="submit" name="enviar3" value="Añadir" class="btn btn-success btn-lg enviar_seta" style="margin-right:15px" /></form>';
	if (isset($_SESSION['usuario'])){
		echo'<a href="catalogoprop.php" class="btn btn-lg btn-primary" name="volv">Volver</a></div>';
	}else{
		echo'<a href="index.php" class="btn btn-lg btn-primary" name="volv">Volver</a></div>';
	}
}
require("footer.php");
?>
