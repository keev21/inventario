<?php
require_once "main.php";
error_reporting(0);
$nombre_servicio = limpiar_cadena($_POST['nombre_servicio']);
$id_auto = limpiar_cadena($_POST['id_carro']);
$descripcion_servicio= limpiar_cadena($_POST['descripcion_servicio']);
$precio_servicio = limpiar_cadena($_POST['precio_servicio']);

//TODO: verificar campos obligatorios
if (
    $nombre_servicio == "" || $descripcion_servicio == "" ||  $precio_servicio == "" || $id_auto=="" 
) {
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//TODO:guardar datos en la bdd
$guardar_servicio= conexion();
$guardar_servicio= $guardar_servicio->prepare("INSERT INTO `servicios`(`id_autos`,`nombre`, `descripcion`, `precio`) 
VALUES (:autos,:nombre,:descripcion,:precio)");

$marcadores = [
  ":autos" => $id_auto,
    ":nombre" => $nombre_servicio,
    ":descripcion" => $descripcion_servicio,
    ":precio" => $precio_servicio,

];
$guardar_servicio->execute($marcadores);

if ($guardar_servicio->rowCount() == 1) {
    echo '
    <article class="message is-success">
  <div class="message-header">
    <p>Servicio registrado</p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
  El servicio ha sido registrado con éxito
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
      Error al guardar el servicio, intente nuevamente
    </div>
  </article>
        ';
}
$guardar_servicio=null;

