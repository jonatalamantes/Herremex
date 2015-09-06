<?php 
	session_start();

	require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 
	require_once(__DIR__."/../Clases/DesplegadorInterfaz.php"); 
	require_once(__DIR__."/../Clases/ControladorSucursal.php");

	ControladorBaseDatos::validarSesionIniciada('MostrarSucursal');

	$plantilla = file_get_contents(__DIR__."/Plantillas/plantillaBusqueda.html");
	$plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
	$plantilla = str_replace('|objeto|', 'Sucursal', $plantilla);
	$plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);

	$inputNormal = '<input name="bNombre" type="text" id="bNombre1" class="busqueda" placeholder="Nombre Sucursal">
	<button onclick="href(\'?keyword=data\');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar(\'busquedaAvanzada\');desplegar(\'busquedaBasica\')">Busqueda Avanzada <span class="fa fa-arrow-circle-right"></span></button>';

	$inputAvanzado = '<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID Sucursal">
	<input name="bCalle" type="text" id="bCalle" class="busqueda" placeholder="Calle Sucursal"><br>
	<input name="bColonia" type="text" id="bColonia" class="busqueda" placeholder="Colonia Sucursal">
	<input name="bNoEdificio" type="text" id="bNoEdificio" class="busqueda" placeholder="No Edificio">
	<input name="bCiudad" type="text" id="bCiudad" class="busqueda" placeholder="Ciudad Sucursal">
	<button onclick="href(\'?keyword_id=sucursal\');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar(\'busquedaAvanzada\'); desplegar(\'busquedaBasica\')">Busqueda Basica <span class="fa fa-arrow-circle-left"></span></button>';

	$plantilla = str_replace('|busquedaBasica|', $inputNormal, $plantilla);
	$plantilla = str_replace('|busquedaAvanzada|', $inputAvanzado, $plantilla);

	$sucursales = ControladorSucursal::frontEndFunctions();
	$maxreg   = 5;
	$tabla    = 'dataTable';

	$tipoActual = ControladorBaseDatos::obtenerTipoUsuario();
	$hidden = "";

	if ($tipoActual == 'G')
	{
		$hidden = "hidden";
	}

	$conTab = $conTab . "<thead>";
		$conTab = $conTab . "<tr>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(0, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>ID</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(1, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Calle</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(2, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Colonia</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(3, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>NoEdificio</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(4, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Ciudad</th>";
			$conTab = $conTab . "<th class='text-left' $hidden onclick='inicializeHidden($maxreg, \"$tabla\")' style='font-size: 15px; rowspan=2'>Operaciones</th>";
		$conTab = $conTab . "<tr>";
	$conTab = $conTab . "<thead>";
	$conTab = $conTab . "<tbody class='table-hover'>";

	$i = 1;
	foreach ($sucursales as $value) 
    {
        $conTab = $conTab . "<tr id='$i'>";
	        $conTab = $conTab . "<td>". $value->getID(). "</td>";
	        $conTab = $conTab . "<td>". $value->getCalle(). "</td>";
	        $conTab = $conTab . "<td>". $value->getColonia(). "</td>";
	        $conTab = $conTab . "<td>". $value->getNoEdificio(). "</td>";
	       	$conTab = $conTab . "<td>". $value->getCiudad()->getAbreviatura(). "</td>";
            $conTab = $conTab . "<td $hidden style='font-size: 15px;'>";
            $conTab = $conTab . "<button onclick = 'changeS($i, \"Sucursal\")'><span class='fa fa-pencil'></span></button>";
            $conTab = $conTab . "<button onclick = 'deleteS($i, \"a la sucursal\")'><span class='fa fa-remove'></span></button></td>";
        $conTab = $conTab . "</tr>";
        $i = $i + 1;
    }

	$conTab = $conTab . "</tbody>";

	$plantilla = str_replace('|tablaContenido|', $conTab, $plantilla);
	echo $plantilla;

?>