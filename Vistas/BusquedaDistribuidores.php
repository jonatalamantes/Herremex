<?php 

	session_start(); 
	require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 
	require_once(__DIR__."/../Clases/DesplegadorInterfaz.php"); 
	require_once(__DIR__."/../Clases/ControladorCliente.php");
	require_once(__DIR__."/../Clases/ControladorDistribuidor.php");

	ControladorBaseDatos::validarSesionIniciada('MostrarDistribuidor');

	$plantilla = file_get_contents(__DIR__."/Plantillas/plantillaBusqueda.html");
	$plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
	$plantilla = str_replace('|objeto|', 'Distribuidor', $plantilla);
	$plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);

	$inputNormal = '<input name="bNombre" type="text" id="bNombre1" class="busqueda" placeholder="Nombre Distribuidor">
	<button onclick="href(\?keyword=data\');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar(\'busquedaAvanzada\');desplegar(\'busquedaBasica\')">Busqueda Avanzada <span class="fa fa-arrow-circle-right"></span></button>';

	$inputAvanzado = '<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID Distribuidores">
	<input name="bNombre" type="text" id="bNombre2" class="busqueda" placeholder="Nombre Distribuidores"><br>
	<input name="bDireccion" type="text" id="bDireccion" class="busqueda" placeholder="Direccion Distribuidor">
	<button onclick="href(\'?keyword_id=distribuidor\');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar(\'busquedaAvanzada\'); desplegar(\'busquedaBasica\')">Busqueda Basica <span class="fa fa-arrow-circle-left"></span></button>';

	$plantilla = str_replace('|busquedaBasica|', $inputNormal, $plantilla);
	$plantilla = str_replace('|busquedaAvanzada|', $inputAvanzado, $plantilla);

	$Distribuidores = ControladorDistribuidor::frontEndFunctions();
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
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(1, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Nombre</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(2, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Direccion</th>";
		    $conTab = $conTab . "<th class='text-left' onclick='decidesort(3, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Herramienta</th>";
			$conTab = $conTab . "<th class='text-left' $hidden onclick='inicializeHidden($maxreg, \"$tabla\")' style='font-size: 15px; rowspan=2'>Operaciones</th>";
		$conTab = $conTab . "<tr>";
	$conTab = $conTab . "<thead>";
	$conTab = $conTab . "<tbody class='table-hover'>";

	$i = 1;
	foreach ($Distribuidores as $value) 
    {
        $value->getHerramienta() !== NULL ? $herramienta = $value->getHerramienta()->getNombre() : 
        									$herramienta = "Sin Herramienta";

        $conTab = $conTab . "<tr id='$i'>";
        	$conTab = $conTab . "<td>". $value->getID(). "</td>";
	        $conTab = $conTab . "<td>". $value->getNombre(). "</td>";
	        $conTab = $conTab . "<td>". $value->getDireccion(). "</td>";
	        $conTab = $conTab . "<td>". $herramienta. "</td>";
            $conTab = $conTab . "<td $hidden  style='font-size: 15px;'>";
            $conTab = $conTab . "<button onclick = 'changeS($i, \"Distribuidor\")'><span class='fa fa-pencil'></span></button>";
            $conTab = $conTab . "<button onclick = 'deleteS($i, \"al distribuidor\")'><span class='fa fa-remove'></span></button></td>";
        $conTab = $conTab . "</tr>";
        $i = $i + 1;
    }
	
	$conTab = $conTab . "</tbody>";

	$plantilla = str_replace('|tablaContenido|', $conTab, $plantilla);
	echo $plantilla;

?>