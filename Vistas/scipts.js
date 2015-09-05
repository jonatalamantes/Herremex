/**
 * Desplega u oculta un parrafo en relación de su ID
 * 
 * @param  {String} parrafo Nombre del ID del parrafo
 */
function desplegar(parrafo)
{
    if(document.getElementById(parrafo).style.display == '') 
    {
        document.getElementById(parrafo).style.display = 'none';
    }
    else 
    {
        document.getElementById(parrafo).style.display = '';
    }
}

function totalVisibles()
{
    selects = document.getElementsByClassName('selects');

    j = 0;
    for (i = 0; i < selects.length; i++)
    {
        if (selects[i].hidden)
        {
            j++;
        }
    }

    return selects.length - j;
}

function ultimoVisible()
{
    selects = document.getElementsByClassName('selects');

    j = 0;
    for (i = 0; i < selects.length; i++)
    {
        if (selects[i].hidden == false)
        {
            return selects[i];
        }
    }

    return null;
}
    
function mostrarTR(id)
{
    selects = document.getElementsByClassName('selects');
    elemento = document.getElementById(id);

    encontrado = false;
    for (i = 0; i < selects.length; i++)
    {
        if (!encontrado)
        {
            if (selects[i].hidden)
            {
                selects[i].hidden = false;
                selects[i].getElementsByClassName('herramientas')[0].options.selectedIndex = -1;
                selects[i].getElementsByClassName('numbericInput')[0].value = 1;
                encontrado = true;
            }
        }
        else
        {
            prevIndex = selects[i].getElementsByClassName('herramientas')[0].options.selectedIndex;
            selects[i].getElementsByClassName('herramientas')[0].options.selectedIndex = selects[i-1].getElementsByClassName('herramientas')[0].options.selectedIndex;
            selects[i-1].getElementsByClassName('herramientas')[0].options.selectedIndex = prevIndex;
        }
    }

    if (totalVisibles() != selects.length)
    {
        for (var i = selects.length - 1; i >= 0; i--) 
        {
            selects[i].getElementsByClassName('menos')[0].hidden = false;
        }
    }
    else
    {
        for (var i = selects.length - 1; i >= 0; i--) 
        {
            selects[i].getElementsByClassName('mas')[0].hidden = true;
        }
    }

    calcularTotal();
}

function ocultarTR(id)
{
    selects = document.getElementsByClassName('selects');

    visibles = totalVisibles();

    if (visibles != 1)
    {
        elemento = document.getElementById(id);
        index = elemento.getElementsByClassName('herramientas')[0].options.selectedIndex;

        if (index != -1)
        {
            for (i = 0; i < selects.length; i++)
            {
                selects[i].getElementsByClassName('herramientas')[0].options[index].hidden = false;            
            }
        }

        elemento.hidden = true;
        elemento.getElementsByClassName('herramientas')[0].options.selectedIndex = -1;
        elemento.getElementsByClassName('numbericInput')[0].value = 1;

        if (visibles == 2)
        {
            ultimoVisible().getElementsByClassName('menos')[0].hidden = true;
        }
    }

    for (var i = selects.length - 1; i >= 0; i--) 
    {
        selects[i].getElementsByClassName('mas')[0].hidden = false;
    }

    calcularTotal();
}

function inicializeSelect()
{
    trs = document.getElementsByClassName('selects');

    trs[0].getElementsByClassName('menos')[0].hidden = true;

    for (var i = 0; i < trs.length; i++) 
    {
        if (i >= 1)
        {
            trs[i].hidden = true;
        }

        trs[i].getElementsByClassName('herramientas')[0].options.selectedIndex = -1;
        trs[i].getElementsByClassName('numbericInput')[0].value = 0;
    }

    document.getElementById('total').value = '$' + 0;
    document.getElementById('total').style.color = "black";
    document.getElementById('subtotal').value = '$' + 0;
    document.getElementById('subtotal').style.color = "black";
}

