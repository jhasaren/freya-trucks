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
                        <?php
                        /*echo "Tipo Gasto->".$this->cache->memcached->get('memcached20')."<br />";
                        echo "Estado Gasto->".$this->cache->memcached->get('memcached21')."<br />";
                        echo "Lista Proveedores->".$this->cache->memcached->get('memcached22')."<br />";
                        echo "Lista Categ Gasto->".$this->cache->memcached->get('memcached23');*/
                        ?>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-success btn-gasto" href="#"><i class="glyphicon glyphicon-plus"></i> Registrar</a>
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
                                <h2>Registro de Gastos</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form role="form" name="form_report_gastos" action="<?php echo base_url().'index.php/CReport/gastossedes'; ?>" method="post">
                                    <div class="modal-body">
                                        <fieldset>
                                            <div class="col-md-3 xdisplay_inputx form-group has-feedback"></div>
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
                                <?php if ($dataRow == 1) { ?>
                                    
                                    <!-- Detalle Gastos por sede-->   
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Detalle</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">FechaPago</th>
                                                            <th class="center">Descripcion</th>
                                                            <th class="center">Valor</th>
                                                            <th class="center">Factura</th>
                                                            <th class="center">Tipo</th>
                                                            <th class="center">Categoria</th>
                                                            <th class="center">Estado</th>
                                                            <th>Sede</th>
                                                            <th>Proveedor</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($gastosDataSedes != FALSE){
                                                            foreach ($gastosDataSedes as $row_gasto){
                                                                ?>
                                                                <tr style="background-color: #2A3F54;">
                                                                    <td class="center"><small><?php echo $row_gasto['fechaPago']; ?></small></td>
                                                                    <td class="green"><small><?php echo $row_gasto['descGasto']; ?></small></td>
                                                                    <td class="green">$<?php echo number_format($row_gasto['valorGasto'],0,',','.'); ?></td>
                                                                    <td class="center"><small><?php echo $row_gasto['nroFactura']; ?></small></td>
                                                                    <td class="blue"><small><?php echo $row_gasto['descTipoGasto']; ?></small></td>
                                                                    <td class="blue"><small><?php echo $row_gasto['descCategoria']; ?></small></td>
                                                                    <?php if ($row_gasto['idEstadoGasto'] == 1) { ?>
                                                                    <td class="red"><small><?php echo $row_gasto['descEstadoGasto']; ?></small></td>
                                                                    <?php } else { ?>
                                                                    <td class="blue"><small><?php echo $row_gasto['descEstadoGasto']; ?></small></td>
                                                                    <?php } ?>
                                                                    <td class="center"><small><?php echo $row_gasto['nombreSede']; ?></small></td>
                                                                    <td class="center"><small><?php echo $row_gasto['proveedor']; ?></small></td>
                                                                    <td class="center">
                                                                        <a class="btn btn-default btn-sm" href="<?php echo base_url().'index.php/CPrincipal/dataedit/gastos/'.$row_gasto['idGasto']; ?>">
                                                                            <i class="glyphicon glyphicon-cog"></i>
                                                                            Editar
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Detalle Gastos por sede--> 
                                    
                                    <!-- Consolidado Gastos por sede-->   
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Consolidado</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">Sede</th>
                                                            <th class="center">Tipo de Gasto</th>
                                                            <th class="center">Valor Pagado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($consGastosSede != FALSE){
                                                            foreach ($consGastosSede as $row_gastoCons){
                                                                ?>
                                                                <tr style="background-color: #2A3F54;">
                                                                    <td class="green"><?php echo $row_gastoCons['nombreSede']; ?></td>
                                                                    <td class="blue"><?php echo $row_gastoCons['descTipoGasto']; ?></td>
                                                                    <td class="green">$<?php echo number_format($row_gastoCons['valor'],0,',','.'); ?></td>
                                                                </tr>
                                                                <?php
                                                                $totalPagado = $totalPagado + $row_gastoCons['valor'];
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <h2 align="right">Gasto Total: <?php echo "$".number_format($totalPagado,0,',','.'); ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Consolidado Gastos por sede-->
                                    
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <!--</div>-->

            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Agregar Gasto-->
        <div class="modal fade" id="myModal-gasto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-gasto" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_gasto" action="<?php echo base_url() . 'index.php/CReport/addgasto/1'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Registrar Gasto</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tipo_gasto">Tipo de Gasto</label>
                                <select class="form-control" name="tipo_gasto">
                                    <?php
                                    foreach ($listTypeGasto as $row1) {
                                        ?>
                                        <option value="<?php echo $row1['idTipoGasto']; ?>"><?php echo $row1['descTipoGasto']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="categoria_gasto">Categoria</label>
                                <select class="form-control" name="categoria_gasto">
                                    <?php
                                    foreach ($listCategoria as $rowCate) {
                                        ?>
                                        <option value="<?php echo $rowCate['idCategoriaGasto']; ?>"><?php echo $rowCate['descCategoria']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="select">Proveedor</label>
                                <div class="controls">
                                    <input class="select2_single form-control" type="text" name="idproveedor" id="idproveedor" required="" />
                                </div>  
                            </div>
                            <div class="form-group">
                                <label for="describe_gasto">Descripción</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="describe_gasto" name="describe_gasto" placeholder="Detalle del Gasto" required="" autocomplete="On" maxlength="95" />
                            </div>
                            <div class="form-group">
                                <label for="valor_gasto">Valor ($)</label>
                                <input type="tel" class="form-control" id="valor_gasto" name="valor_gasto" placeholder="Pesos CO" required="" pattern="\d*" >
                                <input type="tel" class="form-control" id="nro_factura" name="nro_factura" placeholder="Numero de Factura (Opcional)" >
                            </div>
                            <div class="form-group">
                                <label for="fecha_pago">Fecha Pago</label>
                                <input type="text" name="fecha_pago" required="" class="form-control has-feedback-left" id="single_cal4" value="<?php echo $fechaIni; ?>" placeholder="Fecha Pago" aria-describedby="inputSuccess2Status" readonly="">
                                <span class="left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
                            </div>
                            <div class="form-group">
                                <label for="estado_gasto">Estado</label>
                                <select class="form-control" name="estado_gasto">
                                    <?php
                                    foreach ($listStateGasto as $row2) {
                                        ?>
                                        <option value="<?php echo $row2['idEstadoGasto']; ?>"><?php echo $row2['descEstadoGasto']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Guardar</button>
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
   
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url().'public/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js'; ?>"></script>
    <script>
    var proveedores = [
        <?php foreach ($listProveedores as $row_prov) { ?>
            { value: '<?php echo $row_prov['nombre_usuario']." |".$row_prov['idUsuario']; ?>' },
        <?php } ?>
    ];

    $('#idproveedor').autocomplete({
        lookup: proveedores
    });
    </script>
    
  </body>
</html>
