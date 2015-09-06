<?php 
	
	session_start();
	require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 	       
	require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
	require_once(__DIR__."/../Clases/ControladorSucursal.php");

	ControladorBaseDatos::validarSesionIniciada('NuevoSucursal');

	$plantilla = file_get_contents(__DIR__."/Plantillas/plantillaAgregacionSucursal.html");
	$plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
	$plantilla = str_replace('|operacion|', 'Modificar', $plantilla);
	$plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);

    $ciudades = ControladorSucursal::obtenerCiudades();
    $ciudadString = "";

    $ciudadString = $ciudadString . '<select id="aCiudad">';

    foreach ($ciudades as $key => $value) 
    {
        $ciudadString = $ciudadString . "<option id=calidad$key>". $value->getNombre(). "</option>";
    }

    $ciudadString = $ciudadString . "</select>";

   	$plantilla = str_replace('|ciudades|', $ciudadString, $plantilla);

   	echo $plantilla;

	$url = ControladorBaseDatos::getRestoURL();

	if ($url != '')
	{
		$url = substr($url, 4);

		if (is_numeric($url))
		{
			$id = intval($url);

			$Sucursal = ControladorSucursal::obtenerSucursalID($id);

			if ($Sucursal != NULL)
			{
	            $calle 	  = $Sucursal->getCalle();
	            $colonia  = $Sucursal->getColonia();
	            $edificio = $Sucursal->getNoEdificio();

	            //Establece datos de objetos dentro de objetos
				echo "<script>
					    document.getElementById('aCalle').value = '$calle';
					    document.getElementById('aNoEdificio').value = '$edificio';
					    document.getElementById('aColonia').value = '$colonia';";

			    $ciudades = ControladorSucursal::obtenerCiudades();
			    $selector = 0;

			    foreach ($ciudades as $key => $value) 
			    {
			    	if ($value->getAbreviatura() == $Sucursal->getCiudad()->getAbreviatura())
			    	{
			    		$selector = $key;
			    		break;
			    	}
			    }

			    echo "document.getElementById('aCiudad').options.selectedIndex = $selector; //es un select
			 		 </script>";
			}
		}
	}
 ?>