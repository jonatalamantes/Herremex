<?php
class Ciudad {
    
	private $Abreviatura;
	private $Nombre;

	function Ciudad(){}
	public function getAbreviatura(){return $this->Abreviatura;}
	public function setAbreviatura($x){$this->Abreviatura=$x;}
	public function getNombre(){return $this->Nombre;}
	public function setNombre($x){$this->Nombre=$x;}
}

?>