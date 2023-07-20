<?php
require_once "../inc/session_start.php";
require_once "main.php";
error_reporting(0);
$id = limpiar_cadena($_POST['id_factura']);
/*== Verificando facturas ==*/
$check_facturas = conexion();
$check_facturas = $check_facturas->query("SELECT * FROM facturas WHERE id_factura='$id'");

if ($check_facturas->rowCount() <= 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La factura no existe en el sistema
            </div>
        ';
    exit();
} else {
    $datos = $check_facturas->fetch();
}
$check_facturas = null;



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

  /*== Actualizar datos ==*/
$actualizar_facturas = conexion();
$actualizar_facturas = $actualizar_facturas->prepare("UPDATE facturas SET id_cedula =:cedula, fecha=:fecha, id_servicios=:id_servicios, subtotal=:subtotal ,total=:total   where id_factura=:id");

$marcadores = [
    ":cedula" => $cedula,
    ":fecha" => $fecha,
    ":id_servicios" => $servicio,
    ":subtotal" => $subtotal,
    ":total" => $total,
  ":id" => $id
];

if ($actualizar_facturas->execute($marcadores)) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡facturas ACTUALIZADA!</strong><br>
                La factura se actualizó con éxito
            </div>
        ';
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar la factura, por favor intente nuevamente
            </div>
        ';
}
$actualizar_facturas = null;
