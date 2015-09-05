<?php
session_start();

require('fpdf17/fpdf.php');
require(__DIR__."/../ControladorCompraVenta.php");
require('numerosLetras.php');

class PDF extends FPDF
{
    private $nombreEmpresa;
    private $sucursalColonia;
    private $direccionSucursal;
    private $ciudadSucursal;
    private $noFactura;
    private $fecha;
    private $nombreCliente;
    private $clienteRFC;
    private $direccionCliente;
    private $productos;
    private $importe;
    private $subtotal;
    private $iva;
    private $total;
    private $logo;
    private $logoAgua;

    //Constructor function
    public function __construct($idCompra = 1)
    {
        //Defiene a constructor
        parent::FPDF();

        $this->nombreEmpresa = "Herremex";
        $this->iva = 16;
        $this->logo = __DIR__."/logo.png";
        $this->logoAgua = __DIR__."/logoAgua.png";

        $this->getCompra($idCompra);
    }

    /** DE Base de DAtos */
    function getCompra($idCompra = 1)
    {
        $compra = ControladorCompraVenta::obtenerCompraVentaID($idCompra);

        $cliente = $compra->getCliente();
        $this->nombreCliente = $cliente->getNombre();
        $this->clienteRFC = $cliente->getRFC();
        $this->direccionCliente = $cliente->getCalle() . ' #' . $cliente->getNoEdificio() . ' En ' . $cliente->getCiudad()->getNombre();

        $sucursal = $compra->getSucursal();
        $this->direccionSucursal = $sucursal->getCalle() . ' #' . $sucursal->getNoEdificio();
        $this->sucursalColonia = $sucursal->getColonia();
        $this->ciudadSucursal = $sucursal->getCiudad()->getNombre();
            
        $productos  = $compra->getHerramientaComprada()->getIDHerramienta();
        $cantidades = $compra->getHerramientaComprada()->getCantidad();
        $total = 0;
        $arrayName = array();

        foreach ($productos as $key => $value) 
        {
            $herramienta = ControladorHerramienta::obtenerHerramientaID($value);
            $precio = $herramienta->getPrecio();
            $subtotal = $herramienta->getPrecio() * $cantidades[$key];
            $arrayName[] = array($cantidades[$key], $herramienta->getNombre(), $precio, $subtotal);
            $total = $total + $subtotal;
        }

        $this->productos = $arrayName;
        $this->subtotal = $total;
        $this->total = ($this->iva/100 + 1) * $total;
        $this->noFactura = $idCompra;
        $this->setFecha($compra->getFecha());
    }

    /** Getters */
    function getNombreEmpresa()
    {
        return $this->nombreEmpresa;
    }

    function getSucursalColonia()
    {
        return $this->sucursalColonia;
    }

    function getDireccionSucursal()
    {
        return $this->direccionSucursal;
    }

    function getCiudadSucursal()
    {
        return $this->ciudadSucursal;
    }

    function getNoFactura()
    {
        return $this->noFactura;
    }

    function getFecha()
    {
        return $this->fecha;
    }

    function getNombreCliente()
    {
        return $this->nombreCliente;
    }

    function getClienteRFC()
    {
        return $this->clienteRFC;
    }

    function getDireccionCliente()
    {
        return $this->direccionCliente;
    }

    function getProductos()
    {
        return $this->productos;
    }

    function getImporte()
    {
        return $this->importe;
    }

    function getSubtotal()
    {
        return $this->subtotal;
    }

    function getIva()
    {
        return $this->iva;
    }

    function getTotal()
    {
        return $this->total;
    }

    function getLogo()
    {
        return $this->logo;
    }

    function getLogoAgua()
    {
        return $this->logoAgua;
    }

    /** Setters */
    function setNombreEmpresa($nombre)
    {
        $this->nombreEmpresa = $nombre;
    }

    function setSucursalColonia($RFC)
    {
        $this->sucursalColonia = $RFC;
    }

    function setDireccionSucursal($direccion)
    {
        $this->direccionSucursal = $direccion;
    }

    function setCiudadSucursal($direccion)
    {
        $this->ciudadSucursal = $direccion;
    }

    function setNoFactura($numero)
    {
        $this->noFactura = $numero;
    }

    function setFecha($unaFecha)
    {
        $this->fecha = $unaFecha;
    }

    function setNombreCliente($nombreCliente)
    {
        $this->nombreCliente = $nombrecliete;
    }

    function setClienteRFC($RFC)
    {
        $this->clienteRFC = $RFC;
    }

    function setDireccionCliente($direccion)
    {
        $this->direccionCliente = $direccion;
    }

    function setProductos($productos)
    {
        $this->productos = $productos;
    }

    function setImporte($import)
    {
        $this->importe = $import;
    }

    function setSubtotal($sub)
    {
        $this->subtotal = $sub;
    }

    function setIva($impuesto)
    {
        $this->iva = $impuesto;
    }

    function setTotal($final)
    {
        $this->total = $final;
    }

    function setLogo($ubicacion)
    {
        $this->logo = $ubicacion;
    }

    function setLogoAgua($ubicacion)
    {
        $this->logoAgua = $ubicacion;
    }

