<?php 
    
    session_start();
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php");           
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
    require_once(__DIR__."/../Clases/ControladorHerramienta.php");

    ControladorBaseDatos::validarSesionIniciada('NuevaHerramienta');

    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaAgregacionHerramientas.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|operacion|', 'Modificar', $plantilla);
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

    //Cargar modificacion
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
