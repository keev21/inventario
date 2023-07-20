<?php
require_once "./php/main.php";
$id = (isset($_GET['usuario_id_up'])) ? $_GET['usuario_id_up'] : 0;
$id = limpiar_cadena($id);
?>
<?php
require_once "./inc/config.php";
$query=mysqli_query($mysqli, "SELECT id_cedula_empleado, nombre, apellido  FROM empleados")
?>


<div class="container is-fluid mb-6">
	<?php if ($id == $_SESSION['id']) { ?>
		<h1 class="title">Mi cuenta</h1>
		<h2 class="subtitle">Actualizar datos de cuenta</h2>
	<?php } else { ?>

		<h1 class="title">Usuarios</h1>
		<h2 class="subtitle">Actualizar usuario</h2>


	<?php } ?>

</div>

<div class="container pb-6 pt-6">
	<?php
	include "./inc/btn_back.php";
	$check_usuario = conexion();
	$check_usuario = $check_usuario->query("SELECT * FROM usuarios WHERE id_usuario='$id' ");

	if ($check_usuario->rowCount() > 0) {
		$datos = $check_usuario->fetch();
	?>
		<div class="form-rest mb-6 mt-6"></div>



		<form action="./php/usuario_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">

			<!-- obteniendo el id del usuario -->
			<input type="hidden" name="id_usuario" value="<?php echo $datos['id_usuario']; ?>" required>

			<div class="columns">
    <div class="column is-half">
        <div class="control">
            <label>Nombres del empleado</label>
            <select class="input" name="usuario_cedula">
                <option disabled selected>Seleccione un empleado</option>
                <?php
                while ($datos2 = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $datos2['id_cedula_empleado'] ?>"><?php echo $datos2['id_cedula_empleado']."-".$datos2['nombre']." ".$datos2['apellido'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
</div>

			<div class="columns">
				<div class="column">
					<div class="control">
						<label>Username</label>
						<input class="input" type="text" name="usuario_username" value="<?php echo $datos['username']; ?>" pattern="[A-Za-z0-9]+{3,100}" maxlength="100" required>
					</div>
				</div>
				<div class="column">
					<div class="control">
						<label>Contraseña</label>
						<input class="input" type="password" name="usuario_clave" pattern="[a-zA-Z0-9$@.-]{8,150}" maxlength="150" required>
					</div>
				</div>
			</div>
			<div class="columns" style="width: 51%;">
			<div class="column" >
			<div class="control" >
				<label>Tipo de usuario</label>
				<select class="input" name="usuario_tipo" onchange="updateTipoUsuario(this)">
					<option value="" disabled selected>Seleccione un tipo</option>
					<option value="administrador">Administrador</option>
					<option value="empleado">Empleado</option>
				</select>
			</div>
			</div>
			</div>
			<script>
				function updateTipoUsuario(selectElement) {
					var inputElement = document.querySelector('input[name="usuario_tipo"]');
					var selectedOption = selectElement.options[selectElement.selectedIndex].text;
					inputElement.value = selectedOption;
					inputElement.setAttribute('name', selectedOption.toLowerCase());
				}
			</script>



				<br>
			<p class="has-text-centered">
				<button type="submit" class="button is-success is-rounded">Actualizar</button>
			</p>
		</form>
	<?php
	} else {
		include "./inc/error_alert.php";
	}
	$check_usuario = null;

	?>
</div>