function IsNumeric(n) 
{
    if (n[0] =='+')
    {
        n = n.substring(1);
    }

    var numeros = ['0','1','2','3','4','5','6','7','8','9','0'];

    for (i = 0; i < String(n).length; i++)
    {
        if (!(n[i] in numeros))
        {
            return false;
        }
    }    

    if (parseFloat(n) < 0)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function validarInput(id)
{
    obj = document.getElementById(id);
    
    if (!IsNumeric(obj.value) || obj.value < 0)
    {
        obj.value = '0';
    }

    if (obj.value == '')
    {
        obj.value = '0';
    }
}

function validateCURP(cad)
{
    cad1 = cad.toUpperCase;

    var letras = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", 
                  "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "Ñ", '0', '1', '2', 
                  '3', '4', '5', '6', '7', '8', '9', '0']

    for (i = 0; i < String(cad).length; i++)
    {
        if (!(cad[i] in letras))
        {
            return false;
        }
    }    

    return true;
}

function pressKey(id, tam)
{
    obj =  document.getElementById(id);

    cad = obj.value.toUpperCase();

    var letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZÑ01234567890';

    if (letras.indexOf(cad[cad.length - 1]) == -1)
    {
        cad = cad.substring(0, cad.length - 1);
    }
    
    obj.value = cad;

    if (tam == '12')
    {
        if (obj.value.length == 13 || obj.value.length == 12)
        {
            obj.style.color = "green";
        }
        else
        {
            obj.style.color = "black";
        }
    }
    else if (tam == '18')
    {
        if (id != 'txtUsuario')
        {
            if (obj.value.length == 18)
            {
                obj.style.color = "green";
            }
            else
            {
                obj.style.color = "black";
            }
        }
    }
}

function keyPress(evento)
{
    if (evento.keyCode == 13) //enter
    {
        validadUsuario();
    }
}

function cerrarSession()
{
    var datosEnv  = 'Ajax/cerrarSesion.php';

    var ajax = new XMLHttpRequest();

    //Revision del objeto funcionando
    ajax.onreadystatechange = function() 
    {
        if (ajax.readyState == 4 && ajax.status == 200) 
        {            
            pagina = window.location.toString();
            index  = pagina.indexOf("Vistas");
            pagina = pagina.substring(0, index) + 'Vistas/index.php';

            window.location.href = pagina;
        }
    }

    //Envio de datos al servidor
    ajax.open("GET",datosEnv,true);
    ajax.send();
}

function validadUsuario()
{
    txtUsuario  = document.getElementById('txtUsuario');
    txtPassword = document.getElementById('txtPassword');
    txtLoginU   = document.getElementById('txtloginu');
    txtLoginP   = document.getElementById('txtloginp');
    res = true;

    txtLoginU.style.color = "rgb(191,85,13)";
    txtLoginP.style.color = "rgb(191,85,13)";

    if (txtUsuario.value == "")
    {
        txtLoginU.style.color = "red";
        res = false;
    }

    if (txtPassword.value == "")
    {
        txtLoginP.style.color = "red";
        res = false;
    }

    if (res) //inserto todos los documentatos
    {
        var datosEnv  = 'Ajax/validarUsuario.php?'+
                'user='         + txtUsuario.value +
                '&password='    + txtPassword.value;

        var ajax = new XMLHttpRequest();

        //Revision del objeto funcionando
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200) 
            {                
                if (ajax.responseText.indexOf("KO") !== -1)
                {
                    txtUsuario.value             = "";
                    txtUsuario.placeholder       = "Acceso";
                    txtUsuario.style.background  = "rgb(183, 14, 14)"; //Rojo Carmesi

                    txtPassword.value            = "";
                    txtPassword.placeholder      = "Denegado";
                    txtPassword.style.background = "rgb(183, 14, 14)"; //Rojo Carmesi
                }
                else
                {
                    pagina = window.location.toString();
                    index  = pagina.indexOf("Vistas");
                    pagina = pagina.substring(0, index) + 'Vistas/menu.php';

                    window.location.href = pagina;
                }
            }
        }

        //Envio de datos al servidor
        ajax.open("GET",datosEnv,true);
        ajax.send();
    }
}

