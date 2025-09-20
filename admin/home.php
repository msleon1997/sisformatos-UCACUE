<h3>Bienvenid@ al sistema de registro de practicas, preprofesionales, vinculacion y practicas internas de la Universidad Católica de Cuenca</h3>
<hr class="border-purple">
<style>
    #website-cover {
        width: 100%;
        height: 30em;
        object-fit: cover;
        object-position: center center;
    }
</style>
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-building"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Planificaciónes Registradas<br></span><br>
                <span class="info-box-number text-right">
                    <?php
                    echo $conn->query("SELECT *  FROM planificacion ")->num_rows;
                    ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-scroll"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Oficios Direccion Carrera<br></span><br>
                <span class="info-box-number text-right">
                    <?php
                    echo $conn->query("SELECT * FROM `oficio_direccion_carrera` ")->num_rows;
                    ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-user-friends"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Estudiantes Matriculados<br></span><br>
                <span class="info-box-number text-right">
                    <?php
                    echo $conn->query("SELECT DISTINCT users_id FROM matriculacion")->num_rows;
                    ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-file-alt"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Actividades Practicas <br>Registradas</span>
                <span class="info-box-number text-right">
                    <?php
                    echo $conn->query("SELECT * FROM `actividades_practicas_pre`")->num_rows;
                    ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<hr>
<!-- agregar descpues una tabla o graficos -->
<div class="row">
    <div class="col-md-12">
        <img src="">
    </div>
</div>