<!DOCTYPE html>
<html>
<head>
    <title>Imprimir div con estilos</title>
    <link rel="stylesheet" type="text/css" href="./css/bulma.min.css">
    <script>
        function imprimirDiv() {
            var contenidoDiv = document.getElementById("div-a-imprimir").innerHTML;
            var contenidoOriginal = document.body.innerHTML;

            document.body.innerHTML = contenidoDiv;

            window.print();

            document.body.innerHTML = contenidoOriginal;
        }
    </script>
</head>
<body>
<?php
require_once "./php/main.php";
$id=(isset($_GET['factura_id_imprimir'])) ? $_GET['factura_id_imprimir']: 0;
$id=limpiar_cadena($id);
?>



<div class="container is-fluid mb-6">
    <?php if($id==$_SESSION['id']) {?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php } else{ ?>
    
    <h1 class="title">Imprimir factura</h1>
	
        
        
    <?php } ?>
    
</div>

<div class="container pb-6 pt-6" >
    <?php
        include "./inc/btn_back.php";
        $check_factura=conexion();
        $check_factura= $check_factura->query("SELECT f.id_factura, f.id_cedula AS factura_cedula, f.id_servicios AS factura_servicios, c.nombre AS cliente_nombre, c.apellido AS cliente_apellido, c.direccion AS cliente_direccion, c.telefono AS cliente_telefono, c.email AS cliente_email, s.id_servicios AS servicio_id, s.nombre AS servicio_nombre, s.precio, f.subtotal, f.total, f.fecha
        FROM facturas f
        INNER JOIN clientes c ON f.id_cedula = c.id_cedula
        INNER JOIN servicios s ON f.id_servicios = s.id_servicios
        WHERE f.id_factura = '$id'");

        if($check_factura->rowCount()>0){
            $datos= $check_factura->fetch();
    ?>
	<div id="div-a-imprimir">

    <section class="section">
        <div class="container">
            <h1 class="title is-4">Factura N° <?php echo $id ?></h1>

            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Cédula del cliente</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $datos['factura_cedula']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Fecha</label>
                        <div class="control">
                            <input class="input" type="text" id="fecha" value="<?php echo $datos['fecha']; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns">
                
                <div class="column is-half">
                <div class="field">
                        <label class="label">Nombres</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $datos['cliente_nombre']." ".$datos['cliente_apellido'] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                <div class="field">
                        <label class="label">Dirección</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $datos['cliente_direccion']; ?>" readonly>
                        </div>
                    </div>
                </div>

            </div>

            <div class="columns">
                
                <div class="column is-half">
                <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email" value="<?php echo $datos['cliente_email']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                <div class="field">
                        <label class="label">Teléfono</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $datos['cliente_telefono']; ?>" readonly>
                        </div>
                    </div>
                </div>

            </div>

            
            <h2 class="subtitle is-5">Detalle del servicio</h2>
            
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Nombre del servicio</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $datos['servicio_nombre']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Costo del servicio</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $datos['precio']; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            
            <h2 class="subtitle is-5">Resumen de la factura</h2>
            
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Subtotal</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $datos['subtotal']; ?>" disabled>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">IVA 12%</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $datos['subtotal']*0.12 ; ?>" disabled>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Total</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $datos['total']; ?>" disabled>
                        </div>
                    </div>
                </div>
            </div>
            </div>
   
            
            
    </section>
   <?php
        }else{
            include "./inc/error_alert.php";
        }
        $check_factura=null;

   ?>
</div>
    
<div class="has-text-centered">
  <button class="button is-info is-rounded" onclick="imprimirDiv()">Imprimir</button>
</div>
</body>
</html>