function normalBackground()
{
    txtUsuario  = document.getElementById('txtUsuario');
    txtPassword = document.getElementById('txtPassword');

    txtUsuario.style.background  = "rgb(138, 138, 138)";
    txtPassword.style.background = "rgb(138, 138, 138)";

    txtUsuario.placeholder       = "Usuario";
    txtPassword.placeholder      = "••••••••";
}

function inicializarSucursal() 
{
    calle    = document.getElementById('aCalle');
    edificio = document.getElementById('aNoEdificio');
    colonia  = document.getElementById('aColonia');

    calle.style.color    = "black";
    edificio.style.color = "black";
    colonia.style.color  = "black";
}

function guardarSucursal()
{
    calle    = document.getElementById('aCalle');
    edificio = document.getElementById('aNoEdificio');
    colonia  = document.getElementById('aColonia');
    accion   = document.getElementById('tipoAccion');
    ciudad   = document.getElementById('aCiudad'); //es un select

    res = true;

    calle.style.color    = "black";
    edificio.style.color = "black";
    colonia.style.color  = "black";

    if (calle.value == "")
    {
        calle.style.color = "red";
        res = false;
    }

    if (edificio.value == ""  || !IsNumeric(edificio.value))
    {
        edificio.style.color = "red";
        res = false;
    }

    if (colonia.value == "")
    {
        colonia.style.color = "red";
        res = false;
    }

    if (res) //inserto todos los documentatos
    {
        var datosEnv  = 'Ajax/guardarSucursal.php?'+
                        'calle='        + calle.value                 +
                        '&edificio='    + parseInt(edificio.value)    +
                        '&colonia='     + colonia.value               +
                        '&tipoAccion='  + accion.innerHTML            +                        
                        '&ciudad='      + ciudad.options.selectedIndex;

        if (accion.innerHTML == "Modificar")
        {
            id = String(window.location);
            id = id.substring(id.indexOf('?id=') + 4);

            datosEnv = datosEnv + "&id_modificacion=" + id;
        }


        var ajax = new XMLHttpRequest();

        //Revision del objeto funcionando
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200) 
            {
                if (ajax.responseText.indexOf("KO") === -1)
                {
                    alert('Guardado Exitoso');

                    url = String(window.location);

                    pos = url.indexOf("AgregacionesSucursales.php");
                    url = url.substring(0, pos);
                    url = url + "BusquedaSucursales.php";

                    window.location.href = url;
                }
                else
                {
                    alert('No se han podido guardar los datos');
                }
            }
        }

        //Envio de datos al servidor
        ajax.open("GET",datosEnv,true);
        ajax.send();
    }
}

function inicializarClientes() 
{
    rfc       = document.getElementById('aRFC');
    nombre    = document.getElementById('aNombre');
    calle     = document.getElementById('aCalle');
    edificio  = document.getElementById('aNoEdificio');
    regimen   = document.getElementById('aRegimen'); //es un select
    sexo      = document.getElementById('aSexo'); //es un select

    rfc.style.color      = "black";
    nombre.style.color   = "black";
    calle.style.color    = "black";
    edificio.style.color = "black";

    if (regimen.options.selectedIndex == 1) //es moral
    {
        document.getElementById('campo2').hidden = true;
        sexo.options.select = 0;
        sexo.hidden = true;
    }
    else
    {
        document.getElementById('campo2').hidden = false;
        sexo.hidden = false;
    }

    pressKey('aRFC', '12');
}

