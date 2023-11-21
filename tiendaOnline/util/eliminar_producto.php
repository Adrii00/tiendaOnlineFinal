<?php
require "../database.php";
$idProducto = $_GET["id"];

$sql = "DELETE FROM productos_cestas WHERE idProducto = '$idProducto'";
$conexion->query($sql);
$sql1 = "DELETE FROM productos WHERE idProducto = '$idProducto'";
$conexion->query($sql1);
header('location: ../');
