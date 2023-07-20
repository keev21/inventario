<?php
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";
if (isset($busqueda) && $busqueda != "") {
    $consulta_datos = "SELECT * FROM facturas WHERE (id_cedula  LIKE '%$busqueda%' )  ORDER BY id_cedula ASC LIMIT $inicio,$registros";

    $consulta_total = "SELECT COUNT(id_factura) FROM facturas WHERE (id_cedula LIKE '%$busqueda%' ) ";
} else {
    $consulta_datos = "SELECT * FROM facturas ORDER BY id_cedula ASC LIMIT $inicio,$registros";

    $consulta_total = "SELECT COUNT(id_factura) FROM facturas";
}
$conexion = conexion();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int) $total->fetchColumn();

$Npaginas = ceil($total / $registros);

$tabla .= '
        <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Id Factura</th>
                    <th>Cedula</th>
                    <th>Fecha</th>
                    
                    <th>total</th>
                    
                    
                    <th colspan="2">Opciones</th>
                    <th>Imprimir</th>
                </tr>
            </thead>
            <tbody>

    
    ';

if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;
    foreach ($datos as $rows) {
        $tabla .= '
            <tr class="has-text-centered">
            <td>'.$contador.'</td>
            
            <td>'.$rows['id_factura'].'</td>
            <td>'.$rows['id_cedula'].'</td>
            <td>'.$rows['fecha'].'</td>
            
            <td>'.$rows['total'].'</td>
            
            <td>
                <a href="index.php?vista=factura_update&factura_id_up='.$rows['id_factura'].'" class="button is-success is-rounded is-small">Actualizar</a>
            </td>
            <td>
                <a href="'.$url.$pagina.'&factura_id_del='.$rows['id_factura'].'" class="button is-danger is-rounded is-small">Eliminar</a>
            </td>
            <td>
                <a href="index.php?vista=factura_imprimir&factura_id_imprimir='.$rows['id_factura'].'" class="button is-info is-rounded is-small">Imprimir</a>
            </td>
        </tr>

            ';
        $contador++;
    }
    $pag_final = $contador - 1;
} else {
    if ($total >= 1) {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="7">
                    <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
            ';
    } else {
        $tabla .= '
                <tr class="has-text-centered">
                     <td colspan="7">
                         No hay registros en el sistema
                </td>
                </tr>
            ';
    }
}



$tabla .= '</tbody></table></div>';

if($total >= 1 && $pagina <= $Npaginas){
    $tabla .='
    <p class="has-text-right">Mostrando facturas <strong>'.$pag_inicio.'</strong> al 
    <strong>'.$pag_final.'</strong> de un <strong>total de '.$total .'</strong></p>';

}
$conexion=null;
echo $tabla;
if($total >= 1 && $pagina <= $Npaginas){
    echo  paginador_tablas($pagina,$Npaginas,$url,7);
}