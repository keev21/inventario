<?php
require_once "./inc/config.php";
$query=mysqli_query($mysqli, "SELECT id_autos, placa FROM autos")
?>

<div class="container is-fluid mb-6">
    <h1 class="title">Servicios</h1>
    <h2 class="subtitle">Nuevo Servicio</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/servicio_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">

    <div class="columns"  >
        <div class="column is-half" >
                <div class="control">
                    <label>Nombre del servicio</label>
                    <input class="input" type="text" name="nombre_servicio" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}"  maxlength="100" required>
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
                while ($datos = mysqli_fetch_array($query)) {
                    ?>
                    <option value="<?php echo $datos['id_autos'] ?>"><?php echo $datos['placa'] ?></option>
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
                    <textarea class="input" name="descripcion_servicio" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,250}" maxlength="250" required style="height: 200px"></textarea>
                </div>
            </div>
        </div>
        
        <div class="columns"  >
        <div class="column is-half">
                <div class="control">
                    <label>Precio</label>
                    <input class="input" type="text" name="precio_servicio" pattern="[0-9]+([,.][0-9]+)?" minlength="1" required>
                </div>
            </div>
        </div>
        
        
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>

