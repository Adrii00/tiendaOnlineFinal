<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <?php require './database.php'; ?>
    <?php require 'Objetos/producto.php'; ?>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["usuario"]) && isset($_SESSION["rol"])) {
        $usuario = $_SESSION["usuario"];
        $rol = $_SESSION["rol"];
    } else {
        $_SESSION["usuario"] = "invitado";
        $_SESSION["rol"] = "cliente";
        $usuario = $_SESSION["usuario"];
        $rol = $_SESSION["rol"];
    }

    // comprobar si el usuario ha sido eliminado
    $res = mysqli_query($conexion, "select usuario from usuarios where usuario = '$usuario'");
    if (mysqli_num_rows($res) == 0) {
        session_destroy();
    }


    $sql = "SELECT * from productos";
    $resultado = $conexion->query($sql);
    $productos = [];


    while ($fila = $resultado->fetch_assoc()) {
        $nuevo_producto = new Producto(
            $fila["idProducto"],
            $fila["nombreProducto"],
            $fila["precio"],
            $fila["descripcion"],
            $fila["cantidad"],
            $fila["imagen"]
        );
        array_push($productos, $nuevo_producto);
    }
    ?>

    <?php
    require 'util/nav.php';
    ?>

    <div class="container">
        <h2>Bienvenido
            <?php echo $usuario ?>
        </h2>
    </div>
    <div class="container">
        <h1>Listado de productos</h1>
        <div class="row px-xl-5">
            <?php
            foreach ($productos as $producto) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <?php
                        if ($producto->cantidad > 0) {
                            ?>
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?php echo $producto->imagen ?>" alt="">
                                <div class="product-action">
                                    <?php
                                    if ($rol == "admin") {
                                        ?>
                                        <a class="btn btn-outline-dark btn-square"
                                            href="util/eliminar_producto.php?id=<?php echo $producto->idProducto ?>">
                                            <img src="img/iconos/icono_eliminar.gif" alt="" class="img-fluid w-100">
                                        </a>
                                        <?php

                                    }
                                    ?>
                                    <a class="btn btn-outline-light btn-square bg-success" href="producto.php?id=<?php echo $producto->idProducto ?>"> Comprar </a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">
                                    <?php echo $producto->nombreProducto ?>
                                </a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>
                                        <?php echo $producto->precio . " €" ?>
                                    </h5>
                                </div>
                            </div>
                        <?php  # code...
                        } else {
                            ?>
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?php echo $producto->imagen ?>" alt="">
                                <div class="product-action">
                                    <?php
                                    if ($rol == "admin") {
                                        ?>
                                        <a class="btn btn-outline-dark btn-square"
                                            href="util/eliminar_producto.php?id=<?php echo $producto->idProducto ?>">
                                            <img src="img/iconos/icono_eliminar.gif" alt="" class="img-fluid w-100">
                                        </a>
                                        <?php

                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <div class="d-flex bg-danger align-items-center justify-content-center mt-2">
                                    <h5>Producto agotado</h5>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</body>

</html>