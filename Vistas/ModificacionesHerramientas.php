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
<?php require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); ControladorBaseDatos::validarSesionIniciada('NuevaHerramienta');?>
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
	Datos actuales de la Herramienta
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
					Inserta el nombre de la herramienta:
				</p>
			</td>
			<td class="tablei">
				<input name="aNombre" type="text" id="aNombre" class="agregacion" placeholder="Nombre Herramienta" onclick="inicializarHerramienta()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Selecione el tipo de la herramienta:
				</p>
			</td>
			<td class="tablei">
				<div class="opciones">
					<?php 
						require_once(__DIR__."/../Clases/ControladorHerramienta.php");
						$tipos = ControladorHerramienta::obtenerTipoHerramientas();

						echo '<select id="aTipo">';

						foreach ($tipos as $key => $value) 
						{
							echo "<option id=tipos$key>", $value->getNombre(), "</option>";
						}

						echo "</select>";
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta el precio de la herramienta:
				</p>
			</td>
			<td class="tablei">
				<input name="aPrecio" type="text" id="aPrecio" class="agregacion" placeholder="Precio Herramienta" onclick="inicializarHerramienta()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Inserta la cantidad de la herramienta:
				</p>
			</td>
			<td class="tablei">
				<input name="aCantidad" type="text" id="aCantidad" class="agregacion" placeholder="Cantidad de Herramientas" onclick="inicializarHerramienta()">
			</td>
		</tr>
		<tr>
			<td>
				<p class="campo" id = 'campo'>
					Selecione la marca de la herramienta:
				</p>
			</td>
			<td class="tablei">
				<div class="opciones">
					<?php 
						require_once(__DIR__."/../Clases/ControladorHerramienta.php");
						$marcas = ControladorHerramienta::obtenerMarcas();

						echo '<select id="aMarca">';

						foreach ($marcas as $key => $value) 
						{
							echo "<option id=marca$key>", $value->getNombre(), "</option>";
						}

						echo "</select>";
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<button style="background-color: transparent" onclick="guardarHerramienta()"><span class="fa fa-floppy-o fa-5x"></span></button>
			</td>
		</tr>
	</table>
</section>
<?php 
    require_once(__DIR__."/../Clases/ControladorHerramienta.php");
    $url = ControladorBaseDatos::getRestoURL();

    if ($url != '')
    {
    	$url = substr($url, 4);

        if (is_numeric($url))
        {
            $id = intval($url);

            $Herramienta = ControladorHerramienta::obtenerHerramientaID($id);

            if ($Herramienta != NULL)
            {
	            $precio = $Herramienta->getPrecio();
	            $nombre = $Herramienta->getNombre();
	            $cantidad = $Herramienta->getCantidad();

                //Establece datos de objetos dentro de objetos
                echo "<script>
                    	document.getElementById('aNombre').value   = '$nombre';
					    document.getElementById('aPrecio').value   = '$precio';
					    document.getElementById('aCantidad').value = '$cantidad';";

                $index = 0;
                $marcas = ControladorHerramienta::obtenerMarcas();

                foreach ($marcas as $key => $value) 
                {
                	if ($Herramienta->getMarca() == NULL)
                	{
                		continue;
                	}

                    if ($value->getID() == $Herramienta->getMarca()->getID())
                    {
                        $index = $key;
                        break;
                    }
                }

                echo "document.getElementById('aMarca').options.selectedIndex = $index;";

                $index = 0;
                $tipos = ControladorHerramienta::obtenerTipoHerramientas();

                foreach ($tipos as $key => $value) 
                {
                    if ($value->getID() == $Herramienta->getTipo()->getID())
                    {
                        $index = $key;
                        break;
                    }
                }

                echo "document.getElementById('aTipo').options.selectedIndex = $index;";

                echo "inicializarHerramienta();
            		</script>";

            }
        }
    }
 ?>
<footer>Herremex, Todos los derechos reservados © 2015</footer>
<script type="text/javascript">inicializarHerramienta();</script>
</body>
</html>