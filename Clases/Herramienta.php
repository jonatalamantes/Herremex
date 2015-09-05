<?php

require_once(__DIR__.'/Marca.php');
require_once(__DIR__.'/TipoHerramienta.php');

class Herramienta
{
	private $ID;
	private $Nombre;
	private $Tipo;
	private $Precio;
	private $Cantidad;
	private $Marca;
	private $Calidad;
	private $PrecioCompra;

	public function getID(){return $this->ID;}
	public function setID($x){$this->ID=$x;}
	public function getNombre(){return $this->Nombre;}
	public function setNombre($x){$this->Nombre=$x;}
	public function getTipo(){return $this->Tipo;}
	public function setTipo($x){$this->Tipo=$x;}
	public function getPrecio(){return $this->Precio;}
	public function setPrecio($x){$this->Precio=$x;}
	public function getCantidad(){return $this->Cantidad;}
	public function setCantidad($x){$this->Cantidad=$x;}
	public function getCalidad(){return $this->Calidad;}
	public function setCalidad($x){$this->Calidad=$x;}
	public function getMarca(){return $this->Marca;}
	public function setMarca($x){$this->Marca=$x;}
	public function getPrecioCompra(){return $this->PrecioCompra;}
	public function setPrecioCompra($x){$this->PrecioCompra = $x;}
}

?>