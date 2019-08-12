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
                        <h3>Reportes</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CReport/module/reportGYP'; ?>"><i class="glyphicon glyphicon-signal"></i> Estado G&P</a>
                                </span>
                                <span class="input-group-btn">
                                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CReport/module/reportGastos'; ?>"><i class="glyphicon glyphicon-arrow-up"></i> Gastos</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <!--<div class="row">-->
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
                                <h2>Ingresos General</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form role="form" name="form_report" action="<?php echo base_url().'index.php/CReport/paymentsedes'; ?>" method="post">
                                    <div class="modal-body">
                                        <fieldset>
                                            <div class="col-md-3 xdisplay_inputx form-group has-feedback"></div>
                                            <!--<div class="col-md-3 xdisplay_inputx form-group has-feedback">
                                                <input type="text" name="fechaini" required="" class="form-control has-feedback-left" id="single_cal1" value="<?php echo $fechaIni; ?>" placeholder="Fecha Inicio" aria-describedby="inputSuccess2Status" readonly="">
                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                            </div>
                                            <div class="col-md-3 xdisplay_inputx form-group has-feedback">
                                                <input type="text" name="fechafin" required="" class="form-control has-feedback-left" id="single_cal3" value="<?php echo $fechaFin; ?>" placeholder="Fecha Fin" aria-describedby="inputSuccess2Status" readonly="">
                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                            </div>-->
                                            <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                                                <input type="text" name="dateRangeInput" required="" class="form-control has-feedback-left" id="single_cal_all" value="" placeholder="Fecha Inicio" aria-describedby="inputSuccess2Status" readonly="">
                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                            </div>
                                        </fieldset>
                                        <center>
                                            <button type="submit" class="btn btn-success">Consultar</button>
                                        </center>
                                    </div>
                                </form>
                                <?php if ($dataRow == 1) { ?>
                                
                                    <!--Ingreso Entidades Forma de Pago-->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_content">
                                                <div id="pagoentidades" style="height:350px;"></div>
                                                <!--Ingresos por Fecha/Dia-->
                                                <div id="ingresofechadia" style="height:350px;"></div>
                                                <!--/Ingresos por Fecha/Dia-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--/Ingreso Entidades Forma de Pago-->
                                
                                    <!--Sedes Ingresos-->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Ingresos por Sede</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div id="ingresossede" style="height:350px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/Sedes Ingresos-->
                                    
                                    <!--Sedes Egresos-->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Egresos por Sede</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div id="egresossede" style="height:350px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/Sedes Egresos-->
                                    
                                    <!-- Consolidado Pagos Sede -->   
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Consolidado</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <table id="datatable" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="green">Sede</th>
                                                            <th class="blue">Ingreso Caja (+)</th>
                                                            <th class="red">Propinas (-)</th>
                                                            <th class="red">Impoconsumo (-)</th>
                                                            <th class="red">Empleados (-)</th>
                                                            <th class="red">Gastos (-)</th>
                                                            <th>Descuento ($)</th>
                                                            <th>Descuento (Promedio)</th>
                                                            <th class="green">Ingreso Neto</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($paymentConsolidaSedes != FALSE){
                                                            foreach ($paymentConsolidaSedes as $row_con){
                                                                $ingreso = (($row_con['valorLiquida']+$row_con['propina_servicio'])-$row_con['valorDistribucionEntidadPago']-$row_con['valorEmpleado']-$row_con['valorGastos']-$row_con['propina_servicio']-($row_con['valorLiquida']*($this->config->item('porcen_consumo')/100)));
                                                                ?>
                                                                <tr style="background-color: #2A3F54;">
                                                                    <td class="center"><small><?php echo $row_con['nombreSede']; ?></small></td>
                                                                    <td class="center blue">$<?php echo number_format($row_con['valorLiquida']+$row_con['propina_servicio'],0,',','.'); ?></td>
                                                                    <td class="center red">$<?php echo number_format($row_con['propina_servicio'],0,',','.'); ?></td>
                                                                    <td class="center red">$<?php echo number_format($row_con['impoconsumo'],0,',','.'); ?></td>
                                                                    <td class="center red">$<?php echo number_format($row_con['valorEmpleado'],0,',','.'); ?></td>
                                                                    <td class="center red">$<?php echo number_format($row_con['valorGastos'],0,',','.'); ?></td>
                                                                    <td class="center">$<?php echo number_format($row_con['valorDesctoServ'],0,',','.'); ?></td>
                                                                    <td class="center"><?php echo number_format($row_con['promDescuento'],2,',','.'); ?>%</td>
                                                                    <td class="center green">$<?php echo number_format($ingreso,0,',','.'); ?></td>
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
                                    <!-- /Consolidado Pagos Sede -->
                                    
                                    <!-- detalle pagos por sede-->   
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Detalle de Recibos</h2>
                                                <br /><br />
                                                <B>Venta:</B> valor antes de aplicar descuento y propina |
                                                <B>Liquidado:</B> valor con descuento a servicios |
                                                <B>Ingreso en Caja:</B> Liquidado + Propina <br />
                                                <B>Impoconsumo:</B> (Liquidado / %Impoconsumo+1)*%Impoconsumo
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Sede</th>
                                                            <th>Nro. Recibo</th>
                                                            <th>Fecha Pago</th>
                                                            <th>Venta</th>
                                                            <th>Descto.</th>
                                                            <th>Liquidado</th>
                                                            <th>Propina</th>
                                                            <th>Impoconsumo</th>
                                                            <th>Empleado</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($paymentDataSedes != FALSE){
                                                            $impoconsumo = $this->config->item('porcen_consumo');
                                                            foreach ($paymentDataSedes as $row_sede){
                                                                ?>
                                                                <tr style="background-color: #2A3F54;">
                                                                    <td class="center"><small><?php echo $row_sede['nombreSede']; ?></small></td>
                                                                    <td class="center green"><?php echo $row_sede['nroRecibo']; ?></td>
                                                                    <td class="center"><small><?php echo $row_sede['fechaPideCuenta']; ?></small></td>
                                                                    <td class="center blue"><?php echo number_format($row_sede['valorVenta'],0,',','.'); ?></td>
                                                                    <td class="center red"><?php echo number_format(($row_sede['valorVenta']-$row_sede['valorLiquida']),0,',','.'); ?></td>
                                                                    <td class="center green"><?php echo number_format($row_sede['valorLiquida'],0,',','.'); ?></td>
                                                                    <td class="center green"><?php echo number_format($row_sede['popina_servicio'],0,',','.'); ?></td>
                                                                    <td class="center red"><?php echo number_format((($row_sede['valorLiquida']/($row_sede['impoconsumo']+1))*$row_sede['impoconsumo']),0,',','.'); ?></td>
                                                                    <td class="center"><small><?php echo $row_sede['empleado']; ?></small></td>
                                                                    <td class="center">
                                                                        <a class="label label-primary btn-detail" href="<?php echo base_url().'index.php/CReport/detallerecibo/'.$row_sede['idVenta'].'/'.$row_sede['nroRecibo']; ?>">
                                                                            Ver Detalle
                                                                        </a>
                                                                    </td>
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
                                    <!-- /detalle pagos por sede--> 
                                    
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <!--</div>-->

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
    
    <!-- ECharts -->
    <script src="<?php echo base_url().'public/gentelella/vendors/echarts/dist/echarts.min.js'; ?>"></script>
    
    <script> 
    /*Grafico Ingresos*/
    var chart = document.getElementById('ingresossede'); 
    var myChart = echarts.init(chart);
    
    /*Grafico Egresos*/
    var chartEgresos = document.getElementById('egresossede'); 
    var myChartE = echarts.init(chartEgresos);
    
    /*Grafico Pago Entidades*/
    var chartEntidad = document.getElementById('pagoentidades'); 
    var myChartEnt = echarts.init(chartEntidad);
    
    /*Grafico Ingreso por Fecha/dia*/
    var chartFecha = document.getElementById('ingresofechadia'); 
    var myChartFecha = echarts.init(chartFecha);
    
    var itemStyle = {
        normal: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowOffsetY: 5,
            shadowColor: 'rgba(0, 0, 0, 0.4)'
        }
    };
    
    /*Sedes Ingresos*/
    var ingresos = {
        legend: { 
            bottom: '2%',
            data:[
            <?php
            if ($paymentConsolidaSedes != FALSE) {
                foreach ($paymentConsolidaSedes as $row_dsede){
                    echo "'".$row_dsede['nombreSede']."',";
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
            name: 'Ingresos por Sede',
            type: 'pie',
            radius : [20, 90],
            center : ['50%', 140],
            selectedMode: 'single',
            selectedOffset: 30,
            clockwise: true,
            data: [
                <?php
                $totalLiquida = 0;
                if ($paymentConsolidaSedes != FALSE) {
                    foreach ($paymentConsolidaSedes as $row_vsede){
                        echo "{value:".($row_vsede['valorLiquida']+$row_vsede['propina_servicio']).", name:'".$row_vsede['nombreSede']."'},";
                        $totalLiquida = $totalLiquida + ($row_vsede['valorLiquida']+$row_vsede['propina_servicio']);
                    }
                }
                ?>
            ],
            itemStyle: itemStyle,
            color: ['#5882FA','#00FF80']
        }]
    }; 
    
    /*Sedes Egresos*/
    var egresos = {
        legend: { 
            bottom: '2%',
            data:[
            <?php
            if ($paymentConsolidaSedes != FALSE) {
                foreach ($paymentConsolidaSedes as $row_dsede){
                    echo "'".$row_dsede['nombreSede']."',";
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
            name: 'Egresos por Sede',
            type: 'pie',
            radius : [20, 90],
            center : ['50%', 140],
            selectedMode: 'single',
            selectedOffset: 30,
            clockwise: false,
            data: [
                <?php
                if ($paymentConsolidaSedes != FALSE) {
                    foreach ($paymentConsolidaSedes as $row_esede){
                        echo "{value:".($row_esede['valorDistribucionEntidadPago']+$row_esede['valorEmpleado']+$row_esede['valorGastos']).", name:'".$row_esede['nombreSede']."'},";
                    }
                }
                ?>
            ],
            itemStyle: itemStyle,
            color: ['#DF3A01','#FA58AC']
        }]
    };
    
    /*Ingreso Formas de Pago*/
    var dataStyle = {
        normal: {
            label: {show:false},
            labelLine: {show:false}
        }
    };
    var placeHolderStyle = {
        normal : {
            color: 'rgba(0,0,0,0)',
            label: {show:false},
            labelLine: {show:false}
        },
        emphasis : {
            color: 'rgba(0,0,0,0)'
        }
    };
    var formapago = {
        title: {
            text: 'Ingresos',
            x: 'center',
            y: 'center',
            itemGap: 20,
            textStyle : {
                color : 'rgba(30,144,255,0.8)',
                fontSize : 35,
                fontWeight : 'bolder'
            }
        }, 
        tooltip : {
            show: true,
            formatter: "{b} : {d}%"
        },
        legend: {
            orient : 'vertical',
            x : chartEntidad.offsetWidth / 2,
            y : 45,
            itemGap:12,
            data:[
            <?php
            if ($paymenEntidades != FALSE) {
                $ingresoTotal = 0;
                foreach ($paymenEntidades as $row_fpago){
                    echo "'".$row_fpago['descTipoPago']." [$".number_format($row_fpago['sumPago'],0,',','.')."]',";
                    $ingresoTotal = $ingresoTotal + $row_fpago['sumPago'];
                }
            }
            ?> 
            ]
        },
        toolbox: {
            show : true,
            feature : {
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        series:
        [
        <?php
        $radius1 = 125;
        $radius2 = 150;
        $minusRadius = 0;
        if ($paymenEntidades != FALSE) {
            foreach ($paymenEntidades as $row_forpago){
                ?>
                {
                name:'<?php echo $row_forpago['descTipoPago']." [$".number_format($row_forpago['sumPago'],0,',','.')."]"; ?>',
                type:'pie',
                clockWise:false,
                radius : [<?php echo $radius1-$minusRadius; ?>, <?php echo $radius2-$minusRadius; ?>],
                itemStyle : dataStyle,
                data:[
                    {
                        value:<?php echo ($row_forpago['sumPago']/$ingresoTotal)*100; ?>,
                        name:'<?php echo $row_forpago['descTipoPago']; ?>'
                    },
                    {
                        value:<?php echo 100-(($row_forpago['sumPago']/$ingresoTotal)*100); ?>,
                        name:'invisible',
                        itemStyle : placeHolderStyle
                    }
                ],
                },
                <?php
                $minusRadius = $minusRadius + 25;
            }
        }
        ?> 
        ],
        color: ['#04B4AE','#FA58AC','#000000']
    };
    
    /*Ingresos por Fecha Dia*/
    var ingresosFecha = {
        title : {
            text: 'Por Fecha',
            subtext: 'Pesos($)'
        },
        tooltip : {
           trigger: 'axis'
        },
        legend: {
            bottom: '2%',
            data:['Día']
        },
        toolbox: {
            show : true,
            feature : {
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : [
                    <?php
                    if ($paymentFechaDia != FALSE) {
                        foreach ($paymentFechaDia as $row_dia){
                            echo "'".$row_dia['fecha']."',";
                        }
                    }
                    ?> 
                ]
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'Día',
                type:'bar',
                data:[
                    <?php
                    if ($paymentFechaDia != FALSE) {
                        foreach ($paymentFechaDia as $row_dia){
                            echo "'".$row_dia['sumPago']."',";
                        }
                    }
                    ?> 
                ]
            }
        ],
        color: ['#2A3F54']
    }; 
    
    myChartE.setOption(egresos); /*Egresos*/
    myChart.setOption(ingresos); /*Ingresos*/
    myChartEnt.setOption(formapago); /*Formas de Pago*/
    myChartFecha.setOption(ingresosFecha); /*Ingreso fecha/dia*/
    
    </script>   
    
  </body>
</html>
