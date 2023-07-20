<div class="container is-fluid mb-6">
    <h1 class="title">Empleados</h1>
    <h2 class="subtitle">Nuevo empleado</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/empleado_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
        <div class="columns" style="width: 51%">
        <div class="column">
                <div class="control">
                    <label>Cedula</label>
                    <input class="input" type="text" name="empleado_cedula" pattern="[0-9]+" minlength="10" maxlength="10" required>
                </div>
            </div>

            
        </div>
        <div class="columns">
        <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input class="input" type="text" name="empleado_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"  maxlength="40" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input class="input" type="text" name="empleado_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"  maxlength="40" required>
                </div>
            </div>
            

        </div>
        <div class="columns" style="width: 51%">
        <div class="column">
                <div class="control">
                    <label>Direccion</label>
                    <input class="input" type="text" name="empleado_direccion" pattern="[A-Za-z0-9]+{10,100}" maxlength="100" required>
                </div>
            </div>
            
        </div>
        <div class="columns" style="width: 51%">
        <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input" type="email" name="empleado_email" maxlength="70" required>
                </div>
            </div>
        </div>

        <div class="columns" style="width: 51%">
        <div class="column">
                <div class="control">
                    <label>Telefono</label>
                    <input class="input" type="text" name="empleado_telefono" pattern="[0-9]+" minlength="10" maxlength="10" required>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>

