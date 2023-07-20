<?php
require_once "../inc/session_start.php";
require_once "main.php";

/*== Almacenando id ==*/

$cedula_cliente = limpiar_cadena($_POST['cliente_cedula']);



/*== Verificando clientes ==*/
$check_clientes = conexion();
$check_clientes = $check_clientes->query("SELECT * FROM clientes WHERE id_cedula='$cedula_cliente'");

if ($check_clientes->rowCount() <= 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El clientes no existe en el sistema
            </div>
        ';
    exit();
} else {
    $datos = $check_clientes->fetch();
}
$check_clientes = null;


/*== Almacenando datos ==*/
$nombre_cliente = limpiar_cadena($_POST['cliente_nombre']);
$apellido_cliente = limpiar_cadena($_POST['cliente_apellido']);

$direccion_cliente = limpiar_cadena($_POST['cliente_direccion']);
$email_cliente = limpiar_cadena($_POST['cliente_email']);
$telefono_cliente = limpiar_cadena($_POST['cliente_telefono']);

//TODO: verificar campos obligatorios
if (
    $cedula_cliente == "" || $nombre_cliente == "" ||  $apellido_cliente == "" ||  $direccion_cliente == "" ||  $email_cliente == "" ||
    $telefono_cliente == ""
) {
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

if ($cedula_cliente != $datos['id_cedula']) {
$check_cedula = conexion();
$check_cedula = $check_cedula->query("SELECT id_cedula FROM clientes WHERE id_cedula='$cedula_cliente'");
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

if ($email_cliente != $datos['email']) {
if (filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
    $check_email = conexion();
    $check_email = $check_email->query("SELECT email FROM clientes WHERE email='$email_cliente'");
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
$actualizar_clientes = conexion();
$actualizar_clientes = $actualizar_clientes->prepare("UPDATE `clientes` SET `nombre`=:nombre,`apellido`=:apellido,`direccion`=:direccion,`telefono`=:telefono,`email`=:email WHERE `id_cedula`=:cedula");

$marcadores = [
   
    ":nombre" => $nombre_cliente,
    ":apellido" => $apellido_cliente,
    ":direccion" => $direccion_cliente,
    ":telefono" => $telefono_cliente,
    ":email" => $email_cliente,
    ":cedula" => $cedula_cliente,
];

if ($actualizar_clientes->execute($marcadores)) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡CLIENTE ACTUALIZADO!</strong><br>
                El cliente se actualizó con éxito
            </div>
        ';
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el cliente, por favor intente nuevamente
            </div>
        ';
}
$actualizar_clientes = null;
