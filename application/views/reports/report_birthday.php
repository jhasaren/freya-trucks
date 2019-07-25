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
                                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CReport/module/reportFide'; ?>"><i class="glyphicon glyphicon-screenshot"></i> Comportamiento Clientes</a>
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
                        
                        <!--cumpleaños mes-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Cumpleaños del Mes</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <!-- Resultado -->  
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <th>Cliente</th>
                                    <th>Dia Cumpleaños</th>
                                    <th>Dirección</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($birthdayClients != FALSE){
                                        foreach ($birthdayClients as $row_bday){
                                            ?>
                                            <tr style="background-color: #2A3F54;">
                                                <td class="center green"><small><?php echo $row_bday['nombre']."<br />[CC.".$row_bday['idUsuario']."]"; ?></small></td>
                                                <td class="center red"><?php echo $row_bday['dia']; ?></td>
                                                <td class="center blue"><?php echo $row_bday['direccion']; ?></td>
                                                <td class="center blue"><?php echo $row_bday['numCelular']; ?></td>
                                                <td class="center blue"><?php echo $row_bday['email']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <!--cumpleaños mes-->
                        
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

