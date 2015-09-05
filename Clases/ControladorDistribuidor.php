<?php 

    require_once(__DIR__.'/ControladorBaseDatos.php');
    require_once(__DIR__.'/ControladorHerramienta.php');
    require_once(__DIR__.'/Distribuidor.php');

    /**
    * Clase del controlador del Distribuidor
    *
    * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
    */
    class ControladorDistribuidor
    {
        /**
         * Obtieene una lista con todos las herramientas que no tengan un distribuidor
         * excluyendo la herramienta que se desee
         *
         * @author Jonathan Sandoval       <jonathan_s_pisis@yahoo.com.mx>
         * @param  Int $id                 ID de la herramienta a excluir
         * @return Array(Herramienta)      Conjunto de Herramientas resultantes
         */
        static function obtenerHerramientasSinDistribuidor($id = 0)
        {
            $tablaHerramienta = constant('TABLA_HERRAMIENTA');
            $tablaRelacion    = constant('TABLA_DISTRIBUIDOR_HERRAMIENTA');

            $consulta = "SELECT * FROM $tablaHerramienta 
                         WHERE ID NOT IN (
                            SELECT ID_Herramienta 
                            FROM $tablaRelacion
                            WHERE ID_Distribuidor <> $id
                         );";

            $res = ControladorBaseDatos::query($consulta);

            $primera = new Herramienta();

            $primera->setNombre('Sin Herramientas');
            $primera->setID(0);

            $herramientas = array($primera);

            while ($row = $res->fetch_assoc())
            {
                $herramienta = ControladorHerramienta::array_Herramienta($row);

                $herramientas[] = $herramienta;
            }

            return $herramientas;        
        }

        /**
        * Transforma un objeto del tipo Distribuidor en un array asociativo
        *
        * @author Jonathan Sandoval             <jonathan_s_pisis@yahoo.com.mx>
        * @param  Distribuidor $Distribuidor    Objeto de tipo Distribuidor con datos de un Distribuidor
        * @return Array                         Arreglo Asociativo con los datos del distribuidor
        **/
        static function Distribuidor_array($Distribuidor = NULL)
        {
            $arrayDistribuidor = array();

            //Establecemos datos directores del Distribuidor
            $arrayDistribuidor["ID"] = $Distribuidor->getID();
            $arrayDistribuidor["Direccion"] = $Distribuidor->getDireccion();
            $arrayDistribuidor["Nombre"] = $Distribuidor->getNombre();
            $arrayDistribuidor["ID_Herramienta"] = $Distribuidor->getHerramienta()->getID();

            return $arrayDistribuidor;
        }

        /**
        * Transforma un array asociativo a un objeto del tipo Distribuidor
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Array $array          Arreglo Asociativo con los datos de una Distribuidor
        * @return Distribuidor          Objeto de tipo Distribuidor con datos del array recibido
        **/
        static function array_Distribuidor($array = array())
        {
            //Nombre de las tablas
            $objeto = new Distribuidor();

            //Establece datos de la instancia del distribuidor
            $objeto->setID($array["ID"]);
            $objeto->setDireccion($array["Direccion"]);
            $objeto->setNombre($array["Nombre"]);

            isset($array["ID_Herramienta"]) ? $idHerramienta  = $array["ID_Herramienta"] : $idHerramienta = 0;

            $herramienta    = ControladorHerramienta::obtenerHerramientaID(Intval($idHerramienta));

            $objeto->setHerramienta($herramienta);
            return $objeto;
        }

        /**
        * Transforma un objeto del tipo Distribuidor en un String con comillas
        *
        * @author Jonathan Sandoval             <jonathan_s_pisis@yahoo.com.mx>
        * @param  Distribuidor Distribuidor     Objeto del tipo Distribuidor a transformar
        * @return String                        String resultante como para una inserción
        **/
        static function DistribuidorToString($Distribuidor = NULL)
        {
            $string = "";
            $string = $string . "'" . strval($Distribuidor->getNombre()) . "',";
            $string = $string . "'" . strval($Distribuidor->getDireccion()) . "'";

            return $string;
        }

        /**
         * Agrega una tupla a la base de datos con la relación entre un distribuidor y las herramientas
         *    
         * @param  Int $idDistribuidor ID del Distribuidor
         * @param  Int $idHerramienta  ID de la herramienta
         * @param  String  $calidad    Calidad de la herramienta
         * @param  String  $precio     Precio de compra de la herramienta
         * @return boolean             Regresa si pudo o no insertar dicha asociación
         */
        static function insertarDistribuidorHerramienta($idDistribuidor = 0, $idHerramienta = 0, $calidad = '', $precio = -1)
        {
            if ($idDistribuidor == 0 || $idHerramienta == 0 || $calidad == '' || $precio == -1)
            {
                return true;
            }

            $tablaDistribuidor = constant('TABLA_DISTRIBUIDOR');
            $tablaHerramienta  = constant('TABLA_HERRAMIENTA');
            $tablaRelacion     = constant('TABLA_DISTRIBUIDOR_HERRAMIENTA');
            
            $consulta = "INSERT INTO $tablaRelacion
                         (ID_Herramienta, ID_Distribuidor, PrecioCompra, Calidad)
                         VALUES
                         ($idHerramienta, $idDistribuidor, $precio, '$calidad')";

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
         * Elimina la relación entre un distribuidor y una herramienta
         *    
         * @param  Int $idDistribuidor ID del Distribuidor
         * @param  Int $idHerramienta  ID de la herramienta
         * @return boolean             Regresa si pudo o no eliminar dicha asociación
         */
        static function eliminarDistribuidorHerramienta($idDistribuidor = 0, $idHerramienta = 0)
        {
            if ($idDistribuidor == 0 || $idHerramienta == 0)
            {
                return true;
            }

            $tablaRelacion = constant('TABLA_DISTRIBUIDOR_HERRAMIENTA');

            $consulta = "DELETE FROM $tablaRelacion
                         WHERE ID_Herramienta = $idHerramienta AND ID_Distribuidor = $idDistribuidor";

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
        * Obtiene todos los distribuidores registrados en la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @return Array(Distribuidor)   Regresa un arreglo con el conjunto de distribuidores
        **/
        static function obtenerDistribuidores()
        {
            $tablaRelacion     = constant('TABLA_DISTRIBUIDOR_HERRAMIENTA');
            $tablaDistribuidor = constant('TABLA_DISTRIBUIDOR');

            $consulta = "SELECT *
                         FROM $tablaDistribuidor LEFT JOIN $tablaRelacion
                         ON ($tablaDistribuidor.ID = $tablaRelacion.ID_Distribuidor)";

            $res = ControladorBaseDatos::query($consulta);
            $distribuidores = array();

            while ($row = $res->fetch_assoc())
            {
                $distribuidores[] = self::array_Distribuidor($row);
            }

            return $distribuidores;
        }        

        /**
        * Inserta un nuevo Distribuidor en la base de datos
        *
        * @author Jonathan Sandoval             <jonathan_s_pisis@yahoo.com.mx>
        * @param  Distribuidor $distribuidor    Recibe un objeto del tipo Distribuidor a insertar
        * @return Boolean                       Regresa si se pudo o no insertar dicho distribuidor
        **/
        static function insertarDistribuidor($distribuidor = null)
        {
            $nombreTabla    = constant('TABLA_DISTRIBUIDOR');
            $stringDistribuidor = self::DistribuidorToString($distribuidor);

            $consulta = "INSERT INTO $nombreTabla
                         (Nombre, Direccion)
                         VALUES ($stringDistribuidor)";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                if ($distribuidor->getHerramienta() != NULL)
                {
                    $ultimoID = 0;
                    $consulta = "SELECT MAX(ID) AS ID 
                                 FROM $nombreTabla";

                    $res = ControladorBaseDatos::query($consulta);

                    if ($row = $res->fetch_assoc())
                    {
                        $ultimoID = $row["ID"];
                    }

                    $idH     = $distribuidor->getHerramienta()->getID();
                    $calidad = $distribuidor->getHerramienta()->getCalidad()->getAbreviatura();
                    $precio  = $distribuidor->getHerramienta()->getPrecioCompra();

                    $posible  = self::insertarDistribuidorHerramienta($ultimoID, $idH, $calidad, $precio);

                    return $posible;
                }
                else
                {
                    return true;
                }
            }
            else
            {
                return false;
            }
        } 

        /**
        * Actualza la información de un objeto de tipo Distribuidor
        *
        * @author Jonathan Sandoval             <jonathan_s_pisis@yahoo.com.mx>
        * @param  Int $id                       ID del Distribuidor en cuestión
        * @param  Distribuidor $distribuidor    Recibe un objeto del tipo Distribuidor con los nuevos datos
        * @return Boolean                       Regresa si se pudo o no modificar dicho distribuidor
        **/
        static function actualizarDistribuidor($id = 0, $distribuidor = null)
        {
            $nombreTabla    = constant('TABLA_DISTRIBUIDOR');

            $idH     = 0;
            $calidad = 0;
            $precio  = 0;

            if ($distribuidor->getHerramienta() != NULL)
            {
                $idH     = $distribuidor->getHerramienta()->getID();
                $calidad = $distribuidor->getHerramienta()->getCalidad()->getAbreviatura();
                $precio  = $distribuidor->getHerramienta()->getPrecioCompra();
            }

            if (self::obtenerDistribuidorID($id)->getHerramienta() != NULL)
            {
                self::eliminarDistribuidorHerramienta($id, self::obtenerDistribuidorID($id)->getHerramienta()->getID());
            }

            self::insertarDistribuidorHerramienta($id, $idH, $calidad, $precio);

            //Obtenemos todos los datos en variables
            $nombre          = $distribuidor->getNombre();
            $direccion       = $distribuidor->getDireccion();

            $consulta = "UPDATE $nombreTabla
                         SET Direccion = '$direccion' ,
                             Nombre = '$nombre' 
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
        * Elimina un Distribuidor de la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Int $id               ID del Distribuidor a eliminar
        * @return Boolean               Regresa si se pudo o no eliminar dicho distribuidor
        **/
        static function eliminarDistribuidor($id = 0)
        {
            $nombreTabla    = constant('TABLA_DISTRIBUIDOR');

            $consulta = "DELETE FROM $nombreTabla
                         WHERE ID = $id";

            $posible = true;

            if (self::obtenerDistribuidorID($id) != NULL)
            {
                $herramienta = self::obtenerDistribuidorID($id)->getHerramienta();

                if ($herramienta != NULL)
                {
                    $posible = self::eliminarDistribuidorHerramienta($id, $herramienta->getID());
                }
            }

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
        * Obtiene los datos de un distribuidor en particular por su ID
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Int  $id              ID del Distribuidor a encontrar
        * @return Distribuidor          Regresa un objeto de tipo Distribuidor o Null si no existe
        **/
        static function obtenerDistribuidorID($id = 0)
        {
            $tablaRelacion     = constant('TABLA_DISTRIBUIDOR_HERRAMIENTA');
            $tablaDistribuidor = constant('TABLA_DISTRIBUIDOR');

            $consulta = "SELECT *
                         FROM $tablaDistribuidor LEFT JOIN $tablaRelacion
                         ON ($tablaDistribuidor.ID = $tablaRelacion.ID_Distribuidor)
                         WHERE $tablaDistribuidor.ID = $id";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                if ($row = $res->fetch_assoc())
                {
                    $objeto = self::array_Distribuidor($row);

                    return $objeto;
                }
            }

            return NULL;
        }

        /**
         * Obtiene todos los Distribuidores con el nombre parecido al dado en la descripción
         *
         * @author Jonathan Sandoval            <jonathan_s_pisis@yahoo.com.mx>
         * @param String $nombre                Nombre similar a buscar
         * @param Int    $id                    ID similar a buscar
         * @return Array(Distribuidor)          Conjunto de Distribuidores con los nombres dados
         */
        static function obtenerDistribuidorNombreoID($nombre = "", $id = 0)
        {
            $nombreTabla   = constant('TABLA_DISTRIBUIDOR');
            $distribuidores     = array();

            $consult_cad  = "SELECT * 
                             FROM $nombreTabla
                             WHERE Nombre   LIKE \"%$nombre%\" OR 
                                   ID       LIKE \"%$id%\"";
            
            $res          = ControladorBaseDatos::query($consult_cad);

            while ($row = $res->fetch_assoc())
            {
                $distribuidores[] = self::array_Distribuidor($row);
            }

            return $distribuidores;
        }

        /**
        * Filtrar Distribuidor por datos
        * 
        * @author Jonathan Sandoval             <jonathan_s_pisis@hotmail.com>
        * @param Distribuidor $distribuidor     Objeto del tipo Distribuidor con los datos que deben de filtrar
        * @return Array(Distribuidor)           Regresa un Arreglo con el conjunto de Distribuidores filtrados
        */
        static function filtrarDistribuidores($distribuidor = NULL)
        {
            $nombreTabla   = constant('TABLA_DISTRIBUIDOR');

            $id              = $distribuidor->getID();
            $direccion       = $distribuidor->getDireccion();
            $nombre          = $distribuidor->getNombre();

            $distribuidores    = array();

            $consult_cad  = "SELECT *  
                             FROM $nombreTabla
                             WHERE ID               LIKE \"%$id%\"              AND
                                   Direccion        LIKE \"%$direccion%\"       AND
                                   Nombre           LIKE \"%$nombre%\"";

            $res          = ControladorBaseDatos::query($consult_cad);

            while ($row = $res->fetch_assoc())
            {
                $distribuidores[] = self::array_Distribuidor($row);
            }

            return $distribuidores;
        }

        /**
         * Conjunto de funciones para ordenar y filtrar en relación de la URL
         * 
         * @author Jonathan Sandoval        <jonathan_s_pisis@hotmail.com>
         * @return Array(Distribuidor)      Conjunto de Distribuidores despueś de analizar la URL
         */ 
        static function frontendFunctions()
        {
            // Obtención de los datos de la URL
            $url = ControladorBaseDatos::getRestoURL();

            $attribArray = array("ID", "Direccion", "Nombre");

            //Revisa si se desea eliminar un Distribuidor
            if (strripos($url, "?action=delete&distribuidor_id=") !== false)
            {
                $id_distribuidor = Intval(substr($url, strlen("?action=delete&distribuidor_id=")));
                
                /* Validación del tipo de Distribuidor
                */
               
                if (self::eliminarDistribuidor($id_distribuidor) == false)
                {
                    $error = ControladorBaseDatos::getLastError();

                    if ($error != "")
                    {
                        $error = substr($error, (strpos($error, '`herremex`.`') + strlen('`herremex`.`')));

                        $error = substr($error, (strpos($error, '`herremex`.`') + strlen('`herremex`.`')));
                        $error = substr($error, 0, strpos($error, '`'));

                        echo "<script>
                                alert('La tabla \'$error\' está ocupando al distribuidor');
                              </script>";
                    }
                }
            }

            $distribuidores = self::obtenerDistribuidores();

            // Revisa si desea buscar por nombre
            if (strpos($url, "?keyword=") !== false)
            {
                $to_search = substr($url, strlen("?keyword="));
                $to_search = substr($to_search, 0, strpos($to_search, '&'));

                if ($to_search !== "")
                {
                    //Filtra en relación de todo su nombre
                    $distribuidores = self::obtenerDistribuidorNombreoID($to_search, $to_search);
                }
            }

            // Si desea buscar de modo avanzado
            if (strpos($url, "?keyword_id=") !== false)
            {
                $myurl             = $url;
                $distribuidorTemp  = array();
                $distribuidores    = array();

                $keywArray   = array("?keyword_id=", "keyword_direccion=", "keyword_nombre=");


                //Rescara los valores de cada kwyword y los agrega a un objeto Distribuidor
                foreach ($keywArray as $key => $keyword) 
                {
                    $myurl          = substr($myurl, stripos($myurl, $keyword));

                    $distribuidorTemp[$attribArray["$key"]]  = substr($myurl,
                                                           stripos($myurl, $keyword) + strlen($keyword),
                                                           stripos($myurl, "&") - strlen($keyword));
                }

                //Filtra en relación de los datos del objeto obtenido
                $distribuidores = self::filtrarDistribuidores(self::array_Distribuidor($distribuidorTemp));
            }

            //Retorna el conjunto de Distribuidores después de las operaciones
            return $distribuidores;
        }
    }
 ?>