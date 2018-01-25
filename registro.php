<?php
require("header.php");
$cont=$_REQUEST['cont'];
if ($cont == 0){
	$usu=new Usuario();
	$usu->iniciar();
}
if (isset($_SESSION['usuario'])){
	header("Location: catalogoprop.php");
}else{
	$error="Nombre o contraseña equivocados, vuelva a intentarlo.";
	setcookie("error",$error);
	header("Location: index.php");
}
require("footer.php");
?>