function guardarClientes()
{
    rfc       = document.getElementById('aRFC');
    nombre    = document.getElementById('aNombre');
    calle     = document.getElementById('aCalle');
    edificio  = document.getElementById('aNoEdificio');
    accion    = document.getElementById('tipoAccion');
    ciudad    = document.getElementById('aCiudad'); //es un select
    regimen   = document.getElementById('aRegimen'); //es un select
    sexo      = document.getElementById('aSexo'); //es un select

    res = true;

    rfc.style.color      = "black";
    nombre.style.color   = "black";
    calle.style.color    = "black";
    edificio.style.color = "black";

    if (rfc.value == '' || !(rfc.value.length == 12 || rfc.value.length == 13))
    {
        rfc.style.color = "red";
        res = false;
    }

    if (calle.value == "")
    {
        calle.style.color = "red";
        res = false;
    }

    if (edificio.value == ""  || !IsNumeric(edificio.value))
    {
        edificio.style.color = "red";
        res = false;
    }

    if (nombre.value == "")
    {
        nombre.style.color = "red";
        res = false;
    }

    if (res) //inserto todos los documentatos
    {
        var datosEnv  = 'Ajax/guardarCliente.php?'+    
                        'rfc='          + rfc.value                     +
                        '&nombre='      + nombre.value                  +
                        '&calle='       + calle.value                   +
                        '&edificio='    + parseInt(edificio.value)      +
                        '&tipoAccion='  + accion.innerHTML              +                        
                        '&sexo='        + sexo.options.selectedIndex    +
                        '&regimen='     + regimen.options.selectedIndex +
                        '&ciudad='      + ciudad.options.selectedIndex;

        if (accion.innerHTML == "Modificar")
        {
            id = String(window.location);
            id = id.substring(id.indexOf('?id=') + 4);

            datosEnv = datosEnv + "&id_modificacion=" + id;
        }

        var ajax = new XMLHttpRequest();

        //Revision del objeto funcionando
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200) 
            {
                if (ajax.responseText.indexOf("KO") === -1)
                {
                    alert("Guardado Exitoso");

                    url = String(window.location);

                    pos = url.indexOf("AgregacionesClientes.php");
                    url = url.substring(0, pos);
                    url = url + "BusquedaClientes.php";

                    window.location.href = url;
                }
                else
                {
                    alert('No se han podido guardar los datos');
                }
            }
        }

        //Envio de datos al servidor
        ajax.open("GET",datosEnv,true);
        ajax.send();
    }
}


function inicializarDistribuidores() 
{
    nombre      = document.getElementById('aNombre');
    direccion   = document.getElementById('aDireccion');
    precio      = document.getElementById('aPrecioCompra');
    herramienta = document.getElementById('aHerramientas'); //es un select

    direccion.style.color = "black";
    precio.style.color    = "black";
    nombre.style.color    = "black";

    if (herramienta.options.selectedIndex == 0) //sin herramienta
    {
        document.getElementById('campo1').hidden = true;
        document.getElementById('campo2').hidden = true;
    }
    else
    {
        document.getElementById('campo1').hidden = false;
        document.getElementById('campo2').hidden = false;
    }
}

function guardarDistribuidores()
{
    nombre       = document.getElementById('aNombre');
    direccion    = document.getElementById('aDireccion');
    accion       = document.getElementById('tipoAccion');
    calidad      = document.getElementById('aCalidad');
    precio       = document.getElementById('aPrecioCompra');
    herramientas = document.getElementById('aHerramientas'); //es un select

    res = true;

    direccion.style.color = "black";
    nombre.style.color    = "black";
    precio.style.color    = "black";

    if (direccion.value == "")
    {
        direccion.style.color = "red";
        res = false;
    }

    if (nombre.value == "")
    {
        nombre.style.color = "red";
        res = false;
    }

    if (herramientas.options.selectedIndex != 0)
    {
        if (precio.value == '' || !IsNumeric(precio.value))
        {
            precio.style.color = "red";
            res = false;
        }
    }

    if (res) //inserto todos los documentatos
    {
        var datosEnv  = 'Ajax/guardarDistribuidor.php?'+    
                        'nombre='       + nombre.value                  +
                        '&direccion='   + direccion.value               +
                        '&tipoAccion='  + accion.innerHTML              +                        
                        '&herramienta=' + herramientas.options.selectedIndex;

        if (herramientas.options.selectedIndex != 0)
        {
            datosEnv = datosEnv +
                       '&precio='  + precio.value  +                        
                       '&calidad=' + calidad.options.selectedIndex;
        }

        if (accion.innerHTML == "Modificar")
        {
            id = String(window.location);
            id = id.substring(id.indexOf('?id=') + 4);

            datosEnv = datosEnv + "&id_modificacion=" + id;
        }

        var ajax = new XMLHttpRequest();

        //Revision del objeto funcionando
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200) 
            {
                if (ajax.responseText.indexOf("KO") === -1)
                {
                    alert("Guardado Exitoso");

                    url = String(window.location);

                    pos = url.indexOf("AgregacionesDistribuidores.php");
                    url = url.substring(0, pos);
                    url = url + "BusquedaDistribuidores.php";

                    window.location.href = url;
                }
                else
                {
                    alert('No se han podido guardar los datos');
                }
            }
        }

        //Envio de datos al servidor
        ajax.open("GET",datosEnv,true);
        ajax.send();
    }
}