function desactivarSelect(id)
{
    trs = document.getElementsByClassName('selects');
    selects = [];

    for (var i = 0; i < trs.length; i++) 
    {
        selects[i] = trs[i].getElementsByClassName('herramientas')[0];
    }

    //muetras todos las opciones de todos los select
    for (var i = 0; i < selects.length; i++) 
    {
        for (j = 0; j < selects.length; j++)
        {
            selects[i].options[j].hidden = false;
        }
    }

    for (var i = 0; i < selects.length; i++) 
    {
        index = selects[i].options.selectedIndex;

        if (index != -1)
        {
            for (j = 0; j < selects.length; j++)
            {
                if (i != j)
                {
                    selects[j].options[index].hidden = true;
                }
            }
        }
    }

    document.getElementById("nHerramientas" + id).value = 0;

    calcularTotal();
}

function calcularTotal()
{
    trs = document.getElementsByClassName('selects');

    total = 0;
    for (i = 0; i < trs.length; i++)
    {
        index = trs[i].getElementsByClassName('herramientas')[0].options.selectedIndex;

        if (index != -1)
        {
            precio = parseFloat(document.getElementById('precios')[index].value);
            cantidad = parseFloat(trs[i].getElementsByClassName('numbericInput')[0].value);
            total = total + ( precio * cantidad);
        }
        else
        {
            trs[i].getElementsByClassName('numbericInput')[0].value = 0;
        }

        document.getElementById('subtotal').value = '$' + Math.round(total * 100) / 100;
        document.getElementById('total').value = '$' + Math.round((total * 1.16) * 100) / 100;
    }
}

//selects[0].getElementsByClassName('herramientas');

