<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Herremex</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="Recursos/css/style.css">
	<link rel="stylesheet" href="Recursos/css/font-awesome.css">
	<script type="text/javascript" src="scipts.js"></script>
	<script type="text/javascript" src="Ajax/ajax.js"></script>
</head>
<body onload="fechaHoy();">
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('nuevaVenta');?>
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
	<button id = 'prev' onclick="prev(5, 'dataTable')" hidden><span class="fa fa-arrow-left fa-2x"></span></button>
	Ventas Realizadas
	<button id = 'next' onclick="next(5, 'dataTable')" hidden><span class="fa fa-arrow-right fa-2x"></span></button>
</h2>
<a id="operacion" hidden>Consultas</a>
<div id="busqueda" class="seccionbusqueda"><!--Busqueda-->
	<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID compra">
	<input type="date" id="bFecha" class="busqueda" placeholder="Fecha yyyy-mm-dd">
	<button onclick="href('?keyword_id=compra');" class="lupa"><span class="fa fa-search"></span></button>
</div>
<div id="tablaDeResultados"><!--Tabla de resultados de busqueda-->
	<table id = 'dataTable'>
		<tbody class="table-hover">

                <?php 

                    require_once(__DIR__."/../Clases/ControladorCompraVenta.php");

                    $ventas = ControladorCompraVenta::frontendFunctions();

                    echo "<thead>";
                    echo "<th class='text-left'>ID</th>";
                    echo "<th class='text-left'>Reporte</th>";
                    echo "<th class='text-left'>Cliente</th>";
                    echo "<th class='text-left'>Sucursal</th>";
                    echo "<th class='text-left'>Fecha</th>";
                    echo "<th class='text-left'>Herramienta</th>";
                    echo "<th class='text-left'>Cantidad</th>";
                    echo "</thead>";

                    foreach ($ventas as $simple) 
                    {
                        $herramientas = $simple->getHerramientaComprada()->getIDHerramienta();
                        $cantidades   = $simple->getHerramientaComprada()->getCantidad();

                        echo "<tr>";
                        echo "<td rowspan=", sizeof($herramientas),">";
                        echo $simple->getID();
                        echo "</td>";
                        echo "<td rowspan=", sizeof($herramientas),">";
                        echo "<img src=\"Recursos/Imagenes/pdf.png\" onclick=\"facturarNuevaVentana('" . $simple->getID(). "', 'N')\">";
                        echo "</td>";
                        echo "<td rowspan=", sizeof($herramientas),">";
                        echo $simple->getCliente()->getNombre();
                        echo "</td>";
                        echo "<td rowspan=", sizeof($herramientas),">";
                        echo $simple->getSucursal()->getColonia();
                        echo "</td>";
                        echo "<td rowspan=", sizeof($herramientas),">";
                        echo $simple->getFecha();
                        echo "</td>";

                        echo "<td>";
                        echo ControladorHerramienta::obtenerHerramientaID($herramientas[0])->getNombre();
                        echo "</td>";
                        echo "<td>";
                        echo $cantidades[0];
                        echo "</td>";
                        echo "</tr>";

                        for ($i = 1; $i < sizeof($herramientas); $i++)
                        {
                            echo "<tr>";
                            echo "<td>";
                            echo ControladorHerramienta::obtenerHerramientaID($herramientas[$i])->getNombre();
                            echo "</td>";
                            echo "<td>";
                            echo $cantidades[$i];
                            echo "</td>";
                            echo "</tr>";
                        }
                    }

                 ?>
		</tbody>
	</table>
	<br>
</div>

<footer>Herremex, Todos los derechos reservados © 2015</footer>
</body>
</html>