<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <?php require './database.php'; ?>
    <?php require 'util/funciones.php'; ?>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["usuario"]) && isset($_SESSION["rol"])) {
        $usuario = $_SESSION["usuario"];
        $rol = $_SESSION["rol"];
    } else {
        $_SESSION["usuario"] = "invitado";
        $_SESSION["rol"] = "invitado";
        $usuario = $_SESSION["usuario"];
        $rol = $_SESSION["rol"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $temp_nombre = depurar($_POST["nombre"]);
        $temp_descripcion = depurar($_POST["descripcion"]);
        $temp_precio = depurar($_POST["precio"]);
        $temp_cantidad = depurar($_POST["cantidad"]);

        // Imagen
        $nombre_imagen = $_FILES["imagen"]["name"];
        $tipo_imagen = $_FILES["imagen"]["type"];
        $tamano_imagen = $_FILES["imagen"]["size"];
        $ruta_temporal = $_FILES["imagen"]["tmp_name"];

        // * Comprobar nombre
        if (strlen($temp_nombre) == 0) {
            $err_nombre = "El nombre es obligatorio";
        } else {
            if (strlen($temp_nombre) > 40) {
                $err_nombre = "El nombre no puede tener mas de 40 caracteres";
            } else {
                $patron = "/^[A-Za-z0-9]*( [A-Za-z0-9]+)*$/";
                if (!preg_match($patron, $temp_nombre)) {
                    $err_nombre = "El nombre solo pude contener letras, numeros o espacios en blanco";
                } else {
                    $nombre = $temp_nombre;
                }
            }
        }

        // * Comprobar descripcion
        if (strlen($temp_descripcion) == 0) {
            $err_descripcion = "La descripcion es obligatoria";
        } else {
            if (strlen($temp_descripcion) > 255) {
                $err_descripcion = "La descripcion no puede tener mas de 255 caracteres";
            } else {
                $patron = "/^[A-Za-z0-9]*( [A-Za-z0-9]+)*$/";
                if (!preg_match($patron, $temp_descripcion)) {
                    $err_descripcion = "La descripcion solo pude contener letras, numeros o espacios en blanco";
                } else {
                    $descripcion = $temp_descripcion;
                }
            }
        }

        // * Comprobar precio
        if (strlen($temp_precio) == 0) {
            $err_precio = "El precio es obligatorio";
        } elseif (!is_numeric($temp_precio)) {
            $err_precio = "El precio debe ser un número";
        } elseif ($temp_precio < 0) {
            $err_precio = "El precio no puede ser negativo";
        } elseif ($temp_precio > 99999.99) {
            $err_precio = "El precio no puede ser mayor de 99999.99";
        } else {
            $precio = $temp_precio;
        }

        // * Comprobar cantidad
        if (strlen($temp_cantidad) == 0) {
            $err_cantidad = "La cantidad es obligatoria";
        } elseif (filter_var($temp_cantidad, FILTER_VALIDATE_INT) === false) {
            $err_cantidad = "La cantidad debe ser un número entero";
        } elseif ($temp_cantidad < 0) {
            $err_cantidad = "La cantidad no puede ser negativa";
        } elseif ($temp_cantidad > 99999) {
            $err_cantidad = "La cantidad no puede ser mayor de 99999";
        } else {
            $cantidad = $temp_cantidad;
        }

        // * Comprobar imagen
        if ($_FILES["imagen"]["error"] == 4 || $tamano_imagen == 0 && $_FILES["imagen"]["error"] == 0) {
            $err_imagen = "Inserte un archivo";
        } else if (!exif_imagetype($ruta_temporal)) {
            $err_imagen = "Debe ser formato imagen";
        } else {
            $ruta_final = "img/" . $nombre_imagen;
        }
    }

    require 'util/nav.php';
    ?>

    <?php
    if ($rol == "admin") {
        ?>
        <div class="container">
            <h1>Producto</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nombre del producto:</label>
                    <input class="form-control" type="text" name="nombre">
                    <?php if (isset($err_nombre))
                        echo "<label class='text-danger'>" . $err_nombre . "</label>" ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion del producto: </label>
                        <input class="form-control" type="text" name="descripcion">
                    <?php if (isset($err_descripcion))
                        echo "<label class='text-danger'>" . $err_descripcion . "</label>" ?>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Precio: </label>
                        <input class="form-control" type="text" name="precio">
                    <?php if (isset($err_precio))
                        echo "<label class='text-danger'>" . $err_precio . "</label>" ?>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Cantidad:</label>
                        <input class="form-control" type="text" name="cantidad">
                    <?php if (isset($err_cantidad))
                        echo "<label class='text-danger'>" . $err_cantidad . "</label>" ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen</label>
                        <input class="form-control" type="file" name="imagen">
                    <?php if (isset($err_imagen))
                        echo '<label class=text-danger>' . $err_imagen . '</label>' ?>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Enviar">
                </form>
            </div>
        <?php
    } else {
        ?>
        <div class="container">
            <h4 class="alert bg-danger">No tienes permisos para acceder aqui</h4>
        </div>
        <?php
    }
    ?>
    <?php
    if (isset($nombre) && isset($descripcion) && isset($precio) && isset($cantidad) && isset($ruta_final)) {
        $sql = "INSERT INTO productos (nombreProducto, precio, descripcion, cantidad, imagen) VALUES ('$nombre', '$precio', '$descripcion', '$cantidad', '$ruta_final')";
        if ($conexion->query($sql)) {
            move_uploaded_file($ruta_temporal, $ruta_final);
            ?>
            <div class="container alert alert-success mt-3" role="alert">
                Producto añadido correctamente
            </div>

            <?php
        } else {
            ?>
            <div class="container alert alert-danger mt-3" role="alert">
                Ha habido un error al añadir el producto
            </div>
            <?php
        }
    }
    ?>
</body>

</html>