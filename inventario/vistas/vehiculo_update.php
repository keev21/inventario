<?php
require_once "./php/main.php";
$id=(isset($_GET['vehiculo_id_up'])) ? $_GET['vehiculo_id_up']: 0;
$id=limpiar_cadena($id);
?>
<?php
require_once "./inc/config.php";
$query=mysqli_query($mysqli, "SELECT id_cedula, nombre, apellido  FROM clientes")
?>


<div class="container is-fluid mb-6">
    <?php if($id==$_SESSION['id']) {?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php } else{ ?>
    
    <h1 class="title">vehiculos</h1>
	<h2 class="subtitle">Actualizar vehiculo</h2>
        
        
    <?php } ?>
    
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";
        $check_vehiculo=conexion();
        $check_vehiculo= $check_vehiculo->query("SELECT * FROM autos WHERE id_autos='$id'");

        if($check_vehiculo->rowCount()>0){
            $datos= $check_vehiculo->fetch();
    ?>
	<div class="form-rest mb-6 mt-6"></div>



	<form action="./php/vehiculo_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

			<!-- obteniendo el id del vehiculo -->
		<input type="hidden" name="id_autos" value="<?php echo $datos['id_autos']; ?>" required>

        <div class="columns">
    <div class="column is-half">
        <div class="control">
            <label>Nombres del Cliente</label>
            <select class="input" name="cliente_cedula">
                <option disabled selected>Seleccione un Cliente</option>
                <?php
                while ($datos2 = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $datos2['id_cedula'] ?>"><?php echo $datos2['id_cedula']." - ".$datos2['nombre']." ".$datos2['apellido'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
</div>
		
        
        <div class="columns">
        <div class="column is-half">
                <div class="control">
                    <label>Placa</label>
                    <input class="input" type="text" name="placa" value="<?php echo $datos['placa']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\- ]{6,8}" maxlength="8" required>
                </div>
            </div>
            <div class="column is-half">
                <div class="control">
                    <label>Marca</label>
                    <input class="input" type="text" name="marca" value="<?php echo $datos['marca']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}"  maxlength="50" required>
                </div>
            </div>
            

        </div>
        <div class="columns" >
        <div class="column is-half">
                <div class="control">
                    <label>Modelo</label>
                    <input class="input" type="text" name="modelo" value="<?php echo $datos['modelo']; ?>" pattern="[A-Za-z0-9]+{1,50}" maxlength="50" required>
                </div>
            </div>
            
        </div>
        <div class="columns" >
        <div class="column is-half">
                <div class="control">
                    <label>AÑO</label>
                    <input class="input" type="text" name="anio" value="<?php echo $datos['anio']; ?>" pattern="[0-9]+" minlength="4" maxlength="4" required>
                </div>
            </div>
        </div>

        <div class="columns" >
        <div class="column is-half">
                <div class="control">
                    <label>Color</label>
                    <input class="input" type="text" name="color" value="<?php echo $datos['color']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}"  maxlength="50" required>
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
        $check_vehiculo=null;

   ?>
</div>