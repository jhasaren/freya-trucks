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
    
    <style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;border-color:#aabcfe;width: 50%;}
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#669;background-color:#e8edff;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#039;background-color:#b9c9fe;}
    .tg .tg-baqh{text-align:center;vertical-align:top}
    .tg .valores{background-color:#D2E4FC;text-align:right;vertical-align:top}
    .tg .totales{background-color:#D2E4FC;text-align:center;vertical-align:top}
    .tg .header{text-align:left;vertical-align:top}
    .tg .describe{background-color:#D2E4FC;text-align:left;vertical-align:top}
    .tg .describeTotal{background-color:#D2E4FC;text-align:left;vertical-align:top;font-weight: bold;}
    .tg .valueTotal{background-color:#D2E4FC;text-align:right;vertical-align:top;font-weight: bold;}
    </style>

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
                                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CReport/module/reportSedes'; ?>"><i class="glyphicon glyphicon-signal"></i> Ingresos General</a>
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
                                <h2>Estado de Ganancias y Perdidas</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form role="form" name="form_report_gp" action="<?php echo base_url().'index.php/CReport/ganperdidas'; ?>" method="post">
                                    <div class="modal-body">
                                        <fieldset>
                                            <div class="col-md-3 xdisplay_inputx form-group has-feedback">
                                                <select class="form-control" name="sede">
                                                    <?php
                                                    foreach ($listSedes as $row_sede){
                                                        ?>
                                                        <option value="<?php echo $row_sede['idSede']; ?>"><?php echo $row_sede['nombreSede']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
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
                                            <button type="submit" class="btn btn-success">Consultar</button>
                                        </fieldset>
                                    </div>
                                </form>
                                <?php 
                                if ($dataRow == 1) { 
                                    
                                    /*Servicios*/
                                    if ($servicios == NULL){
                                        $valorServicios = 0;
                                    } else {
                                        foreach ($servicios as $valueServ) {
                                            $valorServicios = $valorServicios + $valueServ['valorLiquida'];
                                        }
                                    }
                                    
                                    /*Descuento*/
                                    if ($descuentos == NULL){
                                        $valorDescuento = 0;
                                    } else {
                                        $valorDescuento = $descuentos->valordescuento;
                                        $valorPropina = $descuentos->valorpropina;
                                    }
                                    
                                    /*Productos*/
                                    if ($productos == NULL){
                                        $valorProductos = 0;
                                    } else {
                                        foreach ($productos as $valueProd) {
                                            $valorProductos= $valorProductos + $valueProd['valorLiquida'];
                                        }
                                    }
                                    
                                    /*Adicionales*/
                                    if ($adicional == NULL){
                                        $valorAdicional = 0;
                                    } else {
                                        foreach ($adicional as $valueAdc) {
                                            $valorAdicional = $valorAdicional + $valueAdc['valorLiquida'];
                                        }
                                    }
                                    
                                    /*Gastos Variables*/
                                    if ($gastosVariables == NULL){
                                        $gastosVariables = 0;
                                    } else {
                                        foreach ($gastosVariables as $valueGastosV) {
                                                
                                            $gastosVariablesTotal = $gastosVariablesTotal + $valueGastosV['valorgasto'];
                                                
                                        }
                                    }
                                    
                                    /*Impoconsumo*/
                                    if ($impoconsumo == NULL){
                                        $totalImpoconsumo = 0;
                                    } else {
                                        $totalImpoconsumo = $impoconsumo->valorimpoconsumo;
                                    }
                                    
                                    ?>
                                
                                <table class="tg">
                                  <tr>
                                    <th class="tg-baqh" colspan="12">
                                        <?php echo $this->config->item('namebussines'); ?><br /> 
                                        Estado de Ganancias y Perdidas <br /> 
                                        <?php echo "Desde: ".$fechaIni." Hasta: ".$fechaFin; ?><br />
                                        <?php echo "<small>Generación: ".date("Y-m-d H:i:00")."</small>"; ?>
                                    </th>
                                  </tr>
                                  <tr>
                                    <td class="header" colspan="12">Ingresos Operativos</td>
                                  </tr>
                                  <tr>
                                    <td class="describe" colspan="8">Ventas de Platos Fuertes</td>
                                    <td class="valores" colspan="4"><?php echo "$".number_format($valorServicios-$valorDescuento,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="describe" colspan="8">Ventas de Productos</td>
                                    <td class="valores" colspan="4"><?php echo "$".number_format($valorProductos,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="describe" colspan="8">Ventas de Adicionales</td>
                                    <td class="valores" colspan="4"><?php echo "$".number_format($valorAdicional,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="describeTotal" colspan="8">Ingresos Operativos Totales (<?php echo "Propinas $".number_format($valorPropina,0,',','.') ?>)</td>
                                    <td class="valueTotal" colspan="4"><?php echo "$".number_format($valorProductos+$valorAdicional+($valorServicios-$valorDescuento),0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="header" colspan="12">Gastos Operativos</td>
                                  </tr>
                                  <tr>
                                    <td class="describe" colspan="8">Costo de ventas (variables)</td>
                                    <td class="valores" colspan="4"><?php echo "$".number_format($gastosVariablesTotal,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="describeTotal" colspan="8">Ganancia Bruta</td>
                                    <td class="valueTotal" colspan="4"><?php echo "$".number_format(($valorProductos+$valorAdicional+($valorServicios-$valorDescuento))-$gastosVariablesTotal,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="header" colspan="12">Gastos Fijos</td>
                                  </tr>
                                    <?php
                                    /*Gastos Variables*/
                                    if ($gastosFijos == NULL){
                                        ?>
                                        <tr>
                                          <td class="describe" colspan="8">Fijos</td>
                                          <td class="valores" colspan="4"><?php echo "$".number_format(0,0,',','.'); ?></td>
                                        </tr>
                                        <?php
                                    } else {
                                        foreach ($gastosFijos as $valueGastosF) {
                                            ?>
                                            <tr>
                                              <td class="describe" colspan="8"><?php echo $valueGastosF['descGasto']?></td>
                                              <td class="valores" colspan="4"><?php echo "$".number_format($valueGastosF['valorgasto'],0,',','.'); ?></td>
                                            </tr>
                                            <?php
                                            $gastosFijosTotal = $gastosFijosTotal + $valueGastosF['valorgasto'];
                                        }
                                    }
                                    ?>
                                  <tr>
                                    <td class="describeTotal" colspan="8">Total Gastos Fijos</td>
                                    <td class="valueTotal" colspan="4"><?php echo "$".number_format($gastosFijosTotal,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="describeTotal" colspan="8">Ingresos Operativos</td>
                                    <td class="valueTotal" colspan="4"><?php echo "$".number_format((($valorProductos+$valorAdicional+($valorServicios-$valorDescuento))-$gastosVariablesTotal)-$gastosFijosTotal,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="describeTotal" colspan="8">Ganancias Antes de Impuestos</td>
                                    <td class="valueTotal" colspan="4"><?php echo "$".number_format((($valorProductos+$valorAdicional+($valorServicios-$valorDescuento))-$gastosVariablesTotal)-$gastosFijosTotal,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="describe" colspan="8">Impuesto por Consumo</td>
                                    <td class="valores" colspan="4"><?php echo "$".number_format($totalImpoconsumo,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="describe" colspan="8">Impuesto a la Renta</td>
                                    <td class="valores" colspan="4"><?php echo "$".number_format($valorRenta,0,',','.'); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="describeTotal" colspan="8">Ganancias Netas</td>
                                    <td class="valueTotal" colspan="4"><?php echo "$".number_format(((($valorProductos+$valorAdicional+($valorServicios-$valorDescuento))-$gastosVariablesTotal)-$gastosFijosTotal)-$valorRenta-$totalImpoconsumo,0,',','.'); ?></td>
                                  </tr>
                                </table>
                                <br />
                                <a href="<?php echo base_url() . 'files/Estado-GYP-'.$this->session->userdata('userid').'.pdf'; ?>" class="btn btn-primary btn-lg" target="_blank">
                                    <i class="glyphicon glyphicon-search glyphicon-download"></i> Descargar PDF
                                </a>
                                
                                <?php
                                } 
                                ?>
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
       
  </body>
</html>
