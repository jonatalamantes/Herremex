<?php 

    session_start(); 
    require_once(__DIR__."/../Clases/ControladorBaseDatos.php"); 
    require_once(__DIR__."/../Clases/DesplegadorInterfaz.php"); 
    require_once(__DIR__."/../Clases/ControladorEmpleado.php");
    require_once(__DIR__."/../Clases/ControladorDistribuidor.php");

    ControladorBaseDatos::validarSesionIniciada('MostrarEmpleado');
    
    $plantilla = file_get_contents(__DIR__."/Plantillas/plantillaBusqueda.html");
    $plantilla = str_replace('|header|', DesplegadorInterfaz::getHeader(), $plantilla);
    $plantilla = str_replace('|objeto|', 'Empleado', $plantilla);
    $plantilla = str_replace('|footer|', DesplegadorInterfaz::getFooter(), $plantilla);

    $inputNormal = '<input name="bNombre" type="text" id="bNombre1" class="busqueda" placeholder="Nombre Empleado">
    <button onclick="href(\'?keyword=data\');" class="lupa"><span class="fa fa-search"></span></button>
    <button onclick="desplegar(\'busquedaAvanzada\');desplegar(\'busquedaBasica\')">Busqueda Avanzada <span class="fa fa-arrow-circle-right"></span></button>';

    $inputAvanzado = '<input name="bID" type="text" id="bID" class="busqueda" placeholder="ID Empleado">
    <input name="bCURP" type="text" id="bCURP" class="busqueda" placeholder="CURP Empleado">
    <input name="bNombre" type="text" id="bNombre2" class="busqueda" placeholder="Nombre Empleado"><br>
    <input name="bNombreS" type="text" id="bNombreS" class="busqueda" placeholder="Segundo Nombre">
    <input name="bApellidoP" type="text" id="bApellidoP" class="busqueda" placeholder="Apellido Paterno">
    <input name="bApellidoM" type="text" id="bApellidoM" class="busqueda" placeholder="Apellido Materno"><br>
    <input name="bCalle" type="text" id="bCalle" class="busqueda" placeholder="Calle">
    <input name="bColonia" type="text" id="bColonia" class="busqueda" placeholder="Colonia">
    <input name="bNCasa" type="text" id="bNCasa" class="busqueda" placeholder="Numero de Casa"><br>
    <input name="bNCasaE" type="text" id="bNCasaI" class="busqueda" placeholder="Numero Interior">
    <input name="bCiudad" type="text" id="bCiudad" class="busqueda" placeholder="Ciudad">
    <input name="bTurno" type="text" id="bTurno" class="busqueda" placeholder="Turno"><br>
    <input name="bTipo" type="text" id="bTipo" class="busqueda" placeholder="Tipo">
    <button onclick="href(\'?keyword_id=empleado\');" class="lupa"><span class="fa fa-search"></span></button>
    <button onclick="desplegar(\'busquedaAvanzada\'); desplegar(\'busquedaBasica\')">Busqueda Basica <span class="fa fa-circle-arrow-left"></span></button>';

    $plantilla = str_replace('|busquedaBasica|', $inputNormal, $plantilla);
    $plantilla = str_replace('|busquedaAvanzada|', $inputAvanzado, $plantilla);

        $empleados = ControladorEmpleado::frontEndFunctions();
        $maxreg   = 5;
        $tabla    = 'dataTable';

        $conTab = $conTab . "<thead>";
            $conTab = $conTab . "<tr>";
                $conTab = $conTab . "<th class='text-left' onclick='decidesort(0, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>ID</th>";
                $conTab = $conTab . "<th class='text-left' onclick='decidesort(1, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>CURP</th>";
                $conTab = $conTab . "<th class='text-left' onclick='decidesort(2, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Nombre</th>";
                $conTab = $conTab . "<th class='text-left' onclick='decidesort(3, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Turno</th>";
                $conTab = $conTab . "<th class='text-left' onclick='decidesort(4, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Tipo</th>";
                $conTab = $conTab . "<th class='text-left' onclick='decidesort(5, \"$tabla\"); inicializeHidden($maxreg, \"$tabla\")'>Sucursal</th>";
                $conTab = $conTab . "<th class='text-left' onclick='inicializeHidden($maxreg, \"$tabla\")'>Operaciones</th>";
            $conTab = $conTab . "<tr>";
        $conTab = $conTab . "<thead>";
        $conTab = $conTab . "<tbody class='table-hover'>";

        $i = 1;
        foreach ($empleados as $value) 
        {
            $sucursal = $value->getSucursal() !== NULL ? $value->getSucursal()->getColonia() : "Sin Sucursal";

            $conTab = $conTab . "<tr id='$i'>";
                $conTab = $conTab . "<td>". $value->getID(). "</td>";
                $conTab = $conTab . "<td>". $value->getCurp(). "</td>";
                $conTab = $conTab . "<td>". $value->getNombre(). " ". $value->getSegundoNombre(). 
                     " ". $value->getApellidoPaterno(). " ". $value->getApellidoMaterno();
                $conTab = $conTab . "<td>". $value->getTurno()->getNombre(). "</td>";
                $conTab = $conTab . "<td>". $value->getTipoEmpleado()->getNombre(). "</td>";
                $conTab = $conTab . "<td>". $sucursal. "</td>";
                $conTab = $conTab . "<td><button onclick='mostrarS($i)'><span class='fa fa-eye'></span></button>";
                $conTab = $conTab . "<button onclick='changeS($i, \"Empleado\")'><span class='fa fa-pencil'></span></button>";
                $conTab = $conTab . "<button onclick = 'cambiarClave($i)'><span class='fa fa-key'></span></button>";
                $conTab = $conTab . "<button onclick = 'deleteS($i, \"al empleado\")'><span class='fa fa-remove'></span></button></td>";
            $conTab = $conTab . "</tr>";
            $i = $i + 1;
        }

    $plantilla = str_replace('|tablaContenido|', $conTab, $plantilla);
    echo $plantilla;
