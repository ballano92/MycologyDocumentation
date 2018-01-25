<?php
function modificar($datos){
	$cont=0;
	echo "<form method='POST' action='modificar.php?id=".$_REQUEST['id']."'>";
	echo "<table border='1' align='center'>";
	foreach($datos as $campo => $valor){
		echo "<tr><td>".$campo."</td>";
		if($cont==0) echo "<td><input type='text' name='$campo' value='$valor' readonly='readonly'></td></tr>";
		else if($campo!='Descripcion') echo "<td><input type='text' name='$campo' value='$valor'></td></tr>";
		else echo "<td><textarea type='text' rows='10' cols='150' name='$campo'>$valor</textarea></td></tr>";
		$cont++;
	}
	echo "</table>";
	echo "<p align='center'><input type='submit' name='enviar' value='modificar'></p></form>";
}
function consultar_todosid($tabla){
	global $enlace;
	$result = mysqli_query($enlace,"SELECT ID FROM $tabla");
	for ($i=0; $row = mysqli_fetch_array($result,MYSQLI_ASSOC) ; $i++) { 
		$row2[$i]=$row['ID'];
	}
	// $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	return $row2;
}
function consultar($id, $tabla, $campo){
	global $enlace;
	$result = mysqli_query($enlace,"SELECT * FROM $tabla where $campo='$id'");
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	return $row;
}
function borrar($id, $tabla, $campo){
	global $enlace;
	if(!isset($_REQUEST['si'])&&!isset($_REQUEST['no'])){
		echo "<form action='borrar.php?id=".$id."' method='POST'>";		
		echo "¿ESTAS SEGURO QUE QUIERES BORRAR?<br>";
		echo "<input type='submit' name='si' value='Aceptar'>";
		echo "<input type='submit' name='no' value='cancelar'></form>";
	}else{
		if(isset($_REQUEST['si'])){
			$result = mysqli_query($enlace,"DELETE FROM $tabla where $campo='$id'");
			if($result) echo "<h1 align=center>¡Seta borrada correctamente!</h1><br>";
			else echo "El Seta no se a podido borrar<br>";
			echo "<form action='productos.php' method='POST'>";
			echo "<p align='center'><input type='submit' name='regis' value='Volver Inicio'></p>";
			echo "</form>";
		}
		if(isset($_REQUEST['no'])){
			echo "El registro no se a borrado<br>";
			echo "<a href='productos.php'>Volver a Inicio</a>";
		}
	}
}

function anadir($datos, $tabla){
	global $enlace;
	$listacampos="(";
	$listavalores="(";
	foreach($datos as $campo => $valor){
		$listacampos.="`".$campo."`,";
		$listavalores.="'".$valor."',";
	}
	$listacampos[strlen($listacampos)-1]=')';
	$listavalores[strlen($listavalores)-1]=')';
	$result=mysqli_query($enlace, "INSERT INTO $tabla $listacampos VALUES $listavalores");
	// $result2=mysqli_query($enlace,"CREATE TABLE ".$datos['usuario']."(ID int(4) auto_increment primary key,Nombre varchar(30) not null,Familia varchar (30) not null,Estacion enum('Otoño', 'Primavera', 'Anual') not null,NomPopu varchar(50) not null,foto varchar(50) not null,Descripcion varchar(2500) not null)");
	return $result;
}
function crea_tabla($datos){
	global $enlace;
	$result2=mysqli_query($enlace,"CREATE TABLE ".$datos['usuario']."(ID int(4) auto_increment primary key,Nombre varchar(30) not null,Familia varchar (30) not null,Estacion enum('Otoño', 'Primavera', 'Anual') not null,NomPopu varchar(50) not null,foto varchar(50) not null,Descripcion varchar(2500) not null)");
}

