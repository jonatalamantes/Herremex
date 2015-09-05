<?php
class CompraVenta{

private $ID;
private $Sucursal;
private $Cliente;
private $Herramienta_Comprada;
private $EnvioDomicilio;
private $Facturar;
private $Fecha;

	public function getID(){return $this->ID;}
	public function setID($x){$this->ID=$x;}
	public function getSucursal(){return $this->Sucursal;}
	public function setSucursal($x){$this->Sucursal=$x;}
	public function getCliente(){return $this->Cliente;}
	public function setCliente($x){$this->Cliente=$x;}
	public function getHerramientaComprada(){return $this->Herramienta_Comprada;}
	public function setHerramientaComprada($x){$this->Herramienta_Comprada=$x;}
	public function getEnvioDomicilio(){return $this->EnvioDomicilio;}
	public function setEnvioDomicilio($x){$this->EnvioDomicilio=$x;}
	public function getFacturar(){return $this->Facturar;}
	public function setFacturar($x){$this->Facturar=$x;}
	public function getFecha(){return $this->Fecha;}
	public function setFecha($x){$this->Fecha=$x;}


}

?>