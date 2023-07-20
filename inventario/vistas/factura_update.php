<?php
require_once "./php/main.php";
$id=(isset($_GET['factura_id_up'])) ? $_GET['factura_id_up']: 0;
$id=limpiar_cadena($id);
?>
<?php
require_once "./inc/config.php";
$query = mysqli_query($mysqli, "SELECT * FROM clientes order by nombre")
?>


<div class="container is-fluid mb-6">
    <?php if($id==$_SESSION['id']) {?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php } else{ ?>
    
    <h1 class="title">facturas</h1>
	<h2 class="subtitle">Actualizar factura</h2>
        
        
    <?php } ?>
    
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";
        $check_factura=conexion();
        $check_factura= $check_factura->query("SELECT * FROM facturas WHERE id_factura='$id'");

        if($check_factura->rowCount()>0){
            $datos= $check_factura->fetch();
    ?>
	<div class="form-rest mb-6 mt-6"></div>



	<form action="./php/factura_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

			<!-- obteniendo el id del factura -->
		<input type="hidden" name="id_factura" value="<?php echo $datos['id_factura']; ?>" required>

        <div class="columns">
            <div class="column is-half">
                <div class="control">
                    <label>Nombres del Cliente</label>
                    <select class="input" name="cliente_cedula">
                        <option disabled selected>Seleccione un Cliente</option>
                        <?php
                        while ($datos = mysqli_fetch_array($query)) {
                        ?>
                            <option value="<?php echo $datos['id_cedula'] ?>"><?php echo $datos['id_cedula'] . " - " . $datos['nombre'] . " " . $datos['apellido'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="column is-half">
                <div class="control">
                    <label>Fecha</label>
                    <input class="input" type="datetime" name="fecha" value="<?php echo date("Y-m-d"); ?>">
                </div>
            </div>



        </div>
        <?php
        require_once "./inc/config.php";
        $query = mysqli_query($mysqli, "SELECT servicios.id_servicios, autos.placa, servicios.nombre, servicios.precio 
        FROM servicios INNER JOIN autos ON servicios.id_autos = autos.id_autos;")
        ?>

        <div class="columns">
        <div class="column is-half">
                <div class="control">
                    <label>Seleccione el servicio</label>
                    <select class="input" name="servicio">
                        <option disabled selected>Seleccione un servicio</option>
                        <?php
                        while ($datos = mysqli_fetch_array($query)) {
                        ?>
                            
                            
                            <option value="<?php echo $datos['id_servicios'] ?>"><?php echo $datos['placa']." - ".$datos['nombre'] ?></option>
                            
                       <?php
                        }
                        
                        ?>
                        
                    </select>
                </div>
            </div>
            


        </div>
       
		
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
   <?php
        }else{
            include "./inc/error_alert.php";
        }
        $check_factura=null;

   ?>
</div>