function cambiarClave(id)
{
    idToChange = ((document.getElementById(id)).cells[0]).innerHTML;

    nuevaVentana = window.open('', 'Herremex', "width=500, height=500");
    nuevaVentana.close();
    nuevaVentana = window.open('', 'Herremex', "width=500, height=500");

    //nuevaVentana.document.writeln('<link rel="stylesheet" type="text/css" href="Recursos/css/stylePassword.css">');
    nuevaVentana.document.writeln('<script>');
    nuevaVentana.document.writeln('function comprobarCampos(){');

    nuevaVentana.document.writeln('   antigua1 = document.getElementById("antigua1");');
    nuevaVentana.document.writeln('   antigua2 = document.getElementById("antigua2");');
    nuevaVentana.document.writeln('   nueva    = document.getElementById("nueva");');
    nuevaVentana.document.writeln('   res      = true;');

    nuevaVentana.document.writeln('   if (antigua1.value != antigua2.value) {');
    nuevaVentana.document.writeln('       antigua1.style.color = "red";');
    nuevaVentana.document.writeln('       antigua2.style.color = "red";');
    nuevaVentana.document.writeln('       res = false;');
    nuevaVentana.document.writeln('   }');

    nuevaVentana.document.writeln('   if (antigua1.value == "") {');
    nuevaVentana.document.writeln('       antigua1.style.color = "red";');
    nuevaVentana.document.writeln('       res = false;');
    nuevaVentana.document.writeln('   }');

    nuevaVentana.document.writeln('   if (antigua2.value == "") {');
    nuevaVentana.document.writeln('       antigua2.style.color = "red";');
    nuevaVentana.document.writeln('       res = false;');
    nuevaVentana.document.writeln('   }');

    nuevaVentana.document.writeln('   if (nueva.value == "" || nueva.value.length < 8) {');
    nuevaVentana.document.writeln('       nueva.style.color = "red";');
    nuevaVentana.document.writeln('       res = false;');
    nuevaVentana.document.writeln('   }');

    nuevaVentana.document.writeln('   if (res) {');
    nuevaVentana.document.writeln('       var datosEnv  = "Ajax/cambioClave.php?"+ ');
    nuevaVentana.document.writeln('         "antigua="   + antigua1.value  + ');
    nuevaVentana.document.writeln('         "&nueva="    + nueva.value +');
    nuevaVentana.document.writeln('         "&id="       + ' + String(idToChange) + ';');

    nuevaVentana.document.writeln('       var ajax = new XMLHttpRequest();');

    nuevaVentana.document.writeln('       ajax.onreadystatechange = function() ');
    nuevaVentana.document.writeln('       {');
    nuevaVentana.document.writeln('           if (ajax.readyState == 4 && ajax.status == 200) ');
    nuevaVentana.document.writeln('           {');

    nuevaVentana.document.writeln('               if (ajax.responseText.indexOf("KO") === -1)');
    nuevaVentana.document.writeln('               {');
    nuevaVentana.document.writeln('                   alert("Contraseña Cambiada")');
    nuevaVentana.document.writeln('                   window.close()');                                                      
    nuevaVentana.document.writeln('               }');
    nuevaVentana.document.writeln('               else');
    nuevaVentana.document.writeln('               {');
    nuevaVentana.document.writeln('                   alert("Error al cambiar Contraseña")');
    nuevaVentana.document.writeln('                   window.close()');                                                      
    nuevaVentana.document.writeln('               }');
    nuevaVentana.document.writeln('            }');
    nuevaVentana.document.writeln('       }');
    nuevaVentana.document.writeln('       ajax.open("GET",datosEnv,true);');
    nuevaVentana.document.writeln('       ajax.send();');

    nuevaVentana.document.writeln('   }');
    nuevaVentana.document.writeln('}');

    nuevaVentana.document.writeln('function inicializarCampos(){');

    nuevaVentana.document.writeln('   document.getElementById("antigua1").style.color = "black";');
    nuevaVentana.document.writeln('   document.getElementById("antigua2").style.color = "black";');
    nuevaVentana.document.writeln('   document.getElementById("nueva").style.color = "black";');

    nuevaVentana.document.writeln('}');
    nuevaVentana.document.writeln('</script>');
    
    nuevaVentana.document.writeln('<style>body{text-align:center;}</style>');
    nuevaVentana.document.writeln('<script type="text/javascript" src="Ajax/ajax.js"></script>');
    nuevaVentana.document.writeln("<h1>Cambiar Contraseña Del Empleado " + idToChange + "</h1><br>");
    nuevaVentana.document.writeln("Inserte su actual Contraseña<br>");
    nuevaVentana.document.writeln("<input type='password' id='antigua1' placeholder='minimo 8 caracteres' onclick='inicializarCampos()'><br><br>");
    nuevaVentana.document.writeln("Inserte Otra vez su Contraseña<br>");
    nuevaVentana.document.writeln("<input type='password' id='antigua2' placeholder='minimo 8 caracteres' onclick='inicializarCampos()'><br><br><br>");
    nuevaVentana.document.writeln("Inserte su nueva contraseña<br>");
    nuevaVentana.document.writeln("<input type='password' id = 'nueva' placeholder='minimo 8 caracteres' onclick='inicializarCampos()'><br><br><br>");
    nuevaVentana.document.writeln("<button onclick='comprobarCampos()'>Guardar</button");
}

/**
 * Elimina un elemento mandando una petición al servidor
 * 
 * @param  {String} id  nombre del ID del parrafo
 * @param  {String} res Descripción de como se llama el objeto que se va a eliminar
 */
