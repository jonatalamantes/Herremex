<?php 

    require_once(__DIR__.'/ControladorBaseDatos.php');
    require_once(__DIR__.'/ControladorHerramienta.php');
    require_once(__DIR__.'/ControladorSucursal.php');
    require_once(__DIR__.'/ControladorCliente.php');
    require_once(__DIR__.'/CompraVenta.php');
    require_once(__DIR__.'/HerramientaComprada.php');

    /**
    * Clase del controlador del CompraVenta
    *
    * @author Jonathan Sandoval    <jonathan_s_pisis@yahoo.com.mx>
    */
    class ControladorCompraVenta
    {
        /**
         * Recupera el Número total de herramientas en la base de datos
         *
         * @author Jonathan Sandoval    <jonathan_s_pisis@yahoo.com.mx>
         * @return Int                  Numero total de Herramientas
         */
        static function cantidadHerramientas()
        {
            $nombreTabla = constant('TABLA_HERRAMIENTA');

            $consulta = "SELECT *
                         FROM $nombreTabla";

            $res = ControladorBaseDatos::query($consulta);

            return ControladorBaseDatos::getAffectedRows();        
        }

        /**
         * Obtiene el último Identificador de la tabla de Herramientas Compradas
         *
         * @author Jonathan Sandoval    <jonathan_s_pisis@yahoo.com.mx>
         * @return Int                  Ulitimo Identificador de la tabla 
         *                              'TABLA_HERRAMIENTA_COMPRADA'
         */
        static function obtenerUltimoIdentificador()
        {
            $nombreTabla = constant('TABLA_HERRAMIENTA_COMPRADA');

            $ultimoID = 0;
            $consulta = "SELECT MAX(Identificador) AS ID 
                         FROM $nombreTabla";

            $res = ControladorBaseDatos::query($consulta);

            if ($row = $res->fetch_assoc())
            {
                $ultimoID = $row["ID"];
            }

            return $ultimoID;
        }

        /**
        * Transforma un objeto del tipo CompraVenta en un array asociativo
        *
        * @author Jonathan Sandoval         <jonathan_s_pisis@yahoo.com.mx>
        * @param  CompraVenta $CompraVenta  Objeto de tipo CompraVenta con datos de un CompraVenta
        * @return Array                     Arreglo Asociativo con los datos del CompraVenta
        **/
        static function CompraVenta_array($CompraVenta = NULL)
        {
            $arrayCompraVenta = array();

            //Establecemos datos directors del CompraVenta
            $arrayCompraVenta["ID"]                   = $CompraVenta->getID();
            $arrayCompraVenta["Sucursal"]             = $CompraVenta->getSucursal()->getID();
            $arrayCompraVenta["Cliente"]              = $CompraVenta->getCliente()->getID();
            $arrayCompraVenta["Herramienta_Comprada"] = $CompraVenta->getHerramientaComprada()->getIdentificador();
            $arrayCompraVenta["Envio_Domicilio"]      = $CompraVenta->getEnvioDomicilio();
            $arrayCompraVenta["Factura"]              = $CompraVenta->getFacturar();
            $arrayCompraVenta["Fecha"]                = $CompraVenta->getFecha();
        
            return $arrayCompraVenta;
        }

        /**
        * Transforma un array asociativo a un objeto del tipo CompraVenta
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @param  Array $array          Arreglo Asociativo con los datos de una CompraVenta
        * @return CompraVenta           Objeto de tipo CompraVenta con datos del array recibido
        **/
        static function array_CompraVenta($arrayCompraVenta = array())
        {
            $tablaHerramientaComprada = constant('TABLA_HERRAMIENTA_COMPRADA');

            $CompraVenta   = new CompraVenta();

            //Le ponemos los datos de lo que hemos recibido del array
            $CompraVenta->setID($arrayCompraVenta["ID"]);
            $CompraVenta->setSucursal(ControladorSucursal::obtenerSucursalID($arrayCompraVenta["Sucursal"]));
            $CompraVenta->setCliente(ControladorCliente::obtenerClienteID($arrayCompraVenta["Cliente"]));
            $CompraVenta->setEnvioDomicilio($arrayCompraVenta["Envio_Domicilio"]);
            $CompraVenta->setFacturar($arrayCompraVenta["Factura"]);
            $CompraVenta->setFecha($arrayCompraVenta["Fecha"]);

            //Obtenemos los datos de las herramientas
            $herramientaC  = new HerramientaComprada();
            $herramientas  = array();
            $cantidades    = array();
            $identificador = $arrayCompraVenta["Herramienta_Comprada"];

            $consulta = "SELECT * 
                         FROM $tablaHerramientaComprada
                         WHERE Identificador = $identificador";

            $res = ControladorBaseDatos::query($consulta);

            while ($row = $res->fetch_assoc())
            {
                $herramientas[] = $row["ID_Herramienta"];
                $cantidades[]   = $row["Cantidad"];
            }

            $herramientaC->setCantidad($cantidades);
            $herramientaC->setIDHerramienta($herramientas);
            $herramientaC->setIdentificador($identificador);

            $CompraVenta->setHerramientaComprada($herramientaC);

            return $CompraVenta;

        }

        /**
         * Inserta el conjunto de herramientas de una compra en la tabla de herramienta
         * Compra en vase a su identificador repetido
         *
         * @author Jonathan Sandoval         <jonathan_s_pisis@yahoo.com.mx>
         * @param  CompraVenta $CompraVenta  Objeto con las herramientas a guardar
         */
        static function insertarHerramientaComprada($CompraVenta = NULL)
        {
            $nombreTabla = constant('TABLA_HERRAMIENTA_COMPRADA');

            $identificador = intval(self::obtenerUltimoIdentificador()) + 1;
            $herramientas  = $CompraVenta->getHerramientaComprada()->getIDHerramienta();
            $cantidades    = $CompraVenta->getHerramientaComprada()->getCantidad();

            foreach ($herramientas as $key => $value) 
            {
                $simpleH = $herramientas[$key];
                $simpleC = $cantidades[$key];

                $consulta = "INSERT INTO $nombreTabla
                            (Identificador, ID_Herramienta, Cantidad)
                            VALUES ($identificador, $simpleH, $simpleC)";

                ControladorBaseDatos::query($consulta);
            }
        }

        /**
        * Transforma un objeto del tipo CompraVenta en un String con comillas
        *
        * @author Jonathan Sandoval         <jonathan_s_pisis@yahoo.com.mx>
        * @param  CompraVenta $Emplead      Objeto del tipo CompraVenta a transformar
        * @return String                    String resultante como para una inserción
        **/
        static function CompraVentaToString($CompraVenta = NULL)
        {
            $fecha = date('Y-m-d');

            $string = "";
            $string = $string . strval($CompraVenta->getCliente()->getID()) . ",";
            $string = $string . strval($CompraVenta->getSucursal()->getID()) . ",";
            $string = $string . strval(self::obtenerUltimoIdentificador()) . ",";
            $string = $string . "'" . strval($CompraVenta->getEnvioDomicilio()) . "',";
            $string = $string . "'" . strval($CompraVenta->getFacturar()) . "',";
            $string = $string . "'" . strval($fecha) . "'";

            return $string;
        }

         /**
        * Obtiene todos los CompraVentas registrados en la base de datos
        *
        * @author Jonathan Sandoval     <jonathan_s_pisis@yahoo.com.mx>
        * @return Array(CompraVenta)    Regresa un arreglo con el conjunto de CompraVentas
        **/
        static function obtenerCompraVentas()
        {
            $tablaCompraVentas = constant('TABLA_COMPRA');

            $consulta = "SELECT ID, 
                                ID_Cliente AS Cliente, 
                                ID_Sucursal AS Sucursal, 
                                ID_Herramienta_Comprada AS Herramienta_Comprada, 
                                EnvioDocimilio AS Envio_Domicilio, 
                                Facturar AS Factura, 
                                Fecha 
                         FROM $tablaCompraVentas;";

            $res = ControladorBaseDatos::query($consulta);
            $CompraVentas = array();

            while ($row = $res->fetch_assoc())
            {
                $CompraVentas[] = self::array_CompraVenta($row);
            }

            return $CompraVentas;
        }

        /**
        * Inserta un nuevo CompraVenta en la base de datos
        *
        * @author Jonathan Sandoval             <jonathan_s_pisis@yahoo.com.mx>
        * @param  CompraVenta $CompraVenta      Recibe un objeto del tipo CompraVenta a insertar
        * @return Boolean                       Regresa si se pudo o no insertar dicho CompraVenta
        **/
        static function insertarCompraVenta($CompraVenta = NULL)
        {
            self::insertarHerramientaComprada($CompraVenta);

            $nombreTabla    = constant('TABLA_COMPRA');
            $stringCompraVenta = self::CompraVentaToString($CompraVenta);

            $consulta = "INSERT INTO $nombreTabla
                         (ID_Cliente, ID_Sucursal, ID_Herramienta_Comprada, EnvioDocimilio, Facturar, Fecha)
                         VALUES ($stringCompraVenta)";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() >= 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }  

        /**
        * Obtiene los datos de un CompraVenta en particular por su ID
        *
        * @author Jonathan Sandoval   <jonathan_s_pisis@yahoo.com.mx>
        * @param  int  $id            ID del CompraVenta a encontrar
        * @return CompraVenta         Regresa un objeto de tipo CompraVenta o Null si no existe
        **/
        static function obtenerCompraVentaID($id = 0)
        {
            $tablaCompraVentas  = constant('TABLA_COMPRA');

            $consulta = "SELECT ID, 
                                ID_Cliente AS Cliente, 
                                ID_Sucursal AS Sucursal, 
                                ID_Herramienta_Comprada AS Herramienta_Comprada, 
                                EnvioDocimilio AS Envio_Domicilio, 
                                Facturar AS Factura, 
                                Fecha 
                         FROM $tablaCompraVentas
                         WHERE ID = $id;";

            $res = ControladorBaseDatos::query($consulta);

            if (ControladorBaseDatos::getAffectedRows() == 1)
            {
                if ($row = $res->fetch_assoc())
                {
                    $objeto = self::array_CompraVenta($row);

                    return $objeto;
                }
            }

            return NULL;
        }
        
        /**
         * Obtiene todos los CompraVentas segun el ID, la fecha o ambos
         *
         * @author Jonathan Sandoval      <jonathan_s_pisis@yahoo.com.mx>
         * @param String $id              Nombre similar a buscar
         * @param String $fecha           Fecha  similar a buscar
         * @return Array(CompraVenta)     Conjunto de CompraVentas con los nombres dados
         */
        static function obtenerCompraVentaAvanzada($id = "", $fecha = "")
        {
            $nombreTabla   = constant('TABLA_COMPRA');
            $CompraVentas  = array();
            $operador = "AND";

            if ($id == "")
            {
                $id = 0;
            }

            if ($id == 0 || $fecha == '')
            {
                $operador = "OR";
            }

            $consulta = "SELECT ID, 
                                ID_Cliente              AS Cliente, 
                                ID_Sucursal             AS Sucursal, 
                                ID_Herramienta_Comprada AS Herramienta_Comprada, 
                                EnvioDocimilio          AS Envio_Domicilio, 
                                Facturar                AS Factura, 
                                Fecha 
                         FROM $nombreTabla
                         WHERE ID           = $id  $operador
                               fecha        = '$fecha'";
            
            $res  = ControladorBaseDatos::query($consulta);

            while ($row = $res->fetch_assoc())
            {
                $CompraVentas[] = self::array_CompraVenta($row);
            }

            return $CompraVentas;
        }

        /**
         * Conjunto de funciones para filtrar en relación de la URL
         * 
         * @author Jonathan Sandoval   <jonathan_s_pisis@hotmail.com>
         * @return Array(CompraVenta)  Conjunto de CompraVentas despueś de analizar la URL
         */
        static function frontendFunctions()
        {
            // Obtención de los datos de la URL
            $url = ControladorBaseDatos::getRestoURL();
            //$url = "?keyword_id=2&?keyword_fecha=2015&";

            $CompraVentas = self::obtenerCompraVentas();

            // Si desea buscar de modo avanzado
            if (strpos($url, "?keyword_id=") !== false)
            {
                $myurl             = $url;
                $distribuidorTemp  = array();
                $distribuidores    = array();

                $keywArray   = array("?keyword_id=", "keyword_fecha=");

                $myurl          = substr($myurl, stripos($myurl, $keywArray[0]));

                $id  = substr($myurl,
                       stripos($myurl, $keywArray[0]) + strlen($keywArray[0]),
                       stripos($myurl, "&") - strlen($keywArray[0]));

                $myurl          = substr($myurl, stripos($myurl, $keywArray[1]));

                $fecha  = substr($myurl,
                          stripos($myurl, $keywArray[1]) + strlen($keywArray[1]),
                          stripos($myurl, "&") - strlen($keywArray[1]));

                //Filtra en relación de los datos del objeto obtenido
                $CompraVentas = self::obtenerCompraVentaAvanzada($id, $fecha);
            }

            return $CompraVentas;
        }
    }

 ?>