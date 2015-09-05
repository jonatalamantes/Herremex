<?php 

class NumeroLetra
{
    //Regresa un string con la versión escrita que corresponde a dicho numero
    static function numeroALetra($tipoRecibido, $numero)
    {
        if ($numero == '0')
        {
            return "cero";
        }

        $actual = $numero;
        $tipo = $tipoRecibido % 10;
        $otro = $tipoRecibido / 10;

        if ($otro == 1)
        {
            if ($tipo == 1)
            {
                $actual = EnteroALetra(substr($numero, 1));
            }
            else if ($tipo == 2)
            {
                $actual = FracionarioALetra(substr($numero, 1));
            }
            else if ($tipo == 3)
            {
                $actual = RealALetra(substr($numero, 1));
            }
            else if ($tipo == 4)
            {

                $actual = OrdinalALetra(substr($numero, 0, strlen($numero)-2), false);
            }
            else
            {
                $actual = "número";
            }

            $actual = $actual . " positivo";
        }
        else if ($otro == 2)
        {
            if ($tipo == 1)
            {
                $actual = EnteroALetra(substr($numero, 1));
            }
            else if ($tipo == 2)
            {
                $actual = FracionarioALetra(substr($numero, 1));
            }
            else if ($tipo == 3)
            {
                $actual = RealALetra(substr($numero, 1));
            }
            else if ($tipo == 4)
            {
                $actual = OrdinalALetra(substr($numero, 0, strlen($numero)-2), false);
            }
            else
            {
                $actual = "número";
            }

            $actual = $actual . " negativo";
        }
        else
        {
            if ($tipo == 1)
            {
                $actual = self::EnteroALetra($numero);
            }
            else if ($tipo == 2)
            {
                $actual = self::FracionarioALetra($numero);
            }
            else if ($tipo == 3)
            {
                $actual = self::RealALetra($numero);
            }
            else if ($tipo == 4)
            {
                $actual = self::OrdinalALetra(substr($numero, 0, strlen($numero)-2), false);
            }
            else
            {
                $actual = "número inválido";
            }
        }

        return $actual;
    }

