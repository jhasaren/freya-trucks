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
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'; ?>" rel="stylesheet">-->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css'; ?>" rel="stylesheet">-->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'; ?>" rel="stylesheet">-->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css'; ?>" rel="stylesheet">-->
    
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
                        <h3>Usuarios</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
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
                                <h2>Actualizar Usuario [ID:<?php echo $data_user->idUsuario; ?>]</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!--Formulario-->
                                <form role="form" name="form_usuario" action="<?php echo base_url().'index.php/CUser/upduser'; ?>" method="post" autocomplete="off">
                                    <div class="modal-body">
                                        <?php if ($data_user->idTipoUsuario == 1){ ?>
                                        <div class="form-group">
                                            <label for="Sede">Sede</label>
                                            <!--<a href="#" class="label label-danger" data-toggle="tooltip" data-placement="right" title="Si va a cambiar la sede del empleado se recomienda primero validar si este tiene Citas Reservadas en otra sede ya que podria afectar la atención del servicio cuando el cliente se presente." >Importante</a>-->
                                            <select class="form-control" name="sede">
                                                <?php
                                                foreach ($data_sede as $row_sede){
                                                    if ($data_user->idSede == $row_sede['idSede']){
                                                        ?>
                                                        <option value="<?php echo $row_sede['idSede']; ?>" selected="" ><?php echo $row_sede['nombreSede']; ?></option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="<?php echo $row_sede['idSede']; ?>"><?php echo $row_sede['nombreSede']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for="Nombre">Usuario</label>
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nameclient" name="nameuser" placeholder="Nombres" value="<?php echo $data_user->nombre; ?>" maxlength="90" required="">
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="lastnameclient" name="lastnameuser" placeholder="Apellidos" value="<?php echo $data_user->apellido; ?>" maxlength="90" required="">
                                        </div>
                                        <div class="form-group">
                                            <strong>Dirección</strong><input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="direccion" name="direccion" value="<?php echo $data_user->direccion; ?>" placeholder="Direccion" maxlength="90" ><br />
                                            <strong>Telefono</strong><input type="text" class="form-control" id="celular" name="celular" value="<?php echo $data_user->numCelular; ?>" placeholder="Telefono Fijo/Celular" maxlength="35" ><br />
                                            <strong>Email</strong><input type="email" class="form-control" id="email" name="email" value="<?php echo $data_user->email; ?>" placeholder="Correo Electronico" maxlength="40" ><br />
                                            <strong>Fecha Cumpleaños</strong><input type="text" class="form-control" id="fechacumple" name="fechacumple" value="<?php echo $data_user->dia.' del Mes '.$data_user->mes; ?>" disabled="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="tipousuario">Tipo</label>
                                            <input type="text" class="form-control" id="tipousuario" name="tipousuario" value="<?php echo $data_user->descTipoUsuario; ?>" disabled="">
                                        </div>
                                        <div class="form-group">
                                            <label for="rol">Rol</label>
                                            <input type="text" class="form-control" id="rol" name="rol" value="<?php echo $data_user->descRol.' ['.$data_user->permisos.']'; ?>" disabled="">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Contraseña</label>
                                            <a href="#" class="label label-info" data-toggle="tooltip" data-placement="right" title="Minimo 1 letra mayúscula, 1 letra minúscula, al menos un número y la longitud debe ser minimo 8 caracteres. Ej: Freya1234" >Info</a>
                                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Nueva Clave de Acceso" >
                                            <label>
                                                <input type="checkbox" name="restorepass" value="1" >Restablecer Contraseña
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <?php 
                                            if ($data_user->activo == 'S') { 
                                                $check = 'checked'; 
                                            } else {
                                                $check = ''; 
                                            }
                                            ?>
                                            <label>
                                                Activo
                                              <input type="checkbox" class="flat" name="estado" <?php echo $check; ?> >
                                            </label>
                                        </div>
                                        <input type="hidden" class="form-control" id="identificacion" name="identificacion" value="<?php echo $data_user->idUsuario; ?>" >
                                        <input type="hidden" class="form-control" id="tipouser" name="tipouser" value="<?php echo $data_user->idTipoUsuario; ?>" >
                                        <input type="hidden" class="form-control" id="idrol" name="idrol" value="<?php echo $data_user->idRol; ?>" >
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo base_url().'index.php/CUser'; ?>" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                </form>
                                <!--/Formulario-->
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
    
    <!-- Datatables -->
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/jszip/dist/jszip.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/pdfmake/build/pdfmake.min.js'; ?>"></script>-->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/pdfmake/build/vfs_fonts.js'; ?>"></script>-->
    
    <!-- Chart.js -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/Chart.js/dist/Chart.min.js'; ?>"></script>-->
    <!-- jQuery Sparklines -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/jquery-sparkline/dist/jquery.sparkline.min.js'; ?>"></script>-->
    <!-- easy-pie-chart -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js'; ?>"></script>-->
    <!-- bootstrap-progressbar -->
    <!--<script src="<?php // echo base_url().'public/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'; ?>"></script>-->
    
    <!-- iCheck -->
    <script src="<?php echo base_url().'public/gentelella/vendors/iCheck/icheck.min.js'; ?>"></script>
    
  </body>
</html>
