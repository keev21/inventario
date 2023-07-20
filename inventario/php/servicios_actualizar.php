<?php
require_once "../inc/session_start.php";
require_once "main.php";

/*== Almacenando id ==*/
$id = limpiar_cadena($_POST['id_servicios']);


/*== Verificando servicios ==*/
$check_servicios = conexion();
$check_servicios = $check_servicios->query("SELECT * FROM servicios WHERE id_servicios='$id'");

if ($check_servicios->rowCount() <= 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El servicios no existe en el sistema
            </div>
        ';
    exit();
} else {
    $datos = $check_servicios->fetch();
}
$check_servicios = null;

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

/*== Actualizar datos ==*/
$actualizar_servicios= conexion();
$actualizar_servicios= $actualizar_servicios->prepare("UPDATE servicios SET id_autos=:autos, 
nombre=:nombre, descripcion=:descripcion, precio=:precio  
where id_servicios =:id");

$marcadores = [
    ":autos" => $id_auto,
    ":nombre" => $nombre_servicio,
    ":descripcion" => $descripcion_servicio,
    ":precio" => $precio_servicio,
    ":id" => $id,
];

if ($actualizar_servicios->execute($marcadores)) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡SERVICIO ACTUALIZADO!</strong><br>
                El servicio  se actualizó con éxito
            </div>
        ';
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el servicio, por favor intente nuevamente
            </div>
        ';
}
$actualizar_servicios= null;

