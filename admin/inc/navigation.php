
<?php
$proyecto_pages = ['Proyectos', 'Proyectos/view_proyecto', 'Proyectos/manage_proyecto', 'Proyectos/delete_proyecto'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_active = in_array($current_page, $proyecto_pages) ? 'active' : '';

$listadoEst_pages = ['matriculacion', 'matriculacion/view_matriculacion', 'matriculacion/manage_matriculacion', 'matriculacion/delete_matriculacion'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeEst = in_array($current_page, $listadoEst_pages) ? 'active' : '';

$listadoPlani_pages = ['planificacion', 'planificacion/view_planificacion', 'planificacion/manage_planificacion', 'planificacion/delete_planificacion'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activePlani = in_array($current_page, $listadoPlani_pages) ? 'active' : '';

$listadoRegistroAct_pages = ['ActPract', 'ActPract/view_actpract', 'ActPract/manage_actpract', 'ActPract/delete_actpract'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeActPract = in_array($current_page, $listadoRegistroAct_pages) ? 'active' : '';

$listadoCronograma_pages = ['ActPract/CronoActPract', 'ActPract/CronoActPract/view_crono', 'ActPract/CronoActPract/manage_crono', 'ActPract/CronoActPract/view_crono/delete_crono'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeCrono = in_array($current_page, $listadoCronograma_pages) ? 'active' : '';

$listadoCumplimientoHoras_pages = ['CumplimientoHoras', 'CumplimientoHoras/view_cumplimiento_horas', 'CumplimientoHoras/manage_cumplimiento_horas', 'CumplimientoHoras/delete_cumplimiento_horas'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeCumplimientoHoras = in_array($current_page, $listadoCumplimientoHoras_pages) ? 'active' : '';

$listadoActa_pages = ['ActPract/ActaCompro', 'ActPract/ActaCompro/view_acta', 'ActPract/ActaCompro/manage_acta', 'ActPract/ActaCompro/delete_acta'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeActa = in_array($current_page, $listadoActa_pages) ? 'active' : '';

$listadoEvaluacionPract_pages = ['EvaluacionPract', 'EvaluacionPract/view_evaluacionPract', 'EvaluacionPract/manage_evaluacionPract', 'EvaluacionPract/delete_evaluacionPract'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeEvaPract = in_array($current_page, $listadoEvaluacionPract_pages) ? 'active' : '';

$listadoInforme_final_pages = ['Informe_final', 'Informe_final/view_informe_final', 'Informe_final/manage_informe_final', 'Informe_final/delete_informe_final'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeInformeFinal = in_array($current_page, $listadoInforme_final_pages) ? 'active' : '';

$listadoInformeTutorias_pages = ['InformeTutorias', 'InformeTutorias/view_informe_tutorias', 'InformeTutorias/manage_informe_tutorias', 'InformeTutorias/delete_informe_tutorias'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeInformeTutorias = in_array($current_page, $listadoInformeTutorias_pages) ? 'active' : '';

$listadoActividadesPracticas_pages = ['ActividadesPracticas', 'ActividadesPracticas/view_informe_actividades_practicas'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeActividadesPract = in_array($current_page, $listadoActividadesPracticas_pages) ? 'active' : '';

$listadoOficios_pages = ['oficio', 'oficio/view_oficio', 'oficio/manage_oficio', 'oficio/delete_oficio'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeOficios = in_array($current_page, $listadoOficios_pages) ? 'active' : '';

$listadoEvaluacionFinalCert_pages = ['EvaluacionFinalCertificado', 'EvaluacionFinalCertificado/view_evaluacionFinalCert', 'EvaluacionFinalCertificado/manage_evaluacionFinalCert', 'EvaluacionFinalCertificado/delete_evaluacionFinalCert'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeEvaluacionFinalCert = in_array($current_page, $listadoEvaluacionFinalCert_pages) ? 'active' : '';


$listadoCertificadoPract_pages = ['CertificadoPract', 'CertificadoPract/view_certificado_pract', 'CertificadoPract/manage_certificado_pract', 'CertificadoPract/delete_certificado_pract'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeCertificadoPract = in_array($current_page, $listadoCertificadoPract_pages) ? 'active' : '';

$listadoEstudiantesMatriculados_pages = ['students',  'students/manage_student', 'students/view_student' ,'students/delete_student'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_activeStudentMatriculado = in_array($current_page, $listadoEstudiantesMatriculados_pages) ? 'active' : '';


$DescargaFormatos_pages = ['DescargaInformes', 'DescargaInformes/view_informes'];
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$is_descargaFormatos = in_array($current_page, $DescargaFormatos_pages) ? 'active' : '';
?>

<style>
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active,
.sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
    background-color: #ff0000;
    color: #fff;
}

.nav-compact .nav-header:not(:first-of-type) {
    padding-top: 0.75rem;
    padding-bottom: 0.25rem;
    background-color: gray;
}

i.right.fas.fa-angle-left {
    display: block;
    margin-top: 4px;
    left: 235px;
}

p.titulo-menu {
    font-size: 12px;
}


</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand bg-dark">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>admin" class="brand-link bg-transparent text-sm border-0 shadow-sm">
    <img src="../uploads/logo_institucion.png" alt="Store Logo" class="brand-image img-circle elevation-3 bg-black" style="width: 1.8rem;height: 1.8rem;max-height: unset;object-fit:scale-down;object-position:center center">
    <span class="brand-text font-weight-light" style="margin: auto; float: left; margin-top: -10px;">UNIVERSIDAD <br>CATÓLICA DE CUENCA</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
    <div class="os-resize-observer-host observed">
      <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
    </div>
    <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
      <div class="os-resize-observer"></div>
    </div>
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
    <div class="os-padding">
      <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
          <!-- Sidebar user panel (optional) -->
          <div class="clearfix"></div>
          <!-- Sidebar Menu -->
          <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
            <!-- menu de estudiantes -->
            <?php if ($_settings->userdata('type') == 1) :?> 
            <li class="nav-item dropdown">
                <a href="./" class="nav-link <?php echo !isset($_GET['page']) || $_GET['page'] == 'home' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>DASHBOARD PRINCIPAL</p>
                </a>
              </li>
              
            
              <li class="nav-header">PRÁCTICAS INTERNAS/SERVICIO COMUNITARIO Y/O PROFESIONALES</li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=matriculacion" class="nav-link <?php echo $is_activeEst ?>">
                  <i class="nav-icon fas fa-plus"></i>
                  <p class="titulo-menu">Matriculación Estudiante</p>
                </a>
              </li>
               <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=oficio" class="nav-link <?php echo $is_activeOficios ?>">
                    <i class="nav-icon fas fa-tools"></i>
                      <p class="titulo-menu">F-VS-32 Oficio Dirección de Carrera</p>
                  </a>
                </li>
              
              
              <li class="nav-item has-treeview <?php echo ($is_activePlani || $is_activeActPract || $is_activeCrono || $is_activeActa) ? 'menu-open' : ''; ?>">
                <a href="#" class="nav-link <?php echo ($is_activePlani || $is_activeActPract || $is_activeCrono || $is_activeActa) ? 'active' : ''; ?>">
                  <i class="nav-icon fas fa-calendar-alt"></i>
                  <p class="titulo-menu">
                    F-VS-33 Planificación 2025
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url ?>admin/?page=planificacion" class="nav-link <?php echo $is_activePlani ?>">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Planificación 2025</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url ?>admin/?page=ActPract" class="nav-link <?php echo $is_activeActPract ?>">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Registrar las actividades</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url ?>admin/?page=ActPract/CronoActPract" class="nav-link <?php echo $is_activeCrono ?>">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Cronograma de actividades</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url ?>admin/?page=ActPract/ActaCompro" class="nav-link <?php echo $is_activeActa ?>">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Acta de Compromiso</p>
                    </a>
                  </li>
                </ul>
              </li>

                         <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=CumplimientoHoras" class="nav-link <?php echo $is_activeCumplimientoHoras ?>">
                          <i class="nav-icon fas fa-clock"></i>
                            <p class="titulo-menu">F-VS-34 Cumplimiento de Horas</p>
                          </a>
                        </li>

                        <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=EvaluacionPract" class="nav-link <?php echo $is_activeEvaPract?>">
                          <i class=" nav-icon fas fa-poll"></i>
                            <p class="titulo-menu">F-VS-35 Evaluación de Practicas</p>
                          </a>
                        </li>
                     
                       
                        <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=EvaluacionFinalCertificado" class="nav-link <?php echo $is_activeEvaluacionFinalCert?>">
                          <i class="nav-icon fas fa-check-double"></i>
                            <p class="titulo-menu">F-VS-36 Evaluación Final y Cert</p>
                          </a>
                        </li>
                      <br>
                <li class="nav-header">INFORMES PRÁCTICAS INTERNAS/SERVICIO COMUNITARIO Y/O PROFESIONALES</li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=Informe_final" class="nav-link <?php echo $is_activeInformeFinal ?>">
                  <i class="nav-icon fas fa-file"></i>
                    <p class="titulo-menu">F-VS-37 Informe Final Actividades</p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=InformeTutorias" class="nav-link <?php echo $is_activeInformeTutorias ?>">
                  <i class="nav-icon fas fa-file"></i>
                    <p class="titulo-menu">F-VS-38 Informe Tutorias Practicas</p>
                  </a>
                </li>
                
                 <li class="nav-header">CERTIFICADO FINAL PRACTICAS</li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=CertificadoPract" class="nav-link <?php echo $is_activeCertificadoPract?>">
                  <i class="nav-icon fas fa-award"></i>
                    <p class="titulo-menu">F-VS-39 Certificado de practicas</p>
                  </a>
                </li>
                <br>
                <li class="nav-header">DESCARGA DE FORMATOS COMPLETOS</li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=DescargaInformes" class="nav-link <?php echo $is_descargaFormatos ?>">
                  <i class="nav-icon fas fa-download"></i>
                    <p class="titulo-menu">Formatos completos</p>
                  </a>
                </li>
                <br>
                
              <?php endif; ?>



              <!-- menu de docentes -->
              <?php if ($_settings->userdata('type') == 2) :?> 
            <li class="nav-item dropdown">
                <a href="./" class="nav-link <?php echo !isset($_GET['page']) || $_GET['page'] == 'home' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>DASHBOARD PRINCIPAL</p>
                </a>
                      </li>
                            <li class="nav-header">ADMINISTRACIÓN PROYECTOS</li>
                              <li class="nav-item dropdown">
                                <a href="<?php echo base_url ?>admin/?page=Proyectos" class="nav-link <?php echo $is_active ?>">
                                    <i class="nav-icon fas fa-folder"></i>
                                    <p>Crear Proyectos</p>
                                  </a>
                              </li>

                              <li class="nav-header">ESTUDIANTES MATRICULADOS</li>
                                <li class="nav-item dropdown">
                                  <a href="<?php echo base_url ?>admin/?page=students" class="nav-link <?php echo $is_activeStudentMatriculado ?>">
                                    <i class="nav-icon fas fa-user-friends"></i>
                                    <p>Listado de Estudiantes</p>
                                  </a>
                                </li>
                                <li class="nav-header">PRÁCTICAS INTERNAS/SERVICIO COMUNITARIO Y/O PROFESIONALES</li>

                          <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=oficio" class="nav-link <?php echo $is_activeOficios ?>">
                            <i class="nav-icon fas fa-tools"></i>
                              <p class="titulo-menu">F-VS-32 Oficio Dirección de Carrera</p>
                          </a>
                        </li>
              
              
                        <li class="nav-item has-treeview <?php echo ($is_activePlani || $is_activeActPract || $is_activeCrono || $is_activeActa) ? 'menu-open' : ''; ?>">
                          <a href="#" class="nav-link <?php echo ($is_activePlani || $is_activeActPract || $is_activeCrono || $is_activeActa) ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p class="titulo-menu">
                              F-VS-33 Planificación 2025
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo base_url ?>admin/?page=planificacion" class="nav-link <?php echo $is_activePlani ?>">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Planificación 2025</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo base_url ?>admin/?page=ActPract" class="nav-link <?php echo $is_activeActPract ?>">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Registrar las actividades</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo base_url ?>admin/?page=ActPract/CronoActPract" class="nav-link <?php echo $is_activeCrono ?>">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Cronograma de actividades</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo base_url ?>admin/?page=ActPract/ActaCompro" class="nav-link <?php echo $is_activeActa ?>">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Acta de Compromiso</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                         <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=CumplimientoHoras" class="nav-link <?php echo $is_activeCumplimientoHoras ?>">
                          <i class="nav-icon fas fa-clock"></i>
                            <p class="titulo-menu">F-VS-34 Cumplimiento de Horas</p>
                          </a>
                        </li>

                        <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=EvaluacionPract" class="nav-link <?php echo $is_activeEvaPract?>">
                          <i class=" nav-icon fas fa-poll"></i>
                            <p class="titulo-menu">F-VS-35 Evaluación de Practicas</p>
                          </a>
                        </li>
                     
                       
                        <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=EvaluacionFinalCertificado" class="nav-link <?php echo $is_activeEvaluacionFinalCert?>">
                          <i class="nav-icon fas fa-check-double"></i>
                            <p class="titulo-menu">F-VS-36 Evaluación Final y Cert</p>
                          </a>
                        </li>
                     
                        <li class="nav-header">INFORMES PRÁCTICAS INTERNAS/SERVICIO COMUNITARIO Y/O PROFESIONALES</li>
                        <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=Informe_final" class="nav-link <?php echo $is_activeInformeFinal ?>">
                          <i class="nav-icon fas fa-file"></i>
                            <p class="titulo-menu">F-VS-37 Informe Final Actividades</p>
                          </a>
                        </li>
                        <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=InformeTutorias" class="nav-link <?php echo $is_activeInformeTutorias ?>">
                          <i class="nav-icon fas fa-file"></i>
                            <p class="titulo-menu">F-VS-38 Informe Tutorias Practicas</p>
                          </a>
                        </li>
                        
                        <li class="nav-header">CERTIFICADO FINAL PRACTICAS</li>
                        <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=CertificadoPract" class="nav-link <?php echo $is_activeCertificadoPract?>">
                          <i class="nav-icon fas fa-award"></i>
                            <p class="titulo-menu">F-VS-39 Certificado de practicas</p>
                          </a>
                        </li>
                        
                        <li class="nav-header">DESCARGA DE FORMATOS COMPLETOS</li>
                        <li class="nav-item dropdown">
                          <a href="<?php echo base_url ?>admin/?page=DescargaInformes" class="nav-link <?php echo $is_descargaFormatos ?>">
                          <i class="nav-icon fas fa-download"></i>
                            <p class="titulo-menu">Formatos completos</p>
                          </a>
                        </li>
              <?php endif; ?>



            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar-corner"></div>
  </div>
  <!-- /.sidebar -->
</aside>


<script>
  $(document).ready(function() {
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    page = page.replace(/\//gi, '_');
    if ($('.nav-link.nav-' + page).length > 0) {
      $('.nav-link.nav-' + page).addClass('active');
      if ($('.nav-link.nav-' + page).hasClass('tree-item')) {
        $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active');
        $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open');
      }
      if ($('.nav-link.nav-' + page).hasClass('nav-is-tree')) {
        $('.nav-link.nav-' + page).parent().addClass('menu-open');
      }
    }
  });
</script>

