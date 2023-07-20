<?php
  $usuario_id_del=limpiar_cadena($_GET['usuario_id_del']);

  //TODO: verificar usuario

  $check_usuario= conexion();
  $check_usuario=  $check_usuario->query("SELECT id_usuario FROM usuarios WHERE id_usuario = '$usuario_id_del'");


  if($check_usuario->rowCount()==1){

    $eliminar_usuario= conexion();
    $eliminar_usuario=  $eliminar_usuario->prepare("DELETE FROM usuarios WHERE id_usuario=:id");

    $eliminar_usuario->execute([":id"=>$usuario_id_del]);
    if(($eliminar_usuario->rowCount()==1) )
    {
        echo '
        <div class="notification is-info is-light">
                 <strong>¡Usuario Eliminado!</strong><br>
                    Los datos del usuario se eliminaron con exito
        </div>';

    }else{
        echo '
        <div class="notification is-danger is-light">
                 <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo eliminar el usuario, intente nuevamente
        </div>';

    }
    $eliminar_usuario=null;

  }else{
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El usuario que intenta eliminar no existe
    </div>';

  }
  $check_usuario=null;
 