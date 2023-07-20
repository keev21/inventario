<?php
require_once "../inc/session_start.php";
require_once "main.php";

/*== Almacenando id ==*/

$cedula_empleado = limpiar_cadena($_POST['empleado_cedula']);



/*== Verificando empleados ==*/
$check_empleados = conexion();
$check_empleados = $check_empleados->query("SELECT * FROM empleados WHERE id_cedula_empleado='$cedula_empleado'");

if ($check_empleados->rowCount() <= 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El empleados no existe en el sistema
            </div>
        ';
    exit();
} else {
    $datos = $check_empleados->fetch();
}
$check_empleados = null;


/*== Almacenando datos ==*/
$nombre_empleado = limpiar_cadena($_POST['empleado_nombre']);
$apellido_empleado = limpiar_cadena($_POST['empleado_apellido']);

$direccion_empleado = limpiar_cadena($_POST['empleado_direccion']);
$email_empleado = limpiar_cadena($_POST['empleado_email']);
$telefono_empleado = limpiar_cadena($_POST['empleado_telefono']);

//TODO: verificar campos obligatorios
if (
    $cedula_empleado == "" || $nombre_empleado == "" ||  $apellido_empleado == "" ||  $direccion_empleado == "" ||  $email_empleado == "" ||
    $telefono_empleado == ""
) {
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

if ($cedula_empleado != $datos['id_cedula_empleado']) {
$check_cedula = conexion();
$check_cedula = $check_cedula->query("SELECT id_cedula_empleado FROM empleados WHERE id_cedula_empleado='$cedula_empleado'");
if ($check_cedula->rowCount() > 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La cedula ingresada ya se encuentra registrada, por favor digite otra
            </div>
        ';
    exit();
}
}
$check_cedula = null;

if ($email_empleado != $datos['email']) {
if (filter_var($email_empleado, FILTER_VALIDATE_EMAIL)) {
    $check_email = conexion();
    $check_email = $check_email->query("SELECT email FROM empleados WHERE email='$email_empleado'");
    if ($check_email->rowCount() > 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El correo electrónico ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_email = null;
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Ha ingresado un correo electrónico no valido
        </div>
    ';
    exit();
}
}

/*== Actualizar datos ==*/
$actualizar_empleados = conexion();
$actualizar_empleados = $actualizar_empleados->prepare("UPDATE `empleados` SET `nombre`=:nombre,`apellido`=:apellido,`direccion`=:direccion,`telefono`=:telefono,`email`=:email WHERE `id_cedula_empleado`=:cedula");

$marcadores = [
   
    ":nombre" => $nombre_empleado,
    ":apellido" => $apellido_empleado,
    ":direccion" => $direccion_empleado,
    ":telefono" => $telefono_empleado,
    ":email" => $email_empleado,
    ":cedula" => $cedula_empleado,
];

if ($actualizar_empleados->execute($marcadores)) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡EMPLEADO ACTUALIZADO!</strong><br>
                El empleado se actualizó con éxito
            </div>
        ';
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el empleado, por favor intente nuevamente
            </div>
        ';
}
$actualizar_empleados = null;
