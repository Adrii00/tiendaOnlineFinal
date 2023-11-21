<?php
require "../database.php";
$idCesta = $_POST["id"];
$sql = "SELECT * from productos_cestas where idCesta = '$idCesta'";
    $resultado = $conexion->query($sql);

    while ($fila = $resultado->fetch_assoc()) {
        $cantidad = $fila["cantidad"];
        $idProduto = $fila["idProducto"];
        $sql = "UPDATE productos SET cantidad = (cantidad + '$cantidad') WHERE idProducto = '$idProduto'";
        $conexion->query($sql);
    }
$sql = "DELETE FROM productos_cestas WHERE idCesta = '$idCesta'";
$conexion->query($sql);
header('location: ../');