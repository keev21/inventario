<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?vista=home">
      <img src="./img/tf2.png" width="80" height="50">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Clientes
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=cliente_new" >
            Nuevo
          </a>
          <a class="navbar-item" href="index.php?vista=cliente_list">
            Lista
          </a>
          <a class="navbar-item" href="index.php?vista=cliente_search">
            Buscar
          </a>
          
        </div>
      </div>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Vehiculos
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=vehiculo_new">
            Nuevo
          </a>
          <a class="navbar-item" href="index.php?vista=vehiculo_list">
            Lista
          </a>
          <a class="navbar-item" href="index.php?vista=vehiculo_search">
            Buscar
          </a>
          
        </div>
      </div>

      


      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Servicios
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=servicios_new">
            Nueva
          </a>
          <a class="navbar-item" href="index.php?vista=servicios_list">
            Lista
          </a>
          <a class="navbar-item" href="index.php?vista=servicio_search">
            Buscar
          </a>
          
        </div>
      </div>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Factura
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=factura_new">
            Generar factura
          </a>
          <a class="navbar-item" href="index.php?vista=factura_list">
            Lista
          </a>

          <a class="navbar-item" href="index.php?vista=factura_search">
            Buscar
          </a>
         
          
        </div>
      </div>
      <?php 
     
      
      if($_SESSION['tipo']=="administrador"){

      
      ?>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Empleados
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item"  href="index.php?vista=empleados_new">
            Nuevo
          </a>
          <a class="navbar-item" href="index.php?vista=empleados_list">
            Lista
          </a>
          <a class="navbar-item" href="index.php?vista=empleado_search">
            Buscar
          </a>
          
        </div>
      </div>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Usuarios
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=usuarios_new">
            Nuevo
          </a>
          <a class="navbar-item" href="index.php?vista=usuarios_list">
            Lista
          </a>
          <a class="navbar-item" href="index.php?vista=usuario_search">
            Buscar
          </a>
          
        </div>
      </div>
      <?php 
      }
      ?>

    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-primary is-rounded" href="index.php?vista=usuario_update&usuario_id_up=<?php echo $_SESSION['id']; ?>">
            Mi cuenta
          </a>
          <a href="index.php?vista=logout" class="button is-link is-rounded">
            Salir
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>