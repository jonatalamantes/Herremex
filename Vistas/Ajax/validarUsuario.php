<?php 
require_once(__DIR__.'/../../Clases/ControladorEmpleado.php');

$clave    = sha1($_REQUEST['password']);
$username = $_REQUEST['user'];
$usuario  = ControladorEmpleado::validarUsuario($username, $clave);

if ($usuario !== NULL)
{
    //buscando empleado
    ControladorBaseDatos::iniciarSesion($usuario);
    echo 'OK';
}
else
{
    echo 'KO';
}

 ?>