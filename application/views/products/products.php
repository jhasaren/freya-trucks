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
    <!-- Datatables Buttons -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'; ?>" rel="stylesheet">
    
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
                        <h3>Productos/Ingredientes</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-success btn-producto" href="#"><i class="glyphicon glyphicon-plus"></i> Agregar</a>
                                </span>
                                <span class="input-group-btn">
                                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CProduct/stock'; ?>"><i class="glyphicon glyphicon-eye-open"></i> Ver Stock</a>
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
                                <h2>Detalle de Productos</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Costo</th>
                                        <th>Venta</th>
                                        <th>Unidosis</th>
                                        <th>Disponible</th>
                                        <th>Grupo</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($list_products != FALSE){
                                            foreach ($list_products as $row_list){
                                                ?>
                                                <tr style="background-color: #2A3F54;">
                                                    <td class="center green"><?php echo $row_list['descProducto']; ?></td>
                                                    <td class="center blue">$<?php echo number_format($row_list['costoProducto'],0,',','.'); ?></td>
                                                    <td class="center red">$<?php echo number_format($row_list['valorProducto'],0,',','.'); ?></td>
                                                    <td class="center"><?php echo $row_list['uniDosis']." ".$row_list['aliasUnidad']; ?></td>
                                                    <td class="center green"><?php echo $row_list['disponibles']; ?></td>
                                                    <td class="center blue"><?php echo $row_list['descGrupoServicio']; ?></td>
                                                    <td class="center"><?php echo $row_list['descTipoProducto']; ?></td>
                                                    <td class="center">
                                                        <?php if ($row_list['activo'] == 'S') { ?>
                                                        <span class="label label-success">Activo</span>
                                                        <?php } else { ?>
                                                        <span class="label label-danger">Inactivo</span>
                                                        <?php }?>
                                                    </td>
                                                    <td class="center">
                                                        <a class="btn btn-default btn-sm" href="<?php echo base_url().'index.php/CPrincipal/dataedit/product/'.$row_list['idProducto']; ?>">
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
                    
                <!--</div>-->
            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Agregar Producto-->
        <div class="modal fade" id="myModal-producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-producto" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_service" action="<?php echo base_url() . 'index.php/CProduct/addproduct'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Producto/Ingrediente</h3>
                            <?php
                            //echo "Lista productos->".$this->cache->memcached->get('memcached3')."<br />";
                            //echo "Tipo Productos->".$this->cache->memcached->get('memcached4');
                            //echo "Tipo Unidades->".$this->cache->memcached->get('memcached32');
                            ?>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nameproduct" name="nameproduct" placeholder="Descripcion del Producto" required="">
                            </div>
                            <div class="form-group">
                                <label for="costoProducto">Costo ($)</label>
                                <input type="tel" class="form-control" id="costoProducto" name="costoProducto" placeholder="Pesos CO" required="" pattern="\d*">
                            </div>
                            <div class="form-group">
                                <label for="valorProducto">Valor de Venta ($)</label>
                                <input type="tel" class="form-control" id="valueproduct" name="valueproduct" placeholder="Pesos CO" required="" pattern="\d*">
                            </div>
                            <!--<div class="form-group">-->
                                <!--<label for="distribucionEmpleado">Distribución Empleado</label>-->
                                <input type="hidden" class="form-control" id="distributionproduct" name="distributionproduct" value="0">
                            <!--</div>-->
                            <div class="form-group">
                                <label for="stock">
                                    Stock
                                    <a href="#" class="label label-info" data-toggle="tooltip" data-placement="right" title="Unidades=Cantidad de productos a ingresar en el stock | Unidosis=Cantidad de unidades que se restaran del stock por cada venta/servicio.">Info</a>
                                </label>
                                <select class="form-control" name="undmedida">
                                   <?php
                                    foreach ($list_und as $row_und) {
                                        ?>
                                        <option value="<?php echo $row_und['idUnidadMedida']; ?>"><?php echo $row_und['nombreUnidad']." (".$row_und['aliasUnidad'].")"; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <input type="tel" class="form-control" id="stock" name="stock" placeholder="Cantidad Disponible" required="" pattern="\d*">
                                <input type="tel" class="form-control" id="unidosis" name="unidosis" placeholder="Unidosis de consumo" required="" pattern="\d*">
                            </div>
                            <div class="form-group">
                                <label for="GrupoServicio">Tipo de Producto</label>
                                <select class="form-control" name="typeproduct">
                                    <?php
                                    foreach ($list_type as $row) {
                                        ?>
                                        <option value="<?php echo $row['idTipoProducto']; ?>"><?php echo $row['descTipoProducto']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="GrupoServicio">Grupo</label>
                                <select class="form-control" name="groupservice">
                                    <?php
                                    foreach ($group_service as $row) {
                                        ?>
                                        <option value="<?php echo $row['idGrupoServicio']; ?>"><?php echo $row['descGrupoServicio']; ?></option>
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
        <!--/Modal - Agregar Producto-->

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
    <!-- Datatables Buttons -->
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js'; ?>"></script>
    
  </body>
</html>
