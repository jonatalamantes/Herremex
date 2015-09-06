<?php 
    session_start(); 
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php"); 
    require_once(__DIR__."/../Clases/ControladorCompraVenta.php");

    ControladorBaseDatos::validarSesionIniciada('VerVenta');

    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaBusqueda.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|objeto|', 'Ventas', $plantilla);
    $plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);

    $inputNormal = '<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID compra">
    <input type="date" id="bFecha" class="busqueda" placeholder="Fecha yyyy-mm-dd">
    <button onclick="href(\'?keyword_id=compra\');" class="lupa"><span class="fa fa-search"></span></button>';

    $inputAvanzado = '';

    $plantilla = str_replace('|busquedaBasica|', $inputNormal, $plantilla);
    $plantilla = str_replace('|busquedaAvanzada|', $inputAvanzado, $plantilla);

    $ventas = ControladorCompraVenta::frontendFunctions();

    $conTab = $conTab . "<thead>";
    $conTab = $conTab . "<th class='text-left'>ID</th>";
    $conTab = $conTab . "<th class='text-left'>Reporte</th>";
    $conTab = $conTab . "<th class='text-left'>Cliente</th>";
    $conTab = $conTab . "<th class='text-left'>Sucursal</th>";
    $conTab = $conTab . "<th class='text-left'>Fecha</th>";
    $conTab = $conTab . "<th class='text-left'>Herramienta</th>";
    $conTab = $conTab . "<th class='text-left'>Cantidad</th>";
    $conTab = $conTab . "</thead>";

    foreach ($ventas as $simple) 
    {
        $herramientas = $simple->getHerramientaComprada()->getIDHerramienta();
        $cantidades   = $simple->getHerramientaComprada()->getCantidad();

        $conTab = $conTab . "<tr>";
        $conTab = $conTab . "<td rowspan=". sizeof($herramientas).">";
        $conTab = $conTab . $simple->getID();
        $conTab = $conTab . "</td>";
        $conTab = $conTab . "<td rowspan=". sizeof($herramientas).">";
        $conTab = $conTab . "<img src=\"Recursos/Imagenes/pdf.png\" onclick=\"facturarNuevaVentana('" . $simple->getID(). "', 'N')\">";
        $conTab = $conTab . "</td>";
        $conTab = $conTab . "<td rowspan=". sizeof($herramientas).">";
        $conTab = $conTab . $simple->getCliente()->getNombre();
        $conTab = $conTab . "</td>";
        $conTab = $conTab . "<td rowspan=". sizeof($herramientas).">";
        $conTab = $conTab . $simple->getSucursal()->getColonia();
        $conTab = $conTab . "</td>";
        $conTab = $conTab . "<td rowspan=". sizeof($herramientas).">";
        $conTab = $conTab . $simple->getFecha();
        $conTab = $conTab . "</td>";

        $conTab = $conTab . "<td>";
        $conTab = $conTab . ControladorHerramienta::obtenerHerramientaID($herramientas[0])->getNombre();
        $conTab = $conTab . "</td>";
        $conTab = $conTab . "<td>";
        $conTab = $conTab . $cantidades[0];
        $conTab = $conTab . "</td>";
        $conTab = $conTab . "</tr>";

        for ($i = 1; $i < sizeof($herramientas); $i++)
        {
            $conTab = $conTab . "<tr>";
            $conTab = $conTab . "<td>";
            $conTab = $conTab . ControladorHerramienta::obtenerHerramientaID($herramientas[$i])->getNombre();
            $conTab = $conTab . "</td>";
            $conTab = $conTab . "<td>";
            $conTab = $conTab . $cantidades[$i];
            $conTab = $conTab . "</td>";
            $conTab = $conTab . "</tr>";
        }
    }

    $conTab = $conTab . "</tbody>";

    $plantilla = str_replace('|tablaContenido|', $conTab, $plantilla);
    echo $plantilla;

?>