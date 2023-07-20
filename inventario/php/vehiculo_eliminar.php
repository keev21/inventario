<?php
  $vehiculo_id_del=limpiar_cadena($_GET['vehiculo_id_del']);

  //TODO: verificar vehiculo

  $check_vehiculo= conexion();
  $check_vehiculo=  $check_vehiculo->query("SELECT id_autos FROM autos WHERE id_autos = '$vehiculo_id_del'");

  //TODO: validar servicios
  $check_servicios= conexion();
  $check_servicios=  $check_servicios->query("SELECT id_autos FROM servicios WHERE id_autos='$vehiculo_id_del' LIMIT 1");

  if($check_servicios->rowCount()<=0){

    $eliminar_vehiculo= conexion();
    $eliminar_vehiculo=  $eliminar_vehiculo->prepare("DELETE FROM autos WHERE id_autos=:id");

    $eliminar_vehiculo->execute([":id"=>$vehiculo_id_del]);
    
    if(($eliminar_vehiculo->rowCount()==1) )
    {
        echo '
        <div class="notification is-info is-light">
                 <strong>¡Vehiculo Eliminado!</strong><br>
                    Los datos del vehiculo se eliminaron con exito
        </div>';

    }else{
        echo '
        <div class="notification is-danger is-light">
                 <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo eliminar el vehiculo, intente nuevamente
        </div>';

    }
    $eliminar_vehiculo=null;

  }else{
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El vehiculo  no se puede eliminar ya que tiene un servicio registrado
    </div>';

  }
  $check_vehiculo=null;
 