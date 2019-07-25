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
    <!-- FullCalendar -->
    <link href="<?php echo base_url().'public/gentelella/vendors/fullcalendar/dist/fullcalendar.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo base_url().'public/gentelella/vendors/fullcalendar/dist/fullcalendar.print.css'; ?>" rel="stylesheet" media="print">
    
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url().'public/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css'; ?>" rel="stylesheet">
    
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
                                <form role="form" name="form_calendar_emp" action="<?php echo base_url() . 'index.php/CCalendar/seecalendar'; ?>" method="post">
                                    <div class="modal-body">
                                        <strong><?php echo $nombreSede; ?></strong><br /><br /> 
                                        <input type="hidden" id="servicio" name="servicio" value="<?php echo $dataServicio->idServicio; ?>" >
                                        <input type="hidden" id="cliente" name="cliente" value="<?php echo $idcliente; ?>" >
                                        <input type="hidden" id="idsede" name="idsede" value="<?php echo $sede; ?>" >
                                        <input type="hidden" id="nombreSede" name="nombreSede" value="<?php echo $nombreSede; ?>" >

                                        Servicio: <label class="control-label" for="select"><?php echo $dataServicio->descServicio; ?></label><br />
                                        Tiempo Estimado de Atención: <label class="control-label" for="select"><?php echo $dataServicio->tiempoAtencion; ?> Min.</label>
                                        <br /><br />
                                        <label class="control-label" for="select">Seleccione el Profesional</label>
                                        <div class="controls">
                                            <select class="select2_single form-control" id="empleado" name="empleado" data-rel="chosen">
                                                <?php
                                                foreach ($listEmpleadosAsg as $row_empleado) {
                                                    if ($idEmpleado == $row_empleado['idEmpleado']) {
                                                        ?>
                                                        <option value="<?php echo $row_empleado['idEmpleado'] . "|" . $row_empleado['nombreEmpleado']; ?>" selected="" ><?php echo $row_empleado['nombreEmpleado']; ?></option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="<?php echo $row_empleado['idEmpleado'] . "|" . $row_empleado['nombreEmpleado']; ?>" ><?php echo $row_empleado['nombreEmpleado']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <br />
                                        <div class="form-group">
                                            <label for="fecha">Fecha</label>
                                        </div>
                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="col-md-3 xdisplay_inputx form-group has-feedback">
                                                        <input type="text" name="fechaCita" required="" class="form-control has-feedback-left" id="single_cal1" value="<?php echo $fechaCita; ?>" placeholder="Fecha" aria-describedby="inputSuccess2Status">
                                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                        <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        
                                        <br />
                                        <center>
                                            <a href="<?php echo base_url() . 'index.php/CCalendar'; ?>" class="btn btn-primary btn-lg">
                                                <i class="glyphicon glyphicon-remove-sign glyphicon-white"></i> Cancelar
                                            </a>
                                            <button type="submit" class="btn btn-success btn-lg">Ver Agenda
                                            </button>
                                        </center>
                                    </div>
                                </form> 
                            </div>
                            
                            <?php if ($viewCalendar == 1) { ?>
                            <div class="x_content">
                                <div class="x_content">
                                    <div id='calendar'></div>
                                </div>
                            </div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!--Nuevo Evento Modal-->
        <div class="modal fade" id="myModal-ev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-ev" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_add_event" action="<?php echo base_url() . 'index.php/CCalendar/addevent'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Reservar Cita</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="Desde">Fecha/Hora</label>
                                <input type="text" class="form-control green" name="timeIni" id="timeIni" readonly="" />
                            </div>
                            <div class="form-group">
                                <label for="servicio">Servicio: </label>
                                <div class="form-control"><?php echo $dataServicio->descServicio; ?></div>
                                <input type="hidden" class="form-control" name="idServicio" id="idServicio" value="<?php echo $dataServicio->idServicio; ?>" />
                                <input type="hidden" class="form-control" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>" />
                                <input type="hidden" class="form-control" name="idsede" id="idsede" value="<?php echo $sede; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="tiempoAtencion">Tiempo estimado de Atención: </label>
                                <div class="form-control"><?php echo $dataServicio->tiempoAtencion . " Min."; ?></div>
                                <input type="hidden" class="form-control" name="tiempoAtencion" id="tiempoAtencion" value="<?php echo $dataServicio->tiempoAtencion; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="empleado">Profesional: </label>
                                <div class="form-control"><?php echo $nombreEmpleado; ?></div>
                                <input type="hidden" class="form-control" name="empleado" id="empleado" value="<?php echo $idEmpleado; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="Lugar">Lugar:</label>
                                <div class="form-control"><?php echo $nombreSede; ?></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Reservar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/Modal-->
        
        <!--Aviso Modal Agenda no Disponible-->
        <div class="modal fade" id="myModal-evb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-evb" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3>Agenda No Disponible</h3>
                    </div>
                    <div class="modal-body">
                        La agenda del Profesional no se encuentra disponible para la fecha seleccionada. Las citas
                        se habilitan con una anterioridad de 3 dias.
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
        <!--/Modal-->

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
    
    <!-- FullCalendar -->
    <script src="<?php echo base_url().'public/gentelella/vendors/moment/min/moment.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/fullcalendar/dist/fullcalendar.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/fullcalendar/dist/lang/es.js'; ?>"></script>
    
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url().'public/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js'; ?>"></script>
    
    <script>
    $('#calendar').fullCalendar({
        locale: 'es',
        height: "auto",
        header: {
            left: '',
            center: 'title',
            right: ''
        },
        selectable: true,
        firstDay: 1,
        defaultView: 'agendaDay',
        defaultDate: '<?php echo $fechaCita; ?>',
        minTime: '<?php echo $dataHorario->horaIniciaTurno; ?>',
        maxTime: '<?php echo $dataHorario->horaFinTurno; ?>',
        slotDuration: '00:<?php echo $parametroTime; ?>:00',
        slotEventOverlap: false,
        allDaySlot: false,
        axisFormat: 'HH:mm',
        dayClick: function(date, jsEvent, view) {
            var myDate = new Date();
            var daysToAdd = -1;
            myDate.setDate(myDate.getDate() + daysToAdd);

            var myDatePost = new Date();
            var daysToAddPost = 3;
            myDatePost.setDate(myDatePost.getDate() + daysToAddPost);

            if ((date < myDate) || (date > myDatePost)) {
                //TRUE
                $('#myModal-evb').modal('show');
            } else {
                //FALSE
                $("#timeIni").val(date.format());
                $('#myModal-ev').modal('show');
            }
        },
        eventClick: function (event) {
            alert("evento");
        },      
        events: [
            <?php
            if ($dataEvent == 1){
                foreach ($listEvent as $row_event){
                    ?>
                    {
                        id: '<?php echo $row_event['idEvento']; ?>',
                        title: 'Reservado',
                        start: '<?php echo $row_event['fechaInicioEvento']; ?>',
                        end: '<?php echo $row_event['fechaFinEvento']; ?>'
                    },            
                    <?php
                }
            }
            ?>
            {
                title: 'No Disponible',
                start: '<?php echo $fechaCita." ".$dataHorario->horaIniciaAlmuerzo; ?>',
                end: '<?php echo $fechaCita." ".$dataHorario->horaFinAlmuerzo; ?>',
                color: 'gray'
            }
        ]
    });
    </script>
    
  </body>
</html>
