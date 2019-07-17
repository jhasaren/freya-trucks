<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Freya, Salon, Belleza, Gestion, Seguridad, Eficiencia, Calidad, Informacion">
    <meta name="author" content="Amadeus Soluciones">

    <title>Freya - Restaurante</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url().'public/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url().'public/gentelella/vendors/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url().'public/gentelella/vendors/nprogress/nprogress.css'; ?>" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url().'public/gentelella/build/css/custom.min.css'; ?>" rel="stylesheet">
    
    <!-- Datatables -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'; ?>" rel="stylesheet">
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'; ?>" rel="stylesheet">-->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css'; ?>" rel="stylesheet">-->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'; ?>" rel="stylesheet">-->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css'; ?>" rel="stylesheet">-->
    
    <!-- iCheck -->
    <link href="<?php echo base_url().'public/gentelella/vendors/iCheck/skins/flat/green.css'; ?>" rel="stylesheet">
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
            <?php 
            /*include*/
            $this->load->view('includes/menu');
            ?>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <?php 
            /*include*/
            $this->load->view('includes/top');
            ?>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Platos Fuertes</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!--Alerta-->
                        <?php if ($alert == 1){ ?>
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <?php echo $message; ?>
                            </div>
                        <?php } else if ($alert == 2){ ?>
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <!--/Alerta-->
                        
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Actualizar Plato [ID:<?php echo $id; ?>]</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!--Formulario-->
                                <form role="form" name="form_service" action="<?php echo base_url() . 'index.php/CService/updservice'; ?>" method="post" autocomplete="off">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="Nombre">Nombre</label>
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nameservice" name="nameservice" placeholder="Nombre del Plato" value="<?php echo $data_service->descServicio; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="TiempoAtencion">Tiempo de Atención (Minutos)</label>
                                            <select class="form-control" name="timeservice">
                                                <?php
                                                for ($i=$parametroTime; $i <= 300; $i=$i+$parametroTime) {
                                                    if ($data_service->tiempoAtencion == $i){
                                                        $selected = "selected";
                                                    } else { 
                                                        $selected = "";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $i; ?>" <?php echo $selected; ?> ><?php echo $this->jasr->toHours($i,''); ?> min.</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="valorServicio">Valor ($)</label>
                                            <input type="tel" class="form-control" id="valueservice" name="valueservice" placeholder="Pesos CO" value="<?php echo $data_service->valorServicio; ?>" required="" pattern="\d*">
                                        </div>
                                        <!--<div class="form-group">-->
                                            <!--<label for="distribucionEmpleado">Distribución Empleado (%)</label>-->
                                            <input type="hidden" class="form-control" id="distributionservice" name="distributionservice" placeholder="Porcentaje" value="<?php echo ($data_service->distribucion) * 100; ?>" required="" pattern="\d*">
                                        <!--</div>-->
                                        <div class="form-group">
                                            <label for="gruposervicio">Tipo</label>
                                            <input type="text" class="form-control" id="gruposervicio" name="gruposervicio" value="<?php echo $data_service->descGrupoServicio; ?>" disabled="">
                                        </div>
                                        <!--<div class="form-group">
                                            <label for="ServicioAgenda">Permitir agendar</label>
                                            <select class="form-control" name="serviceCalendar">
                                                <?php //if ($data_service->agenda == 'S') { ?>
                                                    <option value="S">Si</option>
                                                    <option value="N">No</option>
                                                <?php //} else { ?>
                                                    <option value="N">No</option>
                                                    <option value="S">Si</option>
                                                <?php //} ?>
                                            </select>
                                        </div>-->
                                        <div class="">
                                            <?php
                                            if ($data_service->activo == 'S') {
                                                $check = 'checked';
                                            } else {
                                                $check = '';
                                            }
                                            ?>
                                            <label>
                                                Activo
                                              <input type="checkbox" class="flat" name="estado" <?php echo $check; ?> >
                                            </label>
                                        </div>
                                        <input type="hidden" class="form-control" id="idservice" name="idservice" value="<?php echo $id; ?>" >
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo base_url() . 'index.php/CService'; ?>" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                </form>
                                <!--/Formulario-->
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!-- footer content -->
        <?php 
        /*include*/
        $this->load->view('includes/footer-bar');
        ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url().'public/gentelella/vendors/jquery/dist/jquery.min.js'; ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url().'public/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js'; ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url().'public/gentelella/vendors/fastclick/lib/fastclick.js'; ?>"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url().'public/gentelella/vendors/nprogress/nprogress.js'; ?>"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url().'public/gentelella/build/js/custom.js'; ?>"></script><!--Minificar--> 
    
    <!-- Datatables -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/jszip/dist/jszip.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/pdfmake/build/pdfmake.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/pdfmake/build/vfs_fonts.js'; ?>"></script>-->
    
    <!-- Chart.js -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/Chart.js/dist/Chart.min.js'; ?>"></script>-->
    <!-- jQuery Sparklines -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/jquery-sparkline/dist/jquery.sparkline.min.js'; ?>"></script>-->
    <!-- easy-pie-chart -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js'; ?>"></script>-->
    <!-- bootstrap-progressbar -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'; ?>"></script>-->
    
    <!-- iCheck -->
    <script src="<?php echo base_url().'public/gentelella/vendors/iCheck/icheck.min.js'; ?>"></script>
    
  </body>
</html>