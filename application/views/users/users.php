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
                        <h3>Usuarios</h3>
                        <?php if ($this->MRecurso->validaRecurso(6)){ /*Agregar Empleados*/ ?>
                        <span class="input-group-btn">
                            <a class="btn btn-success btn-empleado" href="#"><i class="glyphicon glyphicon-plus"></i> Agregar Empleado</a>
                        </span>
                        <?php } ?>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <?php if ($this->MRecurso->validaRecurso(3)){ /*Agregar clientes*/ ?>
                                <span class="input-group-btn">
                                    <a class="btn btn-success btn-cliente" href="#"><i class="glyphicon glyphicon-plus"></i> Agregar Cliente</a>
                                </span>
                                <?php } ?>
                            </div>
                            <div class="input-group">
                                <div></div>
                                <?php if ($this->MRecurso->validaRecurso(16)){ /*Agregar Proveedor*/ ?>
                                <span class="input-group-btn">
                                    <a class="btn btn-success btn-proveedor" href="#"><i class="glyphicon glyphicon-plus"></i> Agregar Proveedor</a>
                                </span>
                                <?php } ?>
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
                                <h2>Clientes y Empleados</h2>
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
                                        <th>Telefono</th>
                                        <th>Tipo</th>
                                        <th>Categoria</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($list_user != FALSE) {
                                            foreach ($list_user as $row_list){
                                                ?>
                                                <tr>
                                                    <td class="center"><?php echo $row_list['nombre_usuario']." [ID. ".$row_list['idUsuario']."]"; ?></td>
                                                    <td class="center"><?php echo $row_list['numCelular']; ?></td>
                                                    <td class="center"><?php echo $row_list['descTipoUsuario']; ?></td>
                                                    <td class="center"><?php echo $row_list['descTipoProveedor']; ?></td>
                                                    <td class="center">
                                                        <?php if ($row_list['activo'] == 'S') { ?>
                                                        <span class="label label-success">Activo</span>
                                                        <?php } else { ?>
                                                        <span class="label label-danger">Inactivo</span>
                                                        <?php }?>
                                                    </td>
                                                    <td class="center">
                                                        <a class="btn btn-default btn-sm" href="<?php echo base_url().'index.php/CPrincipal/dataedit/user/'.$row_list['idUsuario']; ?>">
                                                            <i class="glyphicon glyphicon-cog"></i>
                                                            Editar
                                                        </a>
                                                        <?php if (($row_list['idTipoUsuario'] == 1) && ($this->session->userdata('perfil') == 'SUPERADMIN')) { ?>
                                                        <a class="btn btn-default btn-sm" href="<?php echo base_url().'index.php/CUser/calendarempleado/'.$row_list['idUsuario']; ?>">
                                                            <i class="glyphicon glyphicon-time"></i>
                                                            Horario
                                                        </a>
                                                        <?php } ?>
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
        
        <!--Modal - Agregar Usuario Cliente-->
        <div class="modal fade" id="myModal-c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-c" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_user_cliente" action="<?php echo base_url().'index.php/CUser/adduser/cliente'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Cliente</h3>
                            <?php 
                            //echo "Lista Usuarios->".$this->cache->memcached->get('memcached5')."<br />"; 
                            //echo "Lista roles->".$this->cache->memcached->get('memcached6')."<br />";
                            //echo "Lista sedes->".$this->cache->memcached->get('memcached7')."<br />"; 
                            //echo "Lista Tipo Proveedor->".$this->cache->memcached->get('memcached8');
                            ?>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="identificacion">Nro. Identificación</label>
                                <input type="number" class="form-control" id="identificacion1" name="identificacion" placeholder="Documento Cliente" min="1" max="99999999999" required="">
                            </div>
                            <div class="form-group">
                                <label for="Nombre">Cliente</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nameclient1" name="nameclient" placeholder="Nombres" maxlength="90" required="">
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="lastnameclient1" name="lastnameclient" placeholder="Apellidos" maxlength="90" required="">
                            </div>
                            <div class="form-group">
                                <label for="datoscontacto">Datos de Contacto</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="direccion1" name="direccion" placeholder="Direccion" maxlength="90" >
                                <input type="text" class="form-control" id="celular1" name="celular" placeholder="Telefono Fijo/Celular" maxlength="35" >
                                <input type="email" class="form-control" id="email1" name="email" placeholder="Correo Electronico" maxlength="40" >
                                <input type="tel" class="form-control" id="diacumple1" name="diacumple" placeholder="Dia Cumpleaños" min="1" max="31" required="" pattern="\d*">
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
        <!--/Modal-->
        
        <!--Modal - Agregar Usuario Proveedor-->
        <div class="modal fade" id="myModal-prov" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-prov" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_user_proveedor" action="<?php echo base_url().'index.php/CUser/adduser/proveedor'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Proveedor</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="rol">Categoria</label>
                                <select class="form-control" name="tproveedor">
                                    <?php
                                    foreach ($list_tprov as $rowProv){
                                        ?>
                                    <option value="<?php echo $rowProv['idTipoProveedor']; ?>"><?php echo $rowProv['descTipoProveedor']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="identificacion">Nro. Identificación</label>
                                <input type="number" class="form-control" id="identificacion2" name="identificacion" placeholder="Documento Proveedor" min="1" max="99999999999" required="">
                            </div>
                            <div class="form-group">
                                <label for="Nombre">Proveedor</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nameclient2" name="nameclient" placeholder="Razon Social" maxlength="90" required="" >
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="lastnameclient2" name="lastnameclient" placeholder="Nombre Comercial" maxlength="90" required="">
                            </div>
                            <div class="form-group">
                                <label for="datoscontacto">Datos de Contacto</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="direccion2" name="direccion" placeholder="Direccion" maxlength="90" >
                                <input type="text" class="form-control" id="celular2" name="celular" placeholder="Telefono Fijo/Celular" maxlength="35" >
                                <input type="email" class="form-control" id="email2" name="email" placeholder="Correo Electronico" maxlength="40" >
                                <input type="hidden" class="form-control" id="diacumple2" name="diacumple" value="31">
                                <input type="hidden" class="form-control" id="mescumple2" name="mescumple" value="12">
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
                
        <!--Modal - Agregar Usuario Empleado-->
        <div class="modal fade" id="myModal-e" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-e" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_user_empleado" action="<?php echo base_url().'index.php/CUser/adduser/empleado'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Empleado</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="sede">Sede</label>
                                <select class="form-control" name="sede">
                                    <?php
                                    foreach ($list_sede as $row_sede){
                                        ?>
                                        <option value="<?php echo $row_sede['idSede']."|".$row_sede['horario']; ?>"><?php echo $row_sede['nombreSede']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="identificacion">Nro. Identificación</label>
                                <input type="number" class="form-control" id="identificacion3" name="identificacion" placeholder="Documento Empleado" min="1" max="99999999999" required="">
                                <br />
                                <label for="Contrasena">Contraseña</label>
                                <a href="#" class="label label-info" data-toggle="tooltip" data-placement="right" title="Minimo 1 letra mayúscula, 1 letra minúscula, al menos un número y la longitud debe ser minimo 8 caracteres. Ej: Freya1234" >Info</a>
                                <input type="password" class="form-control" id="contrasena3" name="contrasena" placeholder="Clave de Acceso" value="Freya1234" required="">
                            </div>
                            <div class="form-group">
                                <label for="Nombre">Empleado</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nameclient3" name="nameclient" placeholder="Nombres" maxlength="90" required="">
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="lastnameclient3" name="lastnameclient" placeholder="Apellidos" maxlength="90" required="">
                            </div>
                            <div class="form-group">
                                <label for="datoscontacto">Datos de Contacto</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="direccion3" name="direccion" placeholder="Direccion" maxlength="90" >
                                <input type="text" class="form-control" id="celular3" name="celular" placeholder="Telefono Fijo/Celular" maxlength="35" >
                                <input type="email" class="form-control" id="email3" name="email" placeholder="Correo Electronico" maxlength="40" >
                                <input type="tel" class="form-control" id="diacumple3" name="diacumple" placeholder="Dia Cumpleaños" min="1" max="31" required="" pattern="\d*">
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
                            <div class="form-group">
                                <label for="rol">Rol</label>
                                <select class="form-control" name="rol">
                                    <?php
                                    foreach ($list_rol as $row){
                                        ?>
                                    <option value="<?php echo $row['idRol']; ?>"><?php echo $row['descRol']; ?></option>
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
