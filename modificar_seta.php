<?php
require("header.php");
$seta= new Seta();
$id=$_REQUEST['id'];
if(isset($_REQUEST['enviar3'])){
	$descripcion =  $_COOKIE["descripcion"];
	setcookie("descripcion","",time()-3600);
		$seta->nombre=$_REQUEST['nombre'];
		$seta->familia=$_REQUEST['familia'];
		$seta->estacion=$_REQUEST['Estacion'];
		$seta->nompopu=$_REQUEST['NomPopu'];
		if(isset($_REQUEST['mortal'])){
			$seta->mortal=$_REQUEST['mortal'];
		}else $seta->mortal="0";
		if(isset($_REQUEST['comestible'])){
			$seta->comestible=$_REQUEST['comestible'];
		}else $seta->comestible="0";
		$seta->descripcion=$descripcion;
		if($seta->modificar_seta($id)==true){
			$error="¡Registro guardado satisfactoriamente!";
			setcookie("error",$error);
			header("Location: catalogoprop.php");
		}else{
			$error="La seta no se ha podido modificar.";
			setcookie("error",$error);
			header("Location: catalogoprop.php");
		} 
}else{
	$row=$seta->consultar_unaseta($id);
	echo "<form enctype='multipart/form-data' method='POST' action='modificar_seta.php?id=".$id."' id=formu_seta>";
	echo '<div class="form-group col-xs-12 col-md-5 col-lg-5"><label id="reg_setas">Nombre<input type="text" class="form-control" name="nombre" value="'.$row['Nombre'].'"></label></div>';
	echo '<div class="form-group col-xs-12 col-md-5 col-lg-5 col-md-offset-2"><label id="reg_setas">Familia<input type="text" class="form-control" name="familia" value="'.$row['Familia'].'"></label></div>';
	echo '<div class="form-group col-xs-12 col-md-5 col-lg-5"><label id="reg_setas">Estacion<select name="Estacion" class="form-control">';
	if($row['Estacion']=='Primavera')echo '<option value="otono">Otoño</option><option value="primavera" selected="selected">Primavera</option><option value="anual">Anual</option></select></label></div>';
	if($row['Estacion']=='Otono')echo '<option value="otono"  selected="selected">Otoño</option><option value="primavera">Primavera</option><option value="anual">Anual</option></select></label></div>';
	if($row['Estacion']=='Anual')echo '<option value="otono">Otoño</option><option value="primavera">Primavera</option><option value="anual"  selected="selected">Anual</option></select></label></div>';
	if($row['Estacion']!='Otono' && $row['Estacion']!='Primavera' && $row['Estacion']!='Anual') echo '<option value=""></option><option value="otono">Otoño</option><option value="primavera">Primavera</option><option value="anual">Anual</option></select></label></div>';
	echo '<div class="form-group col-xs-12 col-md-5 col-lg-5 col-md-offset-2"><label id="reg_setas">Nombre Popular<input type="text" class="form-control" name="NomPopu" value="'.$row['NomPopu'].'"></label></div>';

	if($row['mortal']=='1')echo '<div class="form-group col-xs-6 col-md-2 col-lg-2"><label id="reg_setas">Mortal <input type="checkbox" name="mortal" id="checkbox" value="1" checked></label></div>';
	else echo '<div class="form-group col-xs-6 col-md-2 col-lg-2"><label id="reg_setas">Mortal <input type="checkbox" name="mortal" id="checkbox" value="1"></label></div>';
	if($row['comestible']=='1')echo '<div class="form-group col-xs-6 col-md-2 col-lg-2"><label id="reg_setas">Comestible <input type="checkbox"  name="comestible" id="checkbox" value="1" checked></label></div>';
	else echo '<div class="form-group col-xs-6 col-md-2 col-lg-2"><label id="reg_setas">Comestible <input type="checkbox"  name="comestible" id="checkbox" value="1"></label></div>';
	
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
echo'<script type="text/javascript">$(document).ready(function(){$("html[dir=ltr]").append('.$row['Descripcion'].');});</script>';
?>