function inicializarEmpleado() 
{
    curp       = document.getElementById('aCURP');
    nombre1    = document.getElementById('aNombre');
    nombre2    = document.getElementById('aNombreS');
    apellidop  = document.getElementById('aApellidoP');
    apellidom  = document.getElementById('aApellidoM');
    calle      = document.getElementById('aCalle');
    exterior   = document.getElementById('aNoVivienda');
    interior   = document.getElementById('aNoInterior');
    ciudad     = document.getElementById('aCiudad');
    tipo       = document.getElementById('aTipo');
    turno      = document.getElementById('aTurno');
    sucursal   = document.getElementById('aSucursales');
    pass       = document.getElementById('aPass');
    accion     = document.getElementById('tipoAccion');
    colonia    = document.getElementById('aColonia');

    curp.style.color      = "black";
    nombre1.style.color   = "black";
    nombre2.style.color   = "black";
    apellidop.style.color = "black";
    apellidom.style.color = "black";
    calle.style.color     = "black";
    exterior.style.color  = "black";
    interior.style.color  = "black";
    pass.style.color      = "black";
    colonia.style.color   = "black";

    url = String(window.location);

    if (url.indexOf('?look_id=') !== -1)
    {
        document.getElementById('tipoAccion').innerHTML = "Ver";
        document.getElementById('aCURP').disabled = true;
        document.getElementById('aNombre').disabled = true;
        document.getElementById('aNombreS').disabled = true;
        document.getElementById('aApellidoP').disabled = true;
        document.getElementById('aApellidoM').disabled = true;
        document.getElementById('aCalle').disabled = true;
        document.getElementById('aNoVivienda').disabled = true;
        document.getElementById('aNoInterior').disabled = true;
        document.getElementById('aCiudad').disabled = true;
        document.getElementById('aTipo').disabled = true;
        document.getElementById('aTurno').disabled = true;
        document.getElementById('aSucursales').disabled = true;
        document.getElementById('aPass').disabled = true;
        document.getElementById('campo2').hidden = true;
        document.getElementById('tipoAccion').disabled = true;
        document.getElementById('aColonia').disabled = true;
        document.getElementById('bGuardar').hidden = true;
        document.getElementById('bAnterior').hidden = false;
    }
    else if (url.indexOf('?change_id=') !== -1)
    {
        document.getElementById('tipoAccion').innerHTML = "Modificar";
        document.getElementById('aCURP').disabled = false;
        document.getElementById('aNombre').disabled = false;
        document.getElementById('aNombreS').disabled = false;
        document.getElementById('aApellidoP').disabled = false;
        document.getElementById('aApellidoM').disabled = false;
        document.getElementById('aCalle').disabled = false;
        document.getElementById('aNoVivienda').disabled = false;
        document.getElementById('aNoInterior').disabled = false;
        document.getElementById('aCiudad').disabled = false;
        document.getElementById('aTipo').disabled = false;
        document.getElementById('aTurno').disabled = false;
        document.getElementById('aSucursales').disabled = false;
        document.getElementById('aPass').disabled = false;
        document.getElementById('campo2').hidden = true;
        document.getElementById('tipoAccion').disabled = false;
        document.getElementById('aColonia').disabled = false;
        document.getElementById('bGuardar').hidden = false;
        document.getElementById('bAnterior').hidden = true;
    }
    else
    {
        document.getElementById('tipoAccion').innerHTML = "Agregar";
        document.getElementById('bGuardar').hidden = false;
        document.getElementById('bAnterior').hidden = true;
    }

    pressKey('aCURP', '18');
}

