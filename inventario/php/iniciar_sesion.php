<?php
//TODO: almacenando datos
	/*== Almacenando datos ==*/
    $usuario=limpiar_cadena($_POST['login_usuario']);
    $clave=limpiar_cadena($_POST['login_clave']);


    /*== Verificando campos obligatorios ==*/
    if($usuario=="" || $clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

$check_user=conexion();
$check_cedula=conexion();
$check_user=$check_user->query("SELECT * FROM usuarios WHERE username='$usuario'");

if($check_user->rowCount()==1){

    $check_user=$check_user->fetch();

    if($check_user['username']==$usuario && $check_user['contrasenia']==$clave ){

        $_SESSION['id']=$check_user['id_usuario'];
        $_SESSION['cedula']=$check_user['id_cedula_empleado'];
        $cedula=$_SESSION['cedula'];
        $_SESSION['usuario']=$check_user['username'];
        $_SESSION['tipo']=$check_user['tipo'];
       

        $check_cedula=$check_cedula->query("SELECT * FROM empleados WHERE id_cedula_empleado='$cedula'");

        if($check_cedula->rowCount()==1){
            $check_cedula=$check_cedula->fetch();
            $_SESSION['nombres']=$check_cedula['nombre'];
            $_SESSION['apellidos']=$check_cedula['apellido'];

        }

        if(headers_sent()){
            echo "<script> window.location.href='index.php?vista=home'; </script>";
        }else{
            header("Location: index.php?vista=home");
        }
        

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario o clave incorrectos
            </div>
        ';
    }
}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Usuario o clave incorrectos
        </div>
    ';
}
$check_user=null; 