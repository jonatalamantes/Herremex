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
<body onload="fechaHoy();">
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('NuevoEmpleado');?>
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
	Agregar registro de Empleados
</h2>
<a id="operacion" hidden>Insercion</a>
<section class="capturar">
	<table class="capturarTabla">
	    <tr>
            <td>
                <a id = "tipoAccion" hidden></a>
            </td>
        </tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta la CURP del empleado:
				</p>
			</td>
			<td class="tablei">
				<input name="aCURP" type="text" id="aCURP" class="agregacion" placeholder="De 18 Caracteres" onclick="inicializarEmpleado()" onkeyup="pressKey('aCURP', '18');">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta el nombre del empleado:
				</p>
			</td>
			<td class="tablei">
				<input name="aNombre" type="text" id="aNombre" class="agregacion" placeholder="Nombre Empleado" onclick="inicializarEmpleado()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta el Segundo nombre:
				</p>
			</td>
			<td class="tablei">
				<input name="aNombreS" type="text" id="aNombreS" class="agregacion" placeholder="Segundo Nombre" onclick="inicializarEmpleado()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta el apellido paterno:
				</p>
			</td>
			<td class="tablei">
				<input name="aApellidoP" type="text" id="aApellidoP" class="agregacion" placeholder="Apellido Paterno"  onclick="inicializarEmpleado()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta el apellido materno:
				</p>
			</td>
			<td class="tablei">
				<input name="aApellidoM" type="text" id="aApellidoM" class="agregacion" placeholder="Apellido Materno" onclick="inicializarEmpleado()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta la calle del empleado:
				</p>
			</td>
			<td class="tablei">
				<input name="aCalle" type="text" id="aCalle" class="agregacion" placeholder="Calle Empleado" onclick="inicializarEmpleado()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta el numero de la vivienda:
				</p>
			</td>
			<td class="tablei">
				<input name="aNoVivienda" type="text" id="aNoVivienda" class="agregacion" placeholder="Numero Vivienda" onclick="inicializarEmpleado()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta el numero Interior:
				</p>
			</td>
			<td class="tablei">
				<input name="aNoInterior" type="text" id="aNoInterior" class="agregacion" placeholder="Numero Interior" onclick="inicializarEmpleado()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta la colonia:
				</p>
			</td>
			<td class="tablei">
				<input name="aColonia" type="text" id="aColonia" class="agregacion" placeholder="Colonia" onclick="inicializarEmpleado()">
			</td>
		</tr>
		<tr id = 'campo2'>
			<td>
				<p class="campo" id = 'campo'>
					Inserta la contraseña para el Sistema:
				</p>
			</td>
			<td class="tablei">
				<input name="aPass" type="password" id="aPass" class="agregacion" placeholder="Mínimo 8 caracteres" onclick="inicializarEmpleado()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Selecione la ciudad del empleado:
				</p>
			</td>
			<td class="tablei">
				<div class="opciones">
					<?php 
						require_once(__DIR__."/../Clases/ControladorEmpleado.php");
						$ciudades = ControladorEmpleado::obtenerCiudades();

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
			<td>
				<p class="campo" id = 'campo'>
					Selecione el Turno del empleado:
				</p>
			</td>
			<td class="tablei">
				<div class="opciones">
					<?php 
						require_once(__DIR__."/../Clases/ControladorEmpleado.php");
						$turnos = ControladorEmpleado::obtenerTurnos();

						echo '<select id="aTurno">';

						foreach ($turnos as $key => $value) 
						{
							echo "<option id=calidad$key>", $value->getNombre(), "</option>";
						}

						echo "</select>";
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Selecione el tipo de empleado:
				</p>
			</td>
			<td class="tablei">
				<div class="opciones">
					<?php 
						require_once(__DIR__."/../Clases/ControladorEmpleado.php");
						$tipos = ControladorEmpleado::obtenerTipoEmpleados();

						echo '<select id="aTipo">';

						foreach ($tipos as $key => $value) 
						{
							echo "<option id=calidad$key>", $value->getNombre(), "</option>";
						}

						echo "</select>";
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Selecione la sucursal del empleado:
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
			<td colspan="2" align="center">
                <button id = "bAnterior" style="background-color: transparent" onclick="href('busquedaEmpleados')"><span class="fa fa-arrow-left fa-5x"></span></button>
                <button id = "bGuardar" style="background-color: transparent" onclick="guardarEmpleados()"><span class="fa fa-floppy-o fa-5x"></span></button>
			</td>
		</tr>
	</table>
</section>
<footer>Herremex, Todos los derechos reservados © 2015</footer>
<script type="text/javascript">inicializarEmpleado();</script>
</body>
</html>