    //Regresa la version escrita de dicho numero
    static function EnteroALetra($aux)
    {
        while($aux[0] == "0")
        {
            $aux = substr($aux, 1);
        }

        if (strlen($aux) == 0)
        {
            return "";
        }
        if (strlen($aux) == 1)
        {
            if ($aux == "1")
            {
                return "un";
            }
            else if ($aux == "2")
            {
                return "dos";
            }
            else if ($aux == "3")
            {
                return "tres";
            }
            else if ($aux == "4")
            {
                return "cuatro";
            }
            else if ($aux == "5")
            {
                return "cinco";
            }
            else if ($aux == "6")
            {
                return "seis";
            }
            else if ($aux == "7")
            {
                return "siete";
            }
            else if ($aux == "8")
            {
                return "ocho";
            }
            else if ($aux == "9")
            {
                return "nueve";
            }
            else if ($aux == "0")
            {
                return "";
            }
            else
            {
                //nada
            }
        }
        else if (strlen($aux) == 2)
        {
            if ($aux == "10")
            {
                return "diez";
            }
            else if ($aux == "11")
            {
                return "once";
            }
            else if ($aux == "12")
            {
                return "doce";
            }
            else if ($aux == "13")
            {
                return "trece";
            }
            else if ($aux == "14")
            {
                return "catorce";
            }
            else if ($aux == "15")
            {
                return "quince";
            }
            else if (substr($aux, 0, 1) == "1")
            {
                return "diceci" . self::EnteroALetra(substr($aux,1,1));
            }
            else if ($aux == "20")
            {
                return "veinte";
            }
            else if (substr($aux, 0, 1) == "2")
            {
                return "veinti" . self::EnteroALetra(substr($aux, 1, 1));
            }
            else if ($aux == "30")
            {
                return "treinta";
            }
            else if (substr($aux, 0, 1) == "3")
            {
                return "treinta y " . self::EnteroALetra(substr($aux,1,1));
            }
            else if ($aux == "40")
            {
                return "cuarenta";
            }
            else if (substr($aux, 0, 1) == "4")
            {
                return "cuarenta y " . self::EnteroALetra(substr($aux,1,1));
            }
            else if ($aux == "50")
            {
                return "cincuenta";
            }
            else if (substr($aux, 0, 1) == "5")
            {
                return "cincuenta y " . self::EnteroALetra(substr($aux,1,1));
            }
            else if ($aux == "60")
            {
                return "sesenta";
            }
            else if (substr($aux,0,1) == "6")
            {
                return "sesenta y " . self::EnteroALetra(substr($aux,1,1));
            }
            else if ($aux == "70")
            {
                return "setenta";
            }
            else if (substr($aux,0,1) == "7")
            {
                return "setenta y " . self::EnteroALetra(substr($aux,1,1));
            }
            else if ($aux == "80")
            {
                return "ochenta";
            }
            else if (substr($aux,0,1) == "8")
            {
                return "ochenta y " . self::EnteroALetra(substr($aux,1,1));
            }
            else if ($aux == "90")
            {
                return "noventa";
            }
            else if (substr($aux,0,1) == "9")
            {
                return "noventa y " . self::EnteroALetra(substr($aux,1,1));
            }
            else
            {
                return "" . self::EnteroALetra(substr($aux,1,1));
            }
        }
        else if (strlen($aux) == 3)
        {
            if ($aux == "100")
            {
                return "cien";
            }
            else if (substr($aux,0,1) == "1")
            {
                return "ciento " . self::EnteroALetra(substr($aux,1,2));
            }
            else
            {
                if ($aux == "500")
                {
                    return "quinientos";
                }
                else if (substr($aux,0,1) == "5")
                {
                    return "quinientos " . self::EnteroALetra(substr($aux,1,2));
                }
                if ($aux == "700")
                {
                    return "setecientos";
                }
                else if (substr($aux,0,1) == "7")
                {
                    return "setecientos " . self::EnteroALetra(substr($aux,1,2));
                }
                if ($aux == "900")
                {
                    return "novecientos";
                }
                else if (substr($aux,0,1) == "9")
                {
                    return "novecientos " . self::EnteroALetra(substr($aux,1,2));
                }
                else if (substr($aux,2,1) == "0")
                {
                    return self::EnteroALetra(substr($aux,0,1)) . "cientos";
                }
                else if (substr($aux,0,1) == "0")
                {
                    return self::EnteroALetra(substr($aux,1,2));
                }
                else
                {
                    return self::EnteroALetra(substr($aux,0,1)) . "cientos " . self::EnteroALetra(substr($aux,1,2));
                }
            }
        }
        else if (strlen($aux) >= 4 && strlen($aux) <= 6)
        {
            if ($aux == "1000")
            {
                return "mil";
            }
            else
            {
                if (substr($aux,strlen($aux) - 3, 3) == "000")
                {
                    return self::EnteroALetra(substr($aux,0, strlen($aux) - 3)) . " mil";
                }
                else
                {
                    if (substr($aux,0, 1) == "1")
                    {
                        if (strlen($aux) == 4)
                        {
                            return "mil " . self::EnteroALetra(substr($aux,strlen($aux) - 3, 3));
                        }
                        else
                        {
                            return self::EnteroALetra(substr($aux,0, strlen($aux) - 3)) . " mil " . self::EnteroALetra(substr($aux,strlen($aux) - 3, 3));
                        }
                    }
                    else if (substr($aux,0,1) == "0")
                    {
                        return self::EnteroALetra(substr($aux,1, strlen($aux) - 1));
                    }
                    else
                    {
                        return self::EnteroALetra(substr($aux,0, strlen($aux) - 3)) . " mil " . self::EnteroALetra(substr($aux,strlen($aux) - 3, 3));
                    }
                }
            }
        }
        else if (strlen($aux) >= 7 && strlen($aux) <= 12)
        {
            if ($aux == "1000000")
            {
                return "un millón";
            }
            else
            {
                if (strlen($aux) == 7)
                {
                    if (substr($aux,0, 1) == "1")
                    {
                        return "un millón " . self::EnteroALetra(substr($aux,strlen($aux) - 6, 6));
                    }
                    else
                    {
                        return self::EnteroALetra(substr($aux,0, strlen($aux) - 6)) . " millones " . self::EnteroALetra(substr($aux,strlen($aux) - 6, 6));
                    }
                }
                else
                {
                    return self::EnteroALetra(substr($aux,0, strlen($aux) - 6)) . " millones " . self::EnteroALetra(substr($aux,strlen($aux) - 6, 6));
                }
            }
        }
        else
        {
            if ($aux == "1000000000000")
            {
                return "un billón";
            }
            else
            {
                if (strlen($aux) == 13)
                {
                    if (substr($aux,0, 1) == "1")
                    {
                        return "un billón " . self::EnteroALetra(substr($aux,strlen($aux) - 12, 12));
                    }
                    else
                    {
                        return self::EnteroALetra(substr($aux,0, strlen($aux) - 12)) . " billones " . self::EnteroALetra(substr($aux,strlen($aux) - 12, 12));
                    }
                }
                else
                {
                    return self::EnteroALetra(substr($aux,0, strlen($aux) - 12)) . " billones " . self::EnteroALetra(substr($aux,strlen($aux) - 12, 12));
                }
            }
        }
    }

