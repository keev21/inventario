<?php
  $servicio_id_del=limpiar_cadena($_GET['servicios_id_del']);

  //TODO: verificar servicio

  $check_servicio= conexion();
  $check_servicio=  $check_servicio->query("SELECT id_servicios FROM servicios WHERE id_servicios = '$servicio_id_del'");

  if($check_servicio->rowCount()==1){

    //TODO: validar detalle
    $check_detalle= conexion();
    $check_detalle=  $check_detalle->query("SELECT id_servicios FROM facturas WHERE id_servicios = '$servicio_id_del' LIMIT 1");

    

    if(($check_detalle->rowCount()<=0)){
        
        $eliminar_servicio= conexion();
        $eliminar_servicio=  $eliminar_servicio->prepare("DELETE FROM servicios WHERE id_servicios=:id");

        $eliminar_servicio->execute([":id"=>$servicio_id_del]);
        
        if(($eliminar_servicio->rowCount()==1) )
        {
            echo '
            <div class="notification is-info is-light">
                     <strong>¡servicio Eliminado!</strong><br>
                        Los datos del servicio se eliminaron con exito
            </div>';

        }else{
            echo '
            <div class="notification is-danger is-light">
                     <strong>¡Ocurrio un error inesperado!</strong><br>
                        No se pudo eliminar el servicio, intente nuevamente
            </div>';

        }
        $eliminar_servicio=null;


    }else{
        echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El servicio no se puede eliminar ya que tiene un registro en facturas
    </div>';

    }
    $check_detalle=null;
    

    

  }else{
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El servicio que intenta eliminar no existe
    </div>';

  }
  $check_servicio=null;