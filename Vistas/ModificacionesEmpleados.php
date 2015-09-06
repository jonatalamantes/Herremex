<?php 
    
    session_start();
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php");           
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php");                  
    require_once(__DIR__."/../Clases/ControladorSucursal.php");
    require_once(__DIR__."/../Clases/ControladorEmpleado.php");

    ControladorBaseDatos::validarSesionIniciada('NuevoEmpleado');

    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaAgregacionEmpleados.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|operacion|', 'Modificar', $plantilla);
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

    //Cargar Modificion
    $url = ControladorBaseDatos::getRestoURL();

    if ($url != '')
    {
        if (strpos($url, "?look_id=") !== false)
        {
            $url = substr($url, strpos($url, '?look_id=') + 9);
        }
        else
        {
            $url = substr($url, strpos($url, '?change_id=') + 11);
        }

        if (is_numeric($url))
        {
            $id = intval($url);

            $Empleado = ControladorEmpleado::obtenerEmpleadoID($id);

            if ($Empleado != NULL)
            {
                $CURP = $Empleado->getCURP();
                $Nombre = $Empleado->getNombre();
                $Segundo_Nombre = $Empleado->getSegundoNombre();
                $Apellido_Paterno = $Empleado->getApellidoPaterno();
                $Apellido_Materno = $Empleado->getApellidoMaterno();
                $Calle = $Empleado->getCalle();
                $Colonia = $Empleado->getColonia();
                $NoCasa_Ext = $Empleado->getNoCasaExt();
                $NoCasa_Int = $Empleado->getNoCasaInt();
                $Password = $Empleado->getPassword();

                //Establece datos de objetos dentro de objetos
                echo "<script>
                        document.getElementById('aCURP').value = '$CURP';
                        document.getElementById('aNombre').value = '$Nombre';
                        document.getElementById('aNombreS').value = '$Segundo_Nombre';
                        document.getElementById('aApellidoP').value = '$Apellido_Paterno';
                        document.getElementById('aApellidoM').value = '$Apellido_Materno';
                        document.getElementById('aCalle').value = '$Calle';
                        document.getElementById('aNoVivienda').value = '$NoCasa_Ext';
                        document.getElementById('aNoInterior').value = '$NoCasa_Int';
                        document.getElementById('aColonia').value = '$Colonia';";

                $index = 0;
                $ciudades = ControladorEmpleado::obtenerCiudades();

                foreach ($ciudades as $key => $value) 
                {
                    if ($value->getAbreviatura() == $Empleado->getCiudad()->getAbreviatura())
                    {
                        $index = $key;
                        break;
                    }
                }

                echo "document.getElementById('aCiudad').options.selectedIndex = $index;";

                $index = 0;
                $turnos = ControladorEmpleado::obtenerTurnos();

                foreach ($turnos as $key => $value) 
                {
                    if ($value->getAbreviatura() == $Empleado->getTurno()->getAbreviatura())
                    {
                        $index = $key;
                        break;
                    }
                }

                echo "document.getElementById('aTurno').options.selectedIndex = $index;";

                $index = 0;
                $tipos = ControladorEmpleado::obtenerTipoEmpleados();

                foreach ($tipos as $key => $value) 
                {
                    if ($value->getAbreviatura() == $Empleado->getTipoEmpleado()->getAbreviatura())
                    {
                        $index = $key;
                        break;
                    }
                }

                echo "document.getElementById('aTipo').options.selectedIndex = $index;";

                if ($Empleado->getSucursal() != NULL)
                {
                    $index = 0;
                    $sucursales = ControladorSucursal::obtenerSucursales();

                    foreach ($sucursales as $key => $value) 
                    {
                        if ($value->getID() == $Empleado->getSucursal()->getID())
                        {
                            $index = $key;
                            break;
                        }
                    }

                    echo "document.getElementById('aSucursales').options.selectedIndex = $index;";
                }

                echo "inicializarEmpleado();
                    </script>";

            }
        }
    }
    
?>