    //Regresa la version escrita de dicho numero y si es decimal
    static function OrdinalALetra($aux, $decimal)
    {
        if ($decimal)
        {
            while ( ! ( strlen($aux) == 1 || strlen($aux) == 2 || strlen($aux) == 3 ||
                      strlen($aux) == 6 || strlen($aux) == 12 || strlen($aux) == 18) )
            {
                $aux = $aux.("0");
            }

            if (strlen($aux) == 1)
            {
                return self::EnteroALetra(substr($aux,0,strlen($aux))) . " décimos";
            }
            else if (strlen($aux) == 2)
            {
                return self::EnteroALetra(substr($aux,0,strlen($aux))) . " centésimos";
            }
            else if (strlen($aux) == 3)
            {
                return self::EnteroALetra(substr($aux,0,strlen($aux))) . " milésimos";
            }
            else if (strlen($aux) == 6)
            {
                return self::EnteroALetra(substr($aux,0,strlen($aux))) . " millonésimas";
            }
            else if (strlen($aux) == 12)
            {
                return self::EnteroALetra(substr($aux,0,strlen($aux))) . " billonésimas";
            }
            else if (strlen($aux) == 18)
            {
                return self::EnteroALetra(substr($aux,0,strlen($aux))) . " trillonésimas";
            }
        }
        else
        {
            if (strlen($aux) == 0)
            {
                return "";
            }
            if (strlen($aux) == 1)
            {
                if ($aux == "1")
                {
                    return "primera";
                }
                else if ($aux == "2")
                {
                    return "segunda";
                }
                else if ($aux == "3")
                {
                    return "tercera";
                }
                else if ($aux == "4")
                {
                    return "cuarta";
                }
                else if ($aux == "5")
                {
                    return "quinta";
                }
                else if ($aux == "6")
                {
                    return "sexta";
                }
                else if ($aux == "7")
                {
                    return "septima";
                }
                else if ($aux == "8")
                {
                    return "octava";
                }
                else if ($aux == "9")
                {
                    return "novena";
                }
                else if ($aux == "0")
                {
                    return "cero";
                }
                else
                {
                    //nada
                }
            }
            else if (strlen($aux) == 2)
            {
                if ($aux == "10")
                {
                    return "décimo";
                }
                else if (substr($aux,0,1) == "1")
                {
                    return "décimo " . self::OrdinalALetra(substr($aux,1,1), false);
                }
                else if ($aux == "20")
                {
                    return "vigésimo ";
                }
                else if (substr($aux,0,1) == "2")
                {
                    return "vigésimo" . self::OrdinalALetra(substr($aux,1,1), false);
                }
                else if ($aux == "30")
                {
                    return "trigésimo";
                }
                else if (substr($aux,0,1) == "3")
                {
                    return "trigésimo " . self::OrdinalALetra(substr($aux,1,1), false);
                }
                else if ($aux == "40")
                {
                    return "cuadragésimo";
                }
                else if (substr($aux,0,1) == "4")
                {
                    return "cuadragésimo " . self::OrdinalALetra(substr($aux,1,1), false);
                }
                else if ($aux == "50")
                {
                    return "quincuagésimo";
                }
                else if (substr($aux,0,1) == "5")
                {
                    return "quincuagésimo " . self::OrdinalALetra(substr($aux,1,1), false);
                }
                else if ($aux == "60")
                {
                    return "sexagésimo";
                }
                else if (substr($aux,0,1) == "6")
                {
                    return "sexagésimo " . self::OrdinalALetra(substr($aux,1,1), false);
                }
                else if ($aux == "70")
                {
                    return "septuagésimo";
                }
                else if (substr($aux,0,1) == "7")
                {
                    return "septuagésimo " . self::OrdinalALetra(substr($aux,1,1), false);
                }
                else if ($aux == "80")
                {
                    return "octogésimo";
                }
                else if (substr($aux,0,1) == "8")
                {
                    return "octogésimo " . self::OrdinalALetra(substr($aux,1,1), false);
                }
                else if ($aux == "90")
                {
                    return "nonagésimo";
                }
                else if (substr($aux,0,1) == "9")
                {
                    return "nonagésimo " . self::OrdinalALetra(substr($aux,1,1), false);
                }
                else
                {
                    return self::OrdinalALetra(substr($aux,1,1), false);
                }
            }
            else
            {
                return "";
            }
        }
    }

