<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Herremex</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Recursos/css/styleMenu.css">
	<link rel="stylesheet" href="Recursos/css/font-awesome.css">
	<script type="text/javascript" src="scipts.js"></script>
    <script type="text/javascript" src="Ajax/ajax.js"></script>
</head>
<body>
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('Menu');?>
<header>
	<h1 class="comp">
		<img src="Recursos/Imagenes/logo.png" class="logo"><!--Logo-->
			Herremex
        <button class="logout" onclick="cerrarSession();"><span class="fa fa-sign-out fa-2x">Salir</span></button>
		<div class="hr0"><hr /></div><!--Linea Negra-->
	</h1>
</header>
<h2>
	<?php 
		require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 
		echo "Bievenid@ " . ControladorBaseDatos::obtenerNombreUsuario(); 
	?>
</h2>
<h2>
	¿A que menú quieres acceder?
</h2>
<a id="operacion" hidden>Menú</a>
<section class="menu">
	<table class="menuTabla">

	<?php 

		$tipo = ControladorBaseDatos::obtenerTipoUsuario();

		if ($tipo == 'V' || $tipo == 'A')
		{
			echo "<tr>
					<td id='opc1'>
						<a href='BusquedaHerramientas.php' class='hvr-wobble-vertical'>
							<span class='fa fa-cog fa-5x'></span>
							<p class='titulo'>Herramientas</p>
						</a>
					</td>
				 </tr>";
		}
		else if ($tipo == 'C')
		{
			echo "<tr>
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
		else
		{
			echo "<tr>
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

	 ?>
	</table>
</section>

<footer>Herremex, Todos los derechos reservados © 2015</footer>
</body>
</html>