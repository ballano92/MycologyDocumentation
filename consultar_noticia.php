<?php
require("header.php");
$noticia= new Noticia();
$usu= new Usuario();
$id=$_REQUEST['id'];
$row = $noticia->consultar_unanoticia($id);
echo '<div id="banner_wrapper">';
echo '<div id="volver_foro"><a href="noticias.php" class="btn btn-link glyphicon glyphicon-arrow-left" style="float:left;font-size: 1.5vw;color:white;margin-bottom:10px;"> Volver al foro</a></div>';
echo "<div class='contenido_noticia'>";
echo '<div id="titulo_noticia">'.$row['titulo'].'</div>';
echo '<div><img src="imagenes/fotos_noticias/'.$row['foto'].'" id="foto_noticia"></div>';
echo '<div id="noticia_texto">'.$row['texto'].'</div>';
echo '</div></div>';
include("footer.php");
?>