<?php
//fin del registrador y cominenzo del cuerpo***********************************************************************************
require("header.php");
$seta= new Seta();
$foto= new Foto();
$usu= new Usuario();
$id_usu=$usu->consultarid();
if(isset($_REQUEST['borrar_si'])){
	$id=$_REQUEST['id'];
	$sw=$seta->borrar_seta($id);

	if($sw==true){
		$error="Seta borrada correctamente.";
		setcookie("error",$error);
		header("Location: catalogoprop.php");
	}else{
		$error="La seta no se a podido borrar.";
		setcookie("error",$error);
		header("Location: catalogoprop.php");
	}
}
echo '<div id="banner_wrapper">';
echo "<div class='nuevaSeta1 col-12' id='nuevaSeta'><a href='anadir.php' class='col-xs-12 btn btn-success' style='width: 14%;margin-left: 20px;'>Añadir Seta</a>";
echo '<form action="#">';
	echo "<div class='buscar_seta col-6' id='buscar_seta'>";
		echo '<input type="text" value="" class="form-control search" name="bus"  placeholder="Buscar" />';
		echo '<button type="submit" class="glyphicon glyphicon-search" name="buscar" id="search"/></a>';
	echo "</div>";
echo '</form></div>';
if (isset($_REQUEST['buscar']) && $_REQUEST['bus']!="") {
	$cont=0;
	$result = $seta->buscar_catprop($id_usu);
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		if(!$row) echo "<h2 id='tuCatVacio'>¡ TODAVIA NO TIENES NINGUNA SETA !</h2>";
			echo "<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3' style='margin-top: 40px;'>";
			  echo "<div id='sets'>";
				echo "<a href='#Modal_borrar".$cont."' data-toggle='modal' title='Borrar seta' class='glyphicon glyphicon-trash borrarseta' id='borrar_seta".$cont."'></a><div id='pro_classes'><h3><a title='Modificar datos' href='consultar.php?id=".$row['ID']."&xs=0'>".$row['Nombre']."</a></h3></div>";
				echo '<a href="modificar_seta.php?id='.$row['ID'].'" class="glyphicon glyphicon-pencil" id="borrar_seta">'; 
				//Modal borrar seta

				echo '<div class="modal fade" id="Modal_borrar'.$cont.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
				 echo '<div class="modal-dialog login" role="document">';
				   echo '<div class="modal-content">';
				     echo '<div class="modal-header">';
				       echo '<h5 class="modal-title" id="exampleModalLabel">¿Estas seguro que quieres BORRAR?</h5>';
				       echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
				         echo '<span aria-hidden="true">&times;</span>';
				       echo '</button>';
				     echo '</div>';
				     echo '<div class="modal-body">';
						echo '<form method="POST" action="catalogoprop.php?id='.$row['ID'].'"><input type="submit" class="btn btn-secondary botonLogin" name="borrar_si" value="SI">';
						echo '<button type="button" class="btn btn-secondary botonLogin" data-dismiss="modal">Close</button></form>';
				      echo '</div>';
				    echo '</div>';
				  echo '</div>';
				echo '</div>';
				$cont++;
				$fotos=$foto->consultar_primerafoto($row['ID']);
				if(count($fotos)>0){
					echo "<div class='image_wrapper'><a href='consultar.php?id=".$row['ID']."&xs=0'><img src='imagenes/".$fotos['nombre']."'></img></a></div>";									
				}else{
					echo "<div class='image_wrapper'><a href='consultar.php?id=".$row['ID']."&xs=0'><img src='images/no_foto.jpg'></div>";
				}		
			echo "</div></div>";
	}
}else{
$cont=0;
$result = $seta->consultar_catprop($id_usu);
while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	if(!$row) echo "<h2 id='tuCatVacio'>¡ TODAVIA NO TIENES NINGUNA SETA !</h2>";
			echo "<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3' style='margin-top: 40px;'>";
			  echo "<div id='sets'>";
				echo "<a href='#Modal_borrar".$cont."' data-toggle='modal' title='Borrar seta' class='glyphicon glyphicon-trash borrarseta' id='borrar_seta".$cont."'></a><div id='pro_classes'><h3><a href='consultar.php?id=".$row['ID']."&xs=0'>".$row['Nombre']."</a></h3></div>";
				echo '<a href="modificar_seta.php?id='.$row['ID'].'" class="glyphicon glyphicon-pencil" title="Modificar datos" id="modificar_seta"></a>';
				//Modal borrar seta

				echo '<div class="modal fade" id="Modal_borrar'.$cont.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
				 echo '<div class="modal-dialog login" role="document">';
				   echo '<div class="modal-content">';
				     echo '<div class="modal-header">';
				       echo '<h5 class="modal-title" id="exampleModalLabel">¿Estas seguro que quieres BORRAR?</h5>';
				       echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
				         echo '<span aria-hidden="true">&times;</span>';
				       echo '</button>';
				     echo '</div>';
				     echo '<div class="modal-body">';
						echo '<form method="POST" action="catalogoprop.php?id='.$row['ID'].'"><input type="submit" class="btn btn-secondary botonLogin" name="borrar_si" value="SI">';
						echo '<button type="button" class="btn btn-secondary botonLogin" data-dismiss="modal">Close</button></form>';
				      echo '</div>';
				    echo '</div>';
				  echo '</div>';
				echo '</div>';
				$cont++;
				$fotos=$foto->consultar_primerafoto($row['ID']);
				if(count($fotos)>0){
					echo "<div class='image_wrapper'><a href='consultar.php?id=".$row['ID']."&xs=0'><img src='imagenes/".$fotos['nombre']."'></img></a></div>";									
				}else{
					echo "<div class='image_wrapper'><a href='consultar.php?id=".$row['ID']."&xs=0'><img src='images/no_foto.jpg'></div>";
				}		
			echo "</div></div>";
}
}
echo "</div>";
include("footer.php");
?>
