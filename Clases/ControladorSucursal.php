<?php 

    require_once(__DIR__.'/ControladorBaseDatos.php');
    require_once(__DIR__.'/Sucursal.php');

    /**
    * Clase del controlador del Sucursal
    *
    * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
    */
    class ControladorSucursal
    {
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
        * Transforma un objeto del tipo Sucursal en un array asociativo
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Sucursal $Sucursal    Objeto de tipo Sucursal con datos de un Sucursal
        * @return Array                 Arreglo Asociativo con los datos del sucursal
        **/
        static function Sucursal_array($Sucursal = NULL)
        {
            $arraySucursal = array();

            //Establecemos datos directors del Sucursal
            $arraySucursal["ID"] = $Sucursal->getID();
            $arraySucursal["Calle"] = $Sucursal->getCalle();
            $arraySucursal["Colonia"] = $Sucursal->getColonia();
            $arraySucursal["NoEdificio"] = $Sucursal->getNoEdificio();

            //EStablece datos de objetos dentro de objetos
            $arraySucursal["Ciudad"] = $Sucursal->getCiudad()->getAbreviatura();

            return $arraySucursal;
        }

        /**
        * Transforma un array asociativo a un objeto del tipo Sucursal
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Array $array          Arreglo Asociativo con los datos de una Sucursal
        * @return Sucursal              Objeto de tipo Sucursal con datos del array recibido
        **/
        static function array_Sucursal($array = array())
        {
            //Nombre de las tablas
            $tablaCiudad = constant('TABLA_CIUDAD');

            //Nombre de las abrebviaturas de cada objeto de la tabla
            $abreviaturaCiudad = $array["Ciudad"];

            //Objetos Provisionales
            $ciudad = NULL;

            $objeto = new Sucursal();

            //Establece datos de la instancia del sucursal
            $objeto->setID($array["ID"]);
            $objeto->setCalle($array["Calle"]);
            $objeto->setColonia($array["Colonia"]);
            $objeto->setNoEdificio($array["NoEdificio"]);
            
            //Establece un objeto de tipo ciudad
            $consulta = "SELECT *
                         FROM $tablaCiudad
                         WHERE Abreviatura LIKE '%$abreviaturaCiudad%'";

            $res = ControladorBaseDatos::query($consulta);

            if ($row = $res->fetch_assoc())
            {
                $ciudad = new Ciudad();

                $ciudad->setAbreviatura($row["Abreviatura"]);
                $ciudad->setNombre($row["Nombre"]);
            }

            $objeto->setCiudad($ciudad);

            return $objeto;

        }
        /**
        * Transforma un objeto del tipo Sucursal en un String con comillas
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Sucursal $Emplead     Objeto del tipo Sucursal a transformar
        * @return String                String resultante como para una inserción
        **/
        static function SucursalToString($Sucursal = NULL)
        {
            $string = "";
            $string = $string . "'" . strval($Sucursal->getCiudad()->getAbreviatura()) . "',";
            $string = $string . "'" . strval($Sucursal->getCalle()) . "',";
            $string = $string . "'" . strval($Sucursal->getColonia()) . "',";
            $string = $string . strval($Sucursal->getNoEdificio());

            return $string;
        }

        /**
        * Obtiene todos los sucursales registrados en la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @return Array(Sucursal)       Regresa un arreglo con el conjunto de sucursales
        **/
        static function obtenerSucursales()
        {
            $nombreTabla = constant('TABLA_SUCURSAL');

            $consulta = "SELECT *
                         FROM $nombreTabla";

            $res = ControladorBaseDatos::query($consulta);
            $sucursales = array();

            while ($row = $res->fetch_assoc())
            {
                $sucursales[] = self::array_Sucursal($row);
            }

            return $sucursales;
        }        

        /**
        * Inserta un nuevo Sucursal en la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Sucursal $sucursal    Recibe un objeto del tipo Sucursal a insertar
        * @return Boolean               Regresa si se pudo o no insertar dicho sucursal
        **/
        static function insertarSucursal($sucursal = NULL)
        {
            $nombreTabla    = constant('TABLA_SUCURSAL');
            $stringSucursal = self::SucursalToString($sucursal);

            $consulta = "INSERT INTO $nombreTabla
                         (Ciudad, Calle, Colonia, NoEdificio)
                         VALUES ($stringSucursal)";

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
        * Actualza la información de un objeto de tipo Sucursal
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  int $id               ID del Sucursal en cuestión
        * @param  Sucursal $sucursal    Recibe un objeto del tipo Sucursal con los nuevos datos
        * @return Boolean               Regresa si se pudo o no modificar dicho sucursal
        **/
        static function actualizarSucursal($id = 0, $sucursal = NULL)
        {
            $nombreTabla    = constant('TABLA_SUCURSAL');

            //Obtenemos todos los datos en variables
            $calle           = $sucursal->getCalle();
            $colonia         = $sucursal->getColonia();
            $ciudad          = $sucursal->getCiudad()->getAbreviatura();
            $noEdificio      = $sucursal->getNoEdificio();

            $consulta = "UPDATE $nombreTabla
                         SET Calle = '$calle' ,
                             Colonia = '$colonia' , 
                             NoEdificio = $noEdificio , 
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
        * Elimina un Sucursal de la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  int $id               ID del Sucursal a eliminar
        * @return Boolean               Regresa si se pudo o no eliminar dicho sucursal
        **/
        static function eliminarSucursal($id = 0)
        {
            $nombreTabla    = constant('TABLA_SUCURSAL');

            $consulta = "DELETE FROM $nombreTabla
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
        * Obtiene los datos de un sucursal en particular por su ID
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  int  $id              ID del Sucursal a encontrar
        * @return Sucursal              Regresa un objeto de tipo Sucursal o Null si no existe
        **/
        static function obtenerSucursalID($id = 0)
        {
            $nombreTabla    = constant('TABLA_SUCURSAL');

            $consulta = "SELECT *
                         FROM $nombreTabla
                         WHERE ID = $id";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                if ($row = $res->fetch_assoc())
                {
                    $objeto = self::array_Sucursal($row);

                    return $objeto;
                }
            }

            return NULL;
        }

        /**
         * Obtiene todos los Sucursales con el nombre parecido al dado en la descripción
         *
         * @author Jonathan Sandoval        <jonathan_s_pisis@yahoo.com.mx>
         * @param String $calle             calle similar a buscar
         * @param String $colonia           colonia similar a buscar
         * @param String $noEdificio        noEdificio similar a buscar
         * @param String $id                ID similar a buscar
         * @return Array(Sucursal)          Conjunto de Sucursales con los nombres dados
         */
        static function obtenerSucursalNombres($calle = "", $colonia = "", $noEdificio = "", $id = "")
        {
            $nombreTabla   = constant('TABLA_SUCURSAL');
            $sucursales     = array();

            $consult_cad  = "SELECT * 
                             FROM $nombreTabla
                             WHERE ID           LIKE \"%$id%\"          OR
                                   Calle        LIKE \"%$calle%\"       OR
                                   NoEdificio   LIKE \"%$noEdificio%\"  OR
                                   Colonia      LIKE \"%$colonia%\"";
            
            $res          = ControladorBaseDatos::query($consult_cad);

            while ($row = $res->fetch_assoc())
            {
                $sucursales[] = self::array_Sucursal($row);
            }

            return $sucursales;
        }

        /**
        * Filtrar Sucursal por datos
        * 
        * @author Jonathan Sandoval     <jonathan_s_pisis@hotmail.com>
        * @param Sucursal $sucursal     Objeto del tipo Sucursal con los datos que deben de filtrar
        * @return Array(Sucursal)       Regresa un Arreglo con el conjunto de Sucursales filtrados
        */
        static function filtrarSucursales($sucursal = NULL)
        {
            $nombreTabla   = constant('TABLA_SUCURSAL');

            $id              = $sucursal->getID();
            $calle           = $sucursal->getCalle();
            $colonia         = $sucursal->getColonia();
            $noEdificio      = $sucursal->getNoEdificio();
            $sucursal->getCiudad() !== NULL ? $ciudad = $sucursal->getCiudad()->getAbreviatura()
                                            : $ciudad = "";

            $sucursales    = array();

            $consult_cad  = "SELECT * 
                             FROM $nombreTabla
                             WHERE ID               LIKE \"%$id%\"              AND
                                   Calle            LIKE \"%$calle%\"           AND
                                   Colonia          LIKE \"%$colonia%\"         AND
                                   Ciudad           LIKE \"%$ciudad%\"          AND
                                   NoEdificio       LIKE \"%$noEdificio%\"";

            $res          = ControladorBaseDatos::query($consult_cad);  

            while ($row = $res->fetch_assoc())
            {
                $sucursales[] = self::array_Sucursal($row);
            }

            return $sucursales;
        }

        /**
         * Conjunto de funciones para ordenar y filtrar en relación de la URL
         * 
         * @author Jonathan Sandoval    <jonathan_s_pisis@hotmail.com>
         * @return Array(Sucursal)      Conjunto de Sucursales despueś de analizar la URL
         */ 
        static function frontendFunctions()
        {
            // Obtención de los datos de la URL
            $url = ControladorBaseDatos::getRestoURL();

            $attribArray = array("Ciudad", "ID", "Calle", "Colonia", "NoEdificio");

            //Revisa si se desea eliminar un Sucursal
            if (strripos($url, "?action=delete&sucursal_id=") !== false)
            {
                $id_sucursal = intval(substr($url, strlen("?action=delete&sucursal_id=")));
                
                /* Validación del tipo de Sucursal
                */
               
                if (self::eliminarSucursal($id_sucursal) == false)
                {
                    $error = ControladorBaseDatos::getLastError();

                    if ($error != "")
                    {
                        $error = substr($error, (strpos($error, '`herremex`.`') + strlen('`herremex`.`')));
                        $error = substr($error, 0, strpos($error, '`'));

                        echo "<script>
                                alert('La tabla \'$error\' está ocupando la sucursal');
                              </script>";
                    }
                }
            }

            $sucursales = self::obtenerSucursales();

            // Revisa si desea buscar por nombre
            if (strpos($url, "?keyword=") !== false)
            {
                $to_search = substr($url, strlen("?keyword="));
                $to_search = substr($to_search, 0, strpos($to_search, '&'));

                if ($to_search !== "")
                {
                    //Filtra en relación de todo su nombre
                    $sucursales = self::obtenerSucursalNombres($to_search, $to_search, $to_search, $to_search);
                }
            }

            // Si desea buscar de modo avanzado
            if (strpos($url, "?keyword_ciudad=") !== false)
            {
                $myurl        = $url;
                $sucursalTemp = array();
                $sucursales    = array();

                $keywArray   = array("?keyword_ciudad=", "keyword_id=", "keyword_calle=",  
                                     "keyword_colonia=", "keyword_edificio=");


                //Rescara los valores de cada kwyword y los agrega a un objeto Sucursal
                foreach ($keywArray as $key => $keyword) 
                {
                    $myurl          = substr($myurl, stripos($myurl, $keyword));

                    $sucursalTemp[$attribArray["$key"]]  = substr($myurl,
                                                           stripos($myurl, $keyword) + strlen($keyword),
                                                           stripos($myurl, "&") - strlen($keyword));
                }

                //Filtra en relación de los datos del objeto obtenido
                $sucursales = self::filtrarSucursales(self::array_Sucursal($sucursalTemp));
            }

            //Retorna el conjunto de Sucursales después de las operaciones
            return $sucursales;
        }
    }

 ?>