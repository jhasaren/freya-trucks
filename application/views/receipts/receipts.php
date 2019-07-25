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
    
    <!-- Datatables -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'; ?>" rel="stylesheet">
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'; ?>" rel="stylesheet">-->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css'; ?>" rel="stylesheet">-->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'; ?>" rel="stylesheet">-->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css'; ?>" rel="stylesheet">-->
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed"> <!--menu_fixed-->
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
                        <h3>Recibos</h3>
                        <span class="input-group-btn">
                            <a class="btn btn-success btn-resol" href="#"><i class="glyphicon glyphicon-plus"></i> Crear Rango</a>
                        </span>
                        <br />
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-info btn-receipts" href="<?php echo base_url().'index.php/CReport/module/reportPayment'; ?>"><i class="glyphicon glyphicon-eye-open"></i> Ver Recibos</a>
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
                                <h2>Detalle Resoluciones</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                        <th>Nro. Resolución</th>
                                        <th>Fecha Creación</th>
                                        <th>Numeración</th>
                                        <th>Cantidad</th>
                                        <th>Disponibles</th>
                                        <th>Consumidos</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($detalleResolucion as $row_res){
                                            ?>
                                            <tr style="background-color: #2A3F54;">
                                                <td class="center green"><?php echo $row_res['resolucionExpide']; ?></td>
                                                <td class="center"><?php echo $row_res['fechaRango']; ?></td>
                                                <td class="center green"><?php echo $row_res['inicio']."-".$row_res['final']; ?></td>
                                                <td class="center blue"><?php echo $row_res['cantidadRecibos']; ?></td>
                                                <td class="center blue"><?php echo $row_res['disponibles']; ?></td>
                                                <td class="center red"><?php echo $row_res['consumidos']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!--Widget Grafico-->
                    <div class="col-md-3 col-xs-12 widget widget_tally_box">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Disponible</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <?php $porcentajeConsumo = ($recibosConsumidos->cantidad/($recibosDisponibles->cantidad+$recibosConsumidos->cantidad)*100); ?>
                                <div style="text-align: center; margin-bottom: 17px">
                                    <span class="chart" data-percent="<?php echo 100-$porcentajeConsumo; ?>">
                                        <span class="percent"></span>
                                    </span>
                                </div>

                                <div class="pie_bg" style="text-align: center; display: none; margin-bottom: 17px">
                                    <canvas id="canvas_doughnut" height="130"></canvas>
                                </div>

                                <div style="text-align: center; overflow: hidden; margin: 10px 5px 3px;">
                                </div>
                                <div>
                                    <ul class="list-inline widget_tally">
                                        <li>
                                            <p>
                                                <span class="month">Recibos Pagados </span>
                                                <span class="count"><?php echo $recibosConsumidos->cantidad; ?></span>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <span class="month">Recibos Disponibles </span>
                                                <span class="count"><?php echo ($recibosDisponibles->cantidad + $recibosConsumidos->cantidad) - $recibosConsumidos->cantidad; ?></span>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <span class="month">Total </span>
                                                <span class="count"><?php echo ($recibosDisponibles->cantidad + $recibosConsumidos->cantidad); ?></span>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/Widget Grafico-->
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Crear Rango de Recibos-->
        <div class="modal fade" id="myModal-resol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-resol" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_service" action="<?php echo base_url() . 'index.php/CReceipt/createrange'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Crear Rango de Recibos</h3>
                            <?php
                            //echo "Lista Resoluciones->".$this->cache->memcached->get('memcached9');
                            ?>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="Resolucion">Resolución Expide</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="resolucion" name="resolucion" placeholder="Acta que certifica la generación de Facturas" required="">
                            </div>
                            <div class="form-group">
                                <label for="inicio">Rango Inicial</label>
                                <input type="number" class="form-control" id="inicio" name="inicio" placeholder="Numero del rango según indica su resolución" required="" min="1" >
                            </div>
                            <div class="form-group">
                                <label for="final">Rango Final</label>
                                <input type="number" class="form-control" id="final" name="final" placeholder="Numero del rango según indica su resolución" required="" min="1" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Crear</button>
                        </div>
                    </form>
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
    <script src="<?php echo base_url().'public/gentelella/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js'; ?>"></script>
    <!-- bootstrap-progressbar -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'; ?>"></script>-->
    
  </body>
</html>
