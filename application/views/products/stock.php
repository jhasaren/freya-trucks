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
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'; ?>" rel="stylesheet">-->
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
                        <h3>Productos</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CProduct'; ?>"><i class="glyphicon glyphicon-eye-open"></i> Ver Productos</a>
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
                                <h2>Stock</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                
                                <?php
                                if ($list_products != FALSE) {
                                    
                                    foreach ($list_groups as $row_group) {
                                        
                                        //echo $row_group['descGrupoServicio']."<br />";
                                        ?><div class="clearfix"></div><?php
                                        
                                        foreach ($list_products as $row_list) {
                                            
                                            /*valida el grupo*/
                                            if ($row_list['descGrupoServicio'] == $row_group['descGrupoServicio']){

                                                /*valida que el producto este visible para el inventario*/
                                                if ($row_list['inventario'] == 'S'){

                                                    /*Calcula Porcentaje de Consumo de Productos*/
                                                    $percent = ($row_list['disponibles']/$row_list['unidades'])*100;

                                                    ?>
                                                    <!--Widget Grafico-->
                                                    <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                                        
                                                        <div class="x_panel">
                                                            <center><?php echo $row_group['descGrupoServicio']; ?></center>
                                                            <div class="x_title">
                                                                <?php
                                                                if ($percent >= 70 && $percent <= 100){ 
                                                                    $color = '#A5F19D'; 

                                                                } else if ($percent >= 40 && $percent < 70){
                                                                    $color = '#ECF6A1'; 

                                                                } else if ($percent >= 20 && $percent < 40){
                                                                    $color = '#FACB4D'; 

                                                                } else {
                                                                    $color = '#FA6C4D';

                                                                }
                                                                ?>
                                                                <center>
                                                                <a class="btn btn-default btn-sm" style="background-color:<?php echo $color; ?>;" href="<?php echo base_url().'index.php/CPrincipal/dataedit/product/'.$row_list['idProducto']; ?>">
                                                                    <?php echo substr($row_list['descProducto'], 0, 25); ?>
                                                                </a>
                                                                <div class="clearfix"></div>
                                                                </center>
                                                            </div>
                                                            <div class="x_content">
                                                                <?php 
                                                                if ($percent < 30){ $color = 'red'; } else $color ='';
                                                                ?>
                                                                <div style="text-align: center; margin-bottom: 17px;">
                                                                    <span class="chart <?php echo $color; ?>" data-percent="<?php echo $percent; ?>">
                                                                        <span class="percent"></span>
                                                                    </span>
                                                                </div>

                                                                <div style="text-align: center; overflow: hidden; margin: 10px 5px 3px;">
                                                                </div>
                                                                <div>
                                                                    <ul class="list-inline widget_tally">
                                                                        <li>
                                                                            <p>
                                                                                <span class="month">Disponibles </span>
                                                                                <span class="count"><?php echo $row_list['disponibles']; ?></span>
                                                                            </p>
                                                                        </li>
                                                                        <li>
                                                                            <p>
                                                                                <span class="month">Total </span>
                                                                                <span class="count"><?php echo $row_list['unidades']; ?></span>
                                                                            </p>
                                                                        </li>
                                                                        <li>
                                                                            <p>
                                                                                <?php echo $row_list['descTipoProducto']; ?>
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/Widget Grafico-->
                                                <?php
                                                }
                                            
                                            }
                                            
                                        }
                                        
                                    }
                                        
                                }
                                ?>
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
    
    <!-- easy-pie-chart -->
    <script src="<?php echo base_url().'public/gentelella/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js'; ?>"></script>
    
  </body>
</html>