    //Regresa la version escríta de dicho numero y si es un valor de dinero
    static function MonedaALetra($numero, $nombreMoneda = "pesos")
    {
        $posPunto = strpos($numero, ".");

        if ($posPunto != false)
        {
            $numero = $numero . "0";

            $a = self::EnteroALetra(substr($numero, 0, $posPunto));
            $b = self::EnteroALetra(substr($numero, $posPunto + 1, 2));

            if ($a == '')
            {
                return $b . " centavos";
            }

            return $a . " " . $nombreMoneda . ", " . $b . " centavos";
        }
        else
        {
            return self::EnteroALetra($numero) . " " . $nombreMoneda;
        }
    }

    //Regresa la version escrita de dicho numero
    static function RealALetra($numero)
    {
        $posPunto = stripos($numero, ".");

        $a = self::EnteroALetra(substr($numero, 0, $posPunto));
        $b = self::OrdinalALetra(substr($numero,$posPunto + 1, strlen($numero) - $posPunto + 1), true);

        if ($a == "")
        {
            return $b;
        }
        else
        {
            return $a . " punto " . $b;
        }
    }

    //Regresa la version escrita de dicho numero
    static function FracionarioALetra($numero)
    {
        $posPunto = stripos($numero, "/");

        $a = self::EnteroALetra(substr($numero, 0, $posPunto));
        $b = self::fracionarNumero(substr($numero,$posPunto + 1, strlen($numero) - $posPunto + 1));

        if ($a == "")
        {
            return $b;
        }
        else
        {
            if ($a == "un")
            {
                return $a . " " . $b;
            }
            else
            {
                return $a . " " . $b . "s";
            }
        }
    }

    //regresa la versionfracionaria de un numero, pero no de ambas fraciones
    static function fracionarNumero($aux)
    {
        if (strlen($aux) == 0)
        {
            return "";
        }
        if (strlen($aux) == 1)
        {
            if ($aux == "1")
            {
                return "entero";
            }
            else if ($aux == "2")
            {
                return "medio";
            }
            else if ($aux == "3")
            {
                return "tercio";
            }
            else if ($aux == "4")
            {
                return "cuarto";
            }
            else if ($aux == "5")
            {
                return "quinto";
            }
            else if ($aux == "6")
            {
                return "sexto";
            }
            else if ($aux == "7")
            {
                return "septimo";
            }
            else if ($aux == "8")
            {
                return "octavo";
            }
            else if ($aux == "9")
            {
                return "noveno";
            }
            else if ($aux == "0")
            {
                return "";
            }
            else
            {
                //nada
            }
        }
        else if (strlen($aux) == 2)
        {
            if ($aux == "10")
            {
                return "décimo";
            }
            else
            {
                return self::EnteroALetra($aux) . "avo";
            }
        }
        else if (strlen($aux) == 3)
        {
            if ($aux == "100")
            {
                return "centésimo";
            }
            else
            {
                return self::EnteroALetra($aux) . "avo";
            }
        }
        else if (strlen($aux) == 4)
        {
            if ($aux == "1000")
            {
                return "milésima";
            }
            else
            {
                return self::EnteroALetra($aux) . "avo";
            }
        }
        else if (strlen($aux) == 4)
        {
            if ($aux == "10000")
            {
                return "diez milesima";
            }
            else
            {
                return self::EnteroALetra($aux) . "avo";
            }
        }
        else if (strlen($aux) == 5)
        {
            if ($aux == "100000")
            {
                return "cien milésima";
            }
            else
            {
                return self::EnteroALetra($aux) . "avo";
            }
        }
        else if (strlen($aux) == 6)
        {
            if ($aux == "1000000")
            {
                return "millonésimo";
            }
            else
            {
                return self::EnteroALetra($aux) . "avo";
            }
        }
        else
        {
            return "";
        }
    }

