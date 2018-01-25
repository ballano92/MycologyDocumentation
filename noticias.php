<?php
require("header.php");
$noticia= new Noticia();
$usu= new Usuario();			
				echo '<div id="banner_wrapper"><div class="nuevaSeta1 col-12" id="nuevaSeta">';
				if (isset($_SESSION['usuario'])){
					if($usu->consultar_admin()==true){
						echo '<a href="anadir_noticia.php" class="col-xs-12 btn btn-success" style="width: 14%;margin-left: 20px;">Añadir noticia</a>';
					}
				}
				echo '<form action="#">';
					echo "<div class='buscar_seta col-6' id='buscar_seta'>";
						echo '<input type="text" value="" class="form-control search" name="bus"  placeholder="Buscar" />';
						echo '<button type="submit" class="glyphicon glyphicon-search" name="buscar" id="search"/></a>';
					echo "</div>";
				echo '</form></div>';
			if (isset($_REQUEST['buscar']) && $_REQUEST['bus']!="") {
				$result = $noticia->buscar_noticia();
				if(mysqli_num_rows($result)!=0){
					while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					echo "<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3' style='margin: 60px 1vw 1vw 1vw;'>";
					echo "<div id='noticia'>";
						echo "<div id='titulo_noticia' style='width:100%'><h3><a href='consultar.php?id=".$row['id']."&xs=1'>".$row['titullo']."</a></h3></div>";
						echo "<div class='image_wrapper'><a href='consultar_noticia.php?id=".$row['id']."'><img src='imagenes/fotos_noticias/".$row['foto']."'></img></a></div>";												
					echo "</div></div>";
					}	
				}else{echo "<h3>0 Resultados en su busqueda.</h3>";}
				echo "</div>";
			}else{	
				$result = $noticia->consultar_noticias();
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					echo "<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3' style='margin: 60px 1vw 1vw 1vw;'>";
					echo "<div id='noticia'>";
						echo "<div id='titulo_noticia' style='width:100%'><h3><a href='consultar.php?id=".$row['id']."&xs=1'>".$row['titulo']."</a></h3></div>";
						echo "<div class='image_wrapper'><a href='consultar_noticia.php?id=".$row['id']."'><img src='imagenes/fotos_noticias/".$row['foto']."'></img></a></div>";													
					echo "</div></div>";	
				}
				echo "</div>";
			}
			include("footer.php");
			 ?>
