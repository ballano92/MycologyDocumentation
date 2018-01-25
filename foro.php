<?php
require("header.php");
$hilo= new Hilo();
$usua=new Usuario();
echo '<div id="banner_wrapper">';
echo "<div class='nuevohilo col-12' id='nuevohilo'>";
if (isset($_SESSION['usuario'])){
	echo "<a id='anadir_hilo' class='col-xs-12 btn btn-success' style='width: 14%;margin-left: 20px;overflow: hidden;'>Añadir hilo</a>";
}
echo '<form action="#">';
	echo "<div class='buscar_seta col-6' id='buscar_seta'>";
		echo '<input type="text" value="" class="form-control search" name="bus"  placeholder="Buscar" />';
		echo '<button type="submit" class="glyphicon glyphicon-search" name="buscar" id="search"/></a>';
	echo "</div>";
echo '</form></div>';
echo '<div id="titulo_foro">Foro</div>';
if (isset($_REQUEST['buscar']) && $_REQUEST['bus']!="") {
	$result = $hilo->buscar_hilos();
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo '<a href="mensajes.php?id='.$row['id'].'" style="text-decoration:none"><div class="col-12 hilo">';
		$usuario=$usua->consultar_usuario($row['id_usuario']);
		echo '<a href="mensajes.php" style="text-decoration:none"><div class="col-12 hilo">';
			if($usuario['foto']!=""){			
				echo '<div  id="perfil_foro"><div id="foto"><img id="fotoperfil" src="imagenes/fotos_perfil/'.$usuario['foto'].'"></div><div id="texto"><span> '.$usuario['usuario'].'</span><span>'.$row['fecha'].'</span></div></div>';
			}else{
				echo '<div  id="perfil_foro"><div id="foto"><img id="fotoperfil" src="imagenes/fotos_perfil/sinfoto.jpg"></div><div id="texto"><span> '.$usuario['usuario'].'</span><span>'.$row['fecha'].'</span></div></div>';
			}
			echo '<div id="titulo_hilo">'.$row['titulo'].'</div>';
		echo '</div></a>';
	}
}else{
	$result = $hilo->consultar_hilos();
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo '<a href="mensajes.php?id='.$row['id'].'" style="text-decoration:none"><div class="col-12 hilo">';
		$usuario=$usua->consultar_usuario($row['id_usuario']);
			if($usuario['foto']!=""){			
				echo '<div  id="perfil_foro"><div id="foto"><img id="fotoperfil" src="imagenes/fotos_perfil/'.$usuario['foto'].'"></div><div id="texto"><span> '.$usuario['usuario'].'</span><span>'.$row['fecha'].'</span></div></div>';
			}else{
				echo '<div  id="perfil_foro"><div id="foto"><img id="fotoperfil" src="imagenes/fotos_perfil/sinfoto.jpg"></div><div id="texto"><span> '.$usuario['usuario'].'</span><span>'.$row['fecha'].'</span></div></div>';
			}
			echo '<div id="titulo_hilo">'.$row['titulo'].'</div>';
		echo '</div></a>';
	}
	if (isset($_SESSION['usuario'])){
		echo '<div id="cuadro_texto" class="new_hilo" style="display:none">';
		echo "<form method='POST' action='anadir_hilo.php' id='formu_mensaje'>";	
		echo '<textarea id="hilo_escribir" name="titulo_hilo" placeholder="Escribe aquí el titulo..."></textarea>';		
		echo '<div  id="perfil_foro_hilo"><input type="submit" name="enviar_hilo" value="Enviar" class="btn btn-success btn-lg enviar_hilo" /></div>';
		echo '</div></form>';
		echo '</div>';
	}
}
echo '</div>';
require("footer.php");
?>