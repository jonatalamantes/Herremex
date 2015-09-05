<?php 

require_once(__DIR__.'/../../Clases/ControladorHerramienta.php');

//Creación de un arreglo con los datos obtenidos
$herramienta = array();

$herramienta["Precio"] = $_REQUEST["precio"];
$herramienta["Nombre"] = $_REQUEST["nombre"];
$herramienta["CantidadExistente"] = $_REQUEST["cantidad"];

$posMarca = intval($_REQUEST['marca']);

$marca = ControladorHerramienta::obtenerMarcas()[$posMarca];
$herramienta["ID_Marca"] = $marca->getID();

$posTipo = intval($_REQUEST['tipo']);

$tipo = ControladorHerramienta::obtenerTipoHerramientas()[$posTipo];
$herramienta["ID_Tipo"] = $tipo->getID();

//Creación de un objeto del tipo herramienta
$obj = ControladorHerramienta::array_Herramienta($herramienta);

if ($_REQUEST["accion"] == 'Agregar')
{
    $posible = ControladorHerramienta::insertarHerramienta($obj);

    if ($posible)
    {
        echo 'OK';
    }
    else
    {
        echo 'KO';
    }
}
else if ($_REQUEST["accion"] == 'Modificar')
{
    $id = $_REQUEST["id_modificacion"];

    ControladorHerramienta::actualizarHerramienta($id, $obj);
    echo 'OK';
}
else if ($_REQUEST["accion"] == 'Mostrar')
{
    echo 'OK';
}

 ?>