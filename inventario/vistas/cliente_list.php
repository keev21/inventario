<div class="container is-fluid mb-6">
    <h1 class="title">Clientes</h1>
    <h2 class="subtitle">Lista de clientes</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
    require_once "./php/main.php";

    //TODO: Eliminar cliente
    if(isset($_GET['cliente_id_del'])){
        require_once "./php/cliente_eliminar.php";

    }
    
    if(!isset($_GET['page'])){
        $pagina=1;

    }else{
        $pagina=(int) $_GET['page'];
        if($pagina<=1){
            $pagina=1;
        }

    }
    $pagina=limpiar_cadena($pagina);
    $url="index.php?vista=cliente_list&page=";
    $registros=15;
    $busqueda="";
   



    //TODO: conexion al archivo cliente php
    require_once "./php/cliente_lista.php";
    ?>

</div>