function guardarEmpleados()
{
    console.log("hola");

    curp       = document.getElementById('aCURP');
    nombre1    = document.getElementById('aNombre');
    nombre2    = document.getElementById('aNombreS');
    apellidop  = document.getElementById('aApellidoP');
    apellidom  = document.getElementById('aApellidoM');
    calle      = document.getElementById('aCalle');
    exterior   = document.getElementById('aNoVivienda');
    interior   = document.getElementById('aNoInterior');
    ciudad     = document.getElementById('aCiudad');
    tipo       = document.getElementById('aTipo');
    turno      = document.getElementById('aTurno');
    sucursal   = document.getElementById('aSucursales');
    pass       = document.getElementById('aPass');
    accion     = document.getElementById('tipoAccion');
    colonia    = document.getElementById('aColonia');

    res = true;

    curp.style.color      = "black";
    nombre1.style.color   = "black";
    nombre2.style.color   = "black";
    apellidop.style.color = "black";
    apellidom.style.color = "black";
    calle.style.color     = "black";
    exterior.style.color  = "black";
    interior.style.color  = "black";
    pass.style.color      = "black";
    colonia.style.color   = "black";

    if (curp.value == "" || curp.value.length != 18)
    {
        curp.style.color = "red";
        res = false;
    }

    if (pass.value.length < 8 && tipoAccion.value == 'Agregar')
    {
        pass.style.color = "red";
        res = false;
    }

    if (nombre1.value == "")
    {
        nombre1.style.color = "red";
        res = false;
    }

    if (apellidop.value == "")
    {
        apellidop.style.color = "red";
        res = false;
    }

    if (apellidom.value == "")
    {
        apellidom.style.color = "red";
        res = false;
    }

    if (calle.value == "")
    {
        calle.style.color = "red";
        res = false;
    }

    if (interior.value != '')
    {
        if (!IsNumeric(interior.value))
        {
            interior.style.color = "red";
            res = false;
        }
    }

    if (!IsNumeric(exterior.value))
    {
        exterior.style.color = "red";
        res = false;
    }

    if (colonia.value == "")
    {
        colonia.style.color = "red";
        res = false;
    }

    if (res) //inserto todos los documentatos
    {
        var datosEnv  = 'Ajax/guardarEmpleado.php?'+    
                        'curp='        + curp.value                   +
                        '&nombre1='    + nombre1.value                +
                        '&nombre2='    + nombre2.value                +                        
                        '&apellidop='  + apellidop.value              +                        
                        '&apellidom='  + apellidom.value              +                        
                        '&calle='      + calle.value                  +                        
                        '&exterior='   + exterior.value               +                        
                        '&interior='   + interior.value               +                        
                        '&colonia='    + colonia.value                +                        
                        '&pass='       + pass.value                   +                        
                        '&accion='     + accion.innerHTML             +                        
                        '&ciudad='     + ciudad.options.selectedIndex +
                        '&tipo='       + tipo.options.selectedIndex   +
                        '&turno='      + turno.options.selectedIndex  +
                        '&sucursal='   + sucursal.options.selectedIndex;

        if (accion.innerHTML == "Modificar")
        {
            id = String(window.location);
            id = id.substring(id.indexOf('?change_id=') + 11);

            datosEnv = datosEnv + "&id_modificacion=" + id;
        }
        else if (accion.innerHTML == "Modificar")
        {
            id = String(window.location);
            id = id.substring(id.indexOf('?look_id=') + 9);

            datosEnv = datosEnv + "&id_modificacion=" + id;
        }

        var ajax = new XMLHttpRequest();

        //Revision del objeto funcionando
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200) 
            {
                if (ajax.responseText.indexOf("KO") === -1)
                {
                    alert('Guardado Exitoso');

                    url = String(window.location);

                    pos = url.indexOf("AgregacionesEmpleados.php");
                    url = url.substring(0, pos);
                    url = url + "BusquedaEmpleados.php";

                    window.location.href = url;
                }
                else
                {
                    alert('No se han podido guardar los datos');
                }
            }
        }

        //Envio de datos al servidor
        ajax.open("GET",datosEnv,true);
        ajax.send();
    }
}