function mostrar($row){
$tabla="<tr>";
	foreach($row as $index => $valor){
		if($index=='Nombre'){
			$tabla.="<td><h3><a href='consultar.php?id=".$row['ID']."'>".$valor."</a></h3></td>";
			$tabla.="<td><a href='modificar.php?id=".$row['ID']."'>Modificar</a></td>";
			$tabla.="<td><a href='borrar.php?id=".$row['ID']."'>Borrar</a></td>";
		}
	}
$tabla.="</tr>";
echo $tabla;
}
function mostrar2($row, $cont){
	if($cont==0){
		$tabla="<table border=2 align=center><tr>";
		$tabla.="<td>Setas</td>";
		echo $tabla;
	}
	mostrar($row);
}
function salir(){
	// session_start();
	session_destroy();
	setcookie("familia","",time()-3600);
	header("Location: index.php");
}
function subirimg(){
	$swit=false;
	// if ($_FILES["imagen"]["error"] > 0){
	// 	echo "ha ocurrido un error";
	// } else {
		//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
		//y que el tamano del archivo no exceda los 100kb
		$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
		$limite_kb = 1000000;
		$cont=0;
		while(count($_FILES)>$cont){
			
			if (in_array($_FILES['imagen'.$cont]['type'], $permitidos) && $_FILES['imagen'.$cont]['size'] <= $limite_kb * 1024){
				//esta es la ruta donde copiaremos la imagen
				//recuerden que deben crear un directorio con este mismo nombre
				//en el mismo lugar donde se encuentra el archivo subir.php
				$ruta = "imagenes/".$_SESSION['usuario']."/" . $_FILES['imagen'.$cont]['name'];
				//comprovamos si este archivo existe para no volverlo a copiar.
				//pero si quieren pueden obviar esto si no es necesario.
				//o pueden darle otro nombre para que no sobreescriba el actual.
				if (!file_exists($ruta)){
					//aqui movemos el archivo desde la ruta temporal a nuestra ruta
					//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
					//almacenara true o false
					$resultado = move_uploaded_file($_FILES["imagen".$cont]["tmp_name"], $ruta);
					if ($resultado){
						echo "el archivo ha sido movido exitosamente";
						$swit=true;
					} else {
						echo "ocurrio un error al mover el archivo.";
						$swit=false;
					}
				} else {
					echo $_FILES['imagen'.$cont]['name'] . ", este archivo existe";
				}
			} else {
				echo "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
			}
			$cont++;
		}
return $swit;
}
function modificar_foto($fotos, $usuario, $id){
	global $enlace;
	$result=mysqli_query($enlace, "UPDATE $usuario set foto='".$fotos."' WHERE ID='".$id."'");
}
//formulario para dar de alta usuario
function formu(){
		echo "<form method='POST' action='anadir2.php'>";
			echo "<table id='tabla_formu' align='center'>";
			echo "<div class='form-group'><label>Nombre: </label></td><td><input type='text' id='usuario' name='usuario'></td><td><div id='error'></div></td></tr>";
			echo "<tr><td id='text'>Correo: </td><td><input type='text' id='correo' name='correo'></td><td><div id='error2'></div></td></tr>";
			echo "<tr><td id='text'>Contraseña: </td><td><input type='password' name='pwd' id='pwd'></td><td><div id='error3'></div></td></tr>"; 
			echo "<tr><td id='text'>Repeteir contraseña: </td><td><input type='password' name='pwd2' id='pwd2'></td><td><div id='error4'></div></td></tr></table>";
			echo "<input type='submit' name='enviar4' value='añadir'></form>";
			echo "<form action='index.php' method='POST'>";
				echo "<input type='submit' name='regis' value='Volver'>";
		echo "</form>";
}
//panel registro de usuarios
function registrar(){
global $enlace;
if (isset($_REQUEST['enviar2'])) {
	$result = mysqli_query($enlace,"SELECT * FROM usuarios WHERE usuario='".$_REQUEST['usu']."' AND pwd='".$_REQUEST['pass']."'");
	if(mysqli_num_rows($result)!=0){
		$_SESSION['usuario']=$_REQUEST['usu'];
		header("Location: registro.php");//recargar la pagina
	}else{
		echo "<script>alert('usuario o contraseña incorrectos vuelva a intentarlo.');</script>";
	}
}
if (isset($_SESSION['usuario'])){
	echo "<div id='extra3'>";
}else echo "<div id='extra'>";						

// }else{
	if (isset($_REQUEST['salir'])) salir();
	if (!isset($_SESSION['usuario'])) {
		echo "<form action='index.php' method='POST'>";
		echo "<table id='tablaregistro'><tr>";
		echo "<td>";?><input type='submit' onclick="cerrar()" id="cerrarusu" name='cerrarusu' value=''><?php	
		echo "</tr><tr></td><td>Usuario: <br><input type='text' name='usu'></td></tr>";
		echo "<tr><td>Contraseña: <br><input type='password' name='pass'></td></form></tr>";
		echo "<tr><td><input type='submit' name='enviar2' value='Iniciar sesion'></td>";
		echo "</tr></table>";
	}else{
		if (isset($_SESSION['usuario'])) {
			echo "<div id='idusuario'><p>¡Bienvenido!</p>";
			echo "<p>Usuario: ".$_SESSION['usuario'].".</p>";
			echo "<form action='index.php' method='POST'>";
			echo "<input type='submit' name='salir' value='Cerrar sesion'>";
			echo "</form>";
			echo "<form action='anadir.php' method='POST'>";
			echo "<br><input type='submit' name='regiseta' value='Añadir Seta'><br>";
			echo "</form></div>";
		}
	}
// }	
echo '</div>';
}
?>