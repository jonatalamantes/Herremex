<?php 

require_once(__DIR__.'/../../Clases/ControladorHerramienta.php');

$nombreHerramienta = $_REQUEST["nombreHerramienta"];
$herramienta = ControladorHerramienta::obtenerHerramientaNombreoID($nombreHerramienta, "-1")[0];

echo $herramienta->getCantidad();

 ?>