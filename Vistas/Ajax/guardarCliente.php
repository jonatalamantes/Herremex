<?php 

require_once(__DIR__.'/../../Clases/ControladorCliente.php');

//Creación de un arreglo con los datos obtenidos
$cliente = array();

$cliente["Nombre"]     = $_REQUEST['nombre'];
$cliente["RFC"]        = $_REQUEST['rfc'];
$cliente["Calle"]      = $_REQUEST['calle'];
$cliente["NoEdificio"] = $_REQUEST['edificio'];

$_REQUEST['sexo'] == 0 ? $cliente["Sexo"] = "F" : $cliente["Sexo"] = "M";

if ($_REQUEST['regimen'] == 0)
{
    $cliente["Regimen"] = "Fisica";
}
else
{
    $cliente["Regimen"] = "Moral";
    $cliente["Sexo"]    = "";
}


$posCiudad   = $_REQUEST['ciudad'];
$ciudad      = ControladorCliente::obtenerCiudades()[$posCiudad];

$cliente["Ciudad"]     = $ciudad->getAbreviatura();

//Creación de un objeto del tipo cliente
$obj = ControladorCliente::array_Cliente($cliente);

if ($_REQUEST["tipoAccion"] == 'Agregar')
{
    $posible = ControladorCliente::insertarCliente($obj);

    if ($posible)
    {
        echo 'OK';
    }
    else
    {
        echo 'KO';
    }
}
else if ($_REQUEST["tipoAccion"] == 'Modificar')
{
    $id = $_REQUEST["id_modificacion"];

    ControladorCliente::actualizarCliente($id, $obj);
    echo 'OK';
}

 ?>