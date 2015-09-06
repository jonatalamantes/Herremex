<?php 

	session_start(); 
	require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 
	require_once(__DIR__."/../Clases/DesplegadorInterfaz.php"); 

	ControladorBaseDatos::validarSesionIniciada('Menu');

	$tipo = ControladorBaseDatos::obtenerTipoUsuario();
	$nombre = ControladorBaseDatos::obtenerNombreUsuario();

	$plantilla = file_get_contents(__DIR__."/Plantillas/menu.html");
	$plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);
	$plantilla = str_replace('|username|', $nombre, $plantilla);

	$conTab = "";

    if ($tipo == 'A')
    {
        $conTab = $conTab . "<tr>
                <td id='opc1'>
                    <a href='BusquedaHerramientas.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-cog fa-5x'></span>
                        <p class='titulo'>Herramientas</p>
                    </a>
                </td>
             </tr>";
    }
    else if ($tipo == 'V')
    {
        $conTab = $conTab . "<tr>
                <td id='opc1'>
                    <a href='BusquedaHerramientas.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-cog fa-5x'></span>
                        <p class='titulo'>Herramientas</p>
                    </a>
                </td>
                <td>
                    <a href='RealizarVenta.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-shopping-cart fa-5x'></span>
                        <p class='titulo'>Ventas</p>
                    </a>
                </td>
            </tr>";
    }
    else if ($tipo == 'C')
    {
        $conTab = $conTab . "<tr>
                <td id='opc1'>
                    <a href='BusquedaHerramientas.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-cog fa-5x'></span>
                        <p class='titulo'>Herramientas</p>
                    </a>
                </td>
                <td>
                    <a href='VerVenta.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-shopping-cart fa-5x'></span>
                        <p class='titulo'>Ventas</p>
                    </a>
                </td>
            </tr>";
    }
    else
    {
        $conTab = $conTab . "<tr>
                <td id='opc1'>
                    <a href='BusquedaHerramientas.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-cog fa-5x'></span>
                        <p class='titulo'>Herramientas</p>
                    </a>
                </td>
                <td>
                    <a href='BusquedaClientes.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-group fa-5x'></span>
                        <p class='titulo'>Clientes</p>
                    </a>
                </td>
                <td>
                    <a href='BusquedaEmpleados.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-book fa-5x'></span>
                        <p class='titulo'>Empleados</p>
                    </a>
                </td>
                <td>
                    <a href='BusquedaDistribuidores.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-truck fa-5x'></span>
                        <p class='titulo'>Distribuidores</p>
                    </a>
                </td>
                <td>
                    <a href='BusquedaSucursales.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-briefcase fa-5x'></span>
                        <p class='titulo'>Sucursales</p>
                    </a>
                </td>
                <td>
                    <a href='RealizarVenta.php' class='hvr-wobble-vertical'>
                        <span class='fa fa-shopping-cart fa-5x'></span>
                        <p class='titulo'>Ventas</p>
                    </a>
                </td>
            </tr>";
    }

	$plantilla = str_replace('|tablaContenido|', $conTab, $plantilla);
	echo $plantilla;

?>