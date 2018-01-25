<?php
require("header.php");
$seta= new Seta();
$foto= new Foto();
$id=$_REQUEST['id'];
$xs=$_REQUEST['xs'];
$fotos=array();

$row = $seta->consultar_unaseta($id);
if(isset($_REQUEST['enviar_fotos'])){
	$sw=$foto->subir_foto($id);
	header("Location: consultar.php?id=".$id."&xs=".$xs);
}
if(isset($_REQUEST['borrar_fotos'])){
	$sw=$foto->borrar_foto($id);
	header("Location: consultar.php?id=".$id."&xs=".$xs);
}
if(isset($_REQUEST['anadir_catglobal'])){
	$seta->anadir_catglob($id);
	header("Location: consultar.php?id=".$id."&xs=".$xs);
}
if(isset($_REQUEST['quitar_catglobal'])){
	$seta->quitar_catglob($id);
	header("Location: consultar.php?id=".$id."&xs=".$xs);
}

echo "<div id='marco_imagen' style='overflow:hidden;'>";
echo '<div id="botonera" style="overflow:hidden;margin-bottom: 15px;">';
if($xs==1){
	echo '<div id="volver_cat"><a href="catalogoglobal.php" class="btn btn-link glyphicon glyphicon-arrow-left" style="float:left;font-size: 1.5vw;"> Volver al catalogo</a></div>';
}else{
	echo '<div id="volver_cat"><a href="catalogoprop.php" class="btn btn-link glyphicon glyphicon-arrow-left" style="float:left;font-size: 1.5vw;"> Volver al catalogo</a></div>';
}
	echo '<h3 id="Nombre_imagenes">'.$row['Nombre'].'</h3>';
	echo "</div>";
	$fotos=$foto->consultar_primerafoto($row['ID']);
	if(count($fotos)!=1){		
		if (isset($_SESSION['usuario']) && $xs != 1){
			echo "<div id='main_image' class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>";
				if(count($fotos)>0){
					echo "<a href='imagenes/".$fotos["nombre"]."' class='principal' data-fancybox='images'><img src='imagenes/".$fotos["nombre"]."' id='principal' /></a>";
				}else{
					echo "<img src='images/no_foto.jpg' id='principal' />";
				}
				echo "</div><div class='col-xs-12 col-sm-6 col-md-6 col-lg-6 contenido_consultar2'>";
					echo '<div class="form-group col-12"><label id="info_seta">Familia: <span id="consultar_texto">'.$row["Familia"].'</span></label></div>';
					$estacion=$row["Estacion"];
					if($estacion=="Otono")$estacion="Otoño";
					echo '<div class="form-group col-12"><label id="info_seta">Estacion: <span id="consultar_texto">'.$estacion.'</span></label></div>';
					echo '<div class="form-group col-12"><label id="info_seta">Nombre Popular: <span id="consultar_texto">'.$row["NomPopu"].'</span></label></div>';
					echo '<div class="form-group col-12">';
					if($row['comestible']==true){	
						echo '<span class="glyphicon glyphicon-cutlery" title="Comestible" style="font-size: 3vw;"></span>';
					}
					if($row['mortal']==true){	
						echo '<img title="Mortal" src="images/mortal.png" />';
					}
				echo '</div>';
		
			echo "</div><div id='carrusel'>";
			echo "<div id='panel_edicion'><a class='btn btn-link glyphicon glyphicon-plus' id='mas_fotos'> Subir foto</a><a class='btn btn-link glyphicon glyphicon-trash' id='menos_fotos'> Borrar seleccion</a>";


			/************to do*/

			$usu= new Usuario();
			$id_usu=$usu->consultarid();
			$usu=$usu->consultar_usuario($id_usu);
			if($usu['admin']=='si'){
				if($row['Catglob']=="si"){
					// echo '<a id="seta_catglobal">Catalogo Global <input type="checkbox"  name="comestible" id="checkbox_global" value="1" checked></a></div>';
					echo "<a class='btn btn-link glyphicon glyphicon-book' id='quitar_global' name='quitar_global'> Borrar de catalogo global</a>";
				}else{
					echo "<a class='btn btn-link glyphicon glyphicon-book' id='anadir_global' name='anadir_global'> Añadir a catalogo global</a>";
				}
			}

			echo "</div>";



//MOdal confirmar borrado de imagenes
echo '<div class="modal fade" id="Modal_borrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
  echo '<div class="modal-dialog login" role="document">';
    echo '<div class="modal-content">';
      echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="exampleModalLabel">¿Estas seguro que quieres BORRAR?</h5>';
        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
          echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
      echo '</div>';
      echo '<div class="modal-body">';
      	echo '<div id="formulari">';
			echo "<form enctype='multipart/form-data' method='POST' action='consultar.php?id=".$id."&xs=0'>";
				echo '<input type="submit" class="btn btn-secondary botonLogin" id="registro" value="SI" name="borrar_fotos" />';
				echo '<button type="button" class="btn btn-secondary botonLogin" data-dismiss="modal">NO</button>';						
		echo '</div>';						
      echo '</div>';
   echo ' </div>';
  echo '</div>';
echo '</div>';

//MOdal confirmar añadir a catalogo global
echo '<div class="modal fade" id="Modal_catglobal_anadir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
  echo '<div class="modal-dialog login" role="document">';
    echo '<div class="modal-content">';
      echo '<div class="modal-header">';
      echo '<h5 class="modal-title" id="exampleModalLabel">¿Estas seguro que quieres añadirla?</h5>';
        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
          echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
      echo '</div>';
      echo '<div class="modal-body">';
      	echo '<div id="formulari">';
	      	echo "<form enctype='multipart/form-data' method='POST' action='consultar.php?id=".$id."&xs=0'>";
				echo '<input type="submit" class="btn btn-secondary botonLogin" id="catglobal" value="SI" name="anadir_catglobal" />';
				echo '<button type="button" class="btn btn-secondary botonLogin" data-dismiss="modal">NO</button></form>';		
		echo '</div>';						
      echo '</div>';
   echo ' </div>';
  echo '</div>';
echo '</div>';
//MOdal confirmar borrar a catalogo global
echo '<div class="modal fade" id="Modal_catglobal_borrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
  echo '<div class="modal-dialog login" role="document">';
    echo '<div class="modal-content">';
      echo '<div class="modal-header">';
       	echo '<h5 class="modal-title" id="exampleModalLabel">¿Estas seguro que quieres quitarla?</h5>';
        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
          echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
      echo '</div>';
      echo '<div class="modal-body">';
      	echo '<div id="formulari">';
      		echo "<form enctype='multipart/form-data' method='POST' action='consultar.php?id=".$id."&xs=0'>";
				echo '<input type="submit" class="btn btn-secondary botonLogin" id="catglobal" value="SI" name="quitar_catglobal" />';
				echo '<button type="button" class="btn btn-secondary botonLogin" data-dismiss="modal">NO</button></form>';		
		echo '</div>';						
      echo '</div>';
   echo ' </div>';
  echo '</div>';
echo '</div>';

			echo "<div id='carrusel_image'>";
			$result2=$foto->consultar_fotos($row['ID']);
			for ($i=0; $fotos2 = mysqli_fetch_array($result2,MYSQLI_ASSOC) ; $i++) { 
			 	 echo "<label><input type='checkbox' name='borrar[]' value='".$fotos2['nombre']."' id='checkbox_seta'><label><img src='imagenes/".$fotos2['nombre']."' id='imagen_carru".$i."' /></label></label>";
			 }  
			echo "</div></form>";
		}else{
			echo "<div id=galeria>";
			echo "<div id='main_image' class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>";
				if(count($fotos)>0){
					echo "<a href='imagenes/".$fotos["nombre"]."' class='principal' data-fancybox='images'><img src='imagenes/".$fotos["nombre"]."' id='principal' /></a>";
				}else{
					echo "<img src='images/no_foto.jpg' id='principal' />";
				}
				echo "</div><div class='col-xs-12 col-sm-6 col-md-6 col-lg-6 contenido_consultar2'>";
					echo '<div class="form-group col-12"><label id="info_seta">Familia: <span id="consultar_texto">'.$row["Familia"].'</span></label></div>';
					$estacion=$row["Estacion"];
					if($estacion=="Otono")$estacion="Otoño";
					echo '<div class="form-group col-12"><label id="info_seta">Estacion: <span id="consultar_texto">'.$estacion.'</span></label></div>';
					echo '<div class="form-group col-12"><label id="info_seta">Nombre Popular: <span id="consultar_texto">'.$row["NomPopu"].'</span></label></div>';
					echo '<div class="form-group col-12">';
					if($row['comestible']==true){	
						echo '<span class="glyphicon glyphicon-cutlery" title="Comestible" style="font-size: 3vw;"></span>';
					}
					if($row['mortal']==true){	
						echo '<img title="Mortal" src="images/mortal.png" />';
					}
				echo '</div>';
			echo "</div>";		
			echo "<div id='carrusel' style='margin-top: 20px;''>";
			echo "<div id='carrusel_image'>";
			$result2=$foto->consultar_fotos($id);
			for ($i=0; $fotos2 = mysqli_fetch_array($result2,MYSQLI_ASSOC) ; $i++) { 
				echo "<label><img src='imagenes/".$fotos2['nombre']."' id='imagen_carru".$i."' /></label>";
			} 
			echo "</div></div>";
		}

	echo "</div>";
	}else{
		echo "<div id='panel_edicion'><a class='btn btn-link glyphicon glyphicon-plus' id='mas_fotos'> Subir foto</a></div>";
	}
	echo "</div><div class='contenido_consultar'>";
	echo '<div class="form-group col-xs-12 col-md-12 col-lg-12"><label id="info_seta">Descripcion </label></div>';
	echo '<div class="form-group col-xs-12 col-md-12 col-lg-12" style="text-align: left;text-transform: none;"><span id="descripcion_seta">'.$row["Descripcion"].'</span></label></div>';
echo "</div></section>";	
?>
<div class="modal fade" id="Modal_fotos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog login" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Introduces las fotos que quieras!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div id="formulari">
				<?php echo "<form enctype='multipart/form-data' method='POST' action='consultar.php?id=".$id."&xs=0'>";?>

				<div class="form-group col-xs-12 col-md-12 col-lg-12 fotos0"><a id="menos" style="color: #760505;display: none;margin: 0 15px 0 0;    float: right;" name="menos" class="btn btn-danger glyphicon glyphicon-minus"></a><a id="plus" style="color: #276a02;margin: 0 15px 0 0;    float: right;" name="mas" class="btn btn-success glyphicon glyphicon-plus"></a><label id="reg_setas">Foto<input type="file" class="form-control" name="imagen0"/></label></div>
				<div id="nuevos_input"></div>
				<input type="submit" class="btn btn-secondary botonLogin" id="foto_nueva" value="Enviar_fotos" name="enviar_fotos" />
				<button type="button" class="btn btn-secondary botonLogin" data-dismiss="modal">Close</button>
			</form>							
		</div>						
      </div>
    </div>
  </div>
</div>
<div id="popup" style="display: none; width: 560px;"></div>
<?php
require("footer.php");
?>