function deleteS(id, res)
{
    idToDelete = ((document.getElementById(id)).cells[0]).innerHTML;

    if (res == 'al empleado')
    {
        res = confirm("¿Esta seguro que desea eliminar " + res + " en la fila No." + id + "?");

        if (res)
        {
            href("?action=delete&empleado_id=" + idToDelete + "&");
        }
    }
    else if (res == 'a la herramienta')
    {
        res = confirm("¿Esta seguro que desea eliminar " + res + " en la fila No." + id + "?");

        if (res)
        {
            href("?action=delete&herramienta_id=" + idToDelete + "&");
        }
    }
    else if (res == 'al cliente')
    {
        res = confirm("¿Esta seguro que desea eliminar " + res + " en la fila No." + id + "?");

        if (res)
        {
            href("?action=delete&Cliente_id=" + idToDelete + "&");
        }
    }
    else if (res == 'al distribuidor')
    {
        res = confirm("¿Esta seguro que desea eliminar " + res + " en la fila No." + id + "?");

        if (res)
        {
            href("?action=delete&distribuidor_id=" + idToDelete + "&");
        }
    }
    else if (res == 'a la sucursal')
    {
        res = confirm("¿Esta seguro que desea eliminar " + res + " en la fila No." + id + "?");

        if (res)
        {
            href("?action=delete&sucursal_id=" + idToDelete + "&");
        }
    }
}

function mostrarS(id)
{
    id = ((document.getElementById(id)).cells[0]).innerHTML;
    url = String(window.location);

    pos = url.indexOf("BusquedaEmpleados.php");
    url = url.substring(0, pos);
    url = url + "ModificacionesEmpleados.php?look_id=" + id;

    window.location.href = url;
}

/**
 * Elimina un elemento mandando una petición al servidor
 * 
 * @param  {String} id  nombre del ID del parrafo
 * @param  {String} res Descripción de como se llama el objeto que se va a eliminar
 */
function changeS(id, tipo)
{
    idToDelete = ((document.getElementById(id)).cells[0]).innerHTML;
    url = String(window.location);

    if (tipo == 'Sucursal')
    {
        pos = url.indexOf("BusquedaSucursales.php");
        url = url.substring(0, pos);
        url = url + "ModificacionesSucursales.php?id=" + idToDelete;

        window.location.href = url;
    }
    else if (tipo == 'Empleado')
    {
        console.log("hola");
        pos = url.indexOf("BusquedaEmpleados.php");
        url = url.substring(0, pos);
        url = url + "ModificacionesEmpleados.php?change_id=" + idToDelete;

        window.location.href = url;
    }
    else if (tipo == 'Herramienta')
    {
        console.log("hola");
        pos = url.indexOf("BusquedaHerramientas.php");
        url = url.substring(0, pos);
        url = url + "ModificacionesHerramientas.php?id=" + idToDelete;

        window.location.href = url;
    }
    else if (tipo == 'Cliente')
    {
        pos = url.indexOf("BusquedaClientes.php");
        url = url.substring(0, pos);
        url = url + "ModificacionesClientes.php?id=" + idToDelete;

        window.location.href = url;
    }
    else if (tipo == 'Distribuidor')
    {
        pos = url.indexOf("BusquedaDistribuidores.php");
        url = url.substring(0, pos);
        url = url + "ModificacionesDistribuidores.php?id=" + idToDelete;

        window.location.href = url;
    }
    else if (res == 'a la herramienta')
    {
        res = confirm("¿Esta seguro que desea eliminar " + res + " en la fila No." + id + "?");

        if (res)
        {
            href("?action=delete&herramienta_id=" + idToDelete + "&");
        }
    }
    else if (res == 'al cliente')
    {
        res = confirm("¿Esta seguro que desea eliminar " + res + " en la fila No." + id + "?");

        if (res)
        {
            href("?action=delete&Cliente_id=" + idToDelete + "&");
        }
    }
    else if (res == 'al distribuidor')
    {
        res = confirm("¿Esta seguro que desea eliminar " + res + " en la fila No." + id + "?");

        if (res)
        {
            href("?action=delete&distribuidor_id=" + idToDelete + "&");
        }
    }
    else if (res == 'a la sucursal')
    {
        res = confirm("¿Esta seguro que desea eliminar " + res + " en la fila No." + id + "?");

        if (res)
        {
            href("?action=delete&sucursal_id=" + idToDelete + "&");
        }
    }
}

