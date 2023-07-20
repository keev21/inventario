<?php
require_once "./php/main.php";
$id=(isset($_GET['empleado_id_up'])) ? $_GET['empleado_id_up']: 0;
$id=limpiar_cadena($id);
?>


<div class="container is-fluid mb-6">
    <?php if($id==$_SESSION['id']) {?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php } else{ ?>
    
    <h1 class="title">empleados</h1>
	<h2 class="subtitle">Actualizar empleado</h2>
        
        
    <?php } ?>
    
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";
        $check_empleado=conexion();
        $check_empleado= $check_empleado->query("SELECT * FROM empleados WHERE id_cedula_empleado='$id'");

        if($check_empleado->rowCount()>0){
            $datos= $check_empleado->fetch();
    ?>
	<div class="form-rest mb-6 mt-6"></div>



	<form action="./php/empleado_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

			<!-- obteniendo el id del empleado -->
		<input type="hidden" name="id" value="<?php echo $datos['id_cedula_empleado']; ?>" required>

		<div class="columns" style="width: 51%">
        <div class="column">
                <div class="control">
                    <label>Cedula</label>
                    <input class="input" type="text" name="empleado_cedula" value="<?php echo $datos['id_cedula_empleado']; ?>" pattern="[0-9]+" minlength="10" maxlength="10" required readonly>
                </div>
            </div>

            
        </div>
        <div class="columns">
        <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input class="input" type="text" name="empleado_nombre" value="<?php echo $datos['nombre']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"  maxlength="40" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input class="input" type="text" name="empleado_apellido" value="<?php echo $datos['apellido']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"  maxlength="40" required>
                </div>
            </div>
            

        </div>
        <div class="columns" style="width: 51%">
        <div class="column">
                <div class="control">
                    <label>Direccion</label>
                    <input class="input" type="text" name="empleado_direccion" value="<?php echo $datos['direccion']; ?>" pattern="[A-Za-z0-9]+{10,100}" maxlength="100" required>
                </div>
            </div>
            
        </div>
        <div class="columns" style="width: 51%">
        <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input" type="email" name="empleado_email" value="<?php echo $datos['email']; ?>" maxlength="70" required>
                </div>
            </div>
        </div>

        <div class="columns" style="width: 51%">
        <div class="column">
                <div class="control">
                    <label>Telefono</label>
                    <input class="input" type="text" name="empleado_telefono" value="<?php echo $datos['telefono']; ?>" pattern="[0-9]+" minlength="10" maxlength="10" required>
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
        $check_empleado=null;

   ?>
</div>