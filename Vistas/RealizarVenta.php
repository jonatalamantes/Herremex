<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Herremex</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="Recursos/css/styleVenta.css">
    <link rel="stylesheet" href="Recursos/css/font-awesome.css">
    <script type="text/javascript" src="scipts.js"></script>
    <script type="text/javascript" src="Ajax/ajax.js"></script>
    <script type="text/javascript" src="Recursos/jquery/JQuery.js"></script>
</head>
<body onload="fechaHoy();">
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('VerVenta');?>
<header>
    <h1 class="comp">
        <img src="Recursos/Imagenes/logo.png" class="logo"><!--Logo-->
            Herremex
        <button class="logout" onclick="cerrarSession();"><span class="fa fa-sign-out fa-2x">Salir</span></button>
        <div class="hr6"><hr /></div><!--Linea de color pendiente-->
        <ul class="menu">
            <li><a href="menu.php"><p class="menuTitulos"><span class="fa fa-home" ></span> Menu</p></a>
            <li><a href="#"><p class="menuTitulos"><span class="fa fa-cog" ></span> Herramientas</p></a>
                <ul class="sub-menu">
                    <li><a href="BusquedaHerramientas.php">Consultas</a></li>
                    <li><a href="AgregacionesHerramientas.php">Agregaciones</a></li>
                </ul>
            </li>
            <li><a href="#"><p class="menuTitulos"><span class="fa fa-group"></span> Clientes</p></a>
                <ul class="sub-menu">
                    <li><a href="BusquedaClientes.php">Consultas</a></li>
                    <li><a href="AgregacionesClientes.php">Agregaciones</a></li>
                </ul>
            </li>
            <li><a href="#"><p class="menuTitulos"><span class="fa fa-book"></span> Empleados</p></a>
                <ul class="sub-menu">
                    <li><a href="BusquedaEmpleados.php">Consultas</a></li>
                    <li><a href="AgregacionesEmpleados.php">Agregaciones</a></li>
                </ul>
            </li>
            <li><a href="#"><p class="menuTitulos"><span class="fa fa-truck "></span> Distribuidores</p></a>
                <ul class="sub-menu">
                    <li><a href="BusquedaDistribuidores.php">Consultas</a></li>
                    <li><a href="AgregacionesDistribuidores.php">Agregaciones</a></li>
                </ul>
            </li>
            <li><a href="#"><p class="menuTitulos"><span class="fa fa-briefcase"></span> Sucursales</p></a>
                <ul class="sub-menu">
                    <li><a href="BusquedaSucursales.php">Consultas</a></li>
                    <li><a href="AgregacionesSucursales.php">Agregaciones</a></li>
                </ul>
            </li>
            <li><a href="#"><p class="menuTitulos"><span class="fa fa-shopping-cart fa-spin"></span> Ventas</p></a>
                <ul class="sub-menu">
                    <li><a href="RealizarVenta.php">Realizar Venta</a></li>
                    <li><a href="VerVenta.php">Ver registro de ventas</a></li>
                </ul>
            </li>
        </ul>
    </h1>
    <section id="infoUsuario">
        <i class="fecha"><span id="fecha"> </span></i><!--Fecha Actual-->

    </section>
</header>
<h2>
    Registrar Venta
</h2>
<section id="seccionDeVentas">
<table class="capturarTabla">
        <tr>
            <td>
                <a id = "tipoAccion" hidden></a>
            </td>
        </tr>
        <tr>
            <td>
                <p class="campo" id = 'campo'>
                    Selecione la sucursal en la que se realizo la compra:
                </p>
            </td>
            <td class="tablei">
                <div class="opciones">
                    <?php 
                        require_once(__DIR__."/../Clases/ControladorSucursal.php");
                        $tipos = ControladorSucursal::obtenerSucursales();

                        echo '<select id="aSucursales">';

                        foreach ($tipos as $key => $value) 
                        {
                            echo "<option id=sucursal$key>", $value->getColonia(), "</option>";
                        }

                        echo "</select>";
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <p class="campo" id = 'campo'>
                    Selecione el cliente que se realizo la compra:
                </p>
            </td>
            <td class="tablei">
                <div class="opciones">
                    <?php 
                        require_once(__DIR__."/../Clases/ControladorCliente.php");
                        $clientes = ControladorCliente::obtenerClientes();

                        echo '<select id="aClientes">';

                        foreach ($clientes as $key => $value) 
                        {
                            echo "<option id=cliente$key>", $value->getRFC(), "</option>";
                        }

                        echo "</select>";
                    ?>
                </div>
            </td>
        </tr>
            <?php 
                require_once(__DIR__."/../Clases/ControladorHerramienta.php");
                
                $herramientas = ControladorHerramienta::obtenerHerramientasSinCantidad();

                foreach ($herramientas as $value) 
                {
                    $id = $value->getID();
                    echo "<tr id='$id' class = 'selects'>
                            <td>
                            <p class='campo' id = 'campo'>
                                Selecione la herramienta comprada:
                            </p>
                        </td>";

                    echo '<td class="tablei">
                            <div class="opciones">';
                    echo "<select name='aHerramientas$id' class='herramientas' onchange='desactivarSelect(\"$id\"); calcularTotal()'>";

                    foreach ($herramientas as $key => $value) 
                    {
                        echo "<option class='options'>", $value->getNombre(), "</option>";
                    }

                    echo "</select>";

                    echo "</div>
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

                echo "<tr><td><select name='aHerramientas' id='precios' hidden>";

                foreach ($herramientas as $key => $value) 
                {
                    echo "<option class='options'>", $value->getPrecio(), "</option>";
                }

                echo "</select></td></tr>";
            ?>
        <tr>
            <td rowspan="2">
                <p class="campo" id="campo">Subtotal de la compra:</p>
            </td>
            <td style="text-align: center" rowspan="2">
                <input id="subtotal" disabled class="totales">
            </td>
            <td>
                <input type="checkbox" id="oFacturar" class="oCheckBox" checked>Facturar
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="oEnvioDomicilio" class="oCheckBox">Envio a Domicilio
            </td>
        </tr>
        <tr>
            <td>
                <p class="campo" id="campo">Total (IVA + subtotal):</p>
            </td>
            <td style="text-align: center">
                <input id="total" disabled class="totales">
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <button id = "bAnterior" style="background-color: transparent" onclick="href('VerVenta.php')"><span class="fa fa-times fa-5x"></span></button>
                <button id = "bGuardar" style="background-color: transparent" onclick="guardarCompraVenta()"><span class="fa fa-credit-card fa-5x"></span></button>
            </td>
        </tr>
    </table>
</section>
<a id="operacion" hidden>Insercion</a>
<script type="text/javascript">inicializeSelect();</script>
<footer>Herremex, Todos los derechos reservados © 2015</footer>
</body>
</html>