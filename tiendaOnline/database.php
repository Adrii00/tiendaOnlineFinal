<?php
$servidor = 'localhost';
$usuario = 'root';
$contrasena = 'medac';
$base_datos = 'db_tienda';
$conexion = new Mysqli($servidor, $usuario, $contrasena, $base_datos)

    or die("Error en la conexión");

?>