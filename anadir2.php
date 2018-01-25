<?php
require("header.php");
echo "<div class='contenido_registro'>";
	$usuario=new Usuario();
	$sw=false;
	if(isset($_REQUEST['enviar4'])){				
		$usuario->nombre=$_REQUEST['usuario'];
		$usuario->correo=$_REQUEST['correo'];
		$usuario->pwd=$_REQUEST['pwd'];
		$usuario->foto_usuario=$_REQUEST['foto_perfil'];
		if($_REQUEST['pwd']==$_REQUEST['pwd2']){
			if($usuario->existe()==true){
				$error="El usuario ya existe, pruebe con otro nombre.";
					setcookie("error",$error);
				header("Location: anadir2.php");
			}else {	
				$sw=$usuario->anadir();	
				if($sw==true){
					$_SESSION['usuario']=$_REQUEST['usuario'];
						header("Location: index.php");
				}else{
					$error="El nombre o la foto ya existe en nuestro servidor.";
					setcookie("error",$error);
					header("Location: anadir2.php");
				} 
			}
		}else{
			$error="Las contraseñas no coinciden.";
			setcookie("error",$error);
			header("Location: anadir2.php");
		} 
	}else $usuario->formu();
echo "</div>";
require("footer.php");
?>

