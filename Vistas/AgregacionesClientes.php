<?php 
	
	session_start();
	require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 	       
	require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
	require_once(__DIR__."/../Clases/ControladorCliente.php");

	ControladorBaseDatos::validarSesionIniciada('NuevoCliente');

	$plantilla = file_get_contents(__DIR__."/Plantillas/plantillaAgregacionClientes.html");
	$plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
	$plantilla = str_replace('|operacion|', 'Agregar', $plantilla);
	$plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);

    $ciudades = ControladorCliente::obtenerCiudades();
    $ciudadString = "";

    $ciudadString = $ciudadString . '<select id="aCiudad">';

    foreach ($ciudades as $key => $value) 
    {
        $ciudadString = $ciudadString . "<option id=calidad$key>". $value->getNombre(). "</option>";
    }

    $ciudadString = $ciudadString . "</select>";

   	$plantilla = str_replace('|ciudades|', $ciudadString, $plantilla);

   	echo $plantilla;
?>
