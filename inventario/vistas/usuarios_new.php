<?php
require_once "./inc/config.php";
$query=mysqli_query($mysqli, "SELECT id_cedula_empleado, nombre, apellido  FROM empleados")
?>
<div class="container is-fluid mb-6">
	<h1 class="title">Usuarios</h1>
	<h2 class="subtitle">Nuevo usuario</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/usuario_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
	<div class="columns">
    <div class="column is-half">
        <div class="control">
            <label>Nombres del empleado</label>
            <select class="input" name="usuario_cedula">
                <option disabled selected>Seleccione un empleado</option>
                <?php
                while ($datos = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $datos['id_cedula_empleado'] ?>"><?php echo $datos['id_cedula_empleado']." - ".$datos['nombre']." ".$datos['apellido'] ?></option>
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
					<label>Username</label>
					<input class="input" type="text" name="usuario_username" pattern="[A-Za-z0-9]+{3,100}" maxlength="100" required>
				</div>
			</div>

		</div>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Contraseña</label>
					<input class="input" type="password" name="usuario_clave" pattern="[a-zA-Z0-9$@.-]{8,150}" maxlength="150" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label>Tipo de usuario</label>
					<select class="input" name="usuario_tipo" onchange="updateTipoUsuario(this)">
						<option value="" disabled selected>Seleccione un tipo</option>
						<option value="administrador">Administrador</option>
						<option value="empleado">Empleado</option>
					</select>
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

		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>