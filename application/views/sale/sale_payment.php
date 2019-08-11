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
                        <h3>Venta Finalizada</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <span style="color: #000; font-size: 22px;">
                            Paga con:
                            $<?php echo number_format($pagacon,0,',','.'); ?>
                        </span>
                        <br />
                        <span style="color: #000; font-size: 22px;">
                            Cambio:
                            $<?php echo number_format($cambio,0,',','.'); ?>
                        </span>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <!--Alerta-->
                        <div class="alert alert-info alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <?php echo $message; ?>
                        </div>
                        <!--/Alerta-->
                        
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Pago Exitoso</h2>
                                <div class="clearfix"></div>
                            </div>
                            
                            <!--Ticket informacion-->
                            <div id="myDiv" class="x_content">
                                <center style="font-size: 12px;">
                                <!--<img src="<?php // echo base_url().'public/img/logo.png'; ?>" style="width: 86px; height: 64px" /><br />-->
                                <?php echo $this->session->userdata('nombre_sede'); ?><br />
                                <?php echo $this->session->userdata('dir_sede'); ?><br />
                                <?php echo $this->config->item('nit_recibo'); ?><br />
                                <?php echo "Factura de Venta #".$detalleRecibo['general']->nroRecibo; ?><br />
                                <?php echo "Lugar: ".$detalleRecibo['general']->nombreMesa; ?> | <?php echo "Turno: ".$turno; ?>
                                </center>
                                <br />
                                <p align='left'>
                                    <?php echo "Cliente: ".$detalleRecibo['general']->personaCliente; ?><br />
                                    <?php echo "NIT/CC: ".$detalleRecibo['general']->idUsuarioCliente; ?><br />
                                    <?php echo "DIR: ".$detalleRecibo['general']->dir_cliente." TEL:".$detalleRecibo['general']->tel_cliente; ?>
                                </p>
                                <!--
                                <table style="width: 100%">
                                    <tr>
                                        <td align="center" style="font-size: 20px; font-weight:bold;">
                                            TURNO <?php echo $turno; ?>
                                        </td>
                                    </tr>                               
                                </table>
                                -->
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
                                        <td align="left">Subtotal 1:</td>
                                        <td align="right">$<?php echo number_format($detalleRecibo['general']->valorTotalVenta,0,',','.'); ?></td>
                                    </tr>   
                                    <tr style="font-size: 12px;">
                                        <td align="left">Descuento(<?php echo ($detalleRecibo['general']->porcenDescuento*100); ?>%):</td>
                                        <td align="right">-$<?php echo number_format(($detalleRecibo['general']->valorTotalVenta-$detalleRecibo['general']->valorLiquida),0,',','.'); ?></td>
                                    </tr>
                                    <tr style="font-size: 12px; font-weight:bold;">
                                        <td align="left">Subtotal 2:</td>
                                        <td align="right">$<?php echo number_format($detalleRecibo['general']->valorLiquida,0,',','.'); ?></td>
                                    </tr>  
                                    <tr style="font-size: 12px;">
                                        <td align="left">Atención(<?php echo (round($this->session->userdata('sservicio'),2)); ?>%):</td>
                                        <td align="right">+$<?php echo number_format(($detalleRecibo['general']->valorLiquida*$porcServiceVenta/100),0,',','.'); ?></td>
                                    </tr>
                                    <tr style="font-size: 18px; font-weight:bold;">
                                        <td align="left">Total a Pagar:</td>
                                        <td align="right">$<?php echo number_format($detalleRecibo['general']->valorLiquida+($detalleRecibo['general']->valorLiquida*$porcServiceVenta/100),0,',','.'); ?></td>
                                    </tr>     
                                    <?php 
                                    if ($this->config->item('impo_add_factura') == 1){
                                    ?>
                                    <!--Base-->
                                    <tr style="font-size: 12px;">
                                        <td align="left">Base:</td>
                                        <td align="right">$<?php echo number_format((($detalleRecibo['general']->valorLiquida+($detalleRecibo['general']->valorLiquida*0/100))/($detalleRecibo['general']->impoconsumo+1)),0,',','.'); ?></td>
                                    </tr>
                                    <!--Impuesto-->
                                    <tr style="font-size: 12px;">
                                        <td align="left">Impoconsumo (<?php echo $detalleRecibo['general']->impoconsumo*100; ?>%):</td>
                                        <!--<td align="right">-$<?php //echo number_format(($detalleRecibo['general']->valorLiquida+($detalleRecibo['general']->valorLiquida*$this->session->userdata('sservicio')/100))*$detalleRecibo['general']->impoconsumo,0,',','.'); ?></td>-->
                                        <td align="right">$<?php echo number_format(((($detalleRecibo['general']->valorLiquida+($detalleRecibo['general']->valorLiquida*0/100))/($detalleRecibo['general']->impoconsumo+1))*$detalleRecibo['general']->impoconsumo),0,',','.'); ?></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                                <center style="font-size: 12px;">
                                <br />
                                <?php echo $detalleRecibo['general']->resolucionExpide; ?><br />
                                Gracias por Preferirnos!<br />
                                Freya Software - Amadeus Soluciones<br />
                                <?php echo date("Y-m-d H:i:s"); ?>
                                </center>
                            </div>
                            <!--Fin Ticket informacion-->
                            
                            <div class="clearfix"></div>
                        </div>
                        <center>
                        <p class="center-block download-buttons">
                            <!--<input id="btnprint" class="btn btn-success btn-lg" type="button" value="Imprimir Ticket" onclick="PrintElem('#myDiv')" />-->
                            <a href="<?php echo base_url().'index.php/CSale/boards/2'; ?>" class="btn btn-success btn-lg">
                                <i class="glyphicon glyphicon-repeat glyphicon-white"></i> Nueva venta
                            </a>
                        </p>
                        </center>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        
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
        
    //Lanzamos la llamada al evento click
    /*$(document).ready(function () {
            console.log("Imprimir Ticket");
            $("#btnprint").click();
    });*/
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
