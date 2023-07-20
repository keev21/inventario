<?php
require_once "main.php";
error_reporting(0);
//TODO: almacenando datos
$cedula= limpiar_cadena($_POST['cliente_cedula']);
$fecha = limpiar_cadena($_POST['fecha']);
$servicio = limpiar_cadena($_POST['servicio']);
$subtotal=0;
$iva=0;
$total=0;


//TODO: verificar campos obligatorios
if (
    $cedula == "" || $fecha == "" ||  $servicio == "" 
  ) {
      echo '
      <div class="notification is-danger is-light">
               <strong>¡Ocurrio un error inesperado!</strong><br>
              No has llenado todos los campos que son obligatorios
      </div>';
      exit();
  }
  $guardar_precio = conexion();
$query = $guardar_precio->query("SELECT precio FROM servicios WHERE id_servicios='$servicio'");
if ($query->rowCount() > 0) {
    $row = $query->fetch(); // Obtiene la primera fila de resultados
    $precio = $row['precio']; // Guarda el valor de la columna "precio" en la variable $precio
    $subtotal=$precio;
    $iva=$precio*0.12;

    $total=$subtotal+$iva;
    
    
} 
  $guardar_precio = null;

  

  
//TODO:guardar datos en la bdd
$guardar_facturas = conexion();
$guardar_facturas = $guardar_facturas->prepare("INSERT INTO `facturas`(`id_cedula`, `fecha`, `id_servicios`, `subtotal`, `total`) 
VALUES (:cedula,:fecha,:id_servicios,:subtotal,:total)");

$id_serviciosdores = [
  ":cedula" => $cedula,
  ":fecha" => $fecha,
  ":id_servicios" => $servicio,
  ":subtotal" => $subtotal,
  ":total" => $total

];
$guardar_facturas->execute($id_serviciosdores);

if ($guardar_facturas->rowCount() == 1) {
    echo '
    <article class="message is-success">
  <div class="message-header">
    <p>Factura registrada</p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
  La factura ha sido registrada con éxito
  </div>
</article>
        ';
} else {
    echo '
    <article class="message is-danger">
    <div class="message-header">
      <p>ERROR</p>
      <button class="delete" aria-label="delete"></button>
    </div>
    <div class="message-body">
      Error al guardar la factura, intente nuevamente
    </div>
  </article>
        ';
}
$guardar_facturas=null;
 
 
