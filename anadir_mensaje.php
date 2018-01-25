<?php
session_start();
require("class.php");
$mensaje= new Mensaje();
$usua=new Usuario();
$id=$_REQUEST['id'];
$id_usu=$usua->consultarid();
$mensaje->insertar_mensaje($id, $id_usu);
header("Location: mensajes.php?id=$id");
?>