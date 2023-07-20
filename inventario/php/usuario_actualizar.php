<?php
require_once "../inc/session_start.php";
require_once "main.php";
error_reporting(0);

/*== Almacenando id ==*/
$id = limpiar_cadena($_POST['id_usuario']);


/*== Verificando usuarios ==*/
$check_usuarios = conexion();
$check_usuarios = $check_usuarios->query("SELECT * FROM usuarios WHERE id_usuario='$id'");

if ($check_usuarios->rowCount() <= 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuarios no existe en el sistema
            </div>
        ';
    exit();
} else {
    $datos = $check_usuarios->fetch();
}
$check_usuarios = null;

/*== Almacenando datos ==*/
$cedula_empleado = limpiar_cadena($_POST['usuario_cedula']);

$username = limpiar_cadena($_POST['usuario_username']);
$contrasenia = limpiar_cadena($_POST['usuario_clave']);
$tipo = limpiar_cadena($_POST['usuario_tipo']);





//TODO: verificar campos obligatorios
if ($cedula_empleado == "" || $username == "" ||  $contrasenia == "" ||  $tipo == "") {
    echo '
      <div class="notification is-danger is-light">
               <strong>¡Ocurrio un error inesperado!</strong><br>
              No has llenado todos los campos que son obligatorios
      </div>';
    exit();
}


if ($cedula_empleado != $datos['id_cedula_empleado']) {
    $check_cedula = conexion();
    $check_cedula = $check_cedula->query("SELECT id_cedula_empleado FROM usuarios WHERE id_cedula_empleado='$cedula_empleado'");

    if ($check_cedula->rowCount() > 0) {
        echo '
                      <div class="notification is-danger is-light">
                          <strong>¡Ocurrio un error inesperado!</strong><br>
                          El usuario ya se encuentra registrado, por favor elige otro
                      </div>
                  ';
        exit();
    }
    $check_cedula = null;
}
if ($username != $datos['username']) {
$check_username = conexion();
$check_username = $check_username->query("SELECT username FROM usuarios WHERE username='$username'");
if ($check_username->rowCount() > 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El username ingresado ya se encuentra registrado, por favor digite otro
            </div>
        ';
    exit();
}
$check_username = null;
}



/*== Actualizar datos ==*/
$actualizar_usuarios = conexion();
$actualizar_usuarios = $actualizar_usuarios->prepare("UPDATE usuarios SET id_cedula_empleado=:cedula, username=:username, contrasenia=:contrasenia, tipo=:tipo where id_usuario=:id");

$marcadores = [
    ":cedula" => $cedula_empleado,
    ":username" => $username,
    ":contrasenia" => $contrasenia,
    ":tipo" => $tipo,
    ":id" => $id,
];

if ($actualizar_usuarios->execute($marcadores)) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO ACTUALIZADO!</strong><br>
                El usuario se actualizó con éxito
            </div>
        ';
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el usuario, por favor intente nuevamente
            </div>
        ';
}
$actualizar_usuarios = null;
