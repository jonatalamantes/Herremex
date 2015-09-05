<?php 

require_once(__DIR__.'/../../Clases/ControladorEmpleado.php');

    $nueva   = sha1($_REQUEST["nueva"]);
    $id      = $_REQUEST["id"];
    $antigua = sha1($_REQUEST["antigua"]);

    $correcta = ControladorEmpleado::actualizarClave($id, $antigua, $nueva);

    if ($correcta)
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>