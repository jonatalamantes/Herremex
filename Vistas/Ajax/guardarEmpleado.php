<?php 

require_once(__DIR__.'/../../Clases/ControladorEmpleado.php');

//Creación de un arreglo con los datos obtenidos
$empleado = array();

$empleado["CURP"]             = $_REQUEST["curp"];
$empleado["Nombre"]           = $_REQUEST["nombre1"];
$empleado["Segundo_Nombre"]   = $_REQUEST["nombre2"];
$empleado["Apellido_Paterno"] = $_REQUEST["apellidop"];
$empleado["Apellido_Materno"] = $_REQUEST["apellidom"];
$empleado["Calle"]            = $_REQUEST["calle"];
$empleado["Colonia"]          = $_REQUEST["colonia"];
$empleado["NoCasa_Ext"]       = $_REQUEST["exterior"];
$_REQUEST["interior"] == '' ? $empleado["NoCasa_Int"] = '0' : $empleado["NoCasa_Int"] = $_REQUEST["interior"];
$empleado["Password"]         = sha1($_REQUEST["pass"]);

$posCiudad = intval($_REQUEST['ciudad']);

$ciudad = ControladorEmpleado::obtenerCiudades()[$posCiudad];
$empleado["Ciudad"] = $ciudad->getAbreviatura();

$posTipo = intval($_REQUEST['tipo']);

$tipo = ControladorEmpleado::obtenerTipoEmpleados()[$posTipo];
$empleado["Tipo_Empleado"] = $tipo->getAbreviatura();

$posTurno = intval($_REQUEST['turno']);

$turno = ControladorEmpleado::obtenerTurnos()[$posTurno];
$empleado["Turno"] = $turno->getAbreviatura();

$posSucursal = intval($_REQUEST['sucursal']);

$sucursal = ControladorSucursal::obtenerSucursales()[$posSucursal];
$empleado["ID_Sucursal"] = $sucursal->getID();

//Creación de un objeto del tipo empleado
$obj = ControladorEmpleado::array_Empleado($empleado);

if ($_REQUEST["accion"] == 'Agregar')
{
    $posible = ControladorEmpleado::insertarEmpleado($obj);

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

    ControladorEmpleado::actualizarEmpleado($id, $obj);
    echo 'OK';
}
else if ($_REQUEST["accion"] == 'Mostrar')
{
    echo 'OK';
}

 ?>