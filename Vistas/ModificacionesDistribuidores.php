<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Herremex</title>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="Recursos/css/styleModificaciones.css">
	<link rel="stylesheet" href="Recursos/css/font-awesome.css">
	<script type="text/javascript" src="scipts.js"></script>
    <script type="text/javascript" src="Ajax/ajax.js"></script>
</head>
<body onload="fechaHoy();">
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('NuevoDistribuidor');?>
<header>
	<h1 class="comp">
		<img src="Recursos/Imagenes/logo.png" class="logo"><!--Logo-->
			Herremex
        <button class="logout" onclick="cerrarSession();"><span class="fa fa-sign-out fa-2x">Salir</span></button>
		<div class="hr4"><hr /></div><!--Linea Amarilla-->
		<ul class="menu">
            <li><a href="menu.php"><p class="menuTitulos"><span class="fa fa-home" ></span> Menu</p></a>
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-cog" ></span> Herramientas</p></a>
				<ul class="sub-menu">
					<li><a href="BusquedaHerramientas.php">Consultas</a></li>
					<li><a href="AgregacionesHerramientas.php">Agregaciones</a></li>
				</ul>
			</li>
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-group"></span> Distribuidors</p></a>
				<ul class="sub-menu">
					<li><a href="BusquedaDistribuidors.php">Consultas</a></li>
					<li><a href="AgregacionesDistribuidors.php">Agregaciones</a></li>
				</ul>
			</li>
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-book"></span> Empleados</p></a>
				<ul class="sub-menu">
					<li><a href="BusquedaEmpleados.php">Consultas</a></li>
					<li><a href="AgregacionesEmpleados.php">Agregaciones</a></li>
				</ul>
			</li>
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-truck fa-spin"></span> Distribuidores</p></a>
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
            <li><a href="#"><p class="menuTitulos"><span class="fa fa-shopping-cart"></span> Ventas</p></a>
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
	Datos actuales del Distribuidor
</h2>
<a id="operacion" hidden>Insercion</a>
<section class="capturar">
	<table class="capturarTabla">
        <tr>
            <td>
                <a id = "tipoAccion" hidden>Modificar</a>
            </td>
        </tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta el nombre del distribuidor:
				</p>
			</td>
			<td class="tablei">
				<input name="aNombre" type="text" id="aNombre" class="agregacion" placeholder="Nombre Distribuidor" onclick="inicializarDistribuidores()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta la direccion del distribuidor::
				</p>
			</td>
			<td class="tablei">
				<input name="aDireccion" type="text" id="aDireccion" class="agregacion" placeholder="Direccion" onclick="inicializarDistribuidores()">
			</td>
		</tr>
        <tr>
            <td>
                <p class="campo" id = 'campo'>
                    Selecione la herramienta que distribuye:
                </p>
            </td>
            <td class="tablei">
                <div class="opciones">
                    <?php 
                        require_once(__DIR__."/../Clases/ControladorDistribuidor.php");
                        
                        $url = ControladorBaseDatos::getRestoURL();
                        $herramientas = ControladorDistribuidor::obtenerHerramientasSinDistribuidor();

                        if ($url != '')
                        {
                            $url = substr($url, 4);

                            if (is_numeric($url))
                            {
                                $id = intval($url);
                                $herramientas = ControladorDistribuidor::obtenerHerramientasSinDistribuidor($id);
                            }
                        }

                        echo '<select id="aHerramientas" onclick = "inicializarDistribuidores()">';

                        foreach ($herramientas as $key => $value) 
                        {
                            echo "<option id=calidad$key>", $value->getNombre(), "</option>";
                        }

                        echo "</select>";
                    ?>
                </div>
            </td>
        </tr>
        <tr id = 'campo1'>
            <td>
                <p class="campo" id = 'campo'>
                    Selecione la calidad de la herramienta:
                </p>
            </td>
            <td class="tablei">
                <div class="opciones">
                    <?php 
                        require_once(__DIR__."/../Clases/ControladorHerramienta.php");
                        $calidades = ControladorHerramienta::obtenerCalidades();

                        echo '<select id="aCalidad">';

                        foreach ($calidades as $key => $value) 
                        {
                            echo "<option id=calidad$key>", $value->getNombre(), "</option>";
                        }

                        echo "</select>";
                    ?>
                </div>
            </td>
        </tr>
        <tr id = 'campo2'>
            <td>
                <p class="campo" id = 'campo'>
                    Inserta el precio de compra de la herramienta:
                </p>
            </td>
            <td class="tablei">
                <input name="aPrecioCompra" type="text" id="aPrecioCompra" class="agregacion" placeholder="Precio de compra" onclick="inicializarDistribuidores()">
            </td>
        </tr>
		<tr>
			<td colspan="2" align="center">
                <button style="background-color: transparent" onclick="guardarDistribuidores()"><span class="fa fa-floppy-o fa-5x"></span></button>
			</td>
		</tr>
	</table>
</section>
<?php 
    require_once(__DIR__."/../Clases/ControladorDistribuidor.php");
    $url = ControladorBaseDatos::getRestoURL();

    if ($url != '')
    {
        $url = substr($url, 4);

        if (is_numeric($url))
        {
            $id = intval($url);

            $Distribuidor = ControladorDistribuidor::obtenerDistribuidorID($id);

            if ($Distribuidor != NULL)
            {
                $Distribuidor->getHerramienta() != NULL ? $precio = $Distribuidor->getHerramienta()->getPrecioCompra() : $precio = 0;
                $direccion = $Distribuidor->getDireccion();
                $nombre    = $Distribuidor->getNombre();

                //var_dump($Distribuidor);

                //Establece datos de objetos dentro de objetos
                echo "<script>
                        document.getElementById('aDireccion').value = '$direccion';
                        document.getElementById('aNombre').value = '$nombre';
                        document.getElementById('aPrecioCompra').value = $precio;";

                if ($Distribuidor->getHerramienta() == NULL)
                {
                    echo "document.getElementById('aHerramientas').options.selectedIndex = 0;";
                }
                else
                {
                    $index = 0;
                    $herramientas = ControladorDistribuidor::obtenerHerramientasSinDistribuidor($Distribuidor->getID());



                    foreach ($herramientas as $key => $value) 
                    {
                        if ($value->getID() == $Distribuidor->getHerramienta()->getID())
                        {
                            $index = $key;
                            break;
                        }
                    }

                    echo "document.getElementById('aHerramientas').options.selectedIndex = $index;";

                    $index = 0;
                    $calidades = ControladorHerramienta::obtenerCalidades();

                    foreach ($calidades as $key => $value) 
                    {
                        if ($value->getAbreviatura() == $Distribuidor->getHerramienta()->getCalidad()->getAbreviatura())
                        {
                            $index = $key;
                            break;
                        }
                    }

                    echo "document.getElementById('aCalidad').options.selectedIndex = $index;";
                }

                echo "inicializarDistribuidors();
                </script>";
            }
        }
    }
 ?>
<footer>Herremex, Todos los derechos reservados © 2015</footer>
<script type="text/javascript">inicializarDistribuidores();</script>
</body>
</html>