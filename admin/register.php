
<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../config.php');
require_once('inc/header.php');
require_once('../classes/Register.php');

$base_url = "http://localhost:5170/api/Usuarios";
$usuarios = new Register($base_url);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cedula = $_POST['cedula'];
    $email = $_POST['email'];

    $datos = array(
        'firstname'    => $_POST['firstname'],
        'lastname'     => $_POST['lastname'],
        'cedula'       => $cedula,
        'email'        => $email,
        'password'     => $_POST['password'],
        'type'         => $_POST['type'],
        'lider_group'  => $_POST['lider_group'],
        'status'       => $_POST['status']
    );

    // Verificar si el usuario ya existe antes de intentar crearlo
    if ($usuarios->checkUserExists($cedula)) {
    echo "<script> window.onload = function() {
        Swal.fire({
            title: 'Error',
            text: 'El usuario ya está registrado.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    };
    </script>";
    } elseif (!$usuarios->validarCedulaEcuatoriana($cedula)) {
        echo "<script> window.onload = function() {
            Swal.fire({
                title: 'Error',
                text: 'Cédula incorrecta.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        };
        </script>";
    } elseif (!$usuarios->validarCorreoEstudiantil($email)) {
        echo "<script> window.onload = function() {
            Swal.fire({
                title: 'Error',
                text: 'El correo debe ser institucional.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        };
        </script>";
    }

    
    else {
        // Intentar registrar el usuario
        $result = $usuarios->crearUsuario($datos);

        if ($result) {
            echo "<script>  window.onload = function() {
                Swal.fire({
                    title: 'Éxito',
                    text: 'Usuario registrado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = './login.php';
                });
              };
            </script>";
        } else {
            echo "<script> window.onload = function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al registrar el usuario.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              };
            </script>";
        }
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



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
            <h4 class="text-purle text-center"><b>Registrar Estudiante</b></h4>
          </div>
          <div class="card-body rounded-0">
            <form id="register-frm" action="" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" autofocus name="firstname" id="firstname" placeholder="Nombres del estudiante" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" autofocus name="lastname" id="cedula" placeholder="Apellidos del estudiante" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                  <input type="text" class="form-control" autofocus name="cedula" id="cedula" placeholder="Cédula del estudiante" maxlength="10" required>
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-address-card"></span>
                      </div>
                  </div>
              </div>
              <div class="input-group mb-3">
                  <input type="email" class="form-control" autofocus name="email" id="email" placeholder="Correo del estudiante/institucional" required>
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                      </div>
                  </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                
                <div class="input-group mb-3">
                <label for="toggleBtn">Es usted líder de grupo</label>
                  <div class="toggle-button" id="toggleBtn" onclick="toggleLider()">
                    <div class="toggle-thumb"></div>
                  </div>
                  <!-- Campo hidden para almacenar el valor del toggle -->
                  <input type="hidden" id="liderGroup" name="lider_group" value="0">
                  <!-- Icono de información con tooltip -->
                  <span class="info-icon">ℹ
                    <span class="tooltip-text">
                      Si eres líder de grupo de las prácticas de vinculación, es decir que solo usted puede agregar a los estudiantes de su grupo
                      al momento de registrar la planificacion.
                    </span>
                  </span>
                </div>
                <br>             
              </div>

              

              <div class="input-group mb-3">
                <input type="hidden" class="form-control" name="status" value="1">
                <input type="hidden" class="form-control" name="type" value="1">
                
              </div>


              <div class="row">
                
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
                </div>
                <div class="col-4">
                    <a href="./login.php" class="btn btn-primary btn-block btn-flat">Atrás</a>
                </div>
                <br><br>
                

              
              </div>
              <div class="col-12">
                    <a href="./registerDocente.php" class="btn btn-danger btn-block btn-flat">AREA DOCENTES</a>
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
</body>


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

  <script>
    



    function toggleLider() {
    const toggleBtn = document.getElementById('toggleBtn');
    const liderGroup = document.getElementById('liderGroup');

    // Cambiar el estado de "liderGroup" y el estilo visual del toggle
    if (liderGroup.value === '0') {
        liderGroup.value = '1'; 
        toggleBtn.classList.add('active');
    } else {
        liderGroup.value = '0';
        toggleBtn.classList.remove('active');
    }
}



  </script>

<style>
     /* Estilos básicos del toggle */
  .toggle-button {
    width: 50px;
    height: 25px;
    background-color: #ccc;
    border-radius: 25px;
    position: relative;
    cursor: pointer;
  }

  .toggle-thumb {
    width: 23px;
    height: 23px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    top: 1px;
    left: 1px;
    transition: 0.3s;
  }

  .toggle-button.active .toggle-thumb {
    left: 25px;
    background-color: #4CAF50; /* Color cuando está activo */
  }

  .toggle-button.active {
    background-color: #4CAF50;
  }
  </style>


<style>
.info-icon {
      display: inline-block;
      margin-left: 10px;
      cursor: pointer;
      position: relative;
      font-size: 18px;
      color: #e20613 !important;
    }

    /* Estilos del tooltip */
    .info-icon .tooltip-text {
      visibility: hidden;
      width: 250px;
      background-color: #555;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px;
      position: absolute;
      z-index: 1;
      bottom: 125%; /* Posiciona el tooltip arriba del icono */
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      transition: opacity 0.3s;
      font-size: 14px;
    }

    /* Flecha del tooltip */
    .info-icon .tooltip-text::after {
      content: '';
      position: absolute;
      top: 100%; /* Coloca la flecha en la parte inferior del tooltip */
      left: 50%;
      margin-left: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: #555 transparent transparent transparent;
    }

    /* Mostrar el tooltip al pasar el mouse sobre el icono */
    .info-icon:hover .tooltip-text {
      visibility: visible;
      opacity: 1;
    }   
</style>

  
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