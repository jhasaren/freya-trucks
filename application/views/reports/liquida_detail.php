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
                        <h3>Liquidación Empleado</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
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
                                <h2></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                
                                <section class="content invoice">
                                    <form role="form" name="form_cierre" action="<?php echo base_url() . 'index.php/CReport/paymentcierre'; ?>" method="post">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-xs-12 invoice-header">
                                            <h1>
                                                <i class="fa fa-money"></i> Comprobante de pago
                                                <small class="pull-right">Fecha: <?php echo date('Y-m-d'); ?></small>
                                            </h1>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- info row -->
                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            Empleado:
                                            <?php
                                            if ($liquidaDetalle != FALSE){
                                                foreach ($liquidaDetalle as $valueServ) {
                                                    $nombreEmpleado = $valueServ['nombreEmpleado'];
                                                    $idEmpleado = $valueServ['idEmpleado'];
                                                    $direccion = $valueServ['direccion'];
                                                    $telefono = $valueServ['numCelular'];
                                                    $email = $valueServ['email'];
                                                    $idSede = $valueServ['idSede'];
                                                    $sede = $valueServ['nombreSede'];
                                                    $nitSede = $valueServ['nitSede'];
                                                    $dirSede = $valueServ['direccionSede'];
                                                    $telSede = $valueServ['telefonoSede'];
                                                }
                                            }
                                            ?>
                                            <address>
                                                <strong><?php echo $nombreEmpleado; ?></strong>
                                                <br><strong>CC.<?php echo $idEmpleado; ?></strong>
                                                <br><?php echo $direccion; ?>
                                                <br>Tel. <?php echo $telefono; ?>
                                                <br>Email: <?php echo $email; ?>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 invoice-col">
                                            Entidad:
                                            <address>
                                                <strong><?php echo $sede; ?></strong>
                                                <br><?php echo $nitSede; ?>
                                                <br><?php echo $dirSede; ?>
                                                <br><?php echo $telSede; ?>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 invoice-col">
                                            <b>Orden #
                                                <?php 
                                                $order = time();
                                                echo $order; 
                                                ?>
                                            </b>
                                            <br>
                                            <br>
                                            <b>Periodo</b>
                                            <br>
                                            <b>Desde:</b> <?php echo $fechaDesde; ?>
                                            <br>
                                            <b>Hasta:</b> <?php echo $fechaHasta; ?>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <!-- Table row -->
                                    <div class="row">
                                        <div class="col-xs-12 table">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#Recibo</th>
                                                        <th>Fecha Registro</th>
                                                        <th style="width: 39%">Descripcion</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($liquidaDetalle != FALSE){
                                                        $totalPayment = 0;
                                                        foreach ($liquidaDetalle as $row_liq){
                                                            if ($row_liq['idEstadoRecibo'] == 6){
                                                                ?>
                                                                <tr>
                                                                    <td class="center"><?php echo $row_liq['nroRecibo']; ?></td>
                                                                    <td class="center"><?php echo $row_liq['fechaLiquida']; ?></td>
                                                                    <td class="center"><?php echo $row_liq['nombreSede']; ?></td>
                                                                    <td class="center">$<?php echo number_format($row_liq['valorEmpleado'],0,',','.'); ?></td>
                                                                </tr>
                                                                <?php
                                                                $totalPayment = $totalPayment + $row_liq['valorEmpleado'];
                                                                ?>
                                                                <input type="hidden" name="recibos[]" value="<?php echo $row_liq['nroRecibo']; ?>">
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                    if ($totalPayment == 0){
                                                    ?>
                                                    <div class="alert alert-info alert-dismissible fade in" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                                        </button>
                                                        Todos los recibos del periodo seleccionado ya fueron liquidados al empleado.
                                                    </div>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <div class="row">
                                        <!-- accepted payments column -->
                                        <div class="col-xs-6">
                                            <p class="lead">Nota(s):</p>
                                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                * La información de este comprobante se expide como soporte de pago al empleado.<br />
                                                * Si la liquidación presenta algún tipo de novedad debe reportarlo presentando este comprobante.
                                            </p>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-xs-6">
                                            <p class="lead">Liquidación</p>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:50%">Subtotal:</th>
                                                            <td>$<?php echo number_format($totalPayment,0,',','.'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Retefuente:</th>
                                                            <td>$0</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Otros:</th>
                                                            <td>$0</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total:</th>
                                                            <td>$<?php echo number_format($totalPayment,0,',','.'); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <!-- this row will not appear when printing -->
                                    <div class="row no-print">
                                        <div class="col-xs-12">
                                            <input type="hidden" name="fechaini" value="<?php echo $fechaDesde; ?>">
                                            <input type="hidden" name="fechafin" value="<?php echo $fechaHasta; ?>">
                                            <input type="hidden" name="orden" value="<?php echo $order; ?>">
                                            <input type="hidden" name="empleado" value="<?php echo $idEmpleado; ?>"> 
                                            <input type="hidden" name="nombreEmpleado" value="<?php echo $nombreEmpleado; ?>">
                                            <input type="hidden" name="sede" value="<?php echo $idSede; ?>">
                                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                                            
                                            <?php if ($totalPayment != 0) { ?>
                                            <button type="submit" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Liquidar</button>
                                            <?php } ?>
                                            <a href="<?php echo base_url() . 'index.php/CReport/module/reportNomina'; ?>" class="btn btn-danger pull-right">
                                                <i class="fa fa-backward"></i> Regresar
                                            </a>
                                        </div>
                                    </div>
                                    </form>
                                    <button class="btn btn-success pull-right" onclick="window.print();"><i class="fa fa-print"></i> Imprimir</button>
                                </section>
                                
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
