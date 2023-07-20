<?php
$modulo_buscador=limpiar_cadena($_POST['modulo_buscador']);
$modulos = ["cliente","vehiculo","inventario","servicio","empleado","usuario","factura"];
if(in_array($modulo_buscador,$modulos)){
    $modulos_url=[
        "cliente"=>"cliente_search",
        "vehiculo"=>"vehiculo_search",
        "inventario"=>"inventario_search",
        "servicio"=>"servicio_search",
        "empleado"=>"empleado_search",
        "usuario"=>"usuario_search",
        "factura"=>"factura_search",

    ];
    $modulos_url=$modulos_url[$modulo_buscador];

    $modulo_buscador="busqueda_".$modulo_buscador;

//TODO: iniciar busqueda
    if(isset($_POST['txt_buscador'])){

        $txt=limpiar_cadena($_POST['txt_buscador']);

        if($txt==""){
            echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            El campo de busqueda esta vacio
    </div>';

        }else{
            if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}", $txt)){
                echo '
                <div class="notification is-danger is-light">
                         <strong>¡Ocurrio un error inesperado!</strong><br>
                        El termino de busqueda no coincide con el fornato solicitado
                </div>';

            }
            else{
                $_SESSION[$modulo_buscador]=$txt;
                //header("Location:index.php?vista=$modulos_url", true, 303);
                echo"<script>window.location.href='index.php?vista=$modulos_url';</script>";
                exit();

            }
        }


    }
//TODO: eliminar busqueda
    if(isset($_POST['eliminar_buscador'])){
       unset($_SESSION[$modulo_buscador]);
       echo"<script>window.location.href='index.php?vista=$modulos_url';</script>";
        exit();

    }

}else{
    echo '
    <div class="notification is-danger is-light">
             <strong>¡Ocurrio un error inesperado!</strong><br>
            No se puede procesar la peticion
    </div>';

}
