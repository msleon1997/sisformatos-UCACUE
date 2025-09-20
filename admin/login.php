<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>

<body class="hold-transition ">
  <script>
    start_loader()
  </script>
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
      margin-top: -250px;
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
  <div class="h-100 d-flex align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="w-100">
        <center><img src="./../uploads/logo_institucion.png"></center>
        <!-- <h1 class="text-center py-5 login-title"><b><?php echo $_settings->info('name') ?> - Admin</b></h1> -->
      </div>

    </div>
    <div class="col-5 h-100 bg-gradient">
      <div class="d-flex w-100 h-100 justify-content-center align-items-center">
        <div class="card col-sm-12 col-md-6 col-lg-3 card-outline card-primary rounded-0 shadow">
          <div class="card-header rounded-0">
            <h4 class="text-purle text-center"><b>Ingresar</b></h4>
          </div>
          <div class="card-body rounded-0">
            <form id="login-frm" action="" method="post">
              <div><label>Ingresa tu cedula</label></div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" autofocus name="cedula" placeholder="Cédula" maxlength="10">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>

              <div><label>Ingresa la contraseña</label></div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Contraseña">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">

                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                </div>
                <div class="col-4">
                  <a href="./register.php" class="btn btn-primary btn-block btn-flat">Registrar</a>
                </div>
                <p>Olvidé la contraseña</p>
                <a href="./recuperarContrasena.php" class="red-text">clic aquí</a>
                <!-- /.col -->
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
    $(document).ready(function () {
      end_loader();
    })
  </script>
  <style>
    .red-text {
      color: red;
    }
  </style>
</body>

</html>