    //Indica que tipo de numero es el insertado en relacion de un estado.
    static function evaluadorNumero($tipo)
    {
        if ($tipo % 10 == 1)
        {
            return " Entero ";
        }
        else if ($tipo % 10 == 2)
        {
            return " Fraccionario ";
        }
        else if ($tipo % 10 == 3)
        {
            return " Real ";
        }
        else if ($tipo % 10 == 4)
        {
            return " Ordinal ";
        }
        else
        {
            return " Inválido ";
        }

        if ($tipo / 10 == 1)
        {
            return "Positivo";
        }
        else if ($tipo / 10 == 2)
        {
            return "Negativo";
        }
        else
        {
            return "";
        }

        return endl;
    }

    //Recibe una cadena y retorna el tipo de numero que es:
    //Si la decena es 0 si no tiene signo, 1 es positivo, 2 entonces si negativo
    //si la unidad es 1 es entero, si la unidad es 2 es fracion
    //si la unidad es 3 es real, si la unidad es 4 es ordinal
    static function tipoNumero($cad)
    {
        $estado = 1;
        $positivo = 0;
        $tipo = 0;

        for ($i = 0; $i < strlen($cad); $i++)
        {
            if ($estado == 1)
            {
                if ($cad[$i] == '-')
                {
                    $estado = 2;
                }
                else if ($cad[$i] == '.')
                {
                    $estado = 9;
                }
                else if ($cad[$i] == '+')
                {
                    $estado = 4;
                }
                else if (is_numeric($cad[$i]))
                {
                    $estado = 3;
                }
                else
                {
                    $estado = 0;
                }
            }
            else if ($estado == 2)
            {
                $positivo = 20;

                if (is_numeric($cad[$i]))
                {
                    $estado = 3;
                }
                else
                {
                    $estado = 0;
                }
            }
            else if ($estado == 9)
            {
                $positivo = 10;

                if (is_numeric($cad[$i]))
                {
                    $estado = 3;
                }
                else
                {
                    $estado = 0;
                }
            }
            else if ($estado == 3)
            {
                if ($cad[$i] == '/')
                {
                    $estado = 6;
                }
                else if ($cad[$i] == '.')
                {
                    $estado = 4;
                }
                else if (utf8_encode($cad[$i]) == 'Â') //'°'
                {
                    $estado = 8;
                }
                else if (is_numeric($cad[$i]))
                {
                    $estado = 3;
                }
                else
                {
                    $estado = 0;
                }
            }
            else if ($estado == 4)
            {
                if (is_numeric($cad[$i]))
                {
                    $estado = 5;
                }
                else if (utf8_encode($cad[$i]) == 'Â') //'°'
                {
                    $estado = 8;
                }
                else
                {
                    $estado = 0;
                }
            }
            else if ($estado == 5)
            {
                if (is_numeric($cad[$i]))
                {
                    $estado = 5;
                }
                else
                {
                    $estado = 0;
                }
            }
            else if ($estado == 6)
            {
                if (is_numeric($cad[$i]))
                {
                    $estado = 7;
                }
                else
                {
                    $estado = 0;
                }
            }
            else if ($estado == 7)
            {
                if (is_numeric($cad[$i]))
                {
                    $estado = 7;
                }
                else
                {
                    $estado = 0;
                }
            }
            else if ($estado == 8)
            {
                $estado = 8;
            }
            else
            {
                $estado = 0;
            }
        }

        if ($estado == 3 || $estado == 4)//Entero
        {
            $tipo = 1;
        }
        else if ($estado == 5) //Real
        {
            $tipo = 3;
        }
        else if ($estado == 7) //Fraccion
        {
            $tipo = 2;
        }
        else if ($estado == 8) //ordinal
        {
            $tipo = 4;
        }
        else //Error
        {
            $tipo = 0;
        }

        $tipo = $tipo + $positivo;

        return $tipo;
    }
}

?>