/**
 * Funcion Href que direciona entre páginas y
 * manda peticiones sobre busquedas por objetos al servidor
 * 
 * @param  {String} pagina Nombre de la página a direcionar o 
 *                  cadena especifica para buscar en el servidor
 */
function href(pagina)
{
    if ('?keyword=data' == pagina)
    {
        window.location.href = '?keyword=' + document.getElementById('bNombre1').value + '&';
    }
    else if ('?keyword_id=herramienta' == pagina)
    {
        cadena = "?keyword_id="    + document.getElementById('bID').value + "&" +
                "keyword_tipo="    + document.getElementById('bTipo').value + "&" +
                "keyword_precio="  + document.getElementById('bPrecio').value + "&" +
                "keyword_nombre="  + document.getElementById('bNombre2').value + "&";

        window.location.href = cadena;
    }
    else if ('?keyword_id=compra' == pagina)
    {
        cadena = "?keyword_id="    + document.getElementById('bID').value    + "&" +
                 "keyword_fecha="  + document.getElementById('bFecha').value + "&";

        window.location.href = cadena;
    }
    else if ('?keyword_id=empleado' == pagina)
    {
        cadena = "?keyword_id="             + document.getElementById('bID').value + "&" +
                "keyword_curp="             + document.getElementById('bCURP').value + "&" +
                "keyword_primer_nombre="    + document.getElementById('bNombre2').value + "&" +
                "keyword_segundo_nombre="   + document.getElementById('bNombreS').value + "&" +
                "keyword_apellido_paterno=" + document.getElementById('bApellidoP').value + "&" +
                "keyword_apellido_materno=" + document.getElementById('bApellidoM').value + "&" +
                "keyword_turno="            + document.getElementById('bTurno').value + "&" +
                "keyword_tipo="             + document.getElementById('bTipo').value + "&" +
                "keyword_calle="            + document.getElementById('bCalle').value + "&" +
                "keyword_colonia="          + document.getElementById('bColonia').value + "&" +
                "keyword_ext="              + document.getElementById('bNCasa').value + "&" +
                "keyword_int="              + document.getElementById('bNCasaI').value + "&" +
                "keyword_ciudad="           + document.getElementById('bCiudad').value + "&";

        window.location.href = cadena;
    }
    else if ('?keyword_id=cliente' == pagina)
    {
        cadena = "?keyword_id="       + document.getElementById('bID').value        + "&" +
                "keyword_rfc="        + document.getElementById('bRFC').value       + "&" +
                "keyword_nombre="     + document.getElementById('bNombre2').value   + "&" +
                "keyword_sexo="       + document.getElementById('bSexo').value      + "&" +
                "keyword_regimen="    + document.getElementById('bRegimen').value   + "&" +
                "keyword_calle="      + document.getElementById('bCalle').value     + "&" +
                "keyword_noEdificio=" + document.getElementById('bEdificio').value  + "&" +
                "keyword_ciudad="     + document.getElementById('bCiudad').value    + "&";

        window.location.href = cadena;
    }
    else if ('?keyword_id=distribuidor' == pagina)
    {
        cadena = "?keyword_id="       + document.getElementById('bID').value        + "&" +
                "keyword_direccion="  + document.getElementById('bDireccion').value + "&" +
                "keyword_nombre="     + document.getElementById('bNombre2').value   + "&";

        window.location.href = cadena;
    }
    else if ('?keyword_id=sucursal' == pagina)
    {
        cadena = "?keyword_ciudad="  + document.getElementById('bCiudad').value     + "&" +
                "keyword_id="        + document.getElementById('bID').value         + "&" +
                "keyword_calle="     + document.getElementById('bCalle').value      + "&" +
                "keyword_colonia="   + document.getElementById('bColonia').value    + "&" +
                "keyword_edificio="  + document.getElementById('bNoEdificio').value + "&";

        window.location.href = cadena;
    }
    else if ('busquedaEmpleados' == pagina)
    {      
        url = String(window.location);

        pos = url.indexOf("AgregacionesEmpleados.php");
        url = url.substring(0, pos);
        url = url + "BusquedaEmpleados.php";

        window.location.href = url;
    }
    else
    {
        window.location.href = pagina;
    }
}

