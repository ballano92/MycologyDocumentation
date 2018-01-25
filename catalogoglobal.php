<?php
//fin del registrador y cominenzo del cuerpo***********************************************************************************
			require("header.php");
			$seta= new Seta();
			$foto= new Foto();
			$usu= new Usuario();			
				echo '<div id="banner_wrapper"><div class="nuevaSeta1 col-12" id="nuevaSeta">';
				echo '<form action="#">';
					echo "<div class='buscar_seta col-6' id='buscar_seta'>";
						echo '<input type="text" value="" class="form-control search" name="bus"  placeholder="Buscar" />';
						echo '<button type="submit" class="glyphicon glyphicon-search" name="buscar" id="search"/></a>';
					echo "</div>";
				echo '</form></div>';
			if (isset($_REQUEST['buscar']) && $_REQUEST['bus']!="") {
				$result = $seta->buscar_catglob();
				if(mysqli_num_rows($result)!=0){
					while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					echo "<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3' style='margin-top: 40px;'>";
					echo "<div id='sets'>";
						echo "<div id='pro_classes' style='width:100%'><h3><a href='consultar.php?id=".$row['ID']."&xs=1'>".$row['Nombre']."</a></h3></div>";
						$result_fotos=$foto->consultar_fotos($row['ID']);
						$fotos=$result_fotos->fetch_assoc();
						if(count($fotos)!=1){
							echo "<div class='image_wrapper'><a href='consultar.php?id=".$row['ID']."&xs=1'><img src='imagenes/".$fotos['nombre']."'></img></a></div>";									
						}else{
							echo "<div class='image_wrapper'><a href='consultar.php?id=".$row['ID']."&xs=1'><img src='images/no_foto.jpg'></a></div>";
						}							
					echo "</div></div>";	
					}
				}else{echo "<h3>0 Resultados en su busqueda.</h3>";}
				echo "</div>";
			}else{	
				$result = $seta->consultar_catglob();
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					echo "<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3' style='margin-top: 40px;'>";
					echo "<div id='sets'>";
						echo "<div id='pro_classes' style='width:100%'><h3><a href='consultar.php?id=".$row['ID']."&xs=1'>".$row['Nombre']."</a></h3></div>";
						$result_fotos=$foto->consultar_fotos($row['ID']);
						$fotos=$result_fotos->fetch_assoc();
						if(count($fotos)!=1){
							echo "<div class='image_wrapper'><a href='consultar.php?id=".$row['ID']."&xs=1'><img src='imagenes/".$fotos['nombre']."'></img></a></div>";									
						}else{
							echo "<div class='image_wrapper'><a href='consultar.php?id=".$row['ID']."&xs=1'><img src='images/no_foto.jpg'></a></div>";
						}							
					echo "</div></div>";	
				}
				echo "</div>";
			}
			include("footer.php");
			 ?>
