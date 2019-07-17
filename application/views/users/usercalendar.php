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

    <!--Clockpicker-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/gentelella/vendors/clockpicker/dist/bootstrap-clockpicker.min.css'; ?>">    
    
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
                        <h3>Usuarios</h3>
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
                                <h2>Horario Empleado [ID:<?php echo $data_user->idUsuario; ?>]</h2>
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
                                <form role="form" name="form_user_horario" action="<?php echo base_url().'index.php/CUser/updhorario'; ?>" method="post" autocomplete="off">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="Nombre"><?php echo $data_user->nombre . " " . $data_user->apellido; ?></label><br />
                                            <input type="hidden" value="<?php echo $data_user->idUsuario; ?>" name='idEmpleado' >
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <h4>Lunes</h4>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Inicia Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[0]->horaIniciaTurno; ?>" name='horaIniLun' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[0]->horaFinTurno; ?>" name='horaFinLun' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Inicia Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[0]->horaIniciaAlmuerzo; ?>" name='horaIniLunAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[0]->horaFinAlmuerzo; ?>" name='horaFinLunAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <h4>Martes</h4>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Inicia Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[1]->horaIniciaTurno; ?>" name='horaIniMar' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[1]->horaFinTurno; ?>" name='horaFinMar' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Inicia Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[1]->horaIniciaAlmuerzo; ?>" name='horaIniMarAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[1]->horaFinAlmuerzo; ?>" name='horaFinMarAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <h4>Miercoles</h4>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Inicia Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[2]->horaIniciaTurno; ?>" name='horaIniMie' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[2]->horaFinTurno; ?>" name='horaFinMie' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Inicia Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[2]->horaIniciaAlmuerzo; ?>" name='horaIniMieAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[2]->horaFinAlmuerzo; ?>" name='horaFinMieAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <h4>Jueves</h4>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Inicia Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[3]->horaIniciaTurno; ?>" name='horaIniJue' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[3]->horaFinTurno; ?>" name='horaFinJue' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Inicia Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[3]->horaIniciaAlmuerzo; ?>" name='horaIniJueAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[3]->horaFinAlmuerzo; ?>" name='horaFinJueAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <h4>Viernes</h4>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Inicia Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[4]->horaIniciaTurno; ?>" name='horaIniVie' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[4]->horaFinTurno; ?>" name='horaFinVie' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Inicia Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[4]->horaIniciaAlmuerzo; ?>" name='horaIniVieAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[4]->horaFinAlmuerzo; ?>" name='horaFinVieAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <h4>Sabado</h4>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Inicia Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[5]->horaIniciaTurno; ?>" name='horaIniSab' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[5]->horaFinTurno; ?>" name='horaFinSab' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Inicia Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[5]->horaIniciaAlmuerzo; ?>" name='horaIniSabAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[5]->horaFinAlmuerzo; ?>" name='horaFinSabAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <h4>Domingo</h4>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Inicia Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[6]->horaIniciaTurno; ?>" name='horaIniDom' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Turno
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[6]->horaFinTurno; ?>" name='horaFinDom' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time red"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Inicia Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[6]->horaIniciaAlmuerzo; ?>" name='horaIniDomAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Finaliza Almuerzo
                                                    <div class="input-group clockpicker-with-callbacks">
                                                        <input type="text" class="form-control" value="<?php echo $horario_user[6]->horaFinAlmuerzo; ?>" name='horaFinDomAlm' readonly="">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time green"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo base_url().'index.php/CUser'; ?>" class="btn btn-default" data-dismiss="modal">Cancelar</a>
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
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>
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
    
    <!--Clockpicker-->
    <script type="text/javascript" src="<?php echo base_url().'public/gentelella/vendors/clockpicker/dist/bootstrap-clockpicker.min.js'; ?>"></script>
    
    <script type="text/javascript">
    // Clockpicker
    $('.clockpicker-with-callbacks').clockpicker({
        donetext: 'Listo'
    })
    .find('input').change(function(){
        console.log(this.value);
    });
    // /Clockpicker
    </script>
    
  </body>
</html>
