<?php
session_start();
require("class.php");
$hilo= new Hilo();
$usua=new Usuario();
$id_usu=$usua->consultarid();
$hilo->insertar_hilo($id_usu);
header("Location: foro.php");
?>