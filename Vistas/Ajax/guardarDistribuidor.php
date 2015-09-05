<?php 

require_once(__DIR__.'/../../Clases/ControladorDistribuidor.php');

//Creación de un arreglo con los datos obtenidos
$distribuidor = array();

$distribuidor["Nombre"]     = $_REQUEST['nombre'];
$distribuidor["Direccion"]  = $_REQUEST['direccion'];

$posHerramienta = intval($_REQUEST['herramienta']);

if ($posHerramienta != 0)
{
    if ($_REQUEST["id_modificacion"] != NULL)
    {
        $herramienta = ControladorDistribuidor::obtenerHerramientasSinDistribuidor($_REQUEST["id_modificacion"])[$posHerramienta];
    }
    else
    {
        $herramienta = ControladorDistribuidor::obtenerHerramientasSinDistribuidor()[$posHerramienta];
    }

    $distribuidor["ID_Herramienta"] = $herramienta->getID();
}

//Creación de un objeto del tipo distribuidor
$obj = ControladorDistribuidor::array_Distribuidor($distribuidor);

if ($posHerramienta != 0)
{
    $herramienta = $obj->getHerramienta();

    $posCalidad = $_REQUEST["calidad"];
    $calidad  = ControladorHerramienta::obtenerCalidades()[$posCalidad];

    $herramienta->setCalidad($calidad);
    $herramienta->setPrecioCompra(intval($_REQUEST["precio"]));

    $obj->setHerramienta($herramienta);
}

if ($_REQUEST["tipoAccion"] == 'Agregar')
{
    $posible = ControladorDistribuidor::insertarDistribuidor($obj);

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

    ControladorDistribuidor::actualizarDistribuidor($id, $obj);
    echo 'OK';
}

 ?>