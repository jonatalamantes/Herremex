<?php 

	session_start(); 
	require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 
	require_once(__DIR__."/../Clases/DesplegadorInterfaz.php"); 
	require_once(__DIR__."/../Clases/ControladorCliente.php");

	ControladorBaseDatos::validarSesionIniciada('MostrarCliente');

	$plantilla = file_get_contents(__DIR__."/Plantillas/plantillaBusqueda.html");
	$plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
	$plantilla = str_replace('|objeto|', 'Clientes', $plantilla);
	$plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);

	$inputNormal = '<input name="bNombre" type="text" id="bNombre1" class="busqueda" placeholder="Nombre Cliente">
	<button onclick="href(\'?keyword=data\');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar(\'busquedaAvanzada\');desplegar(\'busquedaBasica\')">Busqueda Avanzada <span class="fa fa-arrow-circle-right"></span></button>';

	$inputAvanzado = '	<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID Cliente">
	<input name="bRFC" type="text" id="bRFC" class="busqueda" placeholder="RFC Cliente">
	<input name="bNombre" type="text" id="bNombre2" class="busqueda" placeholder="Nombre Cliente"><br>
	<input name="bSexo" type="text" id="bSexo" class="busqueda" placeholder="Sexo del Cliente">
	<input name="bRegimen" type="text" id="bRegimen" class="busqueda" placeholder="Regimen">
	<input name="bCalle" type="text" id="bCalle" class="busqueda" placeholder="Calle"><br>
	<input name="bEdificio" type="text" id="bEdificio" class="busqueda" placeholder="No de Edificio">
	<input name="bCiudad" type="text" id="bCiudad" class="busqueda" placeholder="Ciudad">
	<button onclick="href(\'?keyword_id=cliente\');" class="lupa"><span class="fa fa-search"></span></button>
	<button onclick="desplegar(\'busquedaAvanzada\'); desplegar(\'busquedaBasica\')">Busqueda Basica <span class="fa fa-arrow-circle-left"></span></button>';

	$plantilla = str_replace('|busquedaBasica|', $inputNormal, $plantilla);
	$plantilla = str_replace('|busquedaAvanzada|', $inputAvanzado, $plantilla);

    $clientes = ControladorCliente::frontEndFunctions();
    $maxreg   = 5;
    $tabla    = 'dataTable';

    $conTab = "";
    $conTab = $conTab . "<thead>";
        $conTab = $conTab . "<tr>";
            $conTab = $conTab . "<th class='text-left' onclick='decidesort(0, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>ID</th>";
            $conTab = $conTab . "<th class='text-left' onclick='decidesort(1, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>RFC</th>";
            $conTab = $conTab . "<th class='text-left' onclick='decidesort(2, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Nombre</th>";
            $conTab = $conTab . "<th class='text-left' onclick='decidesort(3, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Sexo</th>";
            $conTab = $conTab . "<th class='text-left' onclick='decidesort(4, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Regimen</th>";
            $conTab = $conTab . "<th class='text-left' onclick='decidesort(5, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Calle</th>";
            $conTab = $conTab . "<th class='text-left' onclick='decidesort(6, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>NoEdificio</th>";
            $conTab = $conTab . "<th class='text-left' onclick='decidesort(7, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Ciudad</th>";
            $conTab = $conTab . "<th class='text-left' onclick='inicializeHidden($maxreg, \"$tabla\")' style='font-size: 15px; rowspan=2'>Operaciones</th>";
        $conTab = $conTab . "<tr>";
    $conTab = $conTab . "<thead>";
    $conTab = $conTab . "<tbody class='table-hover'>";

    $i = 1;
    foreach ($clientes as $value) 
    {
        $conTab = $conTab . "<tr id='$i'>";
            $conTab = $conTab . "<td>". $value->getID(). "</td>";
            $conTab = $conTab . "<td>". $value->getRFC(). "</td>";
            $conTab = $conTab . "<td>". $value->getNombre(). "</td>";
            $conTab = $conTab . "<td>". $value->getSexo(). "</td>";
            $conTab = $conTab . "<td>". $value->getRegimen(). "</td>";
            $conTab = $conTab . "<td>". $value->getCalle(). "</td>";
            $conTab = $conTab . "<td>". $value->getNoEdificio(). "</td>";
            $conTab = $conTab . "<td>". $value->getCiudad()->getAbreviatura(). "</td>";
            $conTab = $conTab . "<td style='font-size: 15px;'>";
            $conTab = $conTab . "<button onclick = 'changeS($i, \"Cliente\")'><span class='fa fa-pencil'></span></button>";
            $conTab = $conTab . "<button onclick = 'deleteS($i, \"al cliente\")'><span class='fa fa-remove'></span></button></td>";
        $conTab = $conTab . "</tr>";
    }

	$plantilla = str_replace('|tablaContenido|', $conTab, $plantilla);

	echo $plantilla;
?>