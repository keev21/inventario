<div class="container is-fluid mb-6">
   <br>
    <h2 class="subtitle">Seleccione un empleado</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
    require_once "./php/main.php";

   

    if(!isset($_GET['page'])){
        $pagina=1;

    }else{
        $pagina=(int) $_GET['page'];
        if($pagina<=1){
            $pagina=1;
        }

    }
    $pagina=limpiar_cadena($pagina);
    $url="index.php?vista=usuario_empleado_list&page=";
    $registros=15;
    $busqueda="";
   



    //TODO: conexion al archivo cliente php
    require_once "./php/usuario_empleado_lista.php";
    ?>

</div>