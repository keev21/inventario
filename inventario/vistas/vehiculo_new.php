<?php
require_once "./inc/config.php";
$query=mysqli_query($mysqli, "SELECT id_cedula, nombre, apellido  FROM clientes")
?>
<div class="container is-fluid mb-6">
    <h1 class="title">Vehiculos</h1>
    <h2 class="subtitle">Nuevo Vehiculo</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/vehiculos_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">

    <div class="columns">
    <div class="column is-half">
        <div class="control">
            <label>Nombres del Cliente</label>
            <select class="input" name="cliente_cedula">
                <option disabled selected>Seleccione un Cliente</option>
                <?php
                while ($datos = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $datos['id_cedula'] ?>"><?php echo $datos['id_cedula']." - ".$datos['nombre']." ".$datos['apellido'] ?></option>
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
                    <input class="input" type="text" name="placa" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\- ]{6,8}" maxlength="8" required>
                </div>
            </div>
            <div class="column is-half">
                <div class="control">
                    <label>Marca</label>
                    <input class="input" type="text" name="marca" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}"  maxlength="50" required>
                </div>
            </div>
            

        </div>
        <div class="columns" >
        <div class="column is-half">
                <div class="control">
                    <label>Modelo</label>
                    <input class="input" type="text" name="modelo" pattern="[A-Za-z0-9]+{1,50}" maxlength="50" required>
                </div>
            </div>
            
        </div>
        <div class="columns" >
        <div class="column is-half">
                <div class="control">
                    <label>AÑO</label>
                    <input class="input" type="text" name="anio" pattern="[0-9]+" minlength="4" maxlength="4" required>
                </div>
            </div>
        </div>

        <div class="columns" >
        <div class="column is-half">
                <div class="control">
                    <label>Color</label>
                    <input class="input" type="text" name="color" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}"  maxlength="50" required>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>