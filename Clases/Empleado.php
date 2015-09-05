<?php

require_once(__DIR__.'/TipoEmpleado.php');
require_once(__DIR__.'/Ciudad.php');
require_once(__DIR__.'/Turno.php');

class Empleado {
    
	private $ID;
	private $CURP;
	private $Nombre;
	private $SegundoNombre;
	private $ApellidoPaterno;
	private $ApellidoMaterno;	
	private $Calle;
	private $Colonia;
	private $NoCasaExt;
	private $NoCasaInt;
	private $Password;
	private $Turno;
	private $TipoEmpleado;
	private $Ciudad;
	private $Sucursal;

	function Empleado(){}
	public function getID(){return $this->ID;}
	public function setID($x){$this->ID=$x;}
	public function getNombre(){return $this->Nombre;}
	public function setNombre($x){$this->Nombre=$x;}
	public function getCURP(){return $this->CURP;}
	public function setCURP($x){$this->CURP=$x;}
	public function getSegundoNombre(){return $this->SegundoNombre;}
	public function setSegundoNombre($x){$this->SegundoNombre=$x;}
	public function getApellidoPaterno(){return $this->ApellidoPaterno;}
	public function setApellidoPaterno($x){$this->ApellidoPaterno=$x;}
	public function getApellidoMaterno(){return $this->ApellidoMaterno;}
	public function setApellidoMaterno($x){$this->ApellidoMaterno=$x;}
	public function getCalle(){return $this->Calle;}
	public function setCalle($x){$this->Calle=$x;}
	public function getColonia(){return $this->Colonia;}
	public function setColonia($x){$this->Colonia=$x;}
	public function getNoCasaExt(){return $this->NoCasaExt;}
	public function setNoCasaExt($x){$this->NoCasaExt=$x;}
	public function getNoCasaInt(){return $this->NoCasaInt;}
	public function setNoCasaInt($x){$this->NoCasaInt=$x;}
	public function getPassword(){return $this->Password;}
	public function setPassword($x){$this->Password=$x;}
	public function getTurno(){return $this->Turno;}
	public function setTurno($x){$this->Turno=$x;}
	public function getTipoEmpleado(){return $this->TipoEmpleado;}
	public function setTipoEmpleado($x){$this->TipoEmpleado=$x;}
	public function getCiudad(){return $this->Ciudad;}
	public function setCiudad($x){$this->Ciudad=$x;}
	public function getSucursal(){return $this->Sucursal;}
	public function setSucursal($x){$this->Sucursal=$x;}

	}

?>