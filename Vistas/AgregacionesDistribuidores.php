<?php 
    
    session_start();
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php");           
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
    require_once(__DIR__."/../Clases/ControladorCliente.php");
    require_once(__DIR__."/../Clases/ControladorDistribuidor.php");
    require_once(__DIR__."/../Clases/ControladorHerramienta.php");

    ControladorBaseDatos::validarSesionIniciada('NuevoDistribuidor');

    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaAgregacionDistribuidores.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|operacion|', 'Agregar', $plantilla);
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

?>