function inicializarHerramienta() 
{
    nombre    = document.getElementById('aNombre');
    precio    = document.getElementById('aPrecio');
    cantidad  = document.getElementById('aCantidad');

    nombre.style.color    = "black";
    precio.style.color    = "black";
    cantidad.style.color  = "black";
}

function guardarHerramienta()
{
    nombre    = document.getElementById('aNombre');
    precio    = document.getElementById('aPrecio');
    cantidad  = document.getElementById('aCantidad');
    accion    = document.getElementById('tipoAccion');
    tipo      = document.getElementById('aTipo'); //es un select
    marca     = document.getElementById('aMarca'); //es un select

    res = true;

    nombre.style.color    = "black";
    precio.style.color    = "black";
    cantidad.style.color  = "black";

    if (nombre.value == "")
    {
        nombre.style.color = "red";
        res = false;
    }

    if (precio.value == ""  || !IsNumeric(precio.value))
    {
        precio.style.color = "red";
        res = false;
    }

    if (cantidad.value == ""  || !IsNumeric(cantidad.value))
    {
        cantidad.style.color = "red";
        res = false;
    }

    if (res) //inserto todos los documentatos
    {
        var datosEnv  = 'Ajax/guardarHerramienta.php?'+
                        'nombre='      + nombre.value               +
                        '&precio='     + precio.value               +
                        '&cantidad='   + cantidad.value             +
                        '&accion='     + accion.innerHTML           +                        
                        '&tipo='       + tipo.options.selectedIndex + 
                        '&marca='      + marca.options.selectedIndex;

        if (accion.innerHTML == "Modificar")
        {
            id = String(window.location);
            id = id.substring(id.indexOf('?id=') + 4);

            datosEnv = datosEnv + "&id_modificacion=" + id;
        }


        var ajax = new XMLHttpRequest();

        //Revision del objeto funcionando
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200) 
            {
                if (ajax.responseText.indexOf("KO") === -1)
                {
                    alert('Guardado Exitoso');

                    url = String(window.location);

                    pos = url.indexOf("AgregacionesHerramientas.php");
                    url = url.substring(0, pos);
                    url = url + "BusquedaHerramientas.php";

                    window.location.href = url;
                }
                else
                {
                    alert('No se han podido guardar los datos');
                }
            }
        }

        //Envio de datos al servidor
        ajax.open("GET",datosEnv,true);
        ajax.send();
    }
}

/*Ventana de compra realizada*/
function ventanaDeAgradecimiento(id, facturar)
{
    nuevaVentana = window.open('', 'Herremex', "width=400, height=600");
    nuevaVentana.close();
    nuevaVentana = window.open('', 'Herremex', "width=400, height=600");
    nuevaVentana.moveTo(screen.width/2-200,screen.height/2-300); 

    nuevaVentana.document.writeln('<!DOCTYPE html><html><head>');
    nuevaVentana.document.writeln('<link rel="stylesheet" type="text/css" href="Recursos/css/styleCompraRealizada.css">');
    nuevaVentana.document.writeln('<link rel="stylesheet" href="Recursos/css/font-awesome.css">');
    nuevaVentana.document.writeln('<title>Gracias</title>');
                            
    nuevaVentana.document.writeln('</head><body>');
    nuevaVentana.document.writeln('<style>body{text-align:center;}</style>');
    nuevaVentana.document.writeln('<script type="text/javascript" src="Ajax/ajax.js"></script>');
    nuevaVentana.document.writeln("<h1>Compra realizada con éxito </h1>");
    nuevaVentana.document.writeln("<p>Cerrar Ventana</p>");
    nuevaVentana.document.writeln("<button onclick='cerrarVentana()'><span class='fa fa-arrow-left fa-5x'></span></button>");

    if (facturar == 'S')
    {
        nuevaVentana.document.writeln("<p>Ver Factura</p>");
        nuevaVentana.document.writeln("<button onclick='facturarNuevaVentana(" + id + ", \"S\")'><span class='fa fa-file-text fa-5x'></span></button>");
    }

    nuevaVentana.document.writeln('</body></html>');
}

