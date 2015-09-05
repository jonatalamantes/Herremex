<?php 

    require_once(__DIR__.'/ControladorBaseDatos.php');
    require_once(__DIR__.'/ControladorSucursal.php');
    require_once(__DIR__.'/Cliente.php');

    /**
    * Clase del controlador del Cliente
    *
    * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
    */
    class ControladorCliente
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
        * Transforma un objeto del tipo Cliente en un array asociativo
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Cliente $Cliente      Objeto de tipo Cliente con datos de un Cliente
        * @return Array                 Arreglo Asociativo con los datos del Cliente
        **/
        static function Cliente_array($Cliente = NULL)
        {
            $arrayCliente = array();

            //Establecemos datos directors del Cliente
            $arrayCliente["ID"] = $Cliente->getID();
            $arrayCliente["Nombre"] = $Cliente->getNombre();
            $arrayCliente["RFC"] = $Cliente->getRFC();
            $arrayCliente["Sexo"] = $Cliente->getSexo();
            $arrayCliente["Regimen"] = $Cliente->getRegimen();
            $arrayCliente["Calle"] = $Cliente->getCalle();
            $arrayCliente["NoEdificio"] = $Cliente->getNoEdificio();

            //Establece datos de objetos dentro de objetos
            $arrayCliente["Ciudad"] = $Cliente->getCiudad()->getAbreviatura();
        
            return $arrayCliente;
        }

        /**
        * Transforma un array asociativo a un objeto del tipo Cliente
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Array $array          Arreglo Asociativo con los datos de una Cliente
        * @return Cliente              Objeto de tipo Cliente con datos del array recibido
        **/
        static function array_Cliente($array = array())
        {
            //Nombre de las tablas
            $tablaCiudad = constant('TABLA_CIUDAD');

            //Nombre de las abrebviaturas de cada objeto de la tabla
            $abreviaturaCiudad = $array["Ciudad"];

            //Objetos Provisionales
            $ciudad = NULL;

            $objeto = new Cliente();

            //Establece datos de la instancia del Cliente
            $objeto->setID($array["ID"]);
            $objeto->setRFC($array["RFC"]);
            $objeto->setNombre($array["Nombre"]);
            $objeto->setCalle($array["Calle"]);
            $objeto->setSexo($array["Sexo"]);
            $objeto->setRegimen($array["Regimen"]);
            $objeto->setNoEdificio($array["NoEdificio"]);
            
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

            return $objeto;

        }
        /**
        * Transforma un objeto del tipo Cliente en un String con comillas
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Cliente $Emplead      Objeto del tipo Cliente a transformar
        * @return String                String resultante como para una inserción
        **/
        static function ClienteToString($Cliente = NULL)
        {
            $string = "";
            $string = $string . "'" . strval($Cliente->getRFC()) . "',";
            $string = $string . "'" . strval($Cliente->getNombre()) . "',";
            $string = $string . "'" . strval($Cliente->getSexo()) . "',";
            $string = $string . "'" . strval($Cliente->getRegimen()) . "',";
            $string = $string . strval($Cliente->getNoEdificio()) . ",";
            $string = $string . "'" . strval($Cliente->getCalle()) . "',";
            $string = $string . "'" . strval($Cliente->getCiudad()->getAbreviatura()) . "'";

            return $string;
        }

         /**
        * Obtiene todos los Clientes registrados en la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @return Array(Cliente)        Regresa un arreglo con el conjunto de Clientes
        **/
        static function obtenerClientes()
        {
            $tablaClientes = constant('TABLA_CLIENTE');

            $consulta = "SELECT *
                         FROM $tablaClientes";

            $res = ControladorBaseDatos::query($consulta);
            $Clientes = array();

            while ($row = $res->fetch_assoc())
            {
                $Clientes[] = self::array_Cliente($row);
            }

            return $Clientes;
        }    
        /**
        * Inserta un nuevo Cliente en la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Cliente $Cliente      Recibe un objeto del tipo Cliente a insertar
        * @return Boolean               Regresa si se pudo o no insertar dicho Cliente
        **/
        static function insertarCliente($Cliente = NULL)
        {
            $nombreTabla    = constant('TABLA_CLIENTE');
            $stringCliente = self::ClienteToString($Cliente);

            $consulta = "INSERT INTO $nombreTabla
                         (RFC, Nombre, Sexo, Regimen,
                          NoEdificio, Calle, Ciudad)
                         VALUES ($stringCliente)";

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
        * Actualza la información de un objeto de tipo Cliente
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  int     $id           ID del Cliente en cuestión
        * @param  Cliente $Cliente      Recibe un objeto del tipo Cliente con los nuevos datos
        * @return Boolean               Regresa si se pudo o no modificar dicho Cliente
        **/
        static function actualizarCliente($id = 0, $Cliente = NULL)
        {
            $nombreTabla    = constant('TABLA_CLIENTE');

            //Obtenemos todos los datos en variables
            $rfc             = $Cliente->getRFC();
            $nombre          = $Cliente->getNombre();
            $sexo            = $Cliente->getSexo();
            $regimen         = $Cliente->getRegimen();
            $calle           = $Cliente->getCalle();
            $edificio         = $Cliente->getNoEdificio();
            $ciudad          = $Cliente->getCiudad()->getAbreviatura();

            $consulta = "UPDATE $nombreTabla
                         SET RFC = '$rfc' ,
                             Nombre = '$nombre' ,
                             Sexo = '$sexo' ,
                             Calle = '$calle' ,
                             Regimen = '$regimen' , 
                             NoEdificio = $edificio , 
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
        * Elimina un Cliente de la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  int $id               ID del Cliente a eliminar
        * @return Boolean               Regresa si se pudo o no eliminar dicho Cliente
        **/
        static function eliminarCliente($id = 0)
        {
            $nombreTabla    = constant('TABLA_CLIENTE');

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
        * Obtiene los datos de un Cliente en particular por su ID
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  int  $id              ID del Cliente a encontrar
        * @return Cliente               Regresa un objeto de tipo Cliente o Null si no existe
        **/
        static function obtenerClienteID($id = 0)
        {
            $tablaClientes    = constant('TABLA_CLIENTE');

            $consulta = "SELECT *
                         FROM $tablaClientes
                         WHERE ID = $id";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                if ($row = $res->fetch_assoc())
                {
                    $objeto = self::array_Cliente($row);

                    return $objeto;
                }
            }

            return NULL;
        }
        
        /**
         * Obtiene todos los Clientes con el nombre parecido al dado en la descripción
         *
         * @author Jonathan Sandoval        <jonathan_s_pisis@yahoo.com.mx>
         * @param String $nombre            Nombre similar a buscar
         * @param String $rfc               RFC similar a buscar
         * @return Array(Cliente)           Conjunto de Clientes con los nombres dados
         */
        static function obtenerClienteNombres($nombre = "", $rfc = "")
        {
            $nombreTabla   = constant('TABLA_CLIENTE');
            $Clientes     = array();

            $consult_cad  = "SELECT * 
                             FROM $nombreTabla
                             WHERE Nombre           LIKE \"%$nombre%\" OR
                                   RFC              LIKE \"%$rfc%\"";
            
            $res          = ControladorBaseDatos::query($consult_cad);

            while ($row = $res->fetch_assoc())
            {
                $Clientes[] = self::array_Cliente($row);
            }

            return $Clientes;
        }
        /**
        * Filtrar Cliente por datos
        * 
        * @author Jonathan Sandoval    <jonathan_s_pisis@hotmail.com>
        * @param Cliente $Cliente      Objeto del tipo Cliente con los datos que deben de filtrar
        * @return Array(Cliente)       Regresa un Arreglo con el conjunto de Clientes filtrados
        */
        static function filtrarClientes($Cliente = NULL)
        {
            $nombreTabla   = constant('TABLA_CLIENTE');

            $rfc             = $Cliente->getRFC();
            $nombre          = $Cliente->getNombre();
            $sexo            = $Cliente->getSexo();
            $regimen         = $Cliente->getRegimen();
            $calle           = $Cliente->getCalle();
            $edificio         = $Cliente->getNoEdificio();

            $Cliente->getCiudad() !== NULL ? $tipo = $Cliente->getCiudad()->getAbreviatura()
                                            : $tipo = "";


            $Clientes    = array();

            $consult_cad  = "SELECT * 
                             FROM $nombreTabla
                             WHERE ID            LIKE \"%$id%\"         AND
                                   RFC           LIKE \"%$rfc%\"        AND
                                   Nombre        LIKE \"%$nombre%\"     AND
                                   Sexo          LIKE \"%$sexo%\"       AND
                                   Regimen       LIKE \"%$regimen%\"    AND
                                   Calle         LIKE \"%$calle%\"      AND
                                   Ciudad        LIKE \"%$ciudad%\"     AND
                                   NoEdificio    LIKE \"%$edificio%\"";

            $res          = ControladorBaseDatos::query($consult_cad);

            while ($row = $res->fetch_assoc())
            {
                $Clientes[] = self::array_Cliente($row);
            }

            return $Clientes;
        }
        /**
         * Conjunto de funciones para filtrar en relación de la URL
         * 
         * @author Jonathan Sandoval   <jonathan_s_pisis@hotmail.com>
         * @return Array(Cliente)      Conjunto de Clientes despueś de analizar la URL
         */ 
        static function frontendFunctions()
        {
            // Obtención de los datos de la URL
            $url = ControladorBaseDatos::getRestoURL();

            $attribArray = array("ID", "RFC", "Nombre", "Sexo", "Regimen",
                                 "Calle", "NoEdificio", "Ciudad");

            //Revisa si se desea eliminar un Cliente
            if (strripos($url, "?action=delete&Cliente_id=") !== false)
            {
                $id_Cliente = intval(substr($url, strlen("?action=delete&Cliente_id=")));
                
                /* Validación del tipo de Cliente
                */
                if (self::eliminarCliente($id_Cliente) == false)
                {
                    $error = ControladorBaseDatos::getLastError();

                    if ($error != "")
                    {
                        $error = substr($error, (strpos($error, '`herremex`.`') + strlen('`herremex`.`')));
                        $error = substr($error, 0, strpos($error, '`'));

                        echo "<script>
                                alert('La tabla \'$error\' está ocupando al cliente');
                              </script>";
                    }
                }
            }

            $Clientes = self::obtenerClientes();

            // Revisa si desea buscar por nombre
            if (strpos($url, "?keyword=") !== false)
            {
                $to_search = substr($url, strlen("?keyword="));
                $to_search = substr($to_search, 0, strpos($to_search, '&'));

                if ($to_search !== "")
                {
                    //Filtra en relación de todo su nombre
                    $Clientes = self::obtenerClienteNombres($to_search, $to_search);
                }
            }

            // Si desea buscar de modo avanzado
            if (strpos($url, "?keyword_id=") !== false)
            {
                $myurl        = $url;
                $ClienteTemp = array();
                $Clientes    = array();

                $keywArray   = array("?keyword_id=", "keyword_rfc=", "keyword_nombre=", "keyword_sexo=", 
                                     "keyword_regimen=", "keyword_calle=", "keyword_noEdificio=", "keyword_ciudad=");


                //Rescara los valores de cada kwyword y los agrega a un objeto Cliente
                foreach ($keywArray as $key => $keyword) 
                {
                    $myurl          = substr($myurl, stripos($myurl, $keyword));

                    $ClienteTemp[$attribArray["$key"]]  = substr($myurl,
                                                           stripos($myurl, $keyword) + strlen($keyword),
                                                           stripos($myurl, "&") - strlen($keyword));
                }

                //Filtra en relación de los datos del objeto obtenido
                $Clientes = self::filtrarClientes(self::array_Cliente($ClienteTemp));
            }

            //Retorna el conjunto de Clientes después de las operaciones
            return $Clientes;
        }
    }

 ?>