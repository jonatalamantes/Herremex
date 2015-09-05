
<?php

class Turno {
    
	private $Abreviatura;
	private $Nombre;
	private $Horas;
	private $Inicio;

	function Turno(){}
	public function getAbreviatura(){return $this->Abreviatura;}
	public function setAbreviatura($x){$this->Abreviatura=$x;}
	public function getNombre(){return $this->Nombre;}
	public function setNombre($x){$this->Nombre=$x;}
	public function getHoras(){return $this->Horas;}
	public function setHoras($x){$this->Horas=$x;}
	public function getAInicio(){return $this->Inicio;}
	public function setInicio($x){$this->Inicio=$x;}
	}

?>
