<?php
class Marca{

	private $Abreviatura;
	private $Nombre;
	private $ID;

	public function getAbreviatura(){return $this->Abreviatura;}
	public function setAbreviatura($x){$this->Abreviatura=$x;}
	public function getNombre(){return $this->Nombre;}
	public function setNombre($x){$this->Nombre=$x;}
	public function getID(){return $this->ID;}
	public function setID($x){$this->ID=$x;}
}
?>