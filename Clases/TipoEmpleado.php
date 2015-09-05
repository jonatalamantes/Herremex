<?php
class TipoEmpleado {
    
	private $Abreviatura;
	private $Nombre;
	private $Comision;

	function TipoEmpleado(){}
	public function getAbreviatura(){return $this->Abreviatura;}
	public function setAbreviatura($x){$this->Abreviatura=$x;}
	public function getNombre(){return $this->Nombre;}
	public function setNombre($x){$this->Nombre=$x;}
	public function getComision(){return $this->Comision;}
	public function setComision($x){$this->Comision=$x;}
	}

?>