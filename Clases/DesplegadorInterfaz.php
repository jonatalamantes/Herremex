<?php 

    require_once(__DIR__."/ControladorBaseDatos.php");

    /**
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class DesplegadorInterfaz
    {
        /**
         * Recupera el header para las plantillas en los documentos segun el usuario
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   código HTML para insertar en las plantillas
         */
        static function getHeader()
        {
            $tipo = ControladorBaseDatos::obtenerTipoUsuario();

            $res = '<header>
                <h1 class="comp">
                    <img src="Recursos/Imagenes/logo.png" class="logo"><!--Logo-->
                        Herremex
                    <button class="logout" onclick="cerrarSession();"><span class="fa fa-sign-out fa-2x">Salir</span></button>
                    <div class="hr2"><hr /></div><!--Linea Roja-->';

            if ($tipo == 'A')
            {
                $res = $res . '<ul class="menu">
                        <li><a href="menu.php"><p class="menuTitulos"><span class="fa fa-home fa-spin" ></span> Menú</p></a>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-cog" ></span> Herramientas</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaHerramientas.php">Consultas</a></li>
                            </ul>
                        </li>
                    </ul>';
            }
            else if ($tipo == 'C')
            {
                $res = $res . '<ul class="menu">
                        <li><a href="menu.php"><p class="menuTitulos"><span class="fa fa-home fa-spin" ></span> Menú</p></a>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-cog" ></span> Herramientas</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaHerramientas.php">Consultas</a></li>
                                <li><a href="AgregacionesHerramientas.php">Agregaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-shopping-cart"></span> Ventas</p></a>
                            <ul class="sub-menu">
                                <li><a href="RealizarVenta.php">Realizar Venta</a></li>
                                <li><a href="VerVenta.php">Ver registro de ventas</a></li>
                            </ul>
                        </li>
                    </ul>';
            }
            else if ($tipo == 'G')
            {
                $res = $res . '<ul class="menu">
                        <li><a href="menu.php"><p class="menuTitulos"><span class="fa fa-home fa-spin" ></span> Menú</p></a>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-cog" ></span> Herramientas</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaHerramientas.php">Consultas</a></li>
                                <li><a href="AgregacionesHerramientas.php">Agregaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-group"></span> Clientes</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaClientes.php">Consultas</a></li>
                                <li><a href="AgregacionesClientes.php">Agregaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-book"></span> Empleados</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaEmpleados.php">Consultas</a></li>
                                <li><a href="AgregacionesEmpleados.php">Agregaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-truck "></span> Distribuidores</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaDistribuidores.php">Consultas</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-briefcase"></span> Sucursales</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaSucursales.php">Consultas</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-shopping-cart"></span> Ventas</p></a>
                            <ul class="sub-menu">
                                <li><a href="RealizarVenta.php">Realizar Venta</a></li>
                                <li><a href="VerVenta.php">Ver registro de ventas</a></li>
                            </ul>
                        </li>
                    </ul>';
            }
            else if ($tipo == 'J')
            {
                $res = $res . '<ul class="menu">
                        <li><a href="menu.php"><p class="menuTitulos"><span class="fa fa-home fa-spin" ></span> Menú</p></a>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-cog" ></span> Herramientas</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaHerramientas.php">Consultas</a></li>
                                <li><a href="AgregacionesHerramientas.php">Agregaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-group"></span> Clientes</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaClientes.php">Consultas</a></li>
                                <li><a href="AgregacionesClientes.php">Agregaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-book"></span> Empleados</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaEmpleados.php">Consultas</a></li>
                                <li><a href="AgregacionesEmpleados.php">Agregaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-truck "></span> Distribuidores</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaDistribuidores.php">Consultas</a></li>
                                <li><a href="AgregacionesDistribuidores.php">Agregaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-briefcase"></span> Sucursales</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaSucursales.php">Consultas</a></li>
                                <li><a href="AgregacionesSucursales.php">Agregaciones</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-shopping-cart"></span> Ventas</p></a>
                            <ul class="sub-menu">
                                <li><a href="RealizarVenta.php">Realizar Venta</a></li>
                                <li><a href="VerVenta.php">Ver registro de ventas</a></li>
                            </ul>
                        </li>
                    </ul>';
            }
            else if ($tipo == 'V')
            {
                $res = $res . '<ul class="menu">
                        <li><a href="menu.php"><p class="menuTitulos"><span class="fa fa-home fa-spin" ></span> Menú</p></a>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-cog" ></span> Herramientas</p></a>
                            <ul class="sub-menu">
                                <li><a href="BusquedaHerramientas.php">Consultas</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><p class="menuTitulos"><span class="fa fa-shopping-cart"></span> Ventas</p></a>
                            <ul class="sub-menu">
                                <li><a href="VerVenta.php">Ver registro de ventas</a></li>
                            </ul>
                        </li>
                    </ul>';
            }

            $res = $res . '</h1>
                            <section id="infoUsuario">
                                <i class="fecha"><span id="fecha"> </span></i><!--Fecha Actual-->
                            </section>
                            </header>';

            return $res;
        }

        /**
         * Recupera el footer para las plantillas en los documentos
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   código HTML para insertar en las plantillas
         */
        static function getFooter()
        {
            $string = "<footer>Herremex, Todos los derechos reservados © 2015</footer>";

            return $string;
        }
    }

 ?>