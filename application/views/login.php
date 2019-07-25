<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <style>
    .login {
        background: url("http://localhost/freya-trucks/public/img/photohome.jpg") no-repeat center center fixed; 
        opacity: 0.9;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    </style>
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="login" background="<?php echo base_url().'public/img/6c29587c-5f1d-4ac9-9b56-8ba308cf588f.jpg'; ?>">
    <div>
      <div class="login_wrapper">
      
        <?php
        if ($stateMessage == 1){
        ?>
        <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <?php echo $message; ?>
        </div>
        <?php
        }
        ?>
        <!--<div class="animate form login_form">-->
        <section class="login_content">
            <form class="form-horizontal" name="form_login" id="form_login" action="<?php echo base_url().'index.php/CPrincipal/login'; ?>" method="post">
                <h1>
                    <img alt="Freya" src="<?php echo base_url().'public/img/logo.png'; ?>" />
                </h1>
                <div>
                    <input type="tel" id="username" name="username" class="form-control" placeholder="Usuario" required="" autocomplete="off" pattern="\d*">
                </div>
                <div>
                  <input type="password" name="pass" class="form-control" placeholder="Contraseña" required="">
                </div>
                <div>
                    <p class="center col-md-12">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </p>
                </div>

                <div class="clearfix"></div>

                <div class="separator">

                  <div class="clearfix"></div>
                  <br />

                  <div>
                    <h1><i class="fa fa-leaf"></i> Freya Restaurante</h1>
                    <p>©<?php echo date('Y'); ?> Todos los derechos reservados<br />Amadeus Soluciones</p>
                  </div>
                </div>
            </form>
        </section>
        <!--</div>-->
        
      </div>
    </div>
      
    <!-- jQuery -->
    <script src="<?php echo base_url().'public/gentelella/vendors/jquery/dist/jquery.min.js'; ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url().'public/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js'; ?>"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url().'public/gentelella/build/js/custom.js'; ?>"></script>  
    
  </body>
</html>
