<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AMC</title>
<link rel="shortcut icon" href="images/favicon.ico">
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Cabin+Sketch|Diplomata+SC|Gloria+Hallelujah|Monoton" rel="stylesheet">
<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="fancybox-3.0/dist/jquery.fancybox.min.css?v=2.1.5" media="screen" />

<?php 
	session_start();
	require("class.php");
	if (isset($_REQUEST['cerrarsesion'])){
		session_destroy();
		header("Location: index.php");
	}
?>
</head>
<body>
<div id="container" style="overflow: hidden;">
	<div class="row col">
    	<div class="col-xs-12 col-md-12 col-lg-12" style="padding: 0 -15px;">
	    	<div>
				<div class="panel-body col-xs-12 col-md-12 col-lg-12 header" id="menu">
					<div id="pull">
						<a id="hamburguesa" href="#"></a>
						<img class="hidden-lg hidden-md" id="fotologo" src="images/logo2.png" style="height:50px;">
						<?php
						if (isset($_SESSION['usuario'])){	
							$usuari=new Usuario();	
							$id_usu_foto=$usuari->consultarid();
							$foto_perfil=$usuari->consultar_usuario_foto();
							if($foto_perfil!=""){
								echo '<div  id="perfil" class="hidden-lg hidden-md">'.$_SESSION['usuario'].'  <img id="fotoperfil" src="imagenes/fotos_perfil/'.$foto_perfil.'"></img></div>';
							}else{
								echo '<div  id="perfil" class="hidden-lg hidden-md">'.$_SESSION['usuario'].'  <img id="fotoperfil" src="imagenes/fotos_perfil/sinfoto.jpg"></img></div>';
							}
						}
						?>
					</div>
						<div class="menuregistrado">
							<?php 
							 if (isset($_SESSION['usuario'])){							 				
								echo '<div id="menus" class="home"><img class="hidden-xs hidden-sm" id="fotologo" src="images/logo2.png" style="height:5vw;margin-top:-1.3vw;margin-left: 0.5vw;"><a href="index.php" class="glyphicon glyphicon-home" title="Home" style="float: right;margin-right: 1vw;"></a></div>';							
								echo '<div id="menus" class="catalogoglobal"><a href="catalogoglobal.php" title="Catalogo global">Catálogo<span id="flecha" class="hidden-lg hidden-md">></span></a></div>';
								echo '<div id="menus" class="foro"><a href="foro.php" title="Foro">Foro<span id="flecha" class="hidden-lg hidden-md">><span></a></div>';
								echo '<div id="menus" class="noticias"><a href="noticias.php" title="Noticias">Noticias<span id="flecha" class="hidden-lg hidden-md">><span></a></div>';
								echo '<div id="menus" class="informacion"><a href="informacion.php" title="Informacion">Información<span id="flecha" class="hidden-lg hidden-md">><span></a></div>';							
								echo '<div  id="menus" class="catalogoprop"><a href="catalogoprop.php" tittle="catalogo propio">Mi catálogo<span id="flecha" class="hidden-lg hidden-md">><span></a></div>';
								echo '<div  id="cerSesion"><form action="index.php"><input type="submit" class="btn menuCeSesion" name="cerrarsesion" value="Cerrar sesion"></div></form>';
								$foto_perfil=$usuari->consultar_usuario_foto();
								if($foto_perfil!=""){
									echo '<div  id="perfil" class="hidden-xs hidden-sm">'.$_SESSION['usuario'].'  <img id="fotoperfil" src="imagenes/fotos_perfil/'.$foto_perfil.'"></img></div>';
								}else{
									echo '<div  id="perfil" class="hidden-xs hidden-sm">'.$_SESSION['usuario'].'  <img id="fotoperfil" src="imagenes/fotos_perfil/sinfoto.jpg"></img></div>';
								}
							}else{
								echo '<div id="menus2" class="home"><img class="hidden-xs hidden-sm" id="fotologo" src="images/logo2.png" style="height:5vw;margin-top:-1.3vw;margin-left: 0.5vw;"><a href="index.php" class="glyphicon glyphicon-home" title="Home" style="float: right;    margin-right: 1vw;"></a></div>';							
								echo '<div id="menus2" class="catalogoglobal"><a href="catalogoglobal.php" title="Catalogo global">Catálogo<span id="flecha" class="hidden-lg hidden-md">></span></a></div>';
								echo '<div id="menus2" class="foro"><a href="foro.php" title="Foro">Foro<span id="flecha" class="hidden-lg hidden-md">><span></a></div>';
								echo '<div id="menus2" class="noticias"><a href="noticias.php" title="Noticias">Noticias<span id="flecha" class="hidden-lg hidden-md">><span></a></div>';
								echo '<div id="menus2" class="informacion"><a href="informacion.php" title="Informacion">Información<span id="flecha" class="hidden-lg hidden-md">><span></a></div>';
								echo '<div id="menus2" class="registrate"><a href="anadir2.php" title="Registrate">Registrarse<span id="flecha" class="hidden-lg hidden-md">></span></a></div>';
								echo '<div id="menus2" class="iniciar"><a name="registrarse" title="Iniciar sesion" id="botonregistro">Login<span id="flecha" class="hidden-lg hidden-md">></span></a></div>';
							}?>		
						</div>				
					
				</div>
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog login" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">REGISTRATE!</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				      	<div id="formulari">
							<form method='POST' action='registro.php?cont=0'>
								<div class="form-inline"><label id="nombreLogin" style="height: 40px;padding-top: 10px;">Nombre: </label><input type="text" class="form-control" id="nombre" placeholder="Introduce tu nombre" name="usuario" style="float:right;"></div>
								<div class="form-inline"><label id="nombreLogin" style="height: 40px;padding-top: 10px;">Contraseña: </label><input type="password" class="form-control" id="pwd" placeholder="Introduce tu pass" name="pwd" style="float:right;"></div>
							<input type="submit" class="btn btn-secondary botonLogin" id="registro" value="Entrar" name="entrar" />
							<button type="button" class="btn btn-secondary botonLogin" data-dismiss="modal">Close</button>
							</form>							
						</div>						
				      </div>
				    </div>
				  </div>
				</div>
				<div class="panel-body">