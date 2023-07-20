<?php
require_once "main.php";
 

//TODO: almacenando datos
$cedula_empleado = limpiar_cadena($_POST['empleado_cedula']);

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

if ($email_empleado != "") {
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
$cedula_empleado = limpiar_cadena($_POST['empleado_cedula']);
if (validarCedulaEcuatoriana($cedula_empleado)) {
    
    //TODO:guardar datos en la bdd
$guardar_empleados = conexion();
$guardar_empleados = $guardar_empleados->prepare("INSERT INTO `empleados`(`id_cedula_empleado`, `nombre`, `apellido`, `direccion`, `telefono`, `email`) 
VALUES (:cedula,:nombre,:apellido,:direccion,:telefono,:email)");

$marcadores = [
    ":cedula" => $cedula_empleado,
    ":nombre" => $nombre_empleado,
    ":apellido" => $apellido_empleado,
    ":direccion" => $direccion_empleado,
    ":telefono" => $telefono_empleado,
    ":email" => $email_empleado,

];
$guardar_empleados->execute($marcadores);

if ($guardar_empleados->rowCount() == 1) {
    echo '
    <article class="message is-success">
  <div class="message-header">
    <p>EMPLEADO REGISTRADO</p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
  El empleado ha sido registrado con éxito
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
      Error al guardar el empleado, intente nuevamente
    </div>
  </article>
        ';
}
$guardar_empleados=null;

} else {
    echo '
    <article class="message is-danger">
    <div class="message-header">
      <p>ERROR</p>
      <button class="delete" aria-label="delete"></button>
    </div>
    <div class="message-body">
      La cedula es invalida, ingrese nuevamente
    </div>
  </article>
        ';
}



