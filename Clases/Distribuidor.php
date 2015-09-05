<?php
class Distribuidor{

	private $ID;
	private $Direccion;
	private $Nombre;
    private $Herramienta;

	public function getID(){return $this->ID;}
	public function setID($x){$this->ID=$x;}
	public function getDireccion(){return $this->Direccion;}
	public function setDireccion($x){$this->Direccion=$x;}
	public function getNombre(){return $this->Nombre;}
	public function setNombre($x){$this->Nombre=$x;}
    public function getHerramienta(){return $this->Herramienta;}
    public function setHerramienta($x){$this->Herramienta=$x;}

}
?>