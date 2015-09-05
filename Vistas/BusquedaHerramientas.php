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
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('MostrarHerramienta'); ?>
<header>
	<h1 class="comp">
		<img src="Recursos/Imagenes/logo.png" class="logo"><!--Logo-->
			Herremex
		<button class="logout" onclick="cerrarSession();"><span class="fa fa-sign-out fa-2x">Salir</span></button>
		<div class="hr1"><hr /></div><!--Linea Azul-->
		<ul class="menu">
			<li><a href="menu.php"><p class="menuTitulos"><span class="fa fa-home" ></span> Menu</p></a>
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-cog fa-spin" ></span> Herramientas</p></a>
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
	<button id = 'prev' onclick="prev(5, 'dataTable')" hidden><span class="fa fa-arrow-left fa-2x"></span></button>
	Busqueda de Herramientas
	<button id = 'next' onclick="next(5, 'dataTable')" hidden><span class="fa fa-arrow-right fa-2x"></span></button>
</h2>
<div id="busquedaBasica" class="seccionbusqueda"><!--Busqueda con parametros basicos-->
	<input name="bNombre" type="text" id="bNombre1" class="busqueda" placeholder="Nombre Herramienta">
	<button onclick="href('?keyword=data');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar('busquedaAvanzada');desplegar('busquedaBasica')">Busqueda Avanzada <span class="fa fa-arrow-circle-right"></span></button>
</div>
<div id="busquedaAvanzada" style="display: none;" class="seccionbusqueda"><!--Busqueda con parametros avanzados-->
	<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID Herramienta">
	<input name="bNombre" type="text" id="bNombre2" class="busqueda" placeholder="Nombre Herramienta"><br>
	<input name="bTipo" type="text" id="bTipo" class="busqueda" placeholder="Tipo Herramienta">
	<input name="bPrecio" type="text" id="bPrecio" class="busqueda" placeholder="Precio Herramienta">
	<button onclick="href('?keyword_id=herramienta');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar('busquedaAvanzada'); desplegar('busquedaBasica')">Busqueda Basica <span class="fa fa-arrow-circle-left"></span></button>
</div>
<div id="tablaDeResultados"><!--Tabla de resultados de busqueda-->
	<table id = 'dataTable'>
		<tbody class="table-hover">
			<?php 

			require_once(__DIR__."/../Clases/ControladorHerramienta.php");

    		$herramientas = ControladorHerramienta::frontEndFunctions();
    		$maxreg   = 5;
    		$tabla    = 'dataTable';

    		$tipoActual = ControladorBaseDatos::obtenerTipoUsuario();
    		$hidden = "";

    		if ($tipoActual == 'A' || $tipoActual == 'V')
			{
				$hidden = "hidden";
			}

			echo "<thead>";
				echo "<tr>";
					echo "<th class='text-left' onclick='decidesort(0, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>ID</th>";
				    echo "<th class='text-left' onclick='decidesort(1, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Tipo</th>";
				    echo "<th class='text-left' onclick='decidesort(2, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Precio</th>";
				    echo "<th class='text-left' onclick='decidesort(3, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Nombre</th>";
				    echo "<th class='text-left' onclick='decidesort(4, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Marca</th>";
				    echo "<th class='text-left' onclick='decidesort(5, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Cantidad</th>";
				    echo "<th class='text-left' onclick='decidesort(6, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Calidad</th>";
				    echo "<th class='text-left' onclick='decidesort(7, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Precio Compra</th>";
					echo "<th class='text-left' $hidden onclick='inicializeHidden($maxreg, \"$tabla\")' style='font-size: 15px; rowspan=2'>Operaciones</th>";
				echo "<tr>";
			echo "<thead>";
			echo "<tbody class='table-hover'>";

			$i = 1;
			foreach ($herramientas as $value) 
		    {
		        $marca = $value->getMarca() !== NULL ? $value->getMarca()->getNombre() : "Sin Marca";
		        $cantidad = $value->getCantidad() !== NULL ? $value->getCantidad() : 0;
		        $calidad = $value->getCalidad() !== NULL ? $value->getCalidad()->getNombre() : "Sin Calidad";
		        $precioC = $value->getPrecioCompra() !== NULL ? $value->getPrecioCompra() : 0;

                echo "<tr id='$i'>";
		        	echo "<td>", $value->getID(), "</td>";
			        echo "<td>", $value->getTipo()->getNombre(), "</td>";
			        echo "<td>", $value->getPrecio(), "</td>";
			        echo "<td>", $value->getNombre(), "</td>";
			        echo "<td>", $marca, "</td>";
			        echo "<td>", $cantidad, "</td>";
			        echo "<td>", $calidad, "</td>";
			        echo "<td>", $precioC, "</td>";
	                echo "<td $hidden style='font-size: 15px;'><button onclick='changeS($i, \"Herramienta\")'><span class='fa fa-pencil'></span></button>";
                    echo "<button onclick = 'deleteS($i, \"a la herramienta\")'><span class='fa fa-remove'></span></button></td>";
                echo "</tr>";
                $i = $i + 1;
		    }

		    echo "</tbody>";
	 		?>
	</table>
	<button id = 'next' onclick="next(5, 'dataTable')" hidden>Next</button>
	<button id = 'prev' onclick="prev(5, 'dataTable')" hidden>Prev</button>
	<br>
</div>
<script type="text/javascript">inicializeHidden(5, 'dataTable');</script>
<footer>Herremex, Todos los derechos reservados © 2015</footer>
</body>
</html>