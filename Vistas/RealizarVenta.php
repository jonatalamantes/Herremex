<?php 
    
    session_start();
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php");           
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
    require_once(__DIR__."/../Clases/ControladorCliente.php");
    require_once(__DIR__."/../Clases/ControladorSucursal.php");
    require_once(__DIR__."/../Clases/ControladorHerramienta.php");

    ControladorBaseDatos::validarSesionIniciada('RealizarVenta');

    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaVenta.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);

    //Cargar Sucursales
    $tipos = ControladorSucursal::obtenerSucursales();
    $suc = "";

    $suc = $suc . '<select id="aSucursales">';

    foreach ($tipos as $key => $value) 
    {
        $suc = $suc . "<option id=sucursal$key>". $value->getColonia(). "</option>";
    }

    $suc = $suc . "</select>";
    $plantilla = str_replace('|sucursales|', $suc, $plantilla);

    //Cargar Clientes
    $clientes = ControladorCliente::obtenerClientes();
    $clienteS = "";

    $clienteS = $clienteS . '<select id="aClientes">';

    foreach ($clientes as $key => $value) 
    {
        $clienteS = $clienteS . "<option id=cliente$key>". $value->getRFC(). "</option>";
    }

    $clienteS = $clienteS . "</select>";
    $plantilla = str_replace('|clientes|', $clienteS, $plantilla);

    //Cargar Herramientas 
    $herramientas = ControladorHerramienta::obtenerHerramientasSinCantidad();
    $herr = "";

    foreach ($herramientas as $value) 
    {
        $id = $value->getID();
        $herr = $herr . "<tr id='$id' class = 'selects'>
                <td>
                <p class='campo' id = 'campo'>
                    Selecione la herramienta comprada:
                </p>
            </td>";

        $herr = $herr . '<td class="tablei">
                <div class="opciones">';
        $herr = $herr . "<select name='aHerramientas$id' class='herramientas' onchange='desactivarSelect(\"$id\"); calcularTotal()'>";

        foreach ($herramientas as $key => $value) 
        {
            $herr = $herr . "<option class='options'>". $value->getNombre(). "</option>";
        }

        $herr = $herr . "</select>";

        $herr = $herr . "</div>
                </td>
                <td style='vertical-align: bottom;'>
                    <div class='opcionesNumericas'>
                        <input class = 'numbericInput' MIN='0' type='number' id='nHerramientas$id' onkeyup=\"validarInput('nHerramientas$id'); calcularTotal();\" onchange='calcularTotal(); validarMaxHerramientas(\"nHerramientas$id\")' onclick=\"validarInput('nHerramientas$id'); calcularTotal();\">
                    </div>
                </td>
                <td>
                    <button id='añadir' class='mas' style='background-color: transparent' onclick=\"mostrarTR('$id')\">
                        <span class='fa fa-plus fa-2x'></span>
                    </button>
                    <button id='añadir' class='menos' style='background-color: transparent' onclick=\"ocultarTR('$id')\">
                        <span class='fa fa-minus fa-2x'></span>
                    </button>
                </td>
            </tr>";
    }

    $herr = $herr . "<tr><td><select name='aHerramientas' id='precios' hidden>";

    foreach ($herramientas as $key => $value) 
    {
        $herr = $herr . "<option class='options'>". $value->getPrecio(). "</option>";
    }

    $herr = $herr . "</select></td></tr>";
    $plantilla = str_replace('|herramientasCantidad|', $herr, $plantilla);

    echo $plantilla;
?>
