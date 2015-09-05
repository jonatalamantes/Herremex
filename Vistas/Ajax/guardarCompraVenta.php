<?php 
require_once(__DIR__.'/../../Clases/ControladorCompraVenta.php');

if ($_REQUEST["herramientas"] == '*')
{
    echo 'NO';
}
else
{
  //Creación de un Objeto del tipo CompraVenta
    $compra = new CompraVenta();

    //obtención del cliente
    $cliente = ControladorCliente::obtenerClientes()[$_REQUEST["cliente"]];
    $compra->setCliente($cliente);

    $sucursal = ControladorSucursal::obtenerSucursales()[$_REQUEST["sucursal"]];
    $compra->setSucursal($sucursal);
    $compra->setEnvioDomicilio($_REQUEST["domicilio"]);
    $compra->setFacturar($_REQUEST["factura"]);
    $compra->setFecha(date('Y-m-d'));

    $cantidades   = $_REQUEST["cantidad"];
    $herramientas = $_REQUEST["herramientas"];

    $herramientaSelect = array();
    $cantidadesArray   = array();
    $ID_Herramientas = array();
    $herramientasCompradas = new HerramientaComprada();
    $herramientasDB = ControladorHerramienta::obtenerHerramientasSinCantidad();
    $actual = "";

    //Obtenemos posiciones selecionadas
    for ($i = 0; $i < strlen($herramientas); $i++)
    {
        if ($herramientas[$i] == '|')
        {
            $herramientaSelect[] = $actual;
            $actual = "";
        }
        else if ($herramientas[$i] == '*')
        {
            $actual = "";
        }
        else
        {
            $actual = $actual . $herramientas[$i];
        }   
    }

    $actual = "";
    //Obtenemos las cantidades escogidas
    for ($j = 0; $j < strlen($cantidades); $j++)
    {
        if ($cantidades[$j] == '|')
        {
            $cantidadesArray[] = $actual;
            $actual = "";
        }
        else if ($cantidades[$j] == '*')
        {
            $actual = "";
        }
        else
        {
            $actual = $actual . $cantidades[$j];
        }   
    }

    //Obtenemos los IDS relacionados a cada seleccion del select
    foreach ($herramientaSelect as $key => $value) 
    {
        $ID_Herramientas[] = $herramientasDB[$value]->getID();
    }

    $herramientasCompradas->setIDHerramienta($ID_Herramientas);
    $herramientasCompradas->SetCantidad($cantidadesArray);

    $compra->setHerramientaComprada($herramientasCompradas);

    if (ControladorCompraVenta::insertarCompraVenta($compra))
    {
        echo ControladorCompraVenta::obtenerUltimoIdentificador();

        foreach ($ID_Herramientas as $key => $value) 
        {
            ControladorHerramienta::disminuirHerramientas($value, $cantidadesArray[$key]);
        }
    }
    else
    {
        echo "KO";
    }
}

    
//var_dump($compra);

 ?>