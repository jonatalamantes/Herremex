<?php 
    
    session_start();
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php");           
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
    require_once(__DIR__."/../Clases/ControladorCliente.php");
    require_once(__DIR__."/../Clases/ControladorDistribuidor.php");
    require_once(__DIR__."/../Clases/ControladorHerramienta.php");
    require_once(__DIR__."/../Clases/ControladorDistribuidor.php");

    ControladorBaseDatos::validarSesionIniciada('NuevoDistribuidor');

    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaAgregacionDistribuidores.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|operacion|', 'Modificar', $plantilla);
    $plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);
                        
    $url = ControladorBaseDatos::getRestoURL();
    $herramientas = ControladorDistribuidor::obtenerHerramientasSinDistribuidor();

    if ($url != '')
    {
        $url = substr($url, 4);

        if (is_numeric($url))
        {
            $id = intval($url);
            $herramientas = ControladorDistribuidor::obtenerHerramientasSinDistribuidor($id);
        }
    }

    $herrString = $herrString . '<select id="aHerramientas" onclick = "inicializarDistribuidores()">';

    foreach ($herramientas as $key => $value) 
    {
        $herrString = $herrString . "<option id=calidad$key>". $value->getNombre() . "</option>";
    }

    $herrString = $herrString . "</select>";
    $plantilla = str_replace('|herramientas|', $herrString, $plantilla);

    $calidades = ControladorHerramienta::obtenerCalidades();
    $calString = '<select id="aCalidad">';

    foreach ($calidades as $key => $value) 
    {
        $calString = $calString . "<option id=calidad$key>". $value->getNombre(). "</option>";
    }

    $calString = $calString . "</select>";
    $plantilla = str_replace('|calidades|', $calString, $plantilla);

    echo $plantilla;

    $url = ControladorBaseDatos::getRestoURL();

    if ($url != '')
    {
        $url = substr($url, 4);

        if (is_numeric($url))
        {
            $id = intval($url);

            $Distribuidor = ControladorDistribuidor::obtenerDistribuidorID($id);

            if ($Distribuidor != NULL)
            {
                $Distribuidor->getHerramienta() != NULL ? $precio = $Distribuidor->getHerramienta()->getPrecioCompra() : $precio = 0;
                $direccion = $Distribuidor->getDireccion();
                $nombre    = $Distribuidor->getNombre();

                //var_dump($Distribuidor);

                //Establece datos de objetos dentro de objetos
                echo "<script>
                        document.getElementById('aDireccion').value = '$direccion';
                        document.getElementById('aNombre').value = '$nombre';
                        document.getElementById('aPrecioCompra').value = $precio;";

                if ($Distribuidor->getHerramienta() == NULL)
                {
                    echo "document.getElementById('aHerramientas').options.selectedIndex = 0;";
                }
                else
                {
                    $index = 0;
                    $herramientas = ControladorDistribuidor::obtenerHerramientasSinDistribuidor($Distribuidor->getID());



                    foreach ($herramientas as $key => $value) 
                    {
                        if ($value->getID() == $Distribuidor->getHerramienta()->getID())
                        {
                            $index = $key;
                            break;
                        }
                    }

                    echo "document.getElementById('aHerramientas').options.selectedIndex = $index;";

                    $index = 0;
                    $calidades = ControladorHerramienta::obtenerCalidades();

                    foreach ($calidades as $key => $value) 
                    {
                        if ($value->getAbreviatura() == $Distribuidor->getHerramienta()->getCalidad()->getAbreviatura())
                        {
                            $index = $key;
                            break;
                        }
                    }

                    echo "document.getElementById('aCalidad').options.selectedIndex = $index;";
                }

                echo "inicializarDistribuidores();
                </script>";
            }
        }
    }
 ?>
