<?php 
    
    session_start();
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php");           
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
	require_once(__DIR__."/../Clases/ControladorHerramienta.php");

	ControladorBaseDatos::validarSesionIniciada('NuevaHerramienta');

    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaAgregacionHerramientas.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|operacion|', 'Agregar', $plantilla);
    $plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);
                        
	//Cargar tipos
	$tipos = ControladorHerramienta::obtenerTipoHerramientas();
	$tipoS = "";

	$tipoS = $tipoS . '<select id="aTipo">';

	foreach ($tipos as $key => $value) 
	{
		$tipoS = $tipoS . "<option id=tipos$key>". $value->getNombre(). "</option>";
	}

	$tipoS = $tipoS . "</select>";
    $plantilla = str_replace('|tipos|', $tipoS, $plantilla);

	//Cargar marcas
	$marcas = ControladorHerramienta::obtenerMarcas();
	$marcaS = "";

	$marcaS = $marcaS . '<select id="aMarca">';

	foreach ($marcas as $key => $value) 
	{
		$marcaS = $marcaS ."<option id=marca$key>". $value->getNombre(). "</option>";
	}

	$marcaS = $marcaS . "</select>";
    $plantilla = str_replace('|marcas|', $marcaS, $plantilla);

    echo $plantilla;

?>
