<?php 
	session_start();
	require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 
	require_once(__DIR__."/../Clases/DesplegadorInterfaz.php"); 
	require_once(__DIR__."/../Clases/ControladorCliente.php");
	require_once(__DIR__."/../Clases/ControladorHerramienta.php");

	ControladorBaseDatos::validarSesionIniciada('MostrarHerramienta'); 

	$plantilla = file_get_contents(__DIR__."/Plantillas/plantillaBusqueda.html");
	$plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
	$plantilla = str_replace('|objeto|', 'Herramientas', $plantilla);
	$plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);

	$inputNormal = '<input name="bNombre" type="text" id="bNombre1" class="busqueda" placeholder="Nombre Herramienta">
	<button onclick="href(\'?keyword=data\');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar(\'busquedaAvanzada\');desplegar(\'busquedaBasica\')">Busqueda Avanzada <span class="fa fa-arrow-circle-right"></span></button>';

	$inputAvanzado = '	<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID Herramienta">
	<input name="bNombre" type="text" id="bNombre2" class="busqueda" placeholder="Nombre Herramienta"><br>
	<input name="bTipo" type="text" id="bTipo" class="busqueda" placeholder="Tipo Herramienta">
	<input name="bPrecio" type="text" id="bPrecio" class="busqueda" placeholder="Precio Herramienta">
	<button onclick="href(\'?keyword_id=herramienta\');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar(\'busquedaAvanzada\'); desplegar(\'busquedaBasica\')">Busqueda Basica <span class="fa fa-arrow-circle-left"></span></button>';

	$plantilla = str_replace('|busquedaBasica|', $inputNormal, $plantilla);
	$plantilla = str_replace('|busquedaAvanzada|', $inputAvanzado, $plantilla);

	$herramientas = ControladorHerramienta::frontEndFunctions();
	$maxreg   = 5;
	$tabla    = 'dataTable';

	$tipoActual = ControladorBaseDatos::obtenerTipoUsuario();
	$hidden = "";

	if ($tipoActual == 'A' || $tipoActual == 'V')
	{
		$hidden = "hidden";
	}

	$conTab = $conTab . "<thead>";
		$conTab = $conTab . "<tr>";
			$conTab = $conTab . "<th class='text-left' onclick='decidesort(0, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>ID</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(1, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Tipo</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(2, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Precio</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(3, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Nombre</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(4, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Marca</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(5, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Cantidad</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(6, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Calidad</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(7, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Precio Compra</th>";
			$conTab = $conTab . "<th class='text-left' $hidden onclick='inicializeHidden($maxreg, \"$tabla\")' style='font-size: 15px; rowspan=2'>Operaciones</th>";
		$conTab = $conTab . "<tr>";
	$conTab = $conTab . "<thead>";
	$conTab = $conTab . "<tbody class='table-hover'>";

	$i = 1;
	foreach ($herramientas as $value) 
    {
        $marca = $value->getMarca() !== NULL ? $value->getMarca()->getNombre() : "Sin Marca";
        $cantidad = $value->getCantidad() !== NULL ? $value->getCantidad() : 0;
        $calidad = $value->getCalidad() !== NULL ? $value->getCalidad()->getNombre() : "Sin Calidad";
        $precioC = $value->getPrecioCompra() !== NULL ? $value->getPrecioCompra() : 0;

        $conTab = $conTab . "<tr id='$i'>";
        	$conTab = $conTab . "<td>". $value->getID(). "</td>";
	        $conTab = $conTab . "<td>". $value->getTipo()->getNombre(). "</td>";
	        $conTab = $conTab . "<td>". $value->getPrecio(). "</td>";
	        $conTab = $conTab . "<td>". $value->getNombre(). "</td>";
	        $conTab = $conTab . "<td>". $marca. "</td>";
	        $conTab = $conTab . "<td>". $cantidad. "</td>";
	        $conTab = $conTab . "<td>". $calidad. "</td>";
	        $conTab = $conTab . "<td>". $precioC. "</td>";
            $conTab = $conTab . "<td $hidden style='font-size: 15px;'><button onclick='changeS($i, \"Herramienta\")'><span class='fa fa-pencil'></span></button>";
            $conTab = $conTab . "<button onclick = 'deleteS($i, \"a la herramienta\")'><span class='fa fa-remove'></span></button></td>";
        $conTab = $conTab . "</tr>";
        $i = $i + 1;
    }

	$conTab = $conTab . "</tbody>";

	$plantilla = str_replace('|tablaContenido|', $conTab, $plantilla);
	echo $plantilla;

?>