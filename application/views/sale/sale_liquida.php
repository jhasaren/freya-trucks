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
                                                <i class="glyphicon glyphicon-time glyphicon-white"></i> 
                                                Espera
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
                                        
                                        <!--Ticket informacion-->
                                        <div id="ticketPrint" class="x_content">
                                            <center style="font-size: 12px;">
                                            <img src="<?php echo base_url().'public/img/logo.png'; ?>" style="width: 86px; height: 64px" /><br />
                                            <?php echo $this->session->userdata('nombre_sede'); ?><br />
                                            <?php echo $this->session->userdata('dir_sede'); ?><br />
                                            <?php echo "Nro. Factura ".$detalleRecibo['general']->nroRecibo; ?>
                                            </center>
                                            <br />
                                            <table style="width: 100%">
                                                <tr>
                                                    <td align="center" style="font-size: 20px; font-weight:bold;">
                                                        TURNO <?php echo $turno; ?>
                                                    </td>
                                                </tr>                               
                                            </table>
                                            <table style="width: 100%">
                                                <?php
                                                /*Servicios*/
                                                if ($detalleRecibo['servicios'] != NULL){
                                                    foreach ($detalleRecibo['servicios']  as $valueServ){
                                                        ?>
                                                        <tr style="font-size: 12px;">
                                                            <td align="left"><?php echo "(".$valueServ['cantidad'].") ".$valueServ['descServicio']; ?></td>
                                                            <td align="right">$<?php echo number_format($valueServ['valor'],0,',','.'); ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                /*Productos*/
                                                if ($detalleRecibo['productos'] != NULL){
                                                    foreach ($detalleRecibo['productos']  as $valueProd){
                                                        ?>
                                                        <tr style="font-size: 12px;">
                                                            <td align="left"><?php echo "(".$valueProd['cantidad'].") ".$valueProd['descProducto']; ?></td>
                                                            <td align="right">$<?php echo number_format($valueProd['valor'],0,',','.'); ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                /*Adicionales*/
                                                if ($detalleRecibo['adicional'] != NULL){
                                                    foreach ($detalleRecibo['adicional']  as $valueAdc){
                                                        ?>
                                                        <tr style="font-size: 12px;">
                                                            <td align="left"><?php echo $valueAdc['cargoEspecial']; ?></td>
                                                            <td align="right">$<?php echo number_format($valueAdc['valor'],0,',','.'); ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <tr style="font-size: 12px; font-weight:bold;">
                                                    <td align="left">Subtotal:</td>
                                                    <td align="right">$<?php echo number_format($detalleRecibo['general']->valorTotalVenta,0,',','.'); ?></td>
                                                </tr>   
                                                <tr style="font-size: 12px;">
                                                    <td align="left">Descuento(<?php echo ($detalleRecibo['general']->porcenDescuento*100); ?>%):</td>
                                                    <td align="right">$<?php echo number_format(($detalleRecibo['general']->valorTotalVenta-$detalleRecibo['general']->valorLiquida),0,',','.'); ?></td>
                                                </tr>
                                                <tr style="font-size: 18px; font-weight:bold;">
                                                    <td align="left">Total a Pagar:</td>
                                                    <td align="right">$<?php echo number_format($detalleRecibo['general']->valorLiquida,0,',','.'); ?></td>
                                                </tr>
                                                <tr style="font-size: 12px;">
                                                    <td align="left">Paga con:</td>
                                                    <td align="right">$<?php echo number_format($pagacon,0,',','.'); ?></td>
                                                </tr>
                                                <tr style="font-size: 12px;">
                                                    <td align="left">Cambio:</td>
                                                    <td align="right">$<?php echo number_format($cambio,0,',','.'); ?></td>
                                                </tr>                           
                                            </table>
                                            <center style="font-size: 12px;">
                                            <br />
                                            Burger Republic agradece su compra!<br />
                                            <?php echo date("Y-m-d h:i:s"); ?>
                                            </center>
                                        </div>
                                        <!--Fin Ticket informacion-->
                                        
                                        <input id="btnprint" class="btn btn-success btn-lg" type="button" value="Imprimir Ticket" onclick="PrintElem('#ticketPrint')" />
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
    <!--impresion Ticket-->
    <script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var myWindow = window.open('', 'Ticket', 'height=400,width=600');
        myWindow.document.write('<html><head><title>Ticket de Venta</title>');
        myWindow.document.write('</head><body >');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');
        myWindow.document.close(); //necessary for IE >= 10
        
        myWindow.focus(); //necessary for IE >= 10
        myWindow.print();
        myWindow.close();
        
        /*myWindow.onload=function(){ //necessary if the div contain images
            console.log("Imprime");
            myWindow.focus(); //necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };*/
    }
    </script>
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
