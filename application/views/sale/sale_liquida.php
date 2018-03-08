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

    <title>Freya - Trucks</title>

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
                        <h3>Liquidación</h3>
                        <?php
                        //echo "Tipo Forma Pago->".$this->cache->memcached->get('memcached17')."<br />";
                        ?>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span style="font-size: 18px">
                                    <h1 style="color: #000000;"><?php echo $message; ?></h1>
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
                                <h2>ID:<?php echo $this->session->userdata('idSale'); ?> | Recibo:<?php echo $nrorecibo; ?></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="x_panel">
                                        <form role="form" name="form_pago_sale" action="<?php echo base_url().'index.php/CSale/payregistersale'; ?>" method="post">
                                        
                                        <label class="control-label" for="pagacon">Paga con ($)</label>
                                        <input type="number" class="form-control" id="pagacon" name="pagacon" required="" >
                                        <input type="hidden" class="form-control" id="totalPago" name="totalPago" value="<?php echo ($totalservicios+$totalproductos+$totaladicional); ?>" >
                                        <input type="hidden" class="form-control" id="recibo" name="recibo" value="<?php echo $nrorecibo; ?>" >
                                        <br />
                                        <label for="formapago">Forma de Pago</label>
                                        <select class="form-control" name="formapago">
                                            <?php
                                            foreach ($list_forma_pago as $row){
                                                ?>
                                                <option value="<?php echo $row['idFormaPago'].'|'.$row['distribucionPago']; ?>"><?php echo $row['descFormaPago']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <br />
                                        <center>
                                        <p class="center-block download-buttons">
                                            <a href="<?php echo base_url().'index.php/CSale/waitdatasale'; ?>" class="btn btn-primary btn-lg">
                                                <i class="glyphicon glyphicon-time glyphicon-white"></i> Espera
                                            </a>
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="glyphicon glyphicon-check glyphicon-white"></i>
                                                Pagar
                                            </button>
                                        </p>
                                        <br />
                                        <div class="x_title">
                                            <h2>Resumen de Venta</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                                <li></li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <ul class="list-unstyled timeline">
                                                <li>
                                                    <div class="block" style="background-color: #81a4ba; color: white;">
                                                        <div class="tags" >
                                                            <div class="tag">
                                                                <span>Cliente</span>
                                                            </div>
                                                        </div>
                                                        <div class="block_content">
                                                            <h2 class="title">
                                                                Nro. Identificación: <?php echo $this->session->userdata('sclient'); ?>
                                                            </h2>
                                                            <p class="excerpt">
                                                                Nombre: ---
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="block" style="background-color: #5bdeaf; color: white;">
                                                        <div class="tags">
                                                            <div class="tag">
                                                                <span>Plato</span>
                                                            </div>
                                                        </div>
                                                        <div class="block_content">
                                                            <h2 class="title">
                                                                <?php
                                                                echo "Subtotal: $".number_format($servicios,0,',','.')." <br /> ";
                                                                echo "Descuento: $".number_format($descuento,0,',','.')." <br /> ";
                                                                echo "Total: $".number_format($totalservicios,0,',','.')."<br />";
                                                                ?>
                                                            </h2>
                                                            <p class="excerpt">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="block" style="background-color: #5ec0ff; color: white;">
                                                        <div class="tags">
                                                            <div class="tag">
                                                                <span>Productos</span>
                                                            </div>
                                                        </div>
                                                        <div class="block_content">
                                                            <h2 class="title">
                                                                <?php
                                                                echo "Subtotal: $".number_format($totalproductos,0,',','.')."<br />";
                                                                echo "Descuento: N/A <br /> ";
                                                                echo "Total: $".number_format($totalproductos,0,',','.')."<br />";
                                                                ?>
                                                            </h2>
                                                            <div class="byline">
                                                            </div>
                                                            <p class="excerpt">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="block" style="background-color: #ef777f; color: white;">
                                                        <div class="tags">
                                                            <div class="tag">
                                                                <span>Adicional</span>
                                                            </div>
                                                        </div>
                                                        <div class="block_content">
                                                            <h2 class="title">
                                                                <?php
                                                                echo "Subtotal: $".number_format($totaladicional,0,',','.')."<br />";
                                                                echo "Descuento: N/A <br /> ";
                                                                echo "Total: $".number_format($totaladicional,0,',','.')."<br />";
                                                                ?>
                                                            </h2>
                                                            <div class="byline">
                                                            </div>
                                                            <p class="excerpt">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        </center>
                                        </form>
                                    </div>
                                </div>
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
    
  </body>
</html>
