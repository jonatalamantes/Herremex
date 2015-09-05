<?php 

    require_once(__DIR__.'/ControladorBaseDatos.php');
    require_once(__DIR__.'/Herramienta.php');
    require_once(__DIR__.'/Calidad.php');

    /**
    * Clase de la controlador de la Herramienta
    *
    * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
    */
    class ControladorHerramienta
    {
        /**
         * Obtiene todos los tipos de herramientas de la base de datos
         *
         * @author Jonathan Sandoval      <jonathan_s_pisis@yahoo.com.mx>
         * @return Array(TipoHerramienta) Conjunto de Tipo de herramientas
         */
        static function obtenerTipoHerramientas()
        {
            $nombreTabla = constant('TABLA_TIPOHERRAMIENTA');

            $consulta = "SELECT *
                         FROM $nombreTabla";

            $res = ControladorBaseDatos::query($consulta);

            $tipos = array();

            while ($row = $res->fetch_assoc())
            {
                $tipo = new TipoHerramienta();

                $tipo->setID($row["ID"]);
                $tipo->setNombre($row["Nombre"]);

                $tipos[] = $tipo;
            }

            return $tipos;
        }

        /**
         * Obtiene todas las marcas que esté registradas en la base de datos
         *
         * @author Jonathan Sandoval      <jonathan_s_pisis@yahoo.com.mx>
         * @return Array(Marca)           Conjunto de marcas
         */
        static function obtenerMarcas()
        {
            $nombreTabla = constant('TABLA_MARCA');

            $consulta = "SELECT *
                         FROM $nombreTabla";

            $res = ControladorBaseDatos::query($consulta);

            $marcas = array();

            while ($row = $res->fetch_assoc())
            {
                $marca = new Marca();

                $marca->setID($row["ID"]);
                $marca->setAbreviatura($row["Abreviatura"]);
                $marca->setNombre($row["Nombre"]);

                $marcas[] = $marca;
            }

            return $marcas;
        }

        /**
         * Obtiene todas las calidades que esté registradas en la base de datos
         *
         * @author Jonathan Sandoval      <jonathan_s_pisis@yahoo.com.mx>
         * @return Array(Calidad)           Conjunto de calidades
         */
        static function obtenerCalidades()
        {
            $nombreTabla = constant('TABLA_CALIDAD');

            $consulta = "SELECT *
                         FROM $nombreTabla";

            $res = ControladorBaseDatos::query($consulta);

            $calidades = array();

            while ($row = $res->fetch_assoc())
            {
                $calidad = new Calidad();

                $calidad->setAbreviatura($row["Abreviatura"]);
                $calidad->setNombre($row["Nombre"]);

                $calidades[] = $calidad;
            }

            return $calidades;
        }        

        /**
        * Transforma un objeto del tipo Herramienta en un array asociativo
        *
        * @author Jonathan Sandoval           <jonathan_s_pisis@yahoo.com.mx>
        * @param  Herramienta $herramienta    Objeto de tipo Herramienta con datos de un Herramienta
        * @return Array                       Arreglo Asociativo con los datos de la herramienta
        **/
        static function Herramienta_array($Herramienta = NULL)
        {
            $arrayHerramienta = array();

            //Establecemos datos directors de la Herramienta
            $arrayHerramienta["ID"] = $Herramienta->getID();
            $arrayHerramienta["Precio"] = $Herramienta->getPrecio();
            $arrayHerramienta["Nombre"] = $Herramienta->getNombre();

            //EStablece datos de objetos dentro de objetos
            $marca = $Herramienta->getMarca() !== NULL ? $Herramienta->getMarca()->getID() : 0;
            $cantidad = $Herramienta->getCantidad() !== NULL ? $Herramienta->getCantidad() : 0;
            $calidad = $Herramienta->getCalidad() !== NULL ? $Herramienta->getCalidad()->getAbreviatura() : "Sin Calidad";
            $precioC = $Herramienta->getPrecioCompra() !== NULL ? $Herramienta->getPrecioCompra() : "Sin Datos";

            $arrayHerramienta["ID_Tipo"]      = $Herramienta->getTipo()->getID();
            $arrayHerramienta["ID_Marca"]     = $marca;
            $arrayHerramienta["Calidad"]      = $calidad;
            $arrayHerramienta["PrecioCompra"] = $precioC;
            $arrayHerramienta["CantidadExistente"] = $cantidad;

            return $arrayHerramienta;
        }

        /**
        * Transforma un array asociativo a un objeto del tipo Herramienta
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Array $array          Arreglo Asociativo con los datos de una Herramienta
        * @return Herramienta           Objeto de tipo Herramienta con datos del array recibido
        **/
        static function array_Herramienta($array = array())
        {
            //Nombre de las tablas
            $tablaTipo    = constant('TABLA_TIPOHERRAMIENTA');
            $tablaMarca   = constant('TABLA_MARCA');            
            $tablaCalidad = constant('TABLA_CALIDAD');

            //Nombre de las abrebviaturas de cada objeto de la tabla
            $idtipo     = $array["ID_Tipo"];
            
            isset($array["ID_Marca"]) ? $idMarca = intval($array["ID_Marca"]) : $idMarca = 0;
            isset($array["Calidad"])  ? $abrCalidad = $array["Calidad"] : $abrCalidad = "";

            //Objetos Provisionales
            $tipo    = NULL;
            $marca   = NULL;
            $calidad = NULL;

            $objeto = new Herramienta();

            //Establece datos de la instancia del empleado
            $objeto->setID($array["ID"]);
            $objeto->setNombre($array["Nombre"]);
            $objeto->setPrecio($array["Precio"]);
            $objeto->setCantidad($array["CantidadExistente"]);
            $objeto->setPrecioCompra($array["PrecioCompra"]);

            if ($idtipo != "")
            {
                //Establece un objeto de tipo 'Tipo'
                $consulta = "SELECT *
                             FROM $tablaTipo
                             WHERE ID = '$idtipo' OR
                                   Nombre LIKE '%$idtipo%' 
                             LIMIT 1";

                $res = ControladorBaseDatos::query($consulta);

                if ($row = $res->fetch_assoc())
                {
                    $tipo = new TipoHerramienta();

                    $tipo->setID($row["ID"]);
                    $tipo->setNombre($row["Nombre"]);
                }

            }

            $objeto->setTipo($tipo);

            //Establece un objeto de tipo 'Marca'
            $consulta = "SELECT *
                         FROM $tablaMarca
                         WHERE ID = $idMarca
                         LIMIT 1";

            $res = ControladorBaseDatos::query($consulta);

            if ($row = $res->fetch_assoc())
            {
                $marca = new Marca();

                $marca->setID($row["ID"]);
                $marca->setAbreviatura($row["Abreviatura"]);
                $marca->setNombre($row["Nombre"]);
            }

            $objeto->setMarca($marca);

            //Establece un objeto de tipo 'Calidad'
            $consulta = "SELECT *
                         FROM $tablaCalidad
                         WHERE Abreviatura = '$abrCalidad'
                         LIMIT 1";

            $res = ControladorBaseDatos::query($consulta);

            if ($row = $res->fetch_assoc())
            {
                $calidad = new Calidad();

                $calidad->setAbreviatura($row["Abreviatura"]);
                $calidad->setNombre($row["Nombre"]);
            }

            $objeto->setCalidad($calidad);


            return $objeto;
        }

        /**
        * Transforma un objeto de la tipo Herramienta en un String con comillas
        *
        * @author Jonathan Sandoval        <jonathan_s_pisis@yahoo.com.mx>
        * @param  Herramienta $Emplead     Objeto de la tipo Herramienta a transformar
        * @return String                   String resultante como para una inserción
        **/
        static function HerramientaToString($Herramienta = NULL)
        {
            $string = "";
            $string = $string . strval($Herramienta->getTipo()->getID()) . ",";
            $string = $string . strval($Herramienta->getPrecio()) . ",";
            $string = $string . "'" . strval($Herramienta->getNombre()) . "'";

            return $string;
        }

        /**
        * Obtiene todos los herramientas registrados en la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @return Array(Herramienta)    Regresa un arreglo con el conjunto de herramientas
        **/
        static function obtenerHerramientas()
        {
            $tablaHerramienta = constant('TABLA_HERRAMIENTA');
            $tablaRelacionHM  = constant('TABLA_HERRAMIENTA_MARCA');
            $tablaRelacionDR  = constant('TABLA_DISTRIBUIDOR_HERRAMIENTA');

            $consulta = "SELECT *
                         FROM $tablaHerramienta LEFT JOIN $tablaRelacionHM
                         ON ($tablaHerramienta.ID = $tablaRelacionHM.ID_Herramienta)
                         LEFT JOIN $tablaRelacionDR
                         ON ($tablaHerramienta.ID = $tablaRelacionDR.ID_Herramienta)";

            $res = ControladorBaseDatos::query($consulta);

            $herramientas = array();

            while ($row = $res->fetch_assoc())
            {
                $herramientas[] = self::array_Herramienta($row);
            }

            return $herramientas;
        }        

        /**
        * Obtiene todos los herramientas registrados en la base de datos que no tengan marca
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @return Array(Herramienta)    Regresa un arreglo con el conjunto de herramientas
        **/
        static function obtenerHerramientasSinCantidad()
        {
            $tablaHerramienta = constant('TABLA_HERRAMIENTA');
            $tablaRelacionHM  = constant('TABLA_HERRAMIENTA_MARCA');
            $tablaRelacionDR  = constant('TABLA_DISTRIBUIDOR_HERRAMIENTA');

            $consulta = "SELECT *
                         FROM $tablaHerramienta LEFT JOIN $tablaRelacionHM
                         ON ($tablaHerramienta.ID = $tablaRelacionHM.ID_Herramienta)
                         LEFT JOIN $tablaRelacionDR
                         ON ($tablaHerramienta.ID = $tablaRelacionDR.ID_Herramienta)
                         WHERE $tablaHerramienta.ID = $tablaRelacionHM.ID_Herramienta
                         AND $tablaRelacionHM.CantidadExistente > 0";

            $res = ControladorBaseDatos::query($consulta);

            $herramientas = array();

            while ($row = $res->fetch_assoc())
            {
                $herramientas[] = self::array_Herramienta($row);
            }

            return $herramientas;
        }  
        /**
         * Inserta una nueva tupla en la tabla de relación entre la herramienta y la marca
         *
         * @author Jonathan Sandoval      <jonathan_s_pisis@yahoo.com.mx>
         * @param  Int     $idHerramienta ID de la Herramienta para la relación
         * @param  Int     $idMarca       ID de la Marca a relacionar
         * @param  Int     $cantidad      Cantidad de productos existentes de herramientas de dicha marca
         * @return boolean                Devuelve si pudo o no insertar dicha tupla
         */
        static function insertarHerramientaMarca($idHerramienta = 0, $idMarca = 0, $cantidad = 0)
        {
            if ($idHerramienta == 0 || $idMarca == 0)
            {
                return true;
            }

            $nombreTabla = constant("TABLA_HERRAMIENTA_MARCA");

            $consulta    = "INSERT INTO $nombreTabla
                            (ID_Herramienta, ID_Marca, CantidadExistente)
                            VALUES
                            ($idHerramienta, $idMarca, $cantidad)";

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
         * Eliminar una tupla de relación entre la herramienta y la marca
         *
         * @author Jonathan Sandoval      <jonathan_s_pisis@yahoo.com.mx>
         * @param  Int     $idHerramienta ID de la herramienta
         * @param  Int     $idMarca       ID de la marca a eliminar
         * @return boolean                Devuelve si pudo o no eliminar dicha tupla
         */
        static function eliminarHerramientaMarca($idHerramienta = 0, $idMarca = 0)
        {
            $nombreTabla = constant("TABLA_HERRAMIENTA_MARCA");

            $consulta    = "DELETE FROM $nombreTabla
                            WHERE ID_Herramienta = $idHerramienta AND
                                  ID_Marca = $idMarca";

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
        * Inserta un nuevo Herramienta en la base de datos
        *
        * @author Jonathan Sandoval           <jonathan_s_pisis@yahoo.com.mx>
        * @param  Herramienta $herramienta    Recibe un objeto de la tipo Herramienta a insertar
        * @return Boolean                     Regresa si se pudo o no insertar dicho herramienta
        **/
        static function insertarHerramienta($herramienta = NULL)
        {
            $nombreTabla    = constant('TABLA_HERRAMIENTA');
            $stringHerramienta = self::HerramientaToString($herramienta);

            $consulta = "INSERT INTO $nombreTabla
                         (ID_Tipo, Precio, Nombre)
                         VALUES ($stringHerramienta)";

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

                $posible  = self::insertarHerramientaMarca($ultimoID, 
                                                           $herramienta->getMarca()->getID(), 
                                                           $herramienta->getCantidad());

                return $posible;
            }
            else
            {
                return false;
            }
        }  

        /**
        * Actualza la información de un objeto de tipo Herramienta
        *
        * @author Jonathan Sandoval           <jonathan_s_pisis@yahoo.com.mx>
        * @param  int $id                     ID de la Herramienta en cuestión
        * @param  Herramienta $herramienta    Recibe un objeto de la tipo Herramienta con los nuevos datos
        * @return Boolean                     Regresa si se pudo o no modificar dicho herramienta
        **/
        static function actualizarHerramienta($id = 0, $herramienta = NULL)
        {
            $nombreTabla    = constant('TABLA_HERRAMIENTA');

            $idM      = 0;
            $cantidad = 0;

            if ($herramienta->getMarca() != NULL)
            {
                $idM      = $herramienta->getMarca()->getID();
                $cantidad = $herramienta->getCantidad();
            }

            if (self::obtenerHerramientaID($id)->getMarca() != NULL)
            {
                self::eliminarHerramientaMarca($id, self::obtenerHerramientaID($id)->getMarca()->getID());
            }

            self::insertarHerramientaMarca($id, $idM, $cantidad);

            //Obtenemos todos los datos en variables
            $nombre          = $herramienta->getNombre();
            $precio          = $herramienta->getPrecio();
            $tipo            = $herramienta->getTipo()->getID();

            $consulta = "UPDATE $nombreTabla
                         SET Nombre  = '$nombre' ,
                             Precio  =  $precio  ,
                             ID_Tipo =  $tipo
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
        * Elimina un Herramienta de la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  int $id               ID de la Herramienta a eliminar
        * @return Boolean               Regresa si se pudo o no eliminar dicho herramienta
        **/
        static function eliminarHerramienta($id = 0)
        {
            $tablaHerramienta = constant('TABLA_HERRAMIENTA');

            $posible = true;

            if (self::obtenerHerramientaID($id) != NULL)
            {
                $marca = self::obtenerHerramientaID($id)->getMarca();

                if ($marca != NULL)
                {
                    $posible = self::eliminarHerramientaMarca($id, $marca->getID());
                }
            }
            
            $consulta = "DELETE FROM $tablaHerramienta
                         WHERE $tablaHerramienta.ID = $id";

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
        * Obtiene los datos de un herramienta en particular por su ID
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  int  $id              ID de la Herramienta a encontrar
        * @return Herramienta           Regresa un objeto de tipo Herramienta o Null si no existe
        **/
        static function obtenerHerramientaID($id = 0)
        {
            $tablaHerramienta = constant('TABLA_HERRAMIENTA');
            $tablaRelacionHM  = constant('TABLA_HERRAMIENTA_MARCA');
            $tablaRelacionDR  = constant('TABLA_DISTRIBUIDOR_HERRAMIENTA');

            $consulta = "SELECT *
                         FROM $tablaHerramienta LEFT JOIN $tablaRelacionHM
                         ON ($tablaHerramienta.ID = $tablaRelacionHM.ID_Herramienta)
                         LEFT JOIN $tablaRelacionDR
                         ON ($tablaHerramienta.ID = $tablaRelacionDR.ID_Herramienta)
                         WHERE $tablaHerramienta.ID = $id";

            $res = ControladorBaseDatos::query($consulta);

            if ($row = $res->fetch_assoc())
            {
                $objeto = self::array_Herramienta($row);

                return $objeto;
            }

            return NULL;
        }

        /**
         * Obtiene todos los Herramientas con el nombre parecido al dado en la descripción
         *
         * @author Jonathan Sandoval        <jonathan_s_pisis@yahoo.com.mx>
         * @param String $nombre            Nombre similar a buscar
         * @param Int $id                   ID del Empleado a obtener o semejante
         * @return Array(Herramienta)       Conjunto de Herramientas con los nombres dados
         */
        static function obtenerHerramientaNombreoID($nombre = "", $id = 0)
        {
            $tablaHerramienta = constant('TABLA_HERRAMIENTA');
            $tablaRelacionHM  = constant('TABLA_HERRAMIENTA_MARCA');
            $tablaRelacionDR  = constant('TABLA_DISTRIBUIDOR_HERRAMIENTA');

            $consult_cad = "SELECT *
                         FROM $tablaHerramienta LEFT JOIN $tablaRelacionHM
                         ON ($tablaHerramienta.ID = $tablaRelacionHM.ID_Herramienta)
                         LEFT JOIN $tablaRelacionDR
                         ON ($tablaHerramienta.ID = $tablaRelacionDR.ID_Herramienta)
                         WHERE $tablaHerramienta.ID LIKE \"%$id%\" OR
                               $tablaHerramienta.Nombre LIKE \"%$nombre%\"";

            $res          = ControladorBaseDatos::query($consult_cad);

            while ($row = $res->fetch_assoc())
            {
                $herramientas[] = self::array_Herramienta($row);
            }

            return $herramientas;
        }

        /**
        * Filtrar Herramienta por datos
        * 
        * @author Jonathan Sandoval           <jonathan_s_pisis@hotmail.com>
        * @param Herramienta $herramienta     Objeto de la tipo Herramienta con los datos que deben de filtrar
        * @return Array(Herramienta)          Regresa un Arreglo con el conjunto de Herramientas filtrados
        */
        static function filtrarHerramienta($herramienta = NULL)
        {
            $nombreTabla   = constant('TABLA_HERRAMIENTA');
            $tablaTipo     = constant('TABLA_TIPOHERRAMIENTA');

            $id              = $herramienta->getID();
            $nombre          = $herramienta->getNombre();
            $precio          = $herramienta->getPrecio();
            $herramienta->getTipo() !== NULL ? $tipo = $herramienta->getTipo()->getNombre()
                                             : $tipo = "";

            $herramientas    = array();
            $consult_cad     = "";

            if ($tipo != "")
            {
                $consult_cad  = "SELECT * 
                                 FROM $nombreTabla
                                 WHERE ID               LIKE \"%$id%\"              AND
                                       Nombre           LIKE \"%$nombre%\"          AND
                                       Precio           LIKE \"%$precio%\"          AND
                                       ID_Tipo = (SELECT ID FROM $tablaTipo WHERE Nombre LIKE \"$tipo\")";
            }
            else
            {
                $consult_cad  = "SELECT * 
                                 FROM $nombreTabla
                                 WHERE ID               LIKE \"%$id%\"              AND
                                       Nombre           LIKE \"%$nombre%\"          AND
                                       Precio           LIKE \"%$precio%\"";
            }

            $res          = ControladorBaseDatos::query($consult_cad);

            while ($row = $res->fetch_assoc())
            {
                $herramientas[] = self::array_Herramienta($row);
            }

            return $herramientas;
        }

        /**
         * Conjunto de funciones para ordenar y filtrar en relación de la URL
         * 
         * @author Jonathan Sandoval    <jonathan_s_pisis@hotmail.com>
         * @return Array(Herramienta)      Conjunto de Herramientas despueś de analizar la URL
         */ 
        static function frontendFunctions()
        {
            // Obtención de los datos de la URL
            $url = ControladorBaseDatos::getRestoURL();

            $attribArray = array("ID", "ID_Tipo", "Precio", "Nombre");

            //Revisa si se desea eliminar un Herramienta
            if (strripos($url, "?action=delete&herramienta_id=") !== false)
            {
                $id_herramienta = intval(substr($url, strlen("?action=delete&herramienta_id=")));
                
                /* Validación de la tipo de Herramienta
                */
                if (self::eliminarHerramienta($id_herramienta) == false)
                {
                    $error = ControladorBaseDatos::getLastError();

                    $error = substr($error, (strpos($error, '`herremex`.`') + strlen('`herremex`.`')));
                    $error = substr($error, 0, strpos($error, '`'));

                    echo "<script>
                            alert('La tabla \'$error\' está ocupando la herramienta');
                          </script>";
                }
            }

            $herramientas = self::obtenerHerramientas();

            // Revisa si desea buscar por nombre
            if (strpos($url, "?keyword=") !== false)
            {
                $to_search = substr($url, strlen("?keyword="));
                $to_search = substr($to_search, 0, strpos($to_search, '&'));

                if ($to_search !== "")
                {
                    //Filtra en relación de todo su nombre
                    $herramientas = self::obtenerHerramientaNombreoID($to_search, $to_search);
                }
            }

            // Si desea buscar de modo avanzado
            if (strpos($url, "?keyword_id=") !== false)
            {
                $myurl           = $url;
                $herramientaTemp = array();
                $herramientas    = array();

                $keywArray   = array("?keyword_id=", "keyword_tipo=", "keyword_precio=", "keyword_nombre=");

                //Rescara los valores de cada kwyword y los agrega a un objeto Herramienta
                foreach ($keywArray as $key => $keyword) 
                {
                    $myurl          = substr($myurl, stripos($myurl, $keyword));

                    $herramientaTemp[$attribArray["$key"]]  = substr($myurl,
                                                           stripos($myurl, $keyword) + strlen($keyword),
                                                           stripos($myurl, "&") - strlen($keyword));
                }

                //Filtra en relación de los datos de la objeto obtenido
                $herramientas = self::filtrarHerramienta(self::array_Herramienta($herramientaTemp));
            }

            //Retorna el conjunto de Herramientas después de las operaciones
            return $herramientas;
        }

        static function disminuirHerramientas($idHerramienta = "0", $cantidadDecremental = 0)
        {
            $tablaRelacionHM  = constant('TABLA_HERRAMIENTA_MARCA');

            $herramienta = self::obtenerHerramientaID($idHerramienta);

            if ($herramienta !== NULL)
            {
                $consulta = "UPDATE $tablaRelacionHM
                             SET CantidadExistente = " . strval($herramienta->getCantidad() - $cantidadDecremental) .
                            " WHERE $tablaRelacionHM.ID_Herramienta = $idHerramienta";

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
    }
    
 ?>