/**
 * Ordena una tabla acdendtementede HTML en relación de su numero de columna
 * 
 * @param  {int} num        Numero de la columna a ordenar 
 * @param  {String} tabla   ID de la tabla a ordenar
 */
function sort(num, tabla)
{
    var tag = Array.prototype.slice.call(document.getElementById(tabla).getElementsByTagName('tr')).splice(2)
    var n = tag.length;

    for(var i = 0; i < n; i++)
    {
        var min = i;

        for (j = i+1; j < n; j++)
        {
            val1 = tag[j].cells[num].innerHTML;
            val2 = tag[min].cells[num].innerHTML;

            if (!isNaN(parseInt(val1)))
            {
                val1 = parseInt(tag[j].cells[num].innerHTML);
                val2 = parseInt(tag[min].cells[num].innerHTML);
            }

            if (val1 < val2)
            {
                min = j;
            }
        }

        if (min != i)
        {
            var tagtemp  = tag[i].cells;
            var tagtemp2 = tag[min].cells;

            for (k = 0; k < tagtemp.length -1; k++)
            {
                var dato = tagtemp[k].innerHTML;
                tagtemp[k].innerHTML = tagtemp2[k].innerHTML;
                tagtemp2[k].innerHTML = dato;
            }   
        }
    }
}

/**
 * Ordena de modo invertido una tabla de HTML 
 * 
 * @param  {int} num        Numero de la columna a ordenar 
 * @param  {String} tabla   ID de la tabla a ordenar
 */
function invertSort(num, tabla)
{
    var tag = Array.prototype.slice.call(document.getElementById(tabla).getElementsByTagName('tr')).splice(2);
    var n = tag.length;

    for(var i = 0; i < n-1; i++)
    {
        var min = i;

        for (j = i+1; j < n; j++)
        {
            val1 = tag[j].cells[num].innerHTML;
            val2 = tag[min].cells[num].innerHTML;

            if (!isNaN(parseInt(val1)))
            {
                val1 = parseInt(tag[j].cells[num].innerHTML);
                val2 = parseInt(tag[min].cells[num].innerHTML);
            }

            if (!(val1 < val2))
            {
                min = j;
            }
        }

        if (min != i)
        {
            var tagtemp  = tag[i].cells;
            var tagtemp2 = tag[min].cells;

            for (k = 0; k < tagtemp.length -1; k++)
            {
                var dato = tagtemp[k].innerHTML;
                tagtemp[k].innerHTML = tagtemp2[k].innerHTML;
                tagtemp2[k].innerHTML = dato;
            }   
        }
    }
}

/**
 * Decide que tipo de ordenamiento hará el una columna en una tabla
 * 
 * @param  {int}    col   numero de columna
 * @param  {String} tabla id de una tabla en el documento
 */
function decidesort(col, tabla)
{
    header = document.getElementById(tabla).getElementsByTagName('tr')[0].cells;

    tsort = 1;

    if ((header[col].innerHTML).indexOf('↓') === 0)
    {
        tsort = 2;
    }

    //quitamos todos los simbolos
    for (i = 0; i < header.length; i++)
    {
        cad = header[i].innerHTML;

        if (cad.indexOf('↑') === 0 || cad.indexOf('↓') === 0)
        {
            cad = cad.substring(1);
        }

        header[i].innerHTML = cad;
    }

    if (tsort == 1)
    {
        header[col].innerHTML = '↓' + header[col].innerHTML;    
        sort(col, tabla);
    }
    else
    {
        header[col].innerHTML = '↑' + header[col].innerHTML;    
        invertSort(col, tabla);
    }
}

/**
 * Inicializa de modo que muestre el tamaño 'tam' de registros
 * 
 * @param  {int} tam        Numero total de registros que mostrará por petición
 * @param  {String} tabla   ID de la tabla a inicializar
 */
