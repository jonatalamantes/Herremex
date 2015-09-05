<?php 

    require_once(__DIR__.'/ControladorBaseDatos.php');
    require_once(__DIR__.'/ControladorSucursal.php');
    require_once(__DIR__.'/Empleado.php');

    /**
    * Clase del controlador del Empleado
    *
    * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
    */
    class ControladorEmpleado
    {
        /**
         * Obtiene un conjunto de los tipos de Empleados existentes
         *
         * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
         * @return Array(TipoEmpleado)   Conjunto de Tipos de Empleados
         */
        static function obtenerTipoEmpleados()
        {
            $nombreTabla = constant('TABLA_TIPOEMPLEADO');

            $consulta = "SELECT *
                         FROM $nombreTabla
                         WHERE Abreviatura <> 'J'";

            $res = ControladorBaseDatos::query($consulta);

            $tipos = array();

            while ($row = $res->fetch_assoc())
            {
                $tipo = new TipoEmpleado();

                $tipo->setAbreviatura($row["Abreviatura"]);
                $tipo->setNombre($row["Nombre"]);
                $tipo->setComision($row["Comision"]);

                $tipos[] = $tipo;
            }

            return $tipos;
        }

        /**
         * Obtiene todas las ciudades disponibles en la base de datos
         *
         * @author Jonathan Sandoval   <jonathan_s_pisis@yahoo.com.mx>
         * @return Array(Ciudad)       Conjunto de ciudades existentes
         */
        static function obtenerCiudades()
        {
            $nombreTabla = constant('TABLA_CIUDAD');

            $consulta = "SELECT *
                         FROM $nombreTabla";

            $res = ControladorBaseDatos::query($consulta);

            $ciudades = array();

            while ($row = $res->fetch_assoc())
            {
                $ciudad = new Ciudad();

                $ciudad->setAbreviatura($row["Abreviatura"]);
                $ciudad->setNombre($row["Nombre"]);

                $ciudades[] = $ciudad;
            }

            return $ciudades;        
        }

        /**
         * Obtiene un conjunto de los turnos de los empleados
         *
         * @author Jonathan Sandoval   <jonathan_s_pisis@yahoo.com.mx>
         * @return Array(Turno)        Conjunto de Turnos de  los Empleados
         */
        static function obtenerTurnos()
        {
            $nombreTabla = constant('TABLA_TURNO');

            $consulta = "SELECT *
                         FROM $nombreTabla";

            $res = ControladorBaseDatos::query($consulta);

            $turnos = array();

            while ($row = $res->fetch_assoc())
            {
                $turno = new Turno();

                $turno->setAbreviatura($row["Abreviatura"]);
                $turno->setNombre($row["Nombre"]);
                $turno->setHoras($row["Horas"]);
                $turno->setInicio($row["Inicio"]);

                $turnos[] = $turno;
            }

            return $turnos;        
        }

        /**
        * Transforma un objeto del tipo Empleado en un array asociativo
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Empleado $Empleado    Objeto de tipo Empleado con datos de un Empleado
        * @return Array                 Arreglo Asociativo con los datos del empleado
        **/
        static function Empleado_array($Empleado = NULL)
        {
            $arrayEmpleado = array();

            //Establecemos datos directors del Empleado
            $arrayEmpleado["ID"] = $Empleado->getID();
            $arrayEmpleado["CURP"] = $Empleado->getCURP();
            $arrayEmpleado["Nombre"] = $Empleado->getNombre();
            $arrayEmpleado["Segundo_Nombre"] = $Empleado->getSegundoNombre();
            $arrayEmpleado["Apellido_Paterno"] = $Empleado->getApellidoPaterno();
            $arrayEmpleado["Apellido_Materno"] = $Empleado->getApellidoMaterno();
            $arrayEmpleado["Calle"] = $Empleado->getCalle();
            $arrayEmpleado["Colonia"] = $Empleado->getColonia();
            $arrayEmpleado["NoCasa_Ext"] = $Empleado->getNoCasaExt();
            $arrayEmpleado["NoCasa_Int"] = $Empleado->getNoCasaInt();
            $arrayEmpleado["Password"] = $Empleado->getPassword();

            //EStablece datos de objetos dentro de objetos
            $arrayEmpleado["Turno"] = $Empleado->getTurno()->getAbreviatura();
            $arrayEmpleado["Tipo_Empleado"] = $Empleado->getTipoEmpleado()->getAbreviatura();
            $arrayEmpleado["Ciudad"] = $Empleado->getCiudad()->getAbreviatura();
            
            $Empleado->getSucursal() !== NULL ? $arrayEmpleado["ID_Sucursal"] = $Empleado->getSucursal()->getID():
                                                $arrayEmpleado["ID_Sucursal"] = 0;

            return $arrayEmpleado;
        }

        /**
        * Transforma un array asociativo a un objeto del tipo Empleado
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Array $array          Arreglo Asociativo con los datos de una Empleado
        * @return Empleado              Objeto de tipo Empleado con datos del array recibido
        **/
        static function array_Empleado($array = array())
        {
            //Nombre de las tablas
            $tablaCiudad = constant('TABLA_CIUDAD');
            $tablaTurno  = constant('TABLA_TURNO');
            $tablaTipo   = constant('TABLA_TIPOEMPLEADO');
            $tablaSuc    = constant('TABLA_SUCURSAL');

            //Nombre de las abrebviaturas de cada objeto de la tabla
            $abreviaturaCiudad = $array["Ciudad"];
            $abreviaturaTipo   = $array["Tipo_Empleado"];
            $abreviaturaTurno  = $array["Turno"];
            isset($array["ID_Sucursal"]) ? $idSucursal = $array["ID_Sucursal"] : $idSucursal = 0;

            //Objetos Provisionales
            $ciudad = NULL;
            $turno  = NULL;
            $tipo   = NULL;

            $objeto = new Empleado();

            //Establece datos de la instancia del empleado
            $objeto->setID($array["ID"]);
            $objeto->setCURP($array["CURP"]);
            $objeto->setNombre($array["Nombre"]);
            $objeto->setSegundoNombre($array["Segundo_Nombre"]);
            $objeto->setApellidoPaterno($array["Apellido_Paterno"]);
            $objeto->setApellidoMaterno($array["Apellido_Materno" ]);
            $objeto->setCalle($array["Calle"]);
            $objeto->setColonia($array["Colonia"]);
            $objeto->setNoCasaExt($array["NoCasa_Ext"]);
            $objeto->setNoCasaInt($array["NoCasa_Int"]);
            $objeto->setPassword($array["Password"]);
            
            //Establece un objeto de tipo ciudad
            $consulta = "SELECT *
                         FROM $tablaCiudad
                         WHERE Abreviatura = '$abreviaturaCiudad'";

            $res = ControladorBaseDatos::query($consulta);

            if ($row = $res->fetch_assoc())
            {
                $ciudad = new Ciudad();

                $ciudad->setAbreviatura($row["Abreviatura"]);
                $ciudad->setNombre($row["Nombre"]);
            }

            $objeto->setCiudad($ciudad);

            //Establece un objeto de tipo 'Tipo'
            $consulta = "SELECT *
                         FROM $tablaTipo
                         WHERE Abreviatura = '$abreviaturaTipo'";

            $res = ControladorBaseDatos::query($consulta);

            if ($row = $res->fetch_assoc())
            {
                $tipo = new TipoEmpleado();

                $tipo->setAbreviatura($row["Abreviatura"]);
                $tipo->setNombre($row["Nombre"]);
                $tipo->setComision($row["Comision"]);
            }

            $objeto->setTipoEmpleado($tipo);

            //Establece un objeto de tipo Turno
            $consulta = "SELECT *
                         FROM $tablaTurno
                         WHERE Abreviatura = '$abreviaturaTurno'";

            $res = ControladorBaseDatos::query($consulta);

            if ($row = $res->fetch_assoc())
            {
                $turno = new Turno();

                $turno->setAbreviatura($row["Abreviatura"]);
                $turno->setNombre($row["Nombre"]);
                $turno->setHoras($row["Horas"]);
                $turno->setInicio($row["Inicio"]);
            }

            $objeto->setTurno($turno);

            //Establece un objeto de tipo Sucursal
            $sucursal = ControladorSucursal::obtenerSucursalID($idSucursal);
            $objeto->setSucursal($sucursal);

            return $objeto;

        }
        /**
        * Transforma un objeto del tipo Empleado en un String con comillas
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Empleado $Emplead     Objeto del tipo Empleado a transformar
        * @return String                String resultante como para una inserción
        **/
        static function EmpleadoToString($Empleado = NULL)
        {
            $string = "";
            $string = $string . "'" . strval($Empleado->getCURP()) . "',";
            $string = $string . "'" . strval($Empleado->getNombre()) . "',";
            $string = $string . "'" . strval($Empleado->getSegundoNombre()) . "',";
            $string = $string . "'" . strval($Empleado->getApellidoPaterno()) . "',";
            $string = $string . "'" . strval($Empleado->getApellidoMaterno()) . "',";
            $string = $string . "'" . strval($Empleado->getTurno()->getAbreviatura()) . "',";
            $string = $string . "'" . strval($Empleado->getTipoEmpleado()->getAbreviatura()) . "',";
            $string = $string . "'" . strval($Empleado->getCalle()) . "',";
            $string = $string . "'" . strval($Empleado->getColonia()) . "',";
            $string = $string . strval($Empleado->getNoCasaExt()) . ",";
            $string = $string . strval($Empleado->getNoCasaInt()) . ",";
            $string = $string . "'" . strval($Empleado->getCiudad()->getAbreviatura()) . "',";
            $string = $string . "'" . strval($Empleado->getPassword()) . "'";

            return $string;
        }

        /**
         * Inserta una nueva relación entre una sucursal y un Empleado
         *
         * @author Jonathan Sandoval    <jonathan_s_pisis@yahoo.com.mx>
         * @param  Int $id_empleado     ID del empleado al cual relacionar
         * @param  Int $id_sucursal     ID de la sucursal a relacionar
         * @return boolean              Regresa si pudo o no insertarse dicha relación
         */
        static function insertarEmpleadoSucursal($id_empleado = 0, $id_sucursal = 0)
        {
            $nombreTabla = constant('TABLA_EMPLEADO_SUCURSAL');

            $consulta = "INSERT INTO $nombreTabla
                         (ID_Empleado, ID_Sucursal)
                         VALUES
                         ($id_empleado, $id_sucursal)";

            ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        /**
         * Elimina una nueva relación entre una sucursal y un Empleado
         *
         * @author Jonathan Sandoval    <jonathan_s_pisis@yahoo.com.mx>
         * @param  Int $id_empleado     ID del empleado al cual relacionar
         * @param  Int $id_sucursal     ID de la sucursal a relacionar
         * @return boolean              Regresa si pudo o no eliminar dicha relación
         */
        static function eliminarEmpleadoSucursal($id_empleado = 0, $id_sucursal = 0)
        {
            $nombreTabla = constant('TABLA_EMPLEADO_SUCURSAL');

            $consulta = "DELETE FROM $nombreTabla
                         WHERE ID_Empleado = $id_empleado AND ID_Sucursal = $id_sucursal";

            ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        /**
        * Valida que el usuario y la contraseña sean válidas
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  String $usename       Nombre de usuario que está en la base de datos
        * @param  String $pass          Contraseña de dicho empleado
        * @return Empleado              Regresa un objeto de tipo Empleado con los datos del usuario, sino NULL
        **/
        static function validarUsuario($username = "", $pass = "")
        {
            $nombreTabla = constant('TABLA_EMPLEADO');

            $consulta = "SELECT *
                         FROM $nombreTabla
                         WHERE CURP = '$username'
                         AND Password = '$pass'
                         LIMIT 1";

            $res = ControladorBaseDatos::query($consulta);
            
            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                if ($row = $res->fetch_assoc())
                {
                    $objeto = self::array_Empleado($row);

                    return $objeto;
                }
            }

            return NULL;
        }

        /**
        * Obtiene todos los empleados registrados en la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @return Array(Empleado)       Regresa un arreglo con el conjunto de empleados
        **/
        static function obtenerEmpleados()
        {
            $tablaEmpleados = constant('TABLA_EMPLEADO');
            $tablaSucusal   = constant('TABLA_SUCURSAL');
            $tablaRelacion  = constant('TABLA_EMPLEADO_SUCURSAL');

            $consulta = "SELECT *
                         FROM $tablaEmpleados LEFT JOIN $tablaRelacion
                         ON ($tablaEmpleados.ID = $tablaRelacion.ID_Empleado)";

            $res = ControladorBaseDatos::query($consulta);
            $empleados = array();

            while ($row = $res->fetch_assoc())
            {
                $empleados[] = self::array_Empleado($row);
            }

            return $empleados;
        }        

        /**
        * Inserta un nuevo Empleado en la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Empleado $empleado    Recibe un objeto del tipo Empleado a insertar
        * @return Boolean               Regresa si se pudo o no insertar dicho empleado
        **/
        static function insertarEmpleado($empleado = NULL)
        {
            $nombreTabla    = constant('TABLA_EMPLEADO');
            $stringEmpleado = self::EmpleadoToString($empleado);

            $consulta = "INSERT INTO $nombreTabla
                         (CURP, Nombre, Segundo_Nombre, Apellido_Paterno,
                          Apellido_Materno, Turno, Tipo_Empleado, Calle, Colonia, 
                          NoCasa_Ext, NoCasa_Int, Ciudad, Password)
                         VALUES ($stringEmpleado)";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                $ultimoID = 0;
                $consulta = "SELECT MAX(ID) AS ID 
                             FROM $nombreTabla";

                $res = ControladorBaseDatos::query($consulta);

                if ($row = $res->fetch_assoc())
                {
                    $ultimoID = $row["ID"];
                }

                $posible  = self::insertarEmpleadoSucursal($ultimoID, $empleado->getSucursal()->getID());

                return $posible;

            }
            else
            {
                return false;
            }
        }  

        /**
         * Cambia la contraseña de un empleado para ingresar al sistema
         * 
         * @param  integer $id_empleado Identificador del Empleado interesado
         * @param  string  $anterior    Contraseña Anterior
         * @param  string  $nueva       Nueva Contraseña
         * @return boolean              Regresa si pudo o no cambiar la contraseña
         */
        static function actualizarClave($id_empleado = 0, $anterior = "", $nueva = "")
        {
            $nombreTabla    = constant('TABLA_EMPLEADO');

            $correcta = ControladorEmpleado::validarUsuario(self::obtenerEmpleadoID($id_empleado)->getCURP(), $anterior);

            if ($correcta)
            {
                $consulta = "UPDATE $nombreTabla
                             SET Password = '$nueva'
                             WHERE ID = $id_empleado";

                $res = ControladorBaseDatos::query($consulta);

                if (ControladorBaseDatos::getAffectedRows() == 1)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }

            return false;
        }

        /**
        * Actualza la información de un objeto de tipo Empleado
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Int $id               ID del Empleado en cuestión
        * @param  Empleado $empleado    Recibe un objeto del tipo Empleado con los nuevos datos
        * @return Boolean               Regresa si se pudo o no modificar dicho empleado
        **/
        static function actualizarEmpleado($id = 0, $empleado = NULL)
        {
            $nombreTabla    = constant('TABLA_EMPLEADO');

            //Cambio de sucursal
            if ($empleado->getSucursal() != NULL)
            {
                $idS = $empleado->getSucursal()->getID();
            }

            if (self::obtenerEmpleadoID($id)->getSucursal() != NULL)
            {
                self::eliminarEmpleadoSucursal($id, self::obtenerEmpleadoID($id)->getSucursal()->getID());
            }

            self::insertarEmpleadoSucursal($id, $idS);

            //Obtenemos todos los datos en variables
            $curp            = $empleado->getCURP();
            $nombre          = $empleado->getNombre();
            $segundoNombre   = $empleado->getSegundoNombre();
            $apellidoPaterno = $empleado->getApellidoPaterno();
            $apellidoMaterno = $empleado->getApellidoMaterno();
            $turno           = $empleado->getTurno()->getAbreviatura();
            $tipo            = $empleado->getTipoEmpleado()->getAbreviatura();
            $calle           = $empleado->getCalle();
            $colonia         = $empleado->getColonia();
            $casaIn          = $empleado->getNoCasaInt();
            $ciudad          = $empleado->getCiudad()->getAbreviatura();
            $pass            = $empleado->getPassword();
            $casaEx          = $empleado->getNoCasaExt();
            $casaIn          = $empleado->getNoCasaInt();

            $consulta = "UPDATE $nombreTabla
                         SET CURP = '$curp' ,
                             Nombre = '$nombre' ,
                             Segundo_Nombre = '$segundoNombre' ,
                             Apellido_Paterno = '$apellidoPaterno' ,
                             Apellido_Materno = '$apellidoMaterno' ,
                             Turno = '$turno' ,
                             Tipo_Empleado = '$tipo' ,
                             Calle = '$calle' ,
                             Colonia = '$colonia' , 
                             NoCasa_Ext = $casaEx , 
                             NoCasa_Int = $casaIn ,
                             Ciudad = '$ciudad'
                         WHERE ID = $id";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }  

        /**
        * Elimina un Empleado de la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Int $id               ID del Empleado a eliminar
        * @return Boolean               Regresa si se pudo o no eliminar dicho empleado
        **/
        static function eliminarEmpleado($id = 0)
        {
            $nombreTabla    = constant('TABLA_EMPLEADO');
            $posible = true;

            if (self::obtenerEmpleadoID($id) != NULL)
            {
                $sucursal = self::obtenerEmpleadoID($id)->getSucursal();

                if ($sucursal != NULL)
                {
                    $posible = self::eliminarEmpleadoSucursal($id, $sucursal->getID());
                }
            }

            $consulta = "DELETE FROM $nombreTabla
                         WHERE ID = $id";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1 && $posible)
            {
                return true;
            }
            else
            {
                return false;
            }
        }  
  
        /**
        * Obtiene los datos de un empleado en particular por su ID
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Int  $id              ID del Empleado a encontrar
        * @return Empleado              Regresa un objeto de tipo Empleado o Null si no existe
        **/
        static function obtenerEmpleadoID($id = 0)
        {
            $tablaEmpleados    = constant('TABLA_EMPLEADO');
            $tablaRelacion     = constant('TABLA_EMPLEADO_SUCURSAL');

            $consulta = "SELECT *
                         FROM $tablaEmpleados LEFT JOIN $tablaRelacion
                         ON ($tablaEmpleados.ID = $tablaRelacion.ID_Empleado) 
                         WHERE $tablaEmpleados.ID = $id";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                if ($row = $res->fetch_assoc())
                {
                    $objeto = self::array_Empleado($row);

                    return $objeto;
                }
            }

            return NULL;
        }

        /**
         * Obtiene todos los Empleados con el nombre parecido al dado en la descripción
         *
         * @author Jonathan Sandoval        <jonathan_s_pisis@yahoo.com.mx>
         * @param String $nombre            Nombre similar a buscar
         * @param String $SegundoNombre     Segundo Nombre similar a buscar
         * @param String $apellidoPaterno   Apellido Paterno a buscar
         * @param String $apellidoMaterno   Apellido Materno a Buscar
         * @return Array(Empleado)          Conjunto de Empleados con los nombres dados
         */
        static function obtenerEmpleadoNombres($nombre = "", $segundoNombre = "", $apellidoPaterno = "", $apellidoMaterno = "")
        {
            $nombreTabla   = constant('TABLA_EMPLEADO');
            $empleados     = array();

            $consult_cad  = "SELECT * 
                             FROM $nombreTabla
                             WHERE Nombre           LIKE \"%$nombre%\"  OR
                                   Segundo_Nombre   LIKE \"%$segundoNombre%\" OR
                                   Apellido_Paterno LIKE \"%$apellidoPaterno%\" OR
                                   Apellido_Materno LIKE \"%$apellidoMaterno%\"";
            
            $res          = ControladorBaseDatos::query($consult_cad);

            while ($row = $res->fetch_assoc())
            {
                $empleados[] = self::array_Empleado($row);
            }

            return $empleados;
        }

        /**
        * Filtrar Empleado por datos
        * 
        * @author Jonathan Sandoval     <jonathan_s_pisis@hotmail.com>
        * @param Empleado $empleado     Objeto del tipo Empleado con los datos que deben de filtrar
        * @return Array(Empleado)       Regresa un Arreglo con el conjunto de Empleados filtrados
        */
        static function filtrarEmpleados($empleado = NULL)
        {
            $nombreTabla   = constant('TABLA_EMPLEADO');

            $id              = $empleado->getID();
            $curp            = $empleado->getCURP();
            $nombre          = $empleado->getNombre();
            $segundoNombre   = $empleado->getSegundoNombre();
            $apellidoPaterno = $empleado->getApellidoPaterno();
            $apellidoMaterno = $empleado->getApellidoMaterno();
            $calle           = $empleado->getCalle();
            $colonia         = $empleado->getColonia();
            $casaIn          = $empleado->getNoCasaInt();
            $pass            = $empleado->getPassword();
            $casaEx          = $empleado->getNoCasaExt();
            $casaIn          = $empleado->getNoCasaInt();
            $empleado->getCiudad() !== NULL ? $tipo = $empleado->getCiudad()->getAbreviatura()
                                            : $tipo = "";
            $empleado->getTipoEmpleado() !== NULL ? $tipo = $empleado->getTipoEmpleado()->getAbreviatura()
                                                  : $tipo = "";
            $empleado->getTurno() !== NULL ? $turno = $empleado->getTurno()->getAbreviatura()
                                           : $turno = "";

            $empleados    = array();

            $consult_cad  = "SELECT * 
                             FROM $nombreTabla
                             WHERE ID               LIKE \"%$id%\"              AND
                                   CURP             LIKE \"%$curp%\"            AND
                                   Nombre           LIKE \"%$nombre%\"          AND
                                   Segundo_Nombre   LIKE \"%$segundoNombre%\"   AND
                                   Apellido_Paterno LIKE \"%$apellidoPaterno%\" AND
                                   Apellido_Materno LIKE \"%$apellidoMaterno%\" AND
                                   Calle            LIKE \"%$calle%\"           AND
                                   Colonia          LIKE \"%$colonia%\"         AND
                                   Turno            LIKE \"%$turno%\"           AND
                                   Tipo_Empleado    LIKE \"%$tipo%\"            AND
                                   Ciudad           LIKE \"%$ciudad%\"          AND
                                   NoCasa_Ext       LIKE \"%$casaEx%\"          AND
                                   NoCasa_Int       LIKE \"%$casaIn%\"          AND 
                                   Password         LIKE \"%$pass%\"";

            $res          = ControladorBaseDatos::query($consult_cad);

            while ($row = $res->fetch_assoc())
            {
                $empleados[] = self::array_Empleado($row);
            }

            return $empleados;
        }

        /**
         * Conjunto de funciones para ordenar y filtrar en relación de la URL
         * 
         * @author Jonathan Sandoval    <jonathan_s_pisis@hotmail.com>
         * @return Array(Empleado)      Conjunto de Empleados despueś de analizar la URL
         */ 
        static function frontendFunctions()
        {
            // Obtención de los datos de la URL
            $url = ControladorBaseDatos::getRestoURL();

            $attribArray = array("ID", "CURP", "Nombre", "Segundo_Nombre", "Apellido_Paterno", "Apellido_Materno",
                     "Turno", "Tipo_Empleado", "Calle", "Colonia", "NoCasa_Ext", "NoCasa_Int",
                     "Ciudad", "Password");

            //Revisa si se desea eliminar un Empleado
            if (strripos($url, "?action=delete&empleado_id=") !== false)
            {
                $id_empleado = Intval(substr($url, strlen("?action=delete&empleado_id=")));
                
                /* Validación del tipo de Empleado
                  
                */
                if (self::eliminarEmpleado($id_empleado) == false)
                {
                    $error = ControladorBaseDatos::getLastError();

                    if ($error != "")
                    {
                        $error = substr($error, (strpos($error, '`herremex`.`') + strlen('`herremex`.`')));

                        $error = substr($error, (strpos($error, '`herremex`.`') + strlen('`herremex`.`')));
                        $error = substr($error, 0, strpos($error, '`'));

                        echo "<script>
                                alert('La tabla \'$error\' está ocupando al empleado');
                              </script>";
                    }
                }
            }

            $empleados = self::obtenerEmpleados();

            // Revisa si desea buscar por nombre
            if (strpos($url, "?keyword=") !== false)
            {
                $to_search = substr($url, strlen("?keyword="));
                $to_search = substr($to_search, 0, strpos($to_search, '&'));

                if ($to_search !== "")
                {
                    //Filtra en relación de todo su nombre
                    $empleados = self::obtenerEmpleadoNombres($to_search, $to_search, $to_search, $to_search);
                }
            }

            // Si desea buscar de modo avanzado
            if (strpos($url, "?keyword_id=") !== false)
            {
                $myurl        = $url;
                $empleadoTemp = array();
                $empleados    = array();

                $keywArray   = array("?keyword_id=", "keyword_curp=", "keyword_primer_nombre=", "keyword_segundo_nombre=", 
                                     "keyword_apellido_paterno=", "keyword_apellido_materno=", "keyword_turno=", "keyword_tipo=", 
                                     "keyword_calle=", "keyword_colonia=", "keyword_ext=", "keyword_Int=", 
                                     "keyword_ciudad=");


                //Rescara los valores de cada kwyword y los agrega a un objeto Empleado
                foreach ($keywArray as $key => $keyword) 
                {
                    $myurl          = substr($myurl, stripos($myurl, $keyword));

                    $empleadoTemp[$attribArray["$key"]]  = substr($myurl,
                                                           stripos($myurl, $keyword) + strlen($keyword),
                                                           stripos($myurl, "&") - strlen($keyword));
                }

                //Filtra en relación de los datos del objeto obtenido
                $empleados = self::filtrarEmpleados(self::array_Empleado($empleadoTemp));
            }

            //Retorna el conjunto de Empleados después de las operaciones
            return $empleados;
        }
    }

 ?>