function cerrarVentana()
{
    window.close();
}

function facturarNuevaVentana(id, parent)
{
    if (parent == 'S')
    {
        padre = window.parent;

        url = String(window.location);
        pos = url.indexOf("Vistas");
        url = url.substring(0, pos);
        url = url + "Clases/Factura/facturaPDF.php?id=" + id;

        nuevaVentana = padre.open(url, '_blank');
        cerrarVentana();
    }
    else
    {
        url = String(window.location);
        pos = url.indexOf("Vistas");
        url = url.substring(0, pos);
        url = url + "Clases/Factura/facturaPDF.php?id=" + id;

        nuevaVentana = window.open(url, '_blank');
        cerrarVentana();
    }
}

function guardarCompraVenta()
{
    sucursal       = document.getElementById('aSucursales');
    cliente        = document.getElementById('aClientes');
    facturar       = document.getElementById('oFacturar');
    envioDomicilio = document.getElementById('oEnvioDomicilio');
    
    trs = document.getElementsByClassName('selects');
    selects = [];

    for (var i = 0; i < trs.length; i++) 
    {
        selects[i] = trs[i].getElementsByClassName('herramientas')[0];
    }

    ids = "";
    cantidades = "";

    j = 0;
    for (i = 0; i < trs.length; i++)
    {
        if (selects[i].options.selectedIndex != -1)
        {
            ids = ids + trs[i].getElementsByClassName('herramientas')[0].options.selectedIndex + "|" ;
            cantidades = cantidades + trs[i].getElementsByClassName('numbericInput')[0].value + "|";
        }
    }

    ids = ids + "*";
    cantidades = cantidades + "*";

    docimilio = "N";
    if (envioDomicilio.checked)
    {
        docimilio = 'S';
    }

    factura = "N";
    if (facturar.checked)
    {
        factura ='S';
    }

    var datosEnv  = 'Ajax/guardarCompraVenta.php?'+
                    'sucursal='      + sucursal.options.selectedIndex +
                    '&cliente='      + cliente.options.selectedIndex  +
                    '&cantidad='     + cantidades                     +
                    '&herramientas=' + ids                            +                        
                    '&domicilio='    + docimilio                      + 
                    '&factura='      + factura;

    var ajax = new XMLHttpRequest();

    //Revision del objeto funcionando
    ajax.onreadystatechange = function() 
    {
        if (ajax.readyState == 4 && ajax.status == 200) 
        {
            if (ajax.responseText.indexOf("KO") !== -1) //Es KO
            {
                alert('No se han podido guardar los datos');
            }
            else if (ajax.responseText.indexOf("NO") !== -1) //Es NO
            {
                alert('No ha selecionado una herramienta');
            }
            else //Es OK
            {
                ventanaDeAgradecimiento(ajax.responseText, factura);

                url = String(window.location);

                pos = url.indexOf("RealizarVenta.php");
                url = url.substring(0, pos);
                url = url + "VerVenta.php";

                window.location.href = url;
            }
        }
    }

    //Envio de datos al servidor
    ajax.open("GET",datosEnv,true);
    ajax.send();
}

/*Valida que haya un numero adecuado de herramientas*/
function validarMaxHerramientas(idInput)
{
    select = document.getElementsByName("aHerramientas" + idInput.substring(13))[0];

    var datosEnv  = 'Ajax/getMaximaCantidadHerramienta.php?'+
                    'nombreHerramienta=' + select.value;

    var ajax = new XMLHttpRequest();

    //Revision del objeto funcionando
    ajax.onreadystatechange = function() 
    {
        if (ajax.readyState == 4 && ajax.status == 200) 
        {
            if (parseInt(document.getElementById(idInput).value) > parseInt(ajax.responseText))
            {
                document.getElementById(idInput).value = parseInt(ajax.responseText);
            }
        }
    }

    //Envio de datos al servidor
    ajax.open("GET",datosEnv,true);
    ajax.send();
}
