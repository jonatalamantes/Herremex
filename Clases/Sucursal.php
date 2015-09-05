<?php

require_once(__DIR__.'/Ciudad.php');

class Sucursal{

	private $ID;
	private $Calle;
	private $Colonia;
	private $NoEdificio;
	private $Ciudad;

	public function getID(){return $this->ID;}
	public function setID($x){$this->ID=$x;}
	public function getColonia(){return $this->Colonia;}
	public function setColonia($x){$this->Colonia=$x;}
	public function getCiudad(){return $this->Ciudad;}
	public function setCiudad($x){$this->Ciudad=$x;}
	public function getCalle(){return $this->Calle;}
	public function setCalle($x){$this->Calle=$x;}
	public function getNoEdificio(){return $this->NoEdificio;}
	public function setNoEdificio($x){$this->NoEdificio=$x;}

}
?>