<?php
class Usuario
{
    public string $usuario;
    public string $fechaNacimiento;
    public string $rol;

    function __construct($usuario, $fechaNacimiento, $rol)
    {
        $this->usuario = $usuario;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->rol = $rol;
    }
}
