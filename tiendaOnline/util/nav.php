<nav class="navbar navbar-expand-lg bg-body-tertiary " data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">Tienda</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                if ($rol == "admin") {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="administrar_usuarios.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="insertar_productos.php">Añadir productos</a>
                    </li>
                <?php
                }
                ?>
            </ul>
            
            <?php
            if ($usuario == "invitado") {
            ?>
                <a class="btn btn-primary" href="Sesiones/iniciar_sesion.php">Iniciar Sesión</a>
            <?php
            } else {
            ?>
                <a class="btn bg-success d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="cesta.php">Mi cesta</a>
                <a class="btn btn-danger" href="Sesiones/cerrar_sesion.php">Cerrar Sesión</a>
            <?php
            }
            ?>

        </div>
    </div>
</nav>