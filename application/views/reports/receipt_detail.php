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
                        <h3>Detalle Recibo No.<?php echo $recibo; ?></h3>
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
                                <h2>Venta ID:<?php echo $venta; ?></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php 
                                echo "Estado: ".$general->descEstadoRecibo."<br />";
                                echo "Fecha Pedido: ".$general->fechaLiquida."<br />"; 
                                echo "Fecha Pago: ".$general->fechaPideCuenta."<br />"; 
                                echo "Liquida: ".$general->personaLiquida." [".$general->idUsuarioLiquida."]<br />";
                                echo "Cliente: ".$general->personaCliente." [CC. ".$general->idUsuarioCliente."]<br />";
                                echo "Atiende: ".$general->personaAtiende." [CC. ".$general->idEmpleadoAtiende."]<br />";
                                echo "Subtotal 1: $".number_format($general->valorTotalVenta,0,',','.')."<br />";
                                echo "Descuento: ".($general->porcenDescuento*100)."% *Solo aplica a servicios<br />";
                                echo "Subtotal 2: $".number_format($general->valorLiquida,0,',','.')."<br />";
                                echo "Atención: $".number_format(($general->valorLiquida*$general->porcenServicio),0,',','.')."<br />";
                                echo "<B>Valor Pagado: $".number_format($general->valorLiquida+($general->valorLiquida*$general->porcenServicio),0,',','.')."</B><br />";
                                echo "Base: $".number_format(($general->valorLiquida/($general->impoconsumo+1)),0,',','.')."<br />";
                                echo "Impoconsumo (%".($general->impoconsumo*100)."): $".number_format(($general->valorLiquida/($general->impoconsumo+1))*$general->impoconsumo,0,',','.')."<br />";
                                ?>
                                <hr />
                                <?php
                                /*Forma de Pago*/
                                echo "<h4>Forma de Pago</h4>";
                                if ($formaPago == NULL){
                                    echo "--";
                                } else {
                                    foreach ($formaPago as $valueFormPago) {
                                        echo $valueFormPago['descTipoPago']." -> Valor: $".number_format($valueFormPago['valorPago'],0,',','.')." | Ref: ".$valueFormPago['referenciaPago']."<br />";
                                    }
                                }
                                
                                ?>
                                <hr />
                                <?php
                                /*Servicios*/
                                echo "<h3>Servicios</h3>";
                                if ($servicios == NULL){
                                    echo "--";
                                } else {
                                    foreach ($servicios as $valueServ) {
                                        echo $valueServ['descServicio']." -> Cantidad: ".$valueServ['cantidad']." -> $".number_format($valueServ['valor'],0,',','.')."<br />";
                                    }
                                }

                                /*Productos*/
                                echo "<h3>Productos</h3>";
                                if ($productos == NULL){
                                    echo "--";
                                } else {
                                    foreach ($productos as $valueProd) {
                                        echo $valueProd['descProducto']." -> Cantidad: ".$valueProd['cantidad']." -> $".number_format($valueProd['valor'],0,',','.')."<br />";
                                    }
                                }

                                /*Adicional*/
                                echo "<h3>Adicional</h3>";
                                if ($adicional == NULL){
                                    echo "--";
                                } else {
                                    foreach ($adicional as $valueAdic) {
                                        echo $valueAdic['cargoEspecial']." -> $".number_format($valueAdic['valor'],0,',','.')."<br />";
                                    }
                                }
                                ?>
                                <br /><br />
                            </div>
                            <center>
                                <a href="<?php echo base_url() . 'files/recibos/recibo_'.$recibo.'.pdf'; ?>" class="btn btn-primary btn-lg" target="_blank">
                                    <i class="glyphicon glyphicon-search glyphicon-download"></i> Descargar PDF
                                </a>
                                <a href="<?php echo base_url() . 'index.php/CReport/module/reportPayment'; ?>" class="btn btn-info btn-lg">
                                    <i class="glyphicon glyphicon-search glyphicon-white"></i> Consultar Otro
                                </a>
                                <!--Reimprime Ticket-->
                                <form role="form" name="form_tick_sale" action="<?php echo base_url().'index.php/CReport/reimprimeticket'; ?>" method="post">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="glyphicon glyphicon-check glyphicon-white"></i>
                                        Reimprimir Ticket
                                    </button>
                                </form>
                                <!--Fin: Reimprime Ticket-->
                            </center>
                            
                            <?php if ($general->idEstadoRecibo != 3) { ?>
                            <div class="x_content">
                                <form role="form" name="form_receipt_anul" action="<?php echo base_url() . 'index.php/CReport/anularecibo'; ?>" method="post">
                                    <div class="modal-body">
                                        <fieldset>
                                            <div class="col-md-4 xdisplay_inputx form-group"></div>
                                            <div class="col-md-4 xdisplay_inputx form-group">
                                                <input type="text" name="motivoanula" required="" class="form-control" placeholder="Motivo de Anulacion" autocomplete="off" style="height: 80px;" maxlength="90" >
                                                <input type="hidden" name="recibo" value="<?php echo $recibo; ?>" >
                                            </div>
                                            <div class="col-md-4 xdisplay_inputx form-group has-feedback"></div>
                                        </fieldset>
                                        <center>
                                            <button type="submit" class="btn btn-warning">Anular</button>
                                        </center>
                                    </div>
                                </form>
                            </div>
                            <?php } else { ?>
                            <div class="x_content">
                                    <div class="modal-body">
                                        <fieldset>
                                            <div class="col-md-4 xdisplay_inputx form-group"></div>
                                            <div class="col-md-4 xdisplay_inputx form-group">
                                                <B>Motivo Anulación:</B><br />
                                                <?php echo $general->motivoAnula; ?><br />
                                                <B>Usuario Anula:</B>
                                                <?php echo $general->usuarioAnula; ?><br />
                                                <B>Fecha Anulación:</B>
                                                <?php echo $general->fechaAnula; ?><br />
                                            </div>
                                            <div class="col-md-4 xdisplay_inputx form-group has-feedback"></div>
                                        </fieldset>
                                    </div>
                            </div>
                            <?php } ?>
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
