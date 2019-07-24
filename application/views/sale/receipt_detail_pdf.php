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
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">-->
    <!-- NProgress -->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/nprogress/nprogress.css'; ?>" rel="stylesheet">-->
    <!-- Custom Theme Style -->
    <!--<link href="<?php // echo base_url().'public/gentelella/build/css/custom.min.css'; ?>" rel="stylesheet">-->
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Venta ID:<?php echo $venta; ?></h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Recibo No.<?php echo $recibo; ?></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php 
                                echo "Estado: ".$general->descEstadoRecibo."<br />";
                                echo "Fecha Registro: ".$general->fechaLiquida."<br />"; 
                                echo "Liquida: ".$general->personaLiquida." [".$general->idUsuarioLiquida."]<br />";
                                echo "Cliente: ".$general->personaCliente." [CC. ".$general->idUsuarioCliente."]<br />";
                                echo "Atiende: ".$general->personaAtiende." [CC. ".$general->idEmpleadoAtiende."]<br />";
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
                                <hr />
                                <?php
                                echo "<h3>";
                                echo "<B>Subtotal 1: $".number_format($general->valorTotalVenta,0,',','.')."</B><br />";
                                echo "Descuento: $".number_format($general->valorTotalVenta-($general->valorLiquida),0,',','.')." *Solo aplica a servicios<br />";
                                echo "<B>Subtotal 2: $".number_format($general->valorLiquida,0,',','.')."</B><br />";
                                echo "Atención: $".number_format($general->valorLiquida*$general->porcenServicio,0,',','.')."<br />";
                                echo "<B>Valor Pagado: $".number_format($general->valorLiquida+($general->valorLiquida*$general->porcenServicio),0,',','.')."</B><br />";
                                echo "</h3>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    
  </body>
</html>
