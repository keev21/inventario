<?php
  $empleado_id_del=limpiar_cadena($_GET['empleado_id_del']);

  //TODO: verificar empleado

  $check_empleado= conexion();
  $check_empleado=  $check_empleado->query("SELECT id_cedula_empleado FROM empleados WHERE id_cedula_empleado = '$empleado_id_del'");

  if($check_empleado->rowCount()==1){

    //TODO: validar usuario
    $check_usuario= conexion();
    $check_usuario=  $check_usuario->query("SELECT id_cedula_empleado FROM usuarios WHERE id_cedula_empleado = '$empleado_id_del' LIMIT 1");

    

    if(($check_usuario->rowCount()<=0)){
        
        $eliminar_empleado= conexion();
        $eliminar_empleado=  $eliminar_empleado->prepare("DELETE FROM empleados WHERE id_cedula_empleado=:id");

        $eliminar_empleado->execute([":id"=>$empleado_id_del]);
        
        if(($eliminar_empleado->rowCount()==1) )
        {
            echo '
            <div class="notification is-info is-light">
                     <strong>¡empleado Eliminado!</strong><br>
                        Los datos del empleado se eliminaron con éxito
            </div>';

        }else{
            echo '
            <div class="notification is-danger is-light">
                     <strong>¡Ocurrio un error inesperado!</strong><br>
                        No se pudo eliminar el empleado, intente nuevamente
            </div>';

        }
        $eliminar_empleado=null;


    }else{
        echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El empleado no se puede eliminar ya que tiene un usuario establecido
    </div>';

    }
    $check_usuario=null;
    

    

  }else{
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El empleado que intenta eliminar no existe
    </div>';

  }
  $check_empleado=null;
 