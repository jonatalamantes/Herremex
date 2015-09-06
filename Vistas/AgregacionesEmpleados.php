<?php 
    
    session_start();
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php");           
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
	require_once(__DIR__."/../Clases/ControladorSucursal.php");
	require_once(__DIR__."/../Clases/ControladorEmpleado.php");

	ControladorBaseDatos::validarSesionIniciada('NuevoEmpleado');

    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaAgregacionEmpleados.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|operacion|', 'Agregar', $plantilla);
    $plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);
                        
    //Cargar ciudades
	$ciudades = ControladorEmpleado::obtenerCiudades();
	$ciudadesS = "";

	$ciudadesS = $ciudadesS . '<select id="aCiudad">';

	foreach ($ciudades as $key => $value) 
	{
		$ciudadesS = $ciudadesS . "<option id=calidad$key>". $value->getNombre(). "</option>";
	}

	$ciudadesS = $ciudadesS . "</select>";
    $plantilla = str_replace('|ciudades|', $ciudadesS, $plantilla);

	//Cargar turnos
	$turnos = ControladorEmpleado::obtenerTurnos();
	$turnosS = "";

	$turnosS = $turnosS . '<select id="aTurno">';

	foreach ($turnos as $key => $value) 
	{
		$turnosS = $turnosS . "<option id=calidad$key>". $value->getNombre(). "</option>";
	}

	$turnosS = $turnosS . "</select>";
    $plantilla = str_replace('|turnos|', $turnosS, $plantilla);

	//Cargar los tipos
	$tipos = ControladorEmpleado::obtenerTipoEmpleados();
	$tiposS = "";

	$tiposS = $tiposS . '<select id="aTipo">';

	foreach ($tipos as $key => $value) 
	{
		$tiposS = $tiposS . "<option id=calidad$key>". $value->getNombre(). "</option>";
	}

	$tiposS = $tiposS . "</select>";
    $plantilla = str_replace('|tipos|', $tiposS, $plantilla);

	//Carga las sucursales
	$tipos = ControladorSucursal::obtenerSucursales();
	$tiposS = "";

	$tiposS = $tiposS . '<select id="aSucursales">';

	foreach ($tipos as $key => $value) 
	{
		$tiposS = $tiposS . "<option id=sucursal$key>". $value->getColonia(). "</option>";
	}

	$tiposS = $tiposS . "</select>";
    $plantilla = str_replace('|sucursales|', $tiposS, $plantilla);

    echo $plantilla;

?>
