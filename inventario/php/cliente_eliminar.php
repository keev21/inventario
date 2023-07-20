<?php
  $cliente_id_del=limpiar_cadena($_GET['cliente_id_del']);

  //TODO: verificar cliente

  $check_cliente= conexion();
  $check_cliente=  $check_cliente->query("SELECT id_cedula FROM clientes WHERE id_cedula = '$cliente_id_del'");

  if($check_cliente->rowCount()==1){

    //TODO: validar vehiculo
    $check_vehiculo= conexion();
    $check_vehiculo=  $check_vehiculo->query("SELECT id_cedula FROM autos WHERE id_cedula = '$cliente_id_del' LIMIT 1");

    //TODO: validar factura
    $check_factura= conexion();
    $check_factura=  $check_factura->query("SELECT id_cedula FROM facturas WHERE id_cedula='$cliente_id_del' LIMIT 1");

    if(($check_vehiculo->rowCount()<=0)  && $check_factura->rowCount() <= 0){
        
        $eliminar_cliente= conexion();
        $eliminar_cliente=  $eliminar_cliente->prepare("DELETE FROM clientes WHERE id_cedula=:id");

        $eliminar_cliente->execute([":id"=>$cliente_id_del]);
        
        if(($eliminar_cliente->rowCount()==1) )
        {
            echo '
            <div class="notification is-info is-light">
                     <strong>¡Cliente Eliminado!</strong><br>
                        Los datos del cliente se eliminaron con exito
            </div>';

        }else{
            echo '
            <div class="notification is-danger is-light">
                     <strong>¡Ocurrio un error inesperado!</strong><br>
                        No se pudo eliminar el cliente, intente nuevamente
            </div>';

        }
        $eliminar_cliente=null;


    }else{
        echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El cliente no se puede eliminar ya que tiene vehiculos o facturas registradas
    </div>';

    }
    $check_vehiculo=null;
    $check_factura=null;

    

  }else{
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El cliente que intenta eliminar no existe
    </div>';

  }
  $check_cliente=null;
 