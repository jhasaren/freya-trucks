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
    
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url().'public/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css'; ?>" rel="stylesheet">
    
    <!-- Datatables -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'; ?>" rel="stylesheet">
    <!-- Datatables Buttons -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'; ?>" rel="stylesheet">
    
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
                        <h3>Fidelización</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CReport/module/reportBirthday'; ?>"><i class="glyphicon glyphicon-calendar"></i> Cumpleaños Mes</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!--Alerta-->
                        <?php if ($dataRow == 2){ ?>
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <!--/Alerta-->
                        
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Comportamiento Clientes</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form role="form" name="form_report" action="<?php echo base_url() . 'index.php/CReport/fidelizationclients'; ?>" method="post">
                                    <div class="modal-body">
                                        <center>
                                            <fieldset>
                                                <div class="col-md-3 xdisplay_inputx form-group has-feedback"></div>
                                                <div class="col-md-3 xdisplay_inputx form-group has-feedback">
                                                    <input type="text" name="fechaini" required="" class="form-control has-feedback-left" id="single_cal1" value="<?php echo $fechaIni; ?>" placeholder="Fecha Inicio" aria-describedby="inputSuccess2Status" readonly="">
                                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                                </div>
                                                <div class="col-md-3 xdisplay_inputx form-group has-feedback">
                                                    <input type="text" name="fechafin" required="" class="form-control has-feedback-left" id="single_cal3" value="<?php echo $fechaFin; ?>" placeholder="Fecha Fin" aria-describedby="inputSuccess2Status" readonly="">
                                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                                </div>
                                                <div class="col-md-3 xdisplay_inputx form-group has-feedback"></div>
                                            </fieldset>
                                        </center>
                                    </div>
                                    <center>
                                        <button type="submit" class="btn btn-success">Consultar</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if ($dataRow == 1) { ?>
                    <!--Dia de la semana-->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Clientes por Día</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="diassemana" style="height:350px;"></div>
                            </div>
                        </div>
                    </div>
                    <!--/dia de la semana-->

                    <!--Top Servicios-->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Top 5 Servicios</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="topservices" style="height:350px;"></div>
                            </div>
                        </div>
                    </div>
                    <!--/Top Servicios-->

                    <!--Estadistica General-->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Estadistica General</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <!--Widget Grafico1-->
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <center>
                                            Ventas con más de 1 servicio
                                            <div class="clearfix"></div>
                                            </center>
                                        </div>
                                        <div class="x_content">
                                            <div style="text-align: center; margin-bottom: 17px;">
                                                <span class="chart" data-percent="<?php echo ($tendVentaCliente['est1']/$tendVentaCliente['cant'])*100; ?>">
                                                    <span class="percent"></span>
                                                </span>
                                            </div>
                                            <div style="text-align: center; overflow: hidden; margin: 10px 5px 3px;">
                                            </div>
                                            <div>
                                                <ul class="list-inline widget_tally">
                                                    <li>
                                                        <p>
                                                            <span class="month">Cantidad </span>
                                                            <span class="count"><?php echo $tendVentaCliente['est1']; ?></span>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <span class="month">Total </span>
                                                            <span class="count"><?php echo $tendVentaCliente['cant']; ?></span>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/Widget Grafico1-->

                                <!--Widget Grafico2-->
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <center>
                                            Ventas con más de 2 servicios
                                            <div class="clearfix"></div>
                                            </center>
                                        </div>
                                        <div class="x_content">
                                            <div style="text-align: center; margin-bottom: 17px;">
                                                <span class="chart" data-percent="<?php echo ($tendVentaCliente['est2']/$tendVentaCliente['cant'])*100;?>">
                                                    <span class="percent"></span>
                                                </span>
                                            </div>
                                            <div style="text-align: center; overflow: hidden; margin: 10px 5px 3px;">
                                            </div>
                                            <div>
                                                <ul class="list-inline widget_tally">
                                                    <li>
                                                        <p>
                                                            <span class="month">Cantidad </span>
                                                            <span class="count"><?php echo $tendVentaCliente['est2']; ?></span>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <span class="month">Total </span>
                                                            <span class="count"><?php echo $tendVentaCliente['cant']; ?></span>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/Widget Grafico2-->

                                <!--Widget Grafico3-->
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <center>
                                            Servicios que llevaron Producto
                                            <div class="clearfix"></div>
                                            </center>
                                        </div>
                                        <div class="x_content">
                                            <div style="text-align: center; margin-bottom: 17px;">
                                                <span class="chart" data-percent="<?php echo ($tendVentaCliente['est3']/$tendVentaCliente['cant'])*100; ?>">
                                                    <span class="percent"></span>
                                                </span>
                                            </div>
                                            <div style="text-align: center; overflow: hidden; margin: 10px 5px 3px;">
                                            </div>
                                            <div>
                                                <ul class="list-inline widget_tally">
                                                    <li>
                                                        <p>
                                                            <span class="month">Cantidad </span>
                                                            <span class="count"><?php echo $tendVentaCliente['est3']; ?></span>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <span class="month">Total </span>
                                                            <span class="count"><?php echo $tendVentaCliente['cant']; ?></span>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/Widget Grafico3-->

                                <!--Widget Grafico4-->
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <center>
                                            Servicios con cobro adicional
                                            <div class="clearfix"></div>
                                            </center>
                                        </div>
                                        <div class="x_content">
                                            <div style="text-align: center; margin-bottom: 17px;">
                                                <span class="chart" data-percent="<?php echo ($tendVentaCliente['est4']/$tendVentaCliente['cant'])*100; ?>">
                                                    <span class="percent"></span>
                                                </span>
                                            </div>
                                            <div style="text-align: center; overflow: hidden; margin: 10px 5px 3px;">
                                            </div>
                                            <div>
                                                <ul class="list-inline widget_tally">
                                                    <li>
                                                        <p>
                                                            <span class="month">Cantidad </span>
                                                            <span class="count"><?php echo $tendVentaCliente['est4']; ?></span>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <span class="month">Total </span>
                                                            <span class="count"><?php echo $tendVentaCliente['cant']; ?></span>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/Widget Grafico4-->

                            </div>
                        </div>
                    </div>
                    <!--/Estadistica General-->

                    <!--control de asistencia-->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Control de Asistencia</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <!-- Resultado -->  
                            <div class="x_content">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <th>Cliente</th>
                                    <th>Dias sin asistir</th>
                                    <th>Última Atención</th>
                                    <th>Mes Cumpleaños</th>
                                    <th>Dia Cumpleaños</th>
                                    <th>Cantidad Pagos</th>
                                    <th>Valor Pagos</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($paymentClient != FALSE){
                                        foreach ($paymentClient as $row_client){
                                            /*Calcula dias sin asistir desde la ultima fecha de atencion*/
                                            $segundos = strtotime(date('Y-m-d')) - strtotime($row_client['fechaUltimaAtencion']);
                                            $diferencia_dias = intval($segundos/60/60/24);
                                            ?>
                                            <tr style="background-color: #2A3F54;">
                                                <td class="center green"><small><?php echo $row_client['nombre']." [".$row_client['idUsuarioCliente']."]"; ?></small></td>
                                                <td class="center red"><?php echo $diferencia_dias; ?></td>
                                                <td class="center red"><?php echo $row_client['fechaUltimaAtencion']; ?></td>
                                                <td class="center"><?php echo $row_client['mesCumple']; ?></td>
                                                <td class="center"><?php echo $row_client['diaCumple']; ?></td>
                                                <td class="center"><?php echo $row_client['cantidadPagos']; ?></td>
                                                <td class="center">$<?php echo number_format($row_client['valorPagos'],0,',','.'); ?></td>
                                                <td class="center blue"><small><?php echo $row_client['numCelular']; ?></small></td>
                                                <td class="center blue"><small><?php echo $row_client['email']; ?></small></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <!--control de asistencia-->
                <?php } ?>
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
    
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url().'public/gentelella/vendors/moment/min/moment.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js'; ?>"></script>
    
    <!-- Datatables -->
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>
    <!-- Datatables Buttons -->
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js'; ?>"></script>
    
    <!-- easy-pie-chart -->
    <script src="<?php echo base_url().'public/gentelella/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js'; ?>"></script>
    
    <!-- ECharts -->
    <script src="<?php echo base_url().'public/gentelella/vendors/echarts/dist/echarts.min.js'; ?>"></script>
    
    <script> 
    var chart = document.getElementById('topservices'); 
    var myChart = echarts.init(chart); 
    
    var chartDays = document.getElementById('diassemana');
    var myChartDays = echarts.init(chartDays); 
    
    var itemStyle = {
        normal: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowOffsetY: 5,
            shadowColor: 'rgba(0, 0, 0, 0.4)'
        }
    };
    
    /*Grafico Top Servicios*/
    var services = {
        legend: { 
            bottom: '2%',
            data:[
            <?php
            if ($topServices != FALSE) {
                foreach ($topServices as $row_topserv){
                    echo "'".$row_topserv['descServicio']."',";
                }
            }
            ?>    
            ]
        }, 
        toolbox: {
            left: 'right',
            feature: {
                saveAsImage: {}
            }
        },
        tooltip: { }, 
        series: [{ 
            name: 'Servicio',
            type: 'pie',
            radius : [20, 90],
            center : ['50%', 140],
            selectedMode: 'single',
            selectedOffset: 30,
            clockwise: true,
            data: [
                <?php
                if ($topServices != FALSE) {
                    foreach ($topServices as $row_topserv){
                        echo "{value:".$row_topserv['cantidad'].", name:'".$row_topserv['descServicio']."'},";
                    }
                }
                ?>
            ],
            itemStyle: itemStyle
        }]
    }; 
    myChart.setOption(services);
    
    /*Grafico Dias de la Semana*/
    var weekDay = {
        legend: { 
            bottom: '2%',
            data:[]
        }, 
        toolbox: {
            top: '3%',
            feature: {
                magicType: {
                    type: ['line', 'bar']
                },
                saveAsImage: {}
            }
        },
        tooltip: { }, 
        grid: {
            left: '13%',
            right: '5%',
            bottom: '10%',
            textStyle: {
                fontWeight: 'normal'
            }
        },
        xAxis: {
            type: 'value'
        },
        yAxis: {
            type: 'category',
            data: [
                <?php
                if ($diaSemana != FALSE){
                    foreach ($diaSemana as $row_dia){
                        switch ($row_dia['diasemana']){
                            case 1: 
                                $dia = "Domingo";
                                break;
                            case 2: 
                                $dia = "Lunes";  
                                break;
                            case 3: 
                                $dia = "Martes"; 
                                break;
                            case 4: 
                                $dia = "Miercoles"; 
                                break;
                            case 5: 
                                $dia = "Jueves";
                                break;
                            case 6: 
                                $dia = "Viernes";  
                                break;
                            case 7: 
                                $dia = "Sabado";
                                break;
                        }
                        echo "'".$dia."',";
                    }
                }
                ?>
            ]
        },
        series: [{ 
            name: 'Dia Semana',
            type: 'bar',
            label: {
                normal: {
                    show: true,
                    position: 'insideRight'
                }
            },
            data: [
                <?php
                if ($diaSemana != FALSE){
                    foreach ($diaSemana as $row_dia){
                        echo $row_dia['cantidad'].",";
                    }
                }
                ?>
            ],
            itemStyle: itemStyle
        }]
    }; 
    myChartDays.setOption(weekDay);
    </script>     
    
  </body>
</html>

