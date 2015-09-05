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
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('MostrarEmpleado');?>
<header>
	<h1 class="comp">
		<img src="Recursos/Imagenes/logo.png" class="logo"><!--Logo-->
			Herremex
        <button class="logout" onclick="cerrarSession();"><span class="fa fa-sign-out fa-2x">Salir</span></button>
		<div class="hr3"><hr /></div><!--Linea Anaranjada-->
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
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-book fa-spin"></span> Empleados</p></a>
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
	Busqueda de Empleados
	<button id = 'next' onclick="next(5, 'dataTable')" hidden><span class="fa fa-arrow-right fa-2x"></span></button>
</h2>
<div id="busquedaBasica" class="seccionbusqueda"><!--Busqueda con parametros basicos-->
	<input name="bNombre" type="text" id="bNombre1" class="busqueda" placeholder="Nombre Empleado">
	<button onclick="href('?keyword=data');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar('busquedaAvanzada');desplegar('busquedaBasica')">Busqueda Avanzada <span class="fa fa-arrow-circle-right"></span></button>
</div>
<div id="busquedaAvanzada" style="display: none;" class="seccionbusqueda"><!--Busqueda con parametros avanzados-->
	<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID Empleado">
	<input name="bCURP" type="text" id="bCURP" class="busqueda" placeholder="CURP Empleado">
	<input name="bNombre" type="text" id="bNombre2" class="busqueda" placeholder="Nombre Empleado"><br>
	<input name="bNombreS" type="text" id="bNombreS" class="busqueda" placeholder="Segundo Nombre">
	<input name="bApellidoP" type="text" id="bApellidoP" class="busqueda" placeholder="Apellido Paterno">
	<input name="bApellidoM" type="text" id="bApellidoM" class="busqueda" placeholder="Apellido Materno"><br>
	<input name="bCalle" type="text" id="bCalle" class="busqueda" placeholder="Calle">
	<input name="bColonia" type="text" id="bColonia" class="busqueda" placeholder="Colonia">
	<input name="bNCasa" type="text" id="bNCasa" class="busqueda" placeholder="Numero de Casa"><br>
	<input name="bNCasaE" type="text" id="bNCasaI" class="busqueda" placeholder="Numero Interior">
	<input name="bCiudad" type="text" id="bCiudad" class="busqueda" placeholder="Ciudad">
	<input name="bTurno" type="text" id="bTurno" class="busqueda" placeholder="Turno"><br>
	<input name="bTipo" type="text" id="bTipo" class="busqueda" placeholder="Tipo">
	<button onclick="href('?keyword_id=empleado');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar('busquedaAvanzada'); desplegar('busquedaBasica')">Busqueda Basica <span class="fa fa-circle-arrow-left"></span></button>
</div>
<div id="tablaDeResultados"><!--Tabla de resultados de busqueda-->
	<table id = 'dataTable'> 
	   <tbody class="table-hover">
			<?php 

            require_once(__DIR__."/../Clases/ControladorEmpleado.php");

            $empleados = ControladorEmpleado::frontEndFunctions();
            $maxreg   = 5;
            $tabla    = 'dataTable';

            echo "<thead>";
                echo "<tr>";
                    echo "<th class='text-left' onclick='decidesort(0, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>ID</th>";
                    echo "<th class='text-left' onclick='decidesort(1, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>CURP</th>";
                    echo "<th class='text-left' onclick='decidesort(2, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Nombre</th>";
                    echo "<th class='text-left' onclick='decidesort(3, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Turno</th>";
                    echo "<th class='text-left' onclick='decidesort(4, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Tipo</th>";
                    echo "<th class='text-left' onclick='decidesort(5, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Sucursal</th>";
                    echo "<th class='text-left' onclick='inicializeHidden($maxreg, \"$tabla\")'>Operaciones</th>";
                echo "<tr>";
            echo "<thead>";
            echo "<tbody class='table-hover'>";

            $i = 1;
            foreach ($empleados as $value) 
            {
                $sucursal = $value->getSucursal() !== NULL ? $value->getSucursal()->getColonia() : "Sin Sucursal";

                echo "<tr id='$i'>";
	                echo "<td>", $value->getID(), "</td>";
	                echo "<td>", $value->getCurp(), "</td>";
	                echo "<td>", $value->getNombre(), " ", $value->getSegundoNombre(), 
	                     " ", $value->getApellidoPaterno(), " ", $value->getApellidoMaterno();
	                echo "<td>", $value->getTurno()->getNombre(), "</td>";
	                echo "<td>", $value->getTipoEmpleado()->getNombre(), "</td>";
	                echo "<td>", $sucursal, "</td>";
                    echo "<td><button onclick='mostrarS($i)'><span class='fa fa-eye'></span></button>";
	                echo "<button onclick='changeS($i, \"Empleado\")'><span class='fa fa-pencil'></span></button>";
                    echo "<button onclick = 'cambiarClave($i)'><span class='fa fa-key'></span></button>";
                    echo "<button onclick = 'deleteS($i, \"al empleado\")'><span class='fa fa-remove'></span></button></td>";
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