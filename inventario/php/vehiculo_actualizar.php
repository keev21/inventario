<?php
require_once "../inc/session_start.php";
require_once "main.php";

/*== Almacenando id ==*/
$id = limpiar_cadena($_POST['id_autos']);


/*== Verificando autos ==*/
$check_autos = conexion();
$check_autos = $check_autos->query("SELECT * FROM autos WHERE id_autos='$id'");

if ($check_autos->rowCount() <= 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El autos no existe en el sistema
            </div>
        ';
    exit();
} else {
    $datos = $check_autos->fetch();
}
$check_autos = null;

/*== Almacenando datos ==*/
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



if ($cedula_v != $datos['id_cedula']) {
    $check_cedula = conexion();
    $check_cedula = $check_cedula->query("SELECT id_cedula FROM autos WHERE id_cedula='$cedula_v'");

    if ($check_cedula->rowCount() > 0) {
        echo '
                      <div class="notification is-danger is-light">
                          <strong>¡Ocurrio un error inesperado!</strong><br>
                          La cedula ingresada ya se encuentra registrada, por favor digite otra
                      </div>
                  ';
        exit();
    }
    $check_cedula = null;
}
if ($placa_v != $datos['placa']) {
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
}

/*== Actualizar datos ==*/
$actualizar_autos = conexion();
$actualizar_autos = $actualizar_autos->prepare("UPDATE autos SET id_cedula =:cedula, placa=:placa, marca=:marca, modelo=:modelo ,anio=:anio ,color=:color  where id_autos=:id");

$marcadores = [
  ":cedula" => $cedula_v,
  ":placa" => $placa_v,
  ":marca" => $marca_v,
  ":modelo" => $modelo_v,
  ":anio" => $anio_v,
  ":color" => $color_v,
  ":id" => $id
];

if ($actualizar_autos->execute($marcadores)) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡VEHICULO ACTUALIZADO!</strong><br>
                El vehiculo se actualizó con éxito
            </div>
        ';
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el vehiculo, por favor intente nuevamente
            </div>
        ';
}
$actualizar_autos = null;













