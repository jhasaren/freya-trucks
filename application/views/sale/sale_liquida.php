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
    <!-- iCheck -->
    <link href="<?php echo base_url().'public/gentelella/vendors/iCheck/skins/flat/green.css'; ?>" rel="stylesheet">
    
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
                                <?php
                                if ($detalleRecibo['formaPago'] != NULL){
                                    foreach ($detalleRecibo['formaPago']  as $valueFormPay){
                                        $pagado = $pagado + $valueFormPay['valorPago'];
                                    }
                                }
                                ?>
                                <div></div>
                                <span style="font-size: 18px">
                                    <h1 style="color: #000000; font-size: 28px">Total a Pagar: $<?php echo number_format($message-$pagado,0,',','.'); ?></h1>
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
                                            <label class="control-label" for="pagavalor">Valor ($)</label>
                                            <input type="text" style="font-family: Arial; font-size: 18pt; background-color: #E0DD70; color: #000" class="form-control" id="pagacon" name="pagavalor" required="" placeholder="Valor Pagado" autocomplete="off" >
                                            <input type="hidden" class="form-control" id="totalPago" name="totalPago" value="<?php echo ($totalservicios+$totalproductos+$totaladicional)+(($totalservicios+$totalproductos+$totaladicional)*$this->session->userdata('sservicio')/100); ?>" >
                                            <input type="hidden" class="form-control" id="valuepagado" name="valuepagado" value="<?php echo $pagado; ?>" >
                                            <input type="hidden" class="form-control" id="saldopay" name="saldopay" value="<?php echo $message-$pagado; ?>" >
                                            <input type="hidden" class="form-control" id="porcServiceVenta" name="porcServiceVenta" value="<?php echo $this->session->userdata('sservicio'); ?>" >
                                            <input type="hidden" class="form-control" id="recibo" name="recibo" value="<?php echo $nrorecibo; ?>" >

                                            <select class="form-control" name="formapago">
                                                <?php
                                                foreach ($list_forma_pago as $row){
                                                    ?>
                                                    <option value="<?php echo $row['idTipoPago']; ?>"><?php echo $row['descTipoPago']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            
                                            <input type="number" class="form-control" id="ref_pago" name="ref_pago" placeholder="Referencia del Pago" >
                                            <br />
                                            <input type="checkbox" class="flat" name="mixpayment"> Pago Parcial
                                            <br /><br />
                                            <center>
                                            <p class="center-block download-buttons">
                                                <a href="<?php echo base_url().'index.php/CSale/waitdatasale'; ?>" class="btn btn-primary btn-lg">
                                                    <i class="glyphicon glyphicon-time glyphicon-white"></i> 
                                                    CxCobrar
                                                </a>
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="glyphicon glyphicon-check glyphicon-white"></i>
                                                    Pagar
                                                </button>
                                            </p>
                                            <br />
                                            </center>
                                        </form>
                                    </div>
                                    <div class="x_panel">
                                        Forma de Pago:<br />
                                        <table id="datatable" class="table table-responsive">
                                            <thead>
                                                <th>Tipo</th>
                                                <th>Valor</th>
                                                <th>Referencia</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($detalleRecibo['formaPago'] != NULL){
                                                    foreach ($detalleRecibo['formaPago'] as $valueFormPay){
                                                        ?>
                                                        <tr style="background-color: #FFFFFF;">
                                                            <td class="small green"><?php echo $valueFormPay['descTipoPago']; ?></td>
                                                            <td class="small blue">$<?php echo number_format($valueFormPay['valorPago'],0,',','.'); ?></td>
                                                            <td class="small"><?php echo $valueFormPay['referenciaPago']; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <tr style="background-color: #FFFFFF;">
                                                    <td class="small green"></td>
                                                    <td class="small red">$<?php echo number_format($pagado,0,',','.'); ?></td>
                                                    <td class="small"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="x_panel">
                                        <form role="form" name="form_pago_sale" action="<?php echo base_url().'index.php/CSale/imprimeticketliq'; ?>" method="post">
                                            <center>
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
                                                    <?php echo "DIR: ".$detalleRecibo['general']->dir_cliente." TEL: ".$detalleRecibo['general']->tel_cliente; ?>
                                                </p>
                                                <!--
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td align="center" style="font-size: 20px; font-weight:bold;">
                                                            TURNO <?php //echo $turno; ?>
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
                                                        <td align="left">Servicio(<?php echo (round($this->session->userdata('sservicio'),2)); ?>%):</td>
                                                        <td align="right">+$<?php echo number_format(($detalleRecibo['general']->valorLiquida*$this->session->userdata('sservicio')/100),0,',','.'); ?></td>
                                                    </tr>
                                                    <tr style="font-size: 18px; font-weight:bold;">
                                                        <td align="left">Total a Pagar:</td>
                                                        <td align="right">$<?php echo number_format($detalleRecibo['general']->valorLiquida+($detalleRecibo['general']->valorLiquida*$this->session->userdata('sservicio')/100),0,',','.'); ?></td>
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

                                            <!--Impresion por libreria mike32-->
                                            <!--<a href="<?php //echo base_url().'index.php/CSale/imprimeticket/'.$detalleRecibo."/0"; ?>" class="btn btn-primary btn-lg">
                                                <i class="glyphicon glyphicon-time glyphicon-white"></i> 
                                                Imprimir Ticket
                                            </a>-->
                                            <!--Impresion por libreria mike32-->
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="glyphicon glyphicon-check glyphicon-white"></i>
                                                Imprimir Ticket
                                            </button>
                                            <!--Impresion por navegador-->
                                            <!--<input id="btnprint" class="btn btn-success btn-lg" type="button" value="Imprimir Ticket" onclick="PrintElem('#ticketPrint')" />-->
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
    <!-- iCheck -->
    <script src="<?php echo base_url().'public/gentelella/vendors/iCheck/icheck.min.js'; ?>"></script>
    <!-- Autonumeric -->
    <!--<script src="<?php //echo base_url().'public/gentelella/vendors/autonumeric/AutoNumeric.js'; ?>"></script>-->
    <script src="https://cdn.jsdelivr.net/autonumeric/2.0.0/autoNumeric.min.js"></script>
    <script>
    /*AutoNumeric*/
    $("#pagacon").autoNumeric('init',{
        allowDecimalPadding : "false",
        decimalCharacter : ',',
        digitGroupSeparator : '.',
    });
    </script>
  </body>
</html>
