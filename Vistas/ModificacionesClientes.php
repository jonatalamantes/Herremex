<?php 
    
    session_start();
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php");           
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
    require_once(__DIR__."/../Clases/ControladorCliente.php");

    ControladorBaseDatos::validarSesionIniciada('NuevoCliente');

    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaAgregacionClientes.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|operacion|', 'Modificar', $plantilla);
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

    $url = ControladorBaseDatos::getRestoURL();

    if ($url != '')
    {
        $url = substr($url, 4);

        if (is_numeric($url))
        {
            $id = intval($url);

            $Cliente = ControladorCliente::obtenerClienteID($id);

            if ($Cliente != NULL)
            {
                $calle    = $Cliente->getCalle();
                $edificio = $Cliente->getNoEdificio();
                $rfc      = $Cliente->getRFC();
                $nombre   = $Cliente->getNombre();

                //Establece datos de objetos dentro de objetos
                echo "<script>
                        document.getElementById('aRFC').value = '$rfc';
                        document.getElementById('aNombre').value = '$nombre';
                        document.getElementById('aCalle').value = '$calle';
                        document.getElementById('aNoEdificio').value = '$edificio';";

                if ($Cliente->getRegimen() == 'Moral')
                {
                    echo "document.getElementById('aRegimen').options.selectedIndex = 1;";
                }
                else
                {
                    echo "document.getElementById('aRegimen').options.selectedIndex = 0;";

                    if ($Cliente->getSexo() == 'M')
                    {
                        echo "document.getElementById('aSexo').options.selectedIndex = 1;";
                    }
                }

                $ciudades = ControladorCliente::obtenerCiudades();
                $selector = 0;

                foreach ($ciudades as $key => $value) 
                {
                    if ($value->getAbreviatura() == $Cliente->getCiudad()->getAbreviatura())
                    {
                        $selector = $key;
                        break;
                    }
                }

                echo "document.getElementById('aCiudad').options.selectedIndex = $selector;
                      inicializarClientes();
                </script>";
            }
        }
    }
 ?>
