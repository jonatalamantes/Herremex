<?php
class Cliente{
	private $ID;
	private $RFC;
	private $Nombre;
	private $Sexo;
	private $Regimen;
	private $Calle;
	private $NoEdificio;
	private $Ciudad;

	public function getID(){return $this->ID;}
	public function setID($x){$this->ID=$x;}
	public function getNombre(){return $this->Nombre;}
	public function setNombre($x){$this->Nombre=$x;}
	public function getCiudad(){return $this->Ciudad;}
	public function setCiudad($x){$this->Ciudad=$x;}
	public function getRFC(){return $this->RFC;}
	public function setRFC($x){$this->RFC=$x;}
	public function getSexo(){return $this->Sexo;}
	public function setSexo($x){$this->Sexo=$x;}
	public function getRegimen(){return $this->Regimen;}
	public function setRegimen($x){$this->Regimen=$x;}
	public function getCalle(){return $this->Calle;}
	public function setCalle($x){$this->Calle=$x;}
	public function getNoEdificio(){return $this->NoEdificio;}
	public function setNoEdificio($x){$this->NoEdificio=$x;}

}

?>