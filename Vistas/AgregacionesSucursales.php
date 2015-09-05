<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Herremex</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Recursos/css/styleInserciones.css">
	<link rel="stylesheet" href="Recursos/css/font-awesome.css">
	<script type="text/javascript" src="scipts.js"></script>
	<script type="text/javascript" src="Ajax/ajax.js"></script>
</head>
<body  onload="fechaHoy();">
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('NuevaSucursal');?>
<header>
	<h1 class="comp">
		<img src="Recursos/Imagenes/logo.png" class="logo"><!--Logo-->
			Herremex
		<button class="logout" onclick="cerrarSession();"><span class="fa fa-sign-out fa-2x">Salir</span></button>
		<div class="hr5"><hr /></div><!--Linea Morada-->
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
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-truck"></span> Distribuidores</p></a>
				<ul class="sub-menu">
					<li><a href="BusquedaDistribuidores.php">Consultas</a></li>
					<li><a href="AgregacionesDistribuidores.php">Agregaciones</a></li>
				</ul>
			</li>
			<li><a href="#"><p class="menuTitulos"><span class="fa fa-briefcase fa-spin"></span> Sucursales</p></a>
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
	Agregaciones de Sucursales
</h2>
<a id="operacion" hidden>Insercion</a>
<section class="capturar">
	<table class="capturarTabla">
		<tr>
			<td>
				<a id = "tipoAccion" hidden>Agregar</a>
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta la calle de la sucursal:
				</p>
			</td>
			<td class="tablei">
				<input name="aCalle" type="text" id="aCalle" class="agregacion" placeholder="Calle Sucursal" onclick="inicializarSucursal()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta el numero del edificio:
				</p>
			</td>
			<td class="tablei">
				<input name="aNoEdificio" type="text" id="aNoEdificio" class="agregacion" placeholder="Numero Edificio" onclick="inicializarSucursal()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta la colonia:
				</p>
			</td>
			<td class="tablei">
				<input name="aColonia" type="text" id="aColonia" class="agregacion" placeholder="Colonia" onclick="inicializarSucursal()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Selecione la ciudad de la sucursal:
				</p>
			</td>
			<td class="tablei">
				<div class="opciones">
					<?php 
						require_once(__DIR__."/../Clases/ControladorSucursal.php");
						$ciudades = ControladorSucursal::obtenerCiudades();

						echo '<select id="aCiudad">';

						foreach ($ciudades as $key => $value) 
						{
							echo "<option id=calidad$key>", $value->getNombre(), "</option>";
						}

						echo "</select>";
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<button style="background-color: transparent" onclick="guardarSucursal()"><span class="fa fa-floppy-o fa-5x"></span></button>
			</td>
		</tr>
	</table>
</section>
<footer>Herremex, Todos los derechos reservados © 2015</footer>
<script type="text/javascript">inicializarSucursal();</script>
</body>
</html>