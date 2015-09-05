<?php
class HerramientaComprada{
private $ID_Herramienta;
private $Cantidad;
private $Identificador;

	public function getIDHerramienta(){return $this->ID_Herramienta;}
	public function setIDHerramienta($x){$this->ID_Herramienta=$x;}
	public function getCantidad(){return $this->Cantidad;}
	public function setCantidad($x){$this->Cantidad=$x;}
	public function getIdentificador(){return $this->Identificador;}
	public function setIdentificador($x){$this->Identificador=$x;}

}

?>