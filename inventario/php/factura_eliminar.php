<?php
  $factura_id_del=limpiar_cadena($_GET['factura_id_del']);

  //TODO: verificar factura

  $check_factura= conexion();
  $check_factura=  $check_factura->query("SELECT id_factura FROM facturas WHERE id_factura = '$factura_id_del'");


  if($check_factura->rowCount()==1){

    $eliminar_factura= conexion();
    $eliminar_factura=  $eliminar_factura->prepare("DELETE FROM facturas WHERE id_factura=:id");

    $eliminar_factura->execute([":id"=>$factura_id_del]);
    if(($eliminar_factura->rowCount()==1) )
    {
        echo '
        <div class="notification is-info is-light">
                 <strong>¡Factura Eliminada!</strong><br>
                    Los datos del factura se eliminaron con exito
        </div>';

    }else{
        echo '
        <div class="notification is-danger is-light">
                 <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo eliminar el factura, intente nuevamente
        </div>';

    }
    $eliminar_factura=null;

  }else{
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El factura que intenta eliminar no existe
    </div>';

  }
  $check_factura=null;
 