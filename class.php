<?php
define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'micologia');
	define('DB_CHARSET', 'utf-8');
class Modelo{
	public $_db;
	public function __construct(){
		$this->_db=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($this->_db->connect_error){
			echo "Fallo al conectar a MySQL: ".$this->_db->connect_error;
		}
		$this->_db->set_charset(DB_CHARSET);
	}
}
class Usuario {
	private $id;
	private $nombre;
	private $correo;
	private $pwd;
	private $foto_usuario;
	function __construct(){	}
	public function __set($var,$valor){
		if (property_exists(__CLASS__, $var)){
			$this->$var = $valor;
		} else echo "No existe el atributo".$var;			
	}
	function __get($var){
		if (property_exists(__CLASS__, $var)){
			return $this->$var;
		}
		return NULL;
	}	
	public function consultar_usuario($id){
		$basedatos= new Modelo();
		$result=$basedatos->_db->query("SELECT * FROM usuarios WHERE id='".$id."'");
		$usuario=$result->fetch_assoc();
		return $usuario;
	}
	public function consultar_admin(){
		$basedatos= new Modelo();
		$sw=false;
		$result=$basedatos->_db->query("SELECT * FROM usuarios WHERE usuario='".$_SESSION['usuario']."'");
		$usuario=$result->fetch_assoc();
		if($usuario['admin']=='si'){
			$sw=true;
		}
		return $sw;
	}
	public function consultar_usuario_foto(){
		$basedatos= new Modelo();
		$result=$basedatos->_db->query("SELECT * FROM usuarios WHERE usuario='".$_SESSION['usuario']."'");
		$usuario=$result->fetch_assoc();
		return $usuario['foto'];
	}
	public function consultarid(){
		$basedatos= new Modelo();
		$result=$basedatos->_db->query("SELECT ID FROM usuarios WHERE usuario='".$_SESSION['usuario']."'");
		while ($ids=$result->fetch_assoc()) {
			$id[0]=$ids['ID'];	
		}
		return $id[0];
	}
	public function consultarnombre($id){
		$basedatos= new Modelo();
		$result=$basedatos->_db->query("SELECT usuario FROM usuarios WHERE ID='".$id."'");
		while ($nombres=$result->fetch_assoc()) {
			$nombre[0]=$nombres['usuario'];	
		}
		return $nombre[0];
	}
	public function formu(){
		echo "<form enctype='multipart/form-data' method='POST' action='anadir2.php' id='form_registro'>";
		echo '<div class="form-group col-xs-12 col-md-12 col-lg-12"><label>Nombre<input type="text" class="form-control" name="usuario" placeholder="Introduce tu nombre"></label></div>';
		echo '<div class="form-group col-xs-12 col-md-12 col-lg-12""><label>Correo<input type="email" class="form-control" name="correo" placeholder="Introduce tu email"></label></div>';
		echo '<div class="form-group col-xs-12 col-md-12 col-lg-12""><label>Contrase&ntildea<input type="password" class="form-control" name="pwd" placeholder="Introduce tu pass"></label></div>';
		echo '<div class="form-group col-xs-12 col-md-12 col-lg-12""><label>Repetir contrase&ntildea<input type="password" class="form-control" name="pwd2" placeholder="Repite el pass"></label></div>';
		echo '<div class="form-group col-xs-12 col-md-12 col-lg-12"><label>Foto Perfil<input type="file" class="form-control" name="foto_perfil" /></label></div>';
		echo '<input type="submit" name="enviar4" value="enviar" class="btn btn-success btn-lg" style="margin-right:15px" /><a href="index.php" class="btn btn-lg btn-primary">Volver</a></form>';
	}
	public function iniciar(){
		$basedatos= new Modelo();
		$this->nombre=$_REQUEST['usuario'];
		$this->pwd=$_REQUEST['pwd'];
		$sw=false;
		$result=$basedatos->_db->query("SELECT * FROM usuarios WHERE usuario='".$this->nombre."' AND pwd= AES_ENCRYPT('".$this->pwd."','password')");
		if($df=$result->fetch_assoc()) $sw=true;
		if($sw){
			$_SESSION['usuario']=$this->nombre;
			header("Location: registro.php?cont=1");
		}else{
			echo '<script language="javascript">alert("Usuario o contraseña incorrectos.")</script>';
			header("Location: registro.php?cont=1");
		}
	}
	public function anadir(){
		$basedatos= new Modelo();
		$sw=false;
		$swit=false;
		$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
		$limite_kb = 1000000;
		if (in_array($_FILES['foto_perfil']['type'], $permitidos) && $_FILES['foto_perfil']['size'] <= $limite_kb * 1024){
				$ruta = "imagenes/fotos_perfil/" . $_FILES['foto_perfil']['name'];
				if (!file_exists($ruta)){
					$resultado = move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $ruta);
					if ($resultado){
						$swit=true;					
					} else {
						$swit=false;
						$error="Ocurrio un error al mover el archivo.";
						setcookie("error",$error);						
					}
				} else {
					$error=$_FILES['foto_perfil']['name'].", este archivo existe, cambiele el nombre o comprebe que no lo a subido ya.";
					setcookie("error",$error);					
				}
			} else {
				$error="Archivo no permitido, es tipo de archivo prohibido o excede el tamano de Kilobytes.";
				setcookie("error",$error);
			}
		if($swit==true){
			$listavalores="('".$this->nombre."','".$this->correo."',AES_ENCRYPT('".$this->pwd."','password'),'".$_FILES['foto_perfil']['name']."')";
			if($basedatos->_db->query("INSERT INTO usuarios (usuario,correo,pwd,foto) VALUES $listavalores") === TRUE) $sw=true;
		}
		return $sw;
	}
	public function existe(){
		$basedatos= new Modelo();
		$sw=false;
		$result=$basedatos->_db->query("SELECT * FROM usuarios WHERE usuario='".$this->nombre."'");
		if($df=$result->fetch_assoc()) $sw=true;
		$result=$basedatos->_db->query("SELECT * FROM usuarios WHERE correo='".$this->correo."'");
		if($df=$result->fetch_assoc()) $sw=true;
		return $sw;
	}

	public function cerrar(){
		session_start();
		session_destroy();
	}
}
class Seta{
	private $id;
	private $id_usuario;
	private $catglob;
	private $nombre;
	private $familia;
	private $estacion;
	private $nompopu;
	private $mortal;
	private $comestible;
	private $descripcion;
	function __construct(){	}
	public function __set($var,$valor){
		if (property_exists(__CLASS__, $var)){
			$this->$var = $valor;
		} else echo "No existe el atributo".$var;			
	}
	function __get($var){
		if (property_exists(__CLASS__, $var)){
			return $this->$var;
		}
		return NULL;
	}
	public function consultar_catglob(){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM setas WHERE catglob='si'"))return $result;			
	}
	public function buscar_catglob(){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM setas where nombre like '%".$_REQUEST['bus']."%' AND catglob='si'"))return $result;			
	}
	public function consultar_catprop($id){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM setas where id_usuario='".$id."'"))return $result;		
	}
	public function borrar_seta($id){
		$basedatos= new Modelo();
		$foto= new Foto();
		$result=$foto->consultar_fotos($id);
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
			unlink("imagenes/".$row['nombre']);
		}
		$sw=false;
		if($basedatos->_db->query("DELETE FROM setas where ID='".$id."'")==true){
			if($basedatos->_db->query("DELETE FROM fotos where id_seta='".$id."'")==true)$sw=true;
		}
		return $sw;
	}
	public function consultar_ids(){
		$basedatos= new Modelo();
		$usu= new Usuario();
		if($result=$basedatos->_db->query("SELECT ID FROM setas where id_usuario='".$usu->consultarid()."'"))return $result;	
	}
	public function consultar_unid($id_usu){
		$basedatos= new Modelo();
		$result=$basedatos->_db->query("SELECT ID FROM setas where nombre='".$this->nombre."' AND id_usuario='".$id_usu."'");
		$seta=$result->fetch_assoc();
		return $seta;	
	}
	public function consultar_unaseta($id){
		$basedatos= new Modelo();
		$result=$basedatos->_db->query("SELECT * FROM setas where ID='".$id."'");	
		$seta=$result->fetch_assoc();
		return $seta;
	}
	public function consultar_exist($id){
		$basedatos= new Modelo();
		$sw=false;
		$result=$basedatos->_db->query("SELECT * FROM setas where nombre like '%".$_REQUEST['nombre']."%' AND id_usuario='".$id."'");
		if($df=$result->fetch_assoc()) $sw=true;
		return $sw;			
	}
	public function anadir_seta(){
		$basedatos= new Modelo();
		$sw=false;
		$listacampos="(id_usuario,catglob,Nombre,Familia,Estacion,NomPopu,mortal,comestible,Descripcion)";
		$listavalores="('".$this->id_usuario."','".$this->catglob."','".$this->nombre."','".$this->familia."','".$this->estacion."','".$this->nompopu."','".$this->mortal."','".$this->comestible."','".$this->descripcion."')";
		if($basedatos->_db->query("INSERT INTO setas $listacampos VALUES $listavalores") === TRUE) $sw=true;
		return $sw;
	}
	public function buscar_catprop(){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM setas where nombre like '%".$_REQUEST['bus']."%' AND id_usuario='".$id."'"))return $result;			
	}
	public function modificar_seta($id){
		$basedatos= new Modelo();
		if($this->descripcion=="<p><br></p>"){
            if($result=$basedatos->_db->query("UPDATE setas set Nombre='".$this->nombre."', Familia='".$this->familia."',Estacion='".$this->estacion."',NomPopu='".$this->nompopu."',mortal='".$this->mortal."',comestible='".$this->comestible."' WHERE ID=".$id))return $result;
        }
		if($result=$basedatos->_db->query("UPDATE setas set Nombre='".$this->nombre."', Familia='".$this->familia."',Estacion='".$this->estacion."',NomPopu='".$this->nompopu."',mortal='".$this->mortal."',comestible='".$this->comestible."',Descripcion='".$this->descripcion."' WHERE ID=".$id))return $result;
	}
	public function anadir_catglob($id){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("UPDATE setas set Catglob='si' WHERE ID=".$id));
	}
	public function quitar_catglob($id){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("UPDATE setas set Catglob='no' WHERE ID=".$id));
	}
}
class Foto{
	private $id;
	private $nombre;
	private $id_seta;
	function __construct(){	}
	public function __set($var,$valor){
		if (property_exists(__CLASS__, $var)){
			$this->$var = $valor;
		} else echo "No existe el atributo".$var;			
	}
	function __get($var){
		if (property_exists(__CLASS__, $var)){
			return $this->$var;
		}
		return NULL;
	}
	public function consultar_primerafoto($id){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM fotos WHERE id_seta='".$id."'")){
			$fotos=$result->fetch_assoc();
			return $fotos;
		}
	}
	public function consultar_fotos($id){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM fotos WHERE id_seta='".$id."'"))return $result;
	}
	public function subir_foto($id){
		$basedatos= new Modelo();		
		$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
		$limite_kb = 1000000000000;
		$cont=0;
		while(count($_FILES)>$cont){
			$swit=false;
			if (in_array($_FILES['imagen'.$cont]['type'], $permitidos) && $_FILES['imagen'.$cont]['size'] <= $limite_kb * 1024){
				$ruta = "imagenes/" . $_FILES['imagen'.$cont]['name'];
				if (!file_exists($ruta)){
					$resultado = move_uploaded_file($_FILES["imagen".$cont]["tmp_name"], $ruta);
					if ($resultado){
						$swit=true;
						$error="El archivo ha sido movido exitosamente.";
						setcookie("error",$error);
					} else {
						$swit=false;
						$error="Ocurrio un error al mover el archivo.";
						setcookie("error",$error);						
					}
				} else {
					$error=$_FILES['imagen'.$cont]['name'].", este archivo existe, cambiele el nombre o comprebe que no lo a subido ya.";
					setcookie("error",$error);					
				}
			} else {
				$error="Archivo no permitido, es tipo de archivo prohibido o excede el tamano de Kilobytes.";
				setcookie("error",$error);
			}
			if($swit==true){
				$listavalores="('".$_FILES['imagen'.$cont]['name']."','".$id."')";
				$result=$basedatos->_db->query("INSERT INTO fotos (nombre,id_seta) VALUES $listavalores");
			}
			$cont++;
		}
		return $swit;
	}
	public function borrar_foto($id){
		$basedatos= new Modelo();
		$cont=0;
		$borrar=$_REQUEST['borrar'];
		while(count($borrar)>$cont){
			$result=$basedatos->_db->query("DELETE FROM fotos where nombre='".$borrar[$cont]."' AND id_seta='".$id."'");
			unlink("imagenes/".$borrar[$cont]);
			$cont++;
		}

	}
}
class Hilo{
	private $id;
	private $titulo;
	private $fecha;
	private $id_usuario;
	function __construct(){	}
	public function __set($var,$valor){
		if (property_exists(__CLASS__, $var)){
			$this->$var = $valor;
		} else echo "No existe el atributo".$var;			
	}
	function __get($var){
		if (property_exists(__CLASS__, $var)){
			return $this->$var;
		}
		return NULL;
	}
	public function consultar_hilos(){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM hilos_foro"))return $result;
	}
	public function consultar_unhilo($id){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM hilos_foro WHERE id='".$id."'")){
			$hilo=$result->fetch_assoc();
			return $hilo;
		}
	}
	public function buscar_hilos(){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM hilos_foro  where titulo like '%".$_REQUEST['bus']."%'"))return $result;
	}
	public function insertar_hilo($id){
		$basedatos= new Modelo();
		$this->titulo=$_REQUEST['titulo_hilo'];	
		$fecha=date('Y-m-j');
		$this->fecha=$fecha;
		$this->id_usuario=$id;
		$listavalores="('".$this->titulo."','".$this->fecha."','".$this->id_usuario."')";
		$result=$basedatos->_db->query("INSERT INTO hilos_foro (titulo,fecha,id_usuario) VALUES $listavalores");
	}

}
class Mensaje{
	private $id;
	private $mensaje;
	private $id_usuario;
	private $fecha;
	private $id_hilo;
	function __construct(){	}
	public function __set($var,$valor){
		if (property_exists(__CLASS__, $var)){
			$this->$var = $valor;
		} else echo "No existe el atributo".$var;			
	}
	function __get($var){
		if (property_exists(__CLASS__, $var)){
			return $this->$var;
		}
		return NULL;
	}
	public function consultar_mensajes($id){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM mensajes_foro WHERE id_hilo='".$id."'"))return $result;
	}
	public function insertar_mensaje($id, $id_usu){
		$basedatos= new Modelo();
		$this->mensaje=$_REQUEST['mensaje_escribir'];
		$this->id_usuario=$id_usu;		
		$fecha=date('Y-m-j');
		$this->fecha=$fecha;
		$this->id_hilo=$id;
		$listavalores="('".$this->mensaje."','".$this->id_usuario."','".$this->fecha."','".$this->id_hilo."')";
		$result=$basedatos->_db->query("INSERT INTO mensajes_foro (mensaje,id_usuario, fecha, id_hilo) VALUES $listavalores");
	}
}
class Noticia{
	private $id;
	private $titulo;
	private $foto;
	private $fecha;
	private $texto;
	private $id_usuario;
	function __construct(){	}
	public function __set($var,$valor){
		if (property_exists(__CLASS__, $var)){
			$this->$var = $valor;
		} else echo "No existe el atributo".$var;			
	}
	function __get($var){
		if (property_exists(__CLASS__, $var)){
			return $this->$var;
		}
		return NULL;
	}
	public function consultar_noticias(){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM noticias"))return $result;
	}
	public function consultar_unanoticia($id){
		$basedatos= new Modelo();
		$result=$basedatos->_db->query("SELECT * FROM noticias WHERE id=".$id);
		$notici=$result->fetch_assoc();
		return $notici;
	}
	public function buscar_noticia(){
		$basedatos= new Modelo();
		if($result=$basedatos->_db->query("SELECT * FROM hilos_foro  where titulo like '%".$_REQUEST['bus']."%'"))return $result;
	}
	public function anadir_noticia(){
		$basedatos= new Modelo();	
		$swit=false;
		$sw=false;
		$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
		$limite_kb = 1000000;			
			if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024){
				$ruta = "imagenes/fotos_noticias/" . $_FILES['imagen']['name'];
				if (!file_exists($ruta)){
					$resultado = move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta);
					if ($resultado){
						$swit=true;
						$error="El archivo ha sido movido exitosamente.";
						setcookie("error",$error);
					} else {
						$swit=false;
						$error="Ocurrio un error al mover el archivo.";
						setcookie("error",$error);						
					}
				} else {
					$error=$_FILES['imagen']['name'] .", este archivo existe, cambiele el nombre o comprebe que no lo a subido ya.";
					setcookie("error",$error);					
				}
			} else {
				$error="Archivo no permitido, es tipo de archivo prohibido o excede el tamano de Kilobytes.";
				setcookie("error",$error);
			}
		if($swit==true){	
			$fecha=date('Y-m-j');
			$listavalores="('".$this->titulo."','".$this->foto."','".$this->texto."','".$this->fecha."','".$this->id_usuario."')";
			if($result=$basedatos->_db->query("INSERT INTO noticias (titulo,foto,texto,fecha,id_usuario) VALUES $listavalores")=== TRUE) $sw=true;
		}
		return $sw;
	}


}
?>