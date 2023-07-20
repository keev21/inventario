<?php
require_once "./php/main.php";
$id=(isset($_GET['servicios_id_up'])) ? $_GET['servicios_id_up']: 0;
$id=limpiar_cadena($id);
?>
<?php
require_once "./inc/config.php";
$query=mysqli_query($mysqli, "SELECT id_autos, placa FROM autos")
?>


<div class="container is-fluid mb-6">
    <?php if($id==$_SESSION['id']) {?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php } else{ ?>
    
    <h1 class="title">Servicios</h1>
	<h2 class="subtitle">Actualizar servicios</h2>
        
        
    <?php } ?>
    
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";
        $check_servicios=conexion();
        $check_servicios= $check_servicios->query("SELECT * FROM servicios WHERE id_servicios='$id' ");

        if($check_servicios->rowCount()>0){
            $datos= $check_servicios->fetch();
    ?>
	<div class="form-rest mb-6 mt-6"></div>



	<form action="./php/servicios_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

			<!-- obteniendo el id del servicios -->
		<input type="hidden" name="id_servicios" value="<?php echo $datos['id_servicios']; ?>" required>

		<div class="columns"  >
        <div class="column is-half" >
                <div class="control">
                    <label>Nombre del servicio</label>
                    <input class="input" type="text" name="nombre_servicio" value="<?php echo $datos['nombre']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}"  maxlength="100" required>
                </div>
            </div>
           
            
        </div>
        <div class="columns">
    <div class="column is-half">
        <div class="control">
            <label>Id carro</label>
            <select class="input" name="id_carro">
                <option disabled selected>Seleccione una placa</option>
                <?php
                while ($datos2 = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $datos2['id_autos'] ?>"><?php echo $datos2['placa'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
</div>
       

        <div class="columns" >
        <div class="column is-half">
                <div class="control">
                    <label>Descripcion</label>
                    <textarea class="input" name="descripcion_servicio"  pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,250}" maxlength="250" required style="height: 200px"><?php echo $datos['descripcion']; ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="columns"  >
        <div class="column is-half">
                <div class="control">
                    <label>Precio</label>
                    <input class="input" type="text" name="precio_servicio" value="<?php echo $datos['precio']; ?>" pattern="[0-9]+([,.][0-9]+)?" minlength="1" required>
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
        $check_servicios=null;

   ?>
</div>