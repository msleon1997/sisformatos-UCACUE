<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../config.php');
require_once('inc/header.php');
require_once('../classes/RecuperarContrasena.php');

// Crear una instancia de la clase recuperarContrasena
$recuperarContrasena = new recuperarContrasena();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $cedula = $_POST['cedula'];
    $password = $_POST['password'];

    // Verificar si el usuario con la cédula existe
    if ($recuperarContrasena->checkUserExists($cedula)) {
        // Actualizar la contraseña
        $result = $recuperarContrasena->updatePassword($cedula, $password);

        // Manejar el resultado
        if ($result) {
            echo "<script>alert('Contraseña actualizada correctamente.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar la contraseña.');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado.');</script>";
    }
}

?>




<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<body class="hold-transition ">
  <script>
    start_loader()
  </script>
 
  <div class="h-100 d-flex align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
       <div class="w-100">
        <center><img src="./../uploads/logo_institucion.png"></center>
      </div> 
    </div>
    <br>
    <div class="col-5 h-100 bg-gradient">
      <div class="d-flex w-100 h-100 justify-content-center align-items-center">
        <div class="card col-sm-12 col-md-6 col-lg-3 card-outline card-primary rounded-0 shadow">
          <div class="card-header rounded-0">
            <h4 class="text-purle text-center"><b>Recuperar Contraseña</b></h4>
          </div>
          <div class="card-body rounded-0">
            <form id="recuperarContrasena-frm" action="" method="post">
              
              <div class="input-group mb-3">
                  <input type="text" class="form-control" autofocus name="cedula" placeholder="Cédula del estudiante" maxlength="10">
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-address-card"></span>
                      </div>
                  </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Nueva Contraseña">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>

              <div class="row">
                
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Actualizar</button>
                </div>
                <div class="col-4">
                    <a href="./login.php" class="btn btn-primary btn-block btn-flat">Atrás</a>
                </div>
                <br><br>
                

              
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function() {
      end_loader();
    })

    // Agregar validación adicional utilizando JavaScript
    document.querySelector('[name="cedula"]').addEventListener('input', function() {
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10); // Limitar a 10 caracteres
        }
    });
    
  </script>
</body>

<style>
    html,
    body {
      height: calc(100%) !important;
      width: calc(100%) !important;
    }

    body {
      /* background-image: url("<?php echo validate_image($_settings->info('cover')) ?>"); */
      background-size: cover;
      background-repeat: no-repeat;
    }

    .login-title {
      text-shadow: 2px 2px black
    }

    #login {
      flex-direction: column !important
    }

    #logo-img {
      height: 150px;
      width: 150px;
      object-fit: scale-down;
      object-position: center center;
      border-radius: 100%;
    }

    

    .card-primary.card-outline {
    border-top: 3px solid #ff0000;
    margin-top: -220px;
    }

    #login .col-7,
    #login .col-5 {
      width: 100% !important;
      max-width: unset !important
    }

    .row {
    display: -ms-flexbox;
    display: flex;
    justify-content: center;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
   
    }

  </style>

</html>