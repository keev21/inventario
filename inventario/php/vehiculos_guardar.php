<?php
require_once "main.php";

//TODO: almacenando datos
$cedula_v = limpiar_cadena($_POST['cliente_cedula']);

$placa_v = limpiar_cadena($_POST['placa']);
$marca_v = limpiar_cadena($_POST['marca']);

$modelo_v = limpiar_cadena($_POST['modelo']);
$anio_v = limpiar_cadena($_POST['anio']);
$color_v = limpiar_cadena($_POST['color']);

//TODO: verificar campos obligatorios
if (
  $cedula_v == "" || $placa_v == "" ||  $marca_v == "" ||  $modelo_v == "" ||  $anio_v == "" ||
  $color_v == ""
) {
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}


$check_placa = conexion();
$check_placa = $check_placa->query("SELECT placa FROM autos WHERE placa='$placa_v'");
if ($check_placa->rowCount() > 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La placa ingresada ya se encuentra registrada, por favor digite otra
            </div>
        ';
    exit();
}
$check_placa = null;

//TODO:guardar datos en la bdd
$guardar_autos = conexion();
$guardar_autos = $guardar_autos->prepare("INSERT INTO `autos`(`id_cedula`, `placa`, `marca`, `modelo`, `anio`, `color`) 
VALUES (:cedula,:placa,:marca,:modelo,:anio,:color)");

$marcadores = [
  ":cedula" => $cedula_v,
  ":placa" => $placa_v,
  ":marca" => $marca_v,
  ":modelo" => $modelo_v,
  ":anio" => $anio_v,
  ":color" => $color_v

];
$guardar_autos->execute($marcadores);

if ($guardar_autos->rowCount() == 1) {
    echo '
    <article class="message is-success">
  <div class="message-header">
    <p>Vehiculo registrado</p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
  El vehiculo ha sido registrado con éxito
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
      Error al guardar el vehiculo, intente nuevamente
    </div>
  </article>
        ';
}
$guardar_autos=null;
