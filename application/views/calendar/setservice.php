<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
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
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
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
                        <h3>Agendamiento</h3>
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
                                <h2>Reservar Cita</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form role="form" name="form_calendar" action="<?php echo base_url() . 'index.php/CCalendar/personalcalendar'; ?>" method="post">
                                    <div class="modal-body">
                                        <strong><?php echo $nombreSede; ?></strong><br /><br />
                                        <?php if ($this->session->userdata('perfil') == 'CLIENTE') { ?>
                                            <input type="hidden" class="form-control" name="idcliente" id="idcliente" value="<?php echo "0|".$this->session->userdata('userid'); ?>" />
                                        <?php } else { ?>
                                            <label class="control-label" for="selectError">Seleccione el Cliente</label>
                                            <div class="controls">
                                                <input class="select2_single form-control" type="text" name="idcliente" id="idcliente" required="" />
                                            </div>
                                            <br />
                                        <?php } ?>
                                        <label class="control-label" for="selectService">Seleccione el Servicio</label>
                                        <div class="controls">
                                            <select class="select2_single form-control" id="idservice" name="idservice" data-rel="chosen">
                                                <?php
                                                foreach ($list_service as $row_service) {
                                                    ?>
                                                    <option value="<?php echo $row_service['idServicio']; ?>"><?php echo $row_service['descGrupoServicio'] . ' | ' . $row_service['descServicio']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <input type="hidden" name="idsede" id="idsede" value="<?php echo $sede; ?>" />
                                        <input type="hidden" name="nombresede" id="nombresede" value="<?php echo $nombreSede; ?>" />
                                        <br />
                                    </div>
                                    <center>
                                        <a href="<?php echo base_url() . 'index.php/CCalendar'; ?>" class="btn btn-primary btn-lg">
                                            <i class="glyphicon glyphicon-remove-sign glyphicon-white"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-success btn-lg">Siguiente
                                            <i class="glyphicon glyphicon-forward glyphicon-white"></i>
                                        </button>
                                    </center>
                                </form>
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
    
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url().'public/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js'; ?>"></script>
    
    <script>
    var clientes = [
        <?php foreach ($list_user as $row_user) { ?>
            { value: '<?php echo $row_user['nombre_usuario']." |".$row_user['idUsuario']; ?>' },
        <?php } ?>
    ];

    $('#idcliente').autocomplete({
        lookup: clientes
    });
    </script>
    
  </body>
</html>
