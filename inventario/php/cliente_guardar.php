<?php
require_once "main.php";

//TODO: almacenando datos
$cedula_cli = limpiar_cadena($_POST['cliente_cedula']);

$nombre_cli = limpiar_cadena($_POST['cliente_nombre']);
$apellido_cli = limpiar_cadena($_POST['cliente_apellido']);

$direccion_cli = limpiar_cadena($_POST['cliente_direccion']);
$email_cli = limpiar_cadena($_POST['cliente_email']);
$telefono_cli = limpiar_cadena($_POST['cliente_telefono']);

//TODO: verificar campos obligatorios
if (
    $cedula_cli == "" || $nombre_cli == "" ||  $apellido_cli == "" ||  $direccion_cli == "" ||  $email_cli == "" ||
    $telefono_cli == ""
) {
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

if ($email_cli != "") {
    if (filter_var($email_cli, FILTER_VALIDATE_EMAIL)) {
        $check_email = conexion();
        $check_email = $check_email->query("SELECT email FROM clientes WHERE email='$email_cli'");
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

$check_cedula = conexion();
$check_cedula = $check_cedula->query("SELECT id_cedula FROM clientes WHERE id_cedula='$cedula_cli'");
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
function validarCedulaEcuatoriana($cedula)
{
    // Verificar si la cédula tiene 10 dígitos
    if (strlen($cedula) !== 10) {
        return false;
    }

    // Verificar el primer dígito (provincia)
    $provincia = substr($cedula, 0, 2);
    if ($provincia < 1 || $provincia > 24) {
        return false;
    }

    // Verificar el tercer dígito (primer dígito del último bloque)
    $tercerDigito = (int)substr($cedula, 2, 1);
    if ($tercerDigito < 0 || $tercerDigito > 5) {
        return false;
    }

    // Verificar el último dígito (dígito verificador)
    $coeficientes = array(2, 1, 2, 1, 2, 1, 2, 1, 2);
    $verificador = (int)substr($cedula, -1);
    $suma = 0;

    for ($i = 0; $i < 9; $i++) {
        $digito = (int)substr($cedula, $i, 1);
        $producto = $digito * $coeficientes[$i];

        if ($producto >= 10) {
            $producto -= 9;
        }

        $suma += $producto;
    }

    $suma = 10 - ($suma % 10);
    $suma = ($suma === 10) ? 0 : $suma;

    if ($suma !== $verificador) {
        return false;
    }

    return true;
}

// Uso de la función para validar la cédula
$cedula_cli = limpiar_cadena($_POST['cliente_cedula']);
if (validarCedulaEcuatoriana($cedula_cli)) {
    
    //TODO:guardar datos en la bdd
$guardar_cliente = conexion();
$guardar_cliente = $guardar_cliente->prepare("INSERT INTO `clientes`(`id_cedula`, `nombre`, `apellido`, `direccion`, `telefono`, `email`) 
VALUES (:cedula,:nombre,:apellido,:direccion,:telefono,:email)");

$marcadores = [
    ":cedula" => $cedula_cli,
    ":nombre" => $nombre_cli,
    ":apellido" => $apellido_cli,
    ":direccion" => $direccion_cli,
    ":telefono" => $telefono_cli,
    ":email" => $email_cli,

];
$guardar_cliente->execute($marcadores);

if ($guardar_cliente->rowCount() == 1) {
    echo '
    <article class="message is-success">
  <div class="message-header">
    <p>Cliente registrado</p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
  El cliente ha sido registrado con exito
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
      Error al guardar el cliente, intente nuevamente
    </div>
  </article>
        ';
}
$guardar_cliente=null;
} else {
    echo '
    <article class="message is-danger">
    <div class="message-header">
      <p>ERROR</p>
      <button class="delete" aria-label="delete"></button>
    </div>
    <div class="message-body">
      La cedula es inválida
    </div>
  </article>
        ';
}