    // Cabecera de página
    function Header()
    {
    	$this->Image($this->getLogoAgua(), 10, 90, 190);
        $this->Image($this->getLogo(), 10, 9.66, null, 30);
        $this->SetLineWidth(0.3);
        $this->SetDrawColor(0,0,0);

        //Nombre de la Empresa
        $this->SetFont('Arial','B', 12);
        $this->Cell(40);
        $this->Cell(110,6,$this->getNombreEmpresa(), 0, 0, 'C');

        //Tabla del Numero de Facturas
        $this->SetFont('Times', 'B', 12);
        $this->SetFillColor(17, 55, 144);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(40, 6, "Compra No.", 1, 0, 'C', 1);
        $this->Ln(6);

        //Dirección de sucursal
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(0,0,0);
        $this->Cell(40);
        $this->Cell(110,6,$this->getDireccionSucursal(), 0, 0, 'C');

        //Numero de Factura
        $this->SetFont('Times','B',12);
        $this->SetTextColor(0,0,0);
        $this->Cell(40, 6, sprintf("%07d", $this->getNoFactura()), 1, 0, 'C');
        $this->Ln(6);

        //Colonia De la sucursal
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(40);
        $this->Cell(110,6,$this->getSucursalColonia(), 0, 0, 'C');
        $this->Ln(6);

        //Ciudad de Sucursal
        $this->Cell(40);
        $this->Cell(110,6,$this->getCiudadSucursal(), 0, 0, 'C');

        //Tabla de Fecha de la factura
        $this->SetFont('Times','B',12);
        $this->SetFillColor(17,55,144);
        $this->SetTextColor(255,255,255);
        $this->Cell(40, 6, "Fecha", 1, 0, 'C', 1);
        $this->Ln(6);

        //Fecha de la factura
        $this->Cell(150);
        $this->SetFont('Times','B',12);
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0,0,0);
        $this->Cell(40, 6, $this->getFecha(), 1, 0, 'C', 1);
        $this->Ln(10);

        //Tabla para lo cliente
        $this->Cell(0.1);
        $this->SetLineWidth(0.5);
        $this->SetFont('Courier','B',12);
        $this->SetTextColor(0,0,0);
        $this->SetDrawColor(140, 6, 6);
        $this->Cell(30,9," Cliente:    ", 1, 0, 'L');
        $this->Cell(160,9," ".$this->getNombreCliente(), 1, 1, 'L');

        $this->Cell(0.1);
        $this->Cell(30,9," RFC:    ", 1, 0, 'L');
        $this->Cell(160,9," ".$this->getClienteRFC(), 1, 1, 'L');

        $this->Cell(0.1);
        $this->Cell(30,9,iconv('utf-8', 'cp1252', " Dirección:  "), 1, 0, 'L');
        $this->Cell(160,9," ".$this->getDireccionCliente(), 1, 1, 'L');
        $this->Ln(5);

        //Espeficicaciones del titulo
        $this->SetFont('Helvetica','B',12);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(109, 212, 69);
        $this->SetTextColor(16, 12, 42);
        $this->SetLineWidth(0.5);
        
        //Titulo de tabla
        $this->Cell(0.1);
        $this->Cell(20, 9, "Cantidad", 1, 0, 'C', 1);
        $this->Cell(100, 9, iconv('utf-8', 'cp1252', " Descripción"), 1, 0, 'C', 1);
        $this->Cell(33, 9, "Precio", 1, 0, 'C', 1);
        $this->Cell(37, 9, "Importe", 1, 0, 'C', 1);
        $this->Ln(9);
    }

    //Tabla de Productos comprados
    function table()
    {
        //Especificaciones de cada producto
        $this->SetFont('Times','B',12);
        $this->SetFillColor(12, 152, 2);
        $this->SetLineWidth(0.5);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);

        $i = 0;
        //Tabla de productos
        foreach ($this->getProductos() as $producto) 
        {
            if ($i % 20 == 0 && $i != 0)
            {
                $this->Cell(20,  9, "", 'T');
                $this->Cell(100, 9, "", 'T');
                $this->Cell(33,  9, "", 'T');
                $this->Cell(37,  9, "", 'T');
                $this->Ln(5);

                $this->AddPage();
            }

            $this->Cell(20,  9, $producto[0], 'LR', 0, 'L'); //Cantidad
            $this->Cell(100, 9, $producto[1], 'LR', 0, 'L'); //Nombre
            $this->Cell(33,  9, $producto[2], 'LR', 0, 'L'); //Precio
            $this->Cell(37,  9, $producto[3], 'LR', 0, 'L'); //Subtotal
            $this->Ln(9);
            $i++;
        }

        $this->Cell(20, 9, "", 'T');
        $this->Cell(100, 9, "", 'T');
        $this->Cell(33, 9, "", 'T');
        $this->Cell(37, 9, "", 'T');
        $this->Ln(5);

        //Especificacions del pie de tabla
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(117, 180, 122);  

        //Pie de Tabla
        $this->Cell(130, 9, "CANTIDAD EN LETRA", 'LRT', 0, 'C');
        $this->Cell(23, 9, "Sub-Total:", 0, 0, 'R', 0);
        $this->Cell(37, 9, $this->getSubtotal(), 1, 0, 'C', 1);
        $this->Ln(9);

        $this->Cell(130, 9, "", 'LR');
        $this->Cell(23, 9, "IVA:", 0, 0, 'R');
        $this->Cell(37, 9, strval($this->getIva())."%", 1, 0, 'C', 1);
        $this->Ln(9);

        $this->Cell(130, 9, NumeroLetra::monedaALetra($this->getTotal()), 'LRB', 0, 'C');
        $this->Cell(23, 9, "Total:", 0, 0, 'R');
        $this->Cell(37, 9, $this->getTotal(), 1, 0, 'C', 1);
        $this->Ln(9);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetX(-20);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Creación del objeto de la clase heredada
 
$id = intval($_GET["id"]);

$pdf = new PDF($id);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->table();
$pdf->Output();
?>