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
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('MostrarCliente');?>
<header>
	<h1 class="comp">
		<img src="Recursos/Imagenes/logo.png" class="logo"><!--Logo-->
			Herremex
		<button class="logout" onclick="cerrarSession();"><span class="fa fa-sign-out fa-2x">Salir</span></button>
		<div class="hr2"><hr /></div><!--Linea Roja-->
		<ul class="menu">
			<li><a href="menu.php"><p class="menuTitulos"><span class="fa fa-home" ></span> Menu</p></a>
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-cog" ></span> Herramientas</p></a>
				<ul class="sub-menu">
					<li><a href="BusquedaHerramientas.php">Consultas</a></li>
					<li><a href="AgregacionesHerramientas.php">Agregaciones</a></li>
				</ul>
			</li>
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-group fa-spin"></span> Clientes</p></a>
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
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-truck"></span> Distribuidores</p></a>
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
	<button id = "prev" onclick="prev(5, 'dataTable')" hidden><span class="fa fa-arrow-left fa-2x"></span></button>
	Busqueda de Clientes
	<button id = "next" onclick="next(5, 'dataTable')" hidden><span class="fa fa-arrow-right fa-2x"></span></button>
</h2>
<div id="busquedaBasica" class="seccionbusqueda"><!--Busqueda con parametros basicos-->
	<input name="bNombre" type="text" id="bNombre1" class="busqueda" placeholder="Nombre Cliente">
	<button onclick="href('?keyword=data');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar('busquedaAvanzada');desplegar('busquedaBasica')">Busqueda Avanzada <span class="fa fa-arrow-circle-right"></span></button>
</div>
<div id="busquedaAvanzada" style="display: none;" class="seccionbusqueda"><!--Busqueda con parametros avanzados-->
	<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID Cliente">
	<input name="bRFC" type="text" id="bRFC" class="busqueda" placeholder="RFC Cliente">
	<input name="bNombre" type="text" id="bNombre2" class="busqueda" placeholder="Nombre Cliente"><br>
	<input name="bSexo" type="text" id="bSexo" class="busqueda" placeholder="Sexo del Cliente">
	<input name="bRegimen" type="text" id="bRegimen" class="busqueda" placeholder="Regimen">
	<input name="bCalle" type="text" id="bCalle" class="busqueda" placeholder="Calle"><br>
	<input name="bEdificio" type="text" id="bEdificio" class="busqueda" placeholder="No de Edificio">
	<input name="bCiudad" type="text" id="bCiudad" class="busqueda" placeholder="Ciudad">
	<button onclick="href('?keyword_id=cliente');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar('busquedaAvanzada'); desplegar('busquedaBasica')">Busqueda Basica <span class="fa fa-arrow-circle-left"></span></button>
</div>
<div id="tablaDeResultados"><!--Tabla de resultados de busqueda-->
	<table id = 'dataTable'>
		<tbody class="table-hover">
			<?php 

			require_once(__DIR__."/../Clases/ControladorCliente.php");

    		$clientes = ControladorCliente::frontEndFunctions();
    		$maxreg   = 5;
    		$tabla    = 'dataTable';

			echo "<thead>";
				echo "<tr>";
					echo "<th class='text-left' onclick='decidesort(0, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>ID</th>";
				    echo "<th class='text-left' onclick='decidesort(1, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>RFC</th>";
				    echo "<th class='text-left' onclick='decidesort(2, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Nombre</th>";
				    echo "<th class='text-left' onclick='decidesort(3, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Sexo</th>";
				    echo "<th class='text-left' onclick='decidesort(4, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Regimen</th>";
				    echo "<th class='text-left' onclick='decidesort(5, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Calle</th>";
				    echo "<th class='text-left' onclick='decidesort(6, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>NoEdificio</th>";
				    echo "<th class='text-left' onclick='decidesort(7, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Ciudad</th>";
					echo "<th class='text-left' onclick='inicializeHidden($maxreg, \"$tabla\")' style='font-size: 15px; rowspan=2'>Operaciones</th>";
				echo "<tr>";
			echo "<thead>";
			echo "<tbody class='table-hover'>";

			$i = 1;
			foreach ($clientes as $value) 
		    {
                echo "<tr id='$i'>";
		        	echo "<td>", $value->getID(), "</td>";
			        echo "<td>", $value->getRFC(), "</td>";
			        echo "<td>", $value->getNombre(), "</td>";
			        echo "<td>", $value->getSexo(), "</td>";
			        echo "<td>", $value->getRegimen(), "</td>";
			        echo "<td>", $value->getCalle(), "</td>";
			        echo "<td>", $value->getNoEdificio(), "</td>";
			        echo "<td>", $value->getCiudad()->getAbreviatura(), "</td>";
		            echo "<td style='font-size: 15px;'>";
		            echo "<button onclick = 'changeS($i, \"Cliente\")'><span class='fa fa-pencil'></span></button>";
                    echo "<button onclick = 'deleteS($i, \"al cliente\")'><span class='fa fa-remove'></span></button></td>";
                echo "</tr>";
                $i = $i + 1;
            }
		    echo "</tbody>";
	 		?>
	</table>
	<br>
</div>
<script type="text/javascript">inicializeHidden(5, 'dataTable');</script>
<footer>Herremex, Todos los derechos reservados © 2015</footer>
</body>
</html>