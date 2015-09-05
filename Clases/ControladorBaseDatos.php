<?php session_start();

    define('HOST',                              'localhost');
    define('USUARIO',                           'PersonalHerremex');
    define('PASSWORD',                          '1234');
    define('NOMBRE_BASE_DATOS',                 'herremex');
    define('TABLA_CALIDAD',                     'calidad');
    define('TABLA_CIUDAD',                      'ciudad');
    define('TABLA_CLIENTE',                     'clientes');
    define('TABLA_COMPRA',                      'compraVenta');
    define('TABLA_DISTRIBUIDOR',                'distribuidores');
    define('TABLA_EMPLEADO',                    'empleados');
    define('TABLA_HERRAMIENTA',                 'herramientas');
    define('TABLA_HERRAMIENTA_COMPRADA',        'herramientascompradas');
    define('TABLA_MARCA',                       'marca');
    define('TABLA_DISTRIBUIDOR_HERRAMIENTA',    'rel_distribuidor_herramienta');
    define('TABLA_EMPLEADO_SUCURSAL',           'rel_empleado_sucursal');
    define('TABLA_HERRAMIENTA_MARCA',           'rel_herramienta_marca');
    define('TABLA_HERRAMIENTA_SUCURSAL',        'rel_herramienta_sucursal');
    define('TABLA_SUCURSAL',                    'sucursal');
    define('TABLA_TIPOEMPLEADO',                'tipoempleado');
    define('TABLA_TIPOHERRAMIENTA',             'tipoherramienta');
    define('TABLA_TURNO',                       'turno');

    /**
    * Controlador de la base de datos para control de operaciones
    *
    * @author Jonathan Sandoval    <jonathan_s_pisis@hotmail.com>
    */
    class ControladorBaseDatos
    {
        static private $mysqli_obj = NULL;

        /**
        * Crea una nueva conexión con la base de datos, de existir, una conexión no hace nada
        *
        * @author jonathan_s_pisis@yahoo.com.mx
        **/
        static function ConectarBD()
        {            
            if (!isset(self::$mysqli_obj) || is_NULL(self::$mysqli_obj))
            {                
                $nombreDB = constant('NOMBRE_BASE_DATOS');
                $usuario  = constant('USUARIO');
                $host     = constant('HOST');
                $clave    = constant('PASSWORD');

                self::$mysqli_obj = new mysqli($host, $usuario, $clave, $nombreDB);

                /* check connection */
                if (self::$mysqli_obj->connect_errno) 
                {
                    printf("Connect failed: %s\n", self::$mysqli_obj->connect_error);
                    exit();
                }
            }
        }

        /**
         * Obteiene el ultimo error del objeto mysqli
         * 
         * @return String Descripción de ultimo errir si existe
         */
        static function getLastError()
        {
            return self::$mysqli_obj->error;
        }

        /**
        * Quita la conexión con la base de datos
        *
        * @author Jonathan Sandoval    <jonathan_s_pisis@hotmail.com>
        **/
        static function DesconectarDB()
        {
            self::$mysqli_obj = NULL;
        }

        /**
        * Valida que las cadenas para la consulta no contengan caracteres u ordenes que dañen al sistema
        *
        * @author Jonathan Sandoval    <jonathan_s_pisis@hotmail.com>
        * @param  string[string]       cadena a ser evaluada
        * @return Empleado[newString]  cadena sin instrucciones ni caracteres dañinos
        **/
        static function escapeString($string)
        {
            $posBad = -1;
            $newString = $string;

            //Quitamos la palabra DROP de la cadena
            do
            {
                $posBad = strpos($newString, "DROP ");

                if ($posBad !== false)
                {
                    $newString = substr($newString, 0, $posBad) . substr($newString, $posBad + 5);    
                }
            }
            while($posBad !== false);

            //Quitamos la palabra DROP de la cadena
            do
            {
                $posBad = strpos($newString, "USE ");

                if ($posBad !== false)
                {
                    $newString = substr($newString, 0, $posBad) . substr($newString, $posBad + 4);
                }

            }
            while($posBad !== false);

            //Quitamos la palabra DELETE SIN WHERE de la cadena
            do
            {
                $posBad = strpos($newString, "DELETE ");

                if ($posBad !== false)
                {
                    $tempString = substr($newString, $posBad);
                    $posWHERE   = strpos($tempString, "WHERE");

                    if ($posWHERE === false) //Delete sin where
                    {
                        //Quitamos el delete
                        $newString = substr($newString, 0, $posBad) . substr($newString, $posBad + 7);
                    }
                    else
                    {
                        break;
                    }
                }
            }
            while($posBad !== false);
                        
            return $newString;
        }

        /**
        * Ejecuta una instrucción con la conexión de la base de datos
        *
        * @author Jonathan Sandoval       <jonathan_s_pisis@hotmail.com>
        * @param  string $string          Consulta que se desea hacer
        * @return mysqli_ress[resultado]  Objeto resultante de la consulta, sirve para el fetch_assoc
        **/
        static function query($string = "")
        {
            $newString = self::escapeString($string);
            $resultado = self::$mysqli_obj->query($newString);
            return $resultado;
        }

        /**
        * Devuele la cantidad de columnas que afectó la última operación
        *
        * @author jonathan_s_pisis@yahoo.com.mx
        * @return int[afectadas]    Numero de columnas afectadas en la última operación
        **/
        static function getAffectedRows()
        {
            $afectadas = self::$mysqli_obj->affected_rows;
            return $afectadas;
        }

        /** 
        * Ordena un array en relación de la llave de su asociación
        *
        * @author Jonathan Sandoval    <jonathan_s_pisis@hotmail.com>
        * @param  &array        la referencia a un array
        * @param  string        El nombre de la llave a ordenar
        * @param  typeSort      La constante del tipo de ordenamiento
        */
        static function ordenarPorLlave(&$array, $subkey = "", $sortType) 
        {
            foreach ($array as $subarray) 
            {
                $keys[] = $subarray[$subkey];
            }

            array_multisort($keys, $sortType, $array);
        }

        /**
         * Esta función regresa lo que hay después de la extensión de la página en la URL
         *
         * @author Jonathan Sandoval    <jonathan_s_pisis@hotmail.com>
         * @return String               Ejemplo si la url es: 
         *                              "http//localhost/hola.php?type=1&" 
         *                              regresa "?type=1&"
         */
        static function getRestoURL()
        {
            $size = strlen(htmlentities($_SERVER['PHP_SELF']));
            $url = substr($_SERVER['REQUEST_URI'], $size);

            return $url;
        }

        /**
         * Guarda la sesión de un usario en el sistema
         * 
         * @param  Empĺeado $usuario  un usuario que entró al sistema
         */
        static function iniciarSesion($usuario = NULL)
        {
            $_SESSION["ID"]               = $usuario->getID();
            $_SESSION["CURP"]             = $usuario->getCURP();
            $_SESSION["Nombre"]           = $usuario->getNombre();
            $_SESSION["Segundo_Nombre"]   = $usuario->getSegundoNombre();
            $_SESSION["Apellido_Paterno"] = $usuario->getApellidoPaterno();
            $_SESSION["Apellido_Materno"] = $usuario->getApellidoMaterno();
            $_SESSION["Tipo_Empleado"]    = $usuario->getTipoEmpleado()->getAbreviatura();
        }

        /**
         * Cierra la sesión del usuario actual en el sistema
         * 
         */
        static function cerrarSesion()
        {            
            $_SESSION["ID"]               = NULL;
            $_SESSION["CURP"]             = NULL;
            $_SESSION["Nombre"]           = NULL;
            $_SESSION["Segundo_Nombre"]   = NULL;
            $_SESSION["Apellido_Paterno"] = NULL;
            $_SESSION["Apellido_Materno"] = NULL;
            $_SESSION["Tipo_Empleado"]    = NULL;

            echo "<script>href('index.php');</script>";
        }

        /**
         * Se encarga de direcionar al menú principal en caso de acceder a una página que
         * el usuario no debería de poder acceder
         * 
         * @param  String $pagina Nombre de la página a validad
         */
        static function validarSesionIniciada($pagina = "")
        {
            if ((isset($_SESSION["ID"]) && $_SESSION["ID"] == NULL) || !isset($_SESSION["ID"]))
            {
                echo "<script>href('index.php');</script>";
            }
            else
            {
                if ($pagina != 'Menu')
                {
                    if (self::obtenerTipoUsuario() == 'A')
                    {
                        if (!($pagina == 'MostrarHerramienta'))
                        {
                            echo "<script>href('menu.php');</script>";
                        }
                    }
                    else if (self::obtenerTipoUsuario() == 'V')
                    {
                        if (!($pagina == 'MostrarHerramienta' || $pagina == 'VerVenta'))
                        {
                            echo "<script>href('menu.php');</script>";
                        }
                    }
                    else if (self::obtenerTipoUsuario() == 'C')
                    {
                        if (!($pagina == 'NuevaHerramienta' || $pagina == 'MostrarHerramienta' ||
                              $pagina == 'VerVenta'         || $pagina == 'nuevaVenta'))
                        {
                            echo "<script>href('menu.php');</script>";
                        }
                    }
                    else if (self::obtenerTipoUsuario() == 'G')
                    {
                        if ($pagina == 'NuevoDistribuidor' || $pagina == 'NuevaSucursal')
                        {
                            echo "<script>href('menu.php');</script>";
                        }
                    }
                }
            }
        }

        static function obtenerNombreUsuario()
        {
            if (!((isset($_SESSION["ID"]) && $_SESSION["ID"] == NULL) || !isset($_SESSION["ID"])))
            {
                $cad = $_SESSION["Nombre"] . " " . $_SESSION["Segundo_Nombre"] . " " .
                       $_SESSION["Apellido_Paterno"] . " " . $_SESSION["Apellido_Materno"];

                return $cad;
            }
        }

        static function obtenerTipoUsuario()
        {
            if (!((isset($_SESSION["ID"]) && $_SESSION["ID"] == NULL) || !isset($_SESSION["ID"])))
            {
                return ($_SESSION["Tipo_Empleado"]);
            }
        }
    }

    ControladorBaseDatos::ConectarBD(); 

 ?>