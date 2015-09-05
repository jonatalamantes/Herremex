<?php 

require_once(__DIR__.'/../../Clases/ControladorSucursal.php');

//Creación de un arreglo con los datos obtenidos
$sucursal = array();

$sucursal["Calle"]      = $_REQUEST['calle'];
$sucursal["NoEdificio"] = $_REQUEST['edificio'];
$sucursal["Colonia"]    = $_REQUEST['colonia'];

$posCiudad   = $_REQUEST['ciudad'];
$ciudad      = ControladorSucursal::obtenerCiudades()[$posCiudad];

$sucursal["Ciudad"]     = $ciudad->getAbreviatura();

//Creación de un objeto del tipo sucursal
$obj = ControladorSucursal::array_Sucursal($sucursal);

if ($_REQUEST["tipoAccion"] == 'Agregar')
{
    $posible = ControladorSucursal::insertarSucursal($obj);

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

    ControladorSucursal::actualizarSucursal($id, $obj);
    echo 'OK';
}

 ?>