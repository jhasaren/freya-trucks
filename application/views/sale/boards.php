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
    <!-- Board Style -->
    <link href="<?php echo base_url().'public/gentelella/build/css/board.css'; ?>" rel="stylesheet">
    
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
                        <h3>Mesas</h3>
                        <span class="label label-warning">
                            <a href="<?php echo base_url().'index.php/CSale/pendientespago'; ?>">Ver Cuentas x Cobrar</a>
                        </span>
                        <span class="label label-info">
                            <a href="<?php echo base_url().'index.php/CSale/resetconsecutivoturno'; ?>">Reiniciar Consecutivo Turno</a>
                        </span>
                        <br /><br />
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-info" href="<?php echo base_url().'index.php/CSale/boards/1'; ?>"><i class="glyphicon glyphicon-eye-open"></i> Ver Lista</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">                                
                                <!--**********************************************-->
                                <div class="row">
                                    <?php 
                                    if ($list_board != FALSE){
                                        foreach ($list_board as $row_list){
                                            if ($row_list['idEstadoRecibo'] == 2){ /*liquidado*/
                                                
                                                $color = "#F3BEB5"; /*mesa ocupada en proceso pago - rojo*/
                                                $flag = $row_list['idVenta'];
                                                
                                            } else {
                                                
                                                if ($row_list['idEstadoRecibo'] == 4){ /*proceso liquidacion*/ 
                                                
                                                    $color = "#A8DFED"; /*mesa ocupada en pedido - azul*/
                                                    $flag = $row_list['idVenta'];
                                                    
                                                } else {
                                                    
                                                    $color = "#CBEDA8"; /*mesa libre - verde*/
                                                    $flag = 0;
                                                    
                                                }
                                            }
                                            ?>
                                            <div class="col-sm-2">
                                                <div class="do-item do-item-circle do-circle">
                                                    <img src="http://placehold.it/261x261" class="do-item do-circle">
                                                    <div class="do-info-wrap do-circle" style="background-color: <?php echo $color; ?>">
                                                        <div class="do-info">
                                                            <div class="do-info-front do-circle">
                                                                <center>
                                                                    <h3 style="color: #000"><?php echo $row_list['nombreMesa']; ?></h3>
                                                                </center>
                                                            </div>
                                                            <div class="do-info-back do-circle">
                                                                <h3>Max Mustermann (43)</h3>
                                                                <div>
                                                                    <a href="<?php echo base_url().'index.php/CSale/createsale/'.$row_list['idMesa'].'/'.$flag; ?>">
                                                                        Ventas
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <!--**********************************************-->
                        </div>
                        <!--<center>
                            <p class="center-block download-buttons">
                                <a href="<?php //echo base_url() . 'index.php/CSale/canceldatasale'; ?>" class="btn btn-default btn-lg">
                                    <i class="glyphicon glyphicon-remove red"></i> Eliminar
                                </a>
                                <a href="<?php //echo base_url() . 'index.php/CSale/liquidasale'; ?>" class="btn btn-success btn-lg">
                                    <i class="glyphicon glyphicon-barcode glyphicon-white"></i> Liquidar
                                </a>
                            </p>
                        </center>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Cliente-->
        <div class="modal fade" id="myModal-c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-c" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_client_sale" action="<?php echo base_url() . 'index.php/CSale/addusersale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Cliente</h3>

                            <a class="btn-newcliente" href="#">
                                <i class="glyphicon glyphicon-plus-sign blue"></i>
                                Registrar Nuevo
                            </a>

                        </div>
                        <div class="modal-body">
                            <?php if ($this->session->userdata('sclient') != NULL) { ?>
                                <div class="alert alert-info">
                                    Esta venta tiene asociado el cliente Nro. Identificación: <?php echo $this->session->userdata('sclient'); ?>
                                </div>
                            <?php } ?>
                            <label class="control-label" for="select">Escriba parte del nombre y seleccione de la lista</label>
                            <div class="controls">
                                <input class="select2_single form-control" type="text" name="idcliente" id="idcliente" required="" />
                            </div>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - empleado-->
        <div class="modal fade" id="myModal-em" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-em" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_empleado_sale" action="<?php echo base_url() . 'index.php/CSale/addempleadosale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Empleado</h3>
                        </div>
                        <div class="modal-body">
                            <?php if ($this->session->userdata('sempleado') != NULL) { ?>
                                <div class="alert alert-info">
                                    Esta venta tiene asociado el Empleado Nro. Identificación: <?php echo $this->session->userdata('sempleado'); ?>
                                </div>
                            <?php } ?>
                            <label class="control-label" for="select">Seleccione el Empleado</label>
                            <div class="controls">
                                <select class="select2_single form-control" id="idempleadoventa" name="idempleadoventa" data-rel="chosen">
                                    <?php
                                    foreach ($list_empleado as $row_empleado) {
                                        ?>
                                        <option value="<?php echo $row_empleado['idUsuario']; ?>" <?php if ($row_empleado['idUsuario'] == $this->session->userdata('sempleado')){ echo "selected"; }  ?>><?php echo $row_empleado['idUsuario'] . ' | ' . $row_empleado['nombre_usuario']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Servicio-->
        <div class="modal fade" id="myModal-s" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-s" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_service_sale" action="<?php echo base_url() . 'index.php/CSale/addservicesale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Plato Fuerte</h3>
                        </div>
                        <div class="modal-body">
                            <label class="control-label" for="selectError">Seleccione de la lista</label>
                            <div class="controls">
                                <select class="select2_single form-control" id="idservice" name="idservice" data-rel="chosen">
                                    <?php
                                    foreach ($list_service as $row_service) {
                                        ?>
                                        <option value="<?php echo $row_service['idServicio'] . '|' . $row_service['valorServicio'] . '|' . $row_service['valorEmpleado']; ?>"><?php echo $row_service['descServicio'] . ' | ' . $row_service['descGrupoServicio']. ' | '.$row_service['valorServicio']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!--<label class="control-label" for="selectError">Empleado</label>-->
                            <!--<div class="controls">
                                <select class="select2_single form-control" id="idempleado" name="idempleado" data-rel="chosen">
                                    <?php
                                    /*
                                    foreach ($list_empleado as $row_empleado) {
                                        ?>
                                        <option value="<?php echo $row_empleado['idUsuario']; ?>"><?php echo $row_empleado['idUsuario'] . ' | ' . $row_empleado['nombre_usuario']; ?></option>
                                        <?php
                                    }
                                     */
                                    ?>
                                </select>
                            </div>-->
                            <input type="hidden" class="form-control" id="idempleado_ser" name="idempleado" value="<?php echo $this->session->userdata('userid'); ?>">
                            <br />
                            <label class="control-label" for="selectError">Cantidad</label>
                            <div class="controls">
                                <select class="select2_single form-control" id="cantidad_ser" name="cantidad" data-rel="chosen">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Producto Venta-->
        <div class="modal fade" id="myModal-p" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-p" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_product_sale" action="<?php echo base_url() . 'index.php/CSale/addproductsale'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Producto</h3>
                        </div>
                        <div class="modal-body">
                            <label class="control-label" for="selectError">Seleccione de la lista</label>
                            <div class="controls">
                                <select class="select2_single form-control" id="idproducto" name="idproducto" data-rel="chosen">
                                    <?php
                                    foreach ($list_product as $row_product) {
                                        ?>
                                        <option value="<?php echo $row_product['idProducto'] . '|' . $row_product['valorProducto'] . '|' . $row_product['valorEmpleado']; ?>"><?php echo $row_product['descProducto'] . ' | ' . $row_product['valorProducto']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!--<label class="control-label" for="selectError">Empleado</label>-->
                            <!--<div class="controls">
                                <select class="select2_single form-control" id="idempleado" name="idempleado" data-rel="chosen">
                                    <?php
                                    /*
                                    foreach ($list_empleado as $row_empleado) {
                                        ?>
                                        <option value="<?php echo $row_empleado['idUsuario']; ?>"><?php echo $row_empleado['idUsuario'] . ' | ' . $row_empleado['nombre_usuario']; ?></option>
                                        <?php
                                    }
                                    */
                                    ?>
                                </select>
                            </div>-->
                            <input type="hidden" class="form-control" id="idempleado_pr" name="idempleado" value="<?php echo $this->session->userdata('userid'); ?>">
                            <br />
                            <label class="control-label" for="cantidad">Cantidad</label>
                            <select class="select2_single form-control" id="cantidad_pr" name="cantidad" data-rel="chosen">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Cargo Adicional-->
        <div class="modal fade" id="myModal-esp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-esp" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_cargo_adc" action="<?php echo base_url() . 'index.php/CSale/addcargoadc'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Cargo Adicional</h3>
                        </div>
                        <div class="modal-body">
                            <label class="control-label" for="Interno">Descripción/Motivo</label>
                            <input type="text" class="form-control" id="motivo" name="motivo" onblur="this.value = this.value.toUpperCase()" required="" autocomplete="off" maxlength="60" >
                            <br />
                            <label class="control-label" for="valorCargo">Valor ($)</label>
                            <input type="tel" class="form-control" id="valorCargo" name="valorCargo" required="" autocomplete="off" pattern="\d*">
                            <!--<label class="control-label" for="porcentEmpleado">Porcentaje Empleado (%)</label>-->
                            <input type="hidden" class="form-control" id="porcentEmpleado" name="porcentEmpleado" value="0">
                            <!--<label class="control-label" for="selectError">Empleado</label>-->
                            <!--<div class="controls">
                                <select class="select2_single form-control" id="idempleado" name="idempleado" data-rel="chosen">
                                    <?php
                                    /*
                                    foreach ($list_empleado as $row_empleado) {
                                        ?>
                                        <option value="<?php echo $row_empleado['idUsuario']; ?>"><?php echo $row_empleado['idUsuario'] . ' | ' . $row_empleado['nombre_usuario']; ?></option>
                                        <?php
                                    }
                                     */
                                    ?>
                                </select>
                            </div>-->
                            <input type="hidden" class="form-control" id="idempleado" name="idempleado" value="<?php echo $this->session->userdata('userid'); ?>">
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Consumo Interno-->
        <div class="modal fade" id="myModal-int" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-int" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_product_int" action="<?php echo base_url() . 'index.php/CSale/addproductint'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Consumo Interno</h3>
                        </div>
                        <div class="modal-body">
                            <label class="control-label" for="Interno">Seleccione de la lista</label>
                            <div class="controls">
                                <select class="select2_single form-control" id="idpinterno" name="idpinterno" data-rel="chosen">
                                    <?php
                                    if ($list_interno != NULL){
                                        foreach ($list_interno as $row_interno) {
                                            ?>
                                            <option value="<?php echo $row_interno['idProducto']; ?>"><?php echo $row_interno['descProducto']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <br />
                            <label class="control-label" for="selectError">Empleado</label>
                            <div class="controls">
                                <select class="select2_single form-control" id="idempleadoint" name="idempleadoint" data-rel="chosen">
                                    <?php
                                    foreach ($list_empleado as $row_empleado) {
                                        ?>
                                        <option value="<?php echo $row_empleado['idUsuario']; ?>"><?php echo $row_empleado['idUsuario'] . ' | ' . $row_empleado['nombre_usuario']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <br />
                            <label class="control-label" for="unidosis">Unidosis Consumidas</label>
                            <input type="tel" class="form-control" id="cantidadcons" name="cantidadcons" value="1" required="" pattern="\d*">
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Descuento-->
        <div class="modal fade" id="myModal-desc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-desc" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_descuento" action="<?php echo base_url() . 'index.php/CSale/addporcentdesc'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Servicio/Descuento</h3>
                        </div>
                        <div class="modal-body">
                            <label class="control-label" for="Porcentaje">Servicio Voluntario (%)</label>
                            <input type="tel" class="form-control" id="porcen_servicio" name="porcen_servicio" placeholder="Servicio" value="<?php if ($this->session->userdata('sservicio') !== NULL){ echo $this->session->userdata('sservicio'); } else { echo $this->config->item('procen_servicio'); } ?>" required="" autocomplete="off" pattern="\d*">
                            <br />
                            <label class="control-label" for="Porcentaje">Descuento (%) *Solo aplicable a Plato Fuerte</label>
                            <input type="tel" class="form-control" id="procentaje" name="procentaje" placeholder="Descuento" value="<?php if ($this->session->userdata('sdescuento') !== NULL){ echo $this->session->userdata('sdescuento'); } else { echo 0; } ?>" required="" autocomplete="off" pattern="\d*">
                            <br />
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!--Modal - Agregar Nuevo usuario Cliente -->
        <div class="modal fade" id="myModal-nc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-nc" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_user_cliente" action="<?php echo base_url() . 'index.php/CSale/adduser/cliente'; ?>" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Cliente</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="identificacion">Nro. Identificación</label>
                                <input type="number" class="form-control" id="identificacion" name="identificacion" placeholder="Documento Cliente" required="">
                            </div>
                            <div class="form-group">
                                <label for="Nombre">Cliente</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nameclient" name="nameclient" placeholder="Nombres" required="">
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="lastnameclient" name="lastnameclient" placeholder="Apellidos" required="">
                            </div>
                            <div class="form-group">
                                <label for="datoscontacto">Datos de Contacto</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="direccion" name="direccion" placeholder="Direccion" >
                                <input type="text" class="form-control" id="celular" name="celular" placeholder="Telefono Fijo/Celular" >
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electronico" >
                                <input type="number" class="form-control" id="diacumple" name="diacumple" placeholder="Dia Cumpleaños" min="1" max="31" required="" >
                                <select class="form-control" name="mescumple">
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
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

        <!-- footer content -->
        <?php 
        /*include*/
        //$this->load->view('includes/footer-bar');
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
    
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url().'public/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js'; ?>"></script>
    <script>
    var clientes = [
        <?php foreach ($list_user as $row_user) { ?>
            { value: '<?php echo $row_user['nombre_usuario']." |".$row_user['idUsuario']; ?>' },
        <?php } ?>
    ];

    $('#idcliente').autocomplete({
        lookup: clientes
    });
    </script>
    
  </body>
</html>
