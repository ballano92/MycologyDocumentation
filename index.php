<?php
//fin del registrador y cominenzo del cuerpo***********************************************************************************
require("header.php");
// echo '<div id="logo"><img src="images/logo.png" /></div>';
echo "<div id='main_images'>";
	echo '<img src="images/carrusel4.jpg" class="foto_index" />';
	echo '<img src="images/carrusel2.jpg" class="foto_index"/>';
	echo '<img src="images/carrusel1.jpg" class="foto_index"/>';
echo '</div>';
echo "<div id='main_images2' style='display:none;'>";
	echo '<img src="images/carrusel5.jpg" class="foto_index" />';
	echo '<img src="images/carrusel6.jpg" class="foto_index"/>';
	echo '<img src="images/carrusel7.jpg" class="foto_index"/>';
echo '</div>';
include("footer.php");
?>
