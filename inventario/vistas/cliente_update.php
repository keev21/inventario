<?php
require_once "./php/main.php";
$id=(isset($_GET['cliente_id_up'])) ? $_GET['cliente_id_up']: 0;
$id=limpiar_cadena($id);
?>


<div class="container is-fluid mb-6">
    <?php if($id==$_SESSION['id']) {?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php } else{ ?>
    
    <h1 class="title">clientes</h1>
	<h2 class="subtitle">Actualizar cliente</h2>
        
        
    <?php } ?>
    
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";
        $check_cliente=conexion();
        $check_cliente= $check_cliente->query("SELECT * FROM clientes WHERE id_cedula='$id'");

        if($check_cliente->rowCount()>0){
            $datos= $check_cliente->fetch();
    ?>
	<div class="form-rest mb-6 mt-6"></div>



	<form action="./php/cliente_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

			<!-- obteniendo el id del cliente -->
		<input type="hidden" name="id" value="<?php echo $datos['id_cedula']; ?>" required>

		<div class="columns">
        <div class="column is-half">
                <div class="control">
                    <label>Cedula</label>
                    <input class="input" type="text" name="cliente_cedula" value="<?php echo $datos['id_cedula']; ?>" pattern="[0-9]+" minlength="10" maxlength="10" required readonly>
                </div>
            </div>

            
        </div>
        <div class="columns">
        <div class="column is-half">
                <div class="control">
                    <label>Nombres</label>
                    <input class="input" type="text" name="cliente_nombre" value="<?php echo $datos['nombre']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"  maxlength="40" required>
                </div>
            </div>
            <div class="column is-half">
                <div class="control">
                    <label>Apellidos</label>
                    <input class="input" type="text" name="cliente_apellido" value="<?php echo $datos['apellido']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"  maxlength="40" required>
                </div>
            </div>
            

        </div>
        <div class="columns">
        <div class="column is-half">
                <div class="control">
                    <label>Direccion</label>
                    <input class="input" type="text" name="cliente_direccion" value="<?php echo $datos['direccion']; ?>" pattern="[A-Za-z0-9]+{10,100}" maxlength="100" required>
                </div>
            </div>
            
        </div>
        <div class="columns">
        <div class="column is-half">
                <div class="control">
                    <label>Email</label>
                    <input class="input" type="email" name="cliente_email" value="<?php echo $datos['email']; ?>" maxlength="70" required>
                </div>
            </div>
        </div>

        <div class="columns">
        <div class="column is-half">
                <div class="control">
                    <label>Telefono</label>
                    <input class="input" type="text" name="cliente_telefono" value="<?php echo $datos['telefono']; ?>" pattern="[0-9]+" minlength="10" maxlength="10" required>
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
        $check_cliente=null;

   ?>
</div>