<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <?php require './database.php'; ?>
    <?php require 'Objetos/usuario.php'; ?>
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

    $sql = "SELECT usuario, fechaNacimiento, rol from usuarios";
    $resultado = $conexion->query($sql);
    $usuarios = [];

    while ($fila = $resultado->fetch_assoc()) {
        $nuevo_usuario = new Usuario(
            $fila["usuario"],
            $fila["fechaNacimiento"],
            $fila["rol"]
        );
        array_push($usuarios, $nuevo_usuario);
    }

    require 'util/nav.php';

    if ($rol == "admin") {
        ?>
        <div class="container">
            <h1>Listado de usuarios</h1>
            <table class="table table-striped table-hover table-bordered border-danger">
                <thead class="table-dark">
                    <tr>
                        <th>Usuario</th>
                        <th>Fecha de nacimiento</th>
                        <th>Rol</th>
                        <?php
                        if ($rol == "admin") {
                            ?>
                            <th>Acciones</th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($usuarios as $usuario) {
                        echo "<tr class='table-info'>";
                        echo "<td>" . $usuario->usuario . "</td>";
                        echo "<td>" . $usuario->fechaNacimiento . "</td>";
                        echo "<td>" . $usuario->rol . "</td>";

                        if ($rol == "admin") {
                            ?>
                            <td>
                                <?php
                                if ($usuario->rol != "admin") {
                                    ?>
                                    <a class="btn btn-danger" href="util/eliminar_usuario.php?id=<?php echo $usuario->usuario ?>">
                                        Eliminar
                                        <?php
                                }
                                ?>
                            </td>
                            <?php
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
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
</body>

</html>