function inicializeHidden(tam, tabla)
{
    var tag = document.getElementById(tabla).getElementsByTagName('tr');

    for (i = 1; i < tag.length; i++)
    {
        if (i < tam+1)
        {
            tag[i].hidden = false;
        }
        else
        {
            tag[i].hidden = true;   
        }
    }

    if (!(tag[tam+1] == undefined))
    {
        document.getElementById('next').hidden = false;
    }

    document.getElementById('prev').hidden = true;
}

/**
 * Retorna la posición del primer elemento de la tabla con hidden
 *
 * @param  {String} tabla   ID de la tabla conseguir el primer oculto
 */
function firstHidden(tabla)
{
    var tag = document.getElementById(tabla).getElementsByTagName('tr');

    for (i = 1; i < tag.length; i++)
    {
        if (tag[i].hidden == false)
        {
            return parseInt(i);
        }
    }
}

/**
 * Muestra el siguiente conjunto de elementos de una tabla
 * 
 * @param  {int}    tam     Tamaño de el siguiente numero de registros
 * @param  {String} tabla   ID de la tabla a mostrar el siguiente bloque de registros
 */
function next(tam, tabla)
{
    var tag = document.getElementById(tabla).getElementsByTagName('tr');
    first = firstHidden(tabla);

    doble = (tam * 2) + first;

    console.log(tag[first]);

    document.getElementById('prev').hidden = false;

    for (i = first; i < doble; i++)
    {
        if (i < (tam + first))
        {   
            if (tag[i] == undefined)
            {
                document.getElementById('prev').hidden = false;
                document.getElementById('next').hidden = true;
            }
            else
            {
                tag[i].hidden = true;
            }
        }
        else
        {
            if (tag[i] == undefined)
            {
                document.getElementById('prev').hidden = false;
                document.getElementById('next').hidden = true;
            }
            else
            {
                tag[i].hidden = false;
            }
        }
    }

    if (doble+1 > tag.length)
    {
        document.getElementById('next').hidden = true;
    }
    else
    {
        document.getElementById('next').hidden = false;
    }
}

/**
 * Muestra el anterior conjunto de elementos de una tabla
 * 
 * @param  {int}    tam     Tamaño del anterior numero de registros
 * @param  {String} tabla   ID de la tabla a mostrar el anterior bloque de registros
 */
function prev(tam, tabla)
{
    var tag = document.getElementById(tabla).getElementsByTagName('tr');
    first = firstHidden(tabla);

    doble = first + (tam * 2);

    if (first-tam <= 1)
    {
        document.getElementById('prev').hidden = true;
    }

    document.getElementById('next').hidden = false;

    for (i = first - tam; i < doble; i++)
    {
        if (i < (first))
        {
            tag[i].hidden = false;
        }
        else
        {
            tag[i].hidden = true;
        }
    }
}

/*Encargado de otorgar a la tabla responsibilidad*/
var headertext = [],
headers = document.querySelectorAll("#dataTable th"),
tablerows = document.querySelectorAll("#dataTable th"),
tablebody = document.querySelector("#dataTable tbody");

for(var i = 0; i < headers.length; i++) {
  var current = headers[i];
  headertext.push(current.textContent.replace(/\r?\n|\r/,""));
} 
for (var i = 0, row; row = tablebody.rows[i]; i++) {
  for (var j = 0, col; col = row.cells[j]; j++) {
    col.setAttribute("data-th", headertext[j]);
  } 
}

/*Fecha de hoy*/
function fechaHoy()
{
    var hoy = new Date();
    var dia = hoy.getDate();
    var mes = hoy.getMonth()+1;

    var ano = hoy.getFullYear();
    if(dia<10){
        dd='0'+dd
    } 
    if(mes<10){
        mes='0'+mes
    } 
    var hoy = dia+'/'+mes+'/'+ano;
    document.getElementById("fecha").innerHTML = hoy;   
}

