<?php
require("header.php");
$mensaje= new Mensaje();
$usua=new Usuario();
$hilo= new Hilo();
$id=$_REQUEST['id'];
$array_hilo=$hilo->consultar_unhilo($id);
echo '<div id="banner_wrapper">';
echo '<div id="volver_foro"><a href="foro.php" class="btn btn-link glyphicon glyphicon-arrow-left" style="float:left;font-size: 1.5vw;color:white;margin-bottom:5px;"> Volver al foro</a></div>';
echo '<div id="titulo_mensaje">'.$array_hilo['titulo'].'</div>';
$result = $mensaje->consultar_mensajes($array_hilo['id']);
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$usuario=$usua->consultar_usuario($row['id_usuario']);
		echo '<a style="text-decoration:none"><div class="col-12 hilo">';
			if($usuario['foto']!=""){			
				echo '<div  id="perfil_foro"><div id="foto"><img id="fotoperfil" src="imagenes/fotos_perfil/'.$usuario['foto'].'"></div><div id="texto"><span> '.$usuario['usuario'].'</span><span>'.$row['fecha'].'</span></div></div>';
			}else{
				echo '<div  id="perfil_foro"><div id="foto"><img id="fotoperfil" src="imagenes/fotos_perfil/sinfoto.jpg"></div><div id="texto"><span> '.$usuario['usuario'].'</span><span>'.$row['fecha'].'</span></div></div>';
			}
			echo '<div id="mensaje_hilo">'.$row['mensaje'].'</div>';
		echo '</div></a>';
	}
if (isset($_SESSION['usuario'])){
	echo '<div id="cuadro_texto">';
	echo "<form method='POST' action='anadir_mensaje.php?id=".$id."' id='formu_mensaje'>";	
	echo '<textarea id="mensaje_escribir" name="mensaje_escribir" placeholder="Escribe aquí el comentario..."></textarea>';
	if($foto_perfil!=""){			
		echo '<div  id="perfil_foro_mensaje"><div id="foto"><img id="fotoperfil" src="imagenes/fotos_perfil/'.$foto_perfil.'"></div><div id="texto"><span> '.$_SESSION['usuario'].'</span></div>';
	}else{
		echo '<div  id="perfil_foro_mensaje"><div id="foto"><img id="fotoperfil" src="imagenes/fotos_perfil/sinfoto.jpg"></div><div id="texto"><span> '.$_SESSION['usuario'].'</span></div>';
	}	
	echo '<input type="submit" name="enviar_mensaje" value="Enviar" class="btn btn-success btn-lg enviar_mensaje" /></div></form>';
	echo '</div>';
}else{
	echo '<div id="mensaje_registrate">Para escribir tienes que estar logueado, registrate<a href="anadir2.php">  AQUI</a></div>';
}
echo '</div>';
require("footer.php");
?>