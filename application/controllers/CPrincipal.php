<?php
/**************************************************************************
* Nombre de la Clase: CPrincipal
* Version: 1.0
* Descripcion: Es el controlador principal el cual carga por default al iniciar
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 21/03/2017
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CPrincipal extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        $this->load->driver('cache'); /*Carga cache*/
        
        /*Carga Modelos*/
        $this->load->model('MPrincipal'); /*Modelo Princial*/
        $this->load->model('MService'); /*Modelo para los Servicios*/
        $this->load->model('MUser'); /*Modelo para los Usuarios*/
        $this->load->model('MProduct'); /*Modelo para los Productos*/
        $this->load->model('MSale'); /*Modelo para las Ventas*/
        $this->load->model('MReport'); /*Modelo para los Reportes*/
        $this->load->model('MBoard'); /*Modelo para los Productos*/
        $this->load->model('MAuditoria'); /*Modelo para Auditoria*/
        
        date_default_timezone_set('America/Bogota'); /*Zona horaria*/

        //lineas para eliminar el historico de navegacion./
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: index (por defecto CodeIgniter)
     * Descripcion: Carga la vista de login cuando se inicia sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function index() {
        
        if ($this->session->userdata('validated')) {
            
            $info['serviciosDia'] = $this->MPrincipal->cantidad_servicios(date('Y-m-d'),date('Y-m-d')); /*Consulta el Modelo Cantidad de servicios*/
            $info['productosDia'] = $this->MPrincipal->cantidad_productos_venta(date('Y-m-d'),date('Y-m-d')); /*Consulta el Modelo Cantidad de Productos venta*/
            $info['recibosPagados'] = $this->MPrincipal->cantidad_recibos_estado(date('Y-m-d'),date('Y-m-d'),5); /*Consulta el Modelo Cantidad recibos pagados*/
            $info['recibosLiquidados'] = $this->MPrincipal->cantidad_recibos_pendientes(); /*Consulta el Modelo Cantidad recibos pendiente pago*/
            $info['clientesRegistrados'] = $this->MPrincipal->cantidad_clientes(); /*Consulta el Modelo Cantidad de clientes*/
            $info['gastosPendientes'] = $this->MPrincipal->cantidad_gastos_pendientes(); /*Consulta el Modelo Cantidad de Gastos Pendientes*/
            $info['gastosPendienteDetalle'] = $this->MPrincipal->gastos_pendiente_detalle(); /*Consulta el Modelo detalle de Gastos Pendientes*/
            $info['consumoProductos80'] = $this->MPrincipal->consumo_productos_80(); /*Consulta el Modelo productos consumidos 80%*/
            $info['consumoProductos60'] = $this->MPrincipal->consumo_productos_60(); /*Consulta el Modelo productos consumidos 60%*/
            $this->load->view('home',$info);
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: module
     * Descripcion: Devuelve al usuario al home con mensaje de notificacion.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {
            
            $info['serviciosDia'] = $this->MPrincipal->cantidad_servicios(date('Y-m-d'),date('Y-m-d')); /*Consulta el Modelo Cantidad de servicios*/
            $info['productosDia'] = $this->MPrincipal->cantidad_productos_venta(date('Y-m-d'),date('Y-m-d')); /*Consulta el Modelo Cantidad de Productos venta*/
            $info['recibosPagados'] = $this->MPrincipal->cantidad_recibos_estado(date('Y-m-d'),date('Y-m-d'),5); /*Consulta el Modelo Cantidad recibos pagados*/
            $info['recibosLiquidados'] = $this->MPrincipal->cantidad_recibos_pendientes(); /*Consulta el Modelo Cantidad recibos pendiente pago*/
            $info['clientesRegistrados'] = $this->MPrincipal->cantidad_clientes(); /*Consulta el Modelo Cantidad de clientes*/
            //$info['citasReservadas'] = $this->MPrincipal->cantidad_citas_agendadas(date('Y-m-d'),date('H:i:s')); /*Consulta el Modelo Cantidad de Citas Pendientes*/
            //$info['citasReservadasDia'] = $this->MPrincipal->cantidad_citas_agendadas(date('Y-m-d'),'00:00:00'); /*Consulta el Modelo Cantidad de Citas del Dia*/
            $this->load->view('home',$info);
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: login
     * Descripcion: valida el Inicio de Sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function login(){

        /*valida que la peticion http sea POST*/
        if (!$this->input->post()){
            
            $this->index();
            
        } else {
            
            /*valida que los datos no esten vacios*/
            if ($this->input->post('username') == NULL || $this->input->post('pass') == NULL) { 

                $this->index();

            } else {

                /*Captura Variables*/
                $username = $this->input->post('username');
                $password = $this->input->post('pass');

                /*Consulta el Modelo Principal validacion de credenciales*/
                $validateLogin = $this->MPrincipal->login_verify($username,$password);

                if ($validateLogin != FALSE){

                    if ($validateLogin->activo == 'S'){
                        
                        /*Consulta el Modelo Principal para obtener los recursos*/
                        $recursos = $this->MPrincipal->rol_recurso($validateLogin->idRol);
                        
                        if ($recursos == FALSE){
                            
                            $info['message'] = "No tiene recursos asignados. Comuniquese con el administrador";
                            $info['stateMessage'] = 1;
                            $this->load->view('login',$info);
                            
                        } else {
                        
                            $datos_session = array(
                                'userid' => $username,
                                'nombre_usuario' => $validateLogin->nombre_usuario,
                                'perfil' => $validateLogin->descRol,
                                'activo' => $validateLogin->activo,
                                'recursos' => $recursos,
                                'sede' => $validateLogin->idSede,
                                'nombre_sede' => $validateLogin->nombreSede,
                                'dir_sede' => $validateLogin->direccionSede,
								'tel_sede' => $validateLogin->telefonoSede,
                                'printer_sede' => $validateLogin->printer,
                                'validated' => true
                            );

                            $this->session->set_userdata($datos_session);
                            log_message("DEBUG", "=================================");
                            log_message("DEBUG", "Inicio de Sesion");
                            log_message("DEBUG", $this->session->userdata('validated'));
                            log_message("DEBUG", $this->session->userdata('userid'));
                            log_message("DEBUG", "=================================");

                            //$this->index();
                            redirect('', 'refresh');

                        }
                        
                    } else {

                        $info['message'] = "Usuario Inactivo. Comuniquese con el administrador";
                        $info['stateMessage'] = 1;
                        $this->load->view('login',$info);

                    }

                } else {

                    $info['message'] = "Usuario y/o Contraseña incorrecto";
                    $info['stateMessage'] = 1;
                    $this->load->view('login',$info);

                }

            }
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: changepass
     * Descripcion: Cambiar contraseña usuario logueado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function changepass(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->index();

            } else {

                /*Captura Variables*/
                $passactual = $this->input->post('passactual');
                $passnew = $this->input->post('passnew');
                $passnewconf = $this->input->post('passnewconf');
                    
                /*Consulta el Modulo para validar la clave actual sea correcta*/
                $validateLogin = $this->MPrincipal->login_verify($this->session->userdata('userid'),$passactual);

                if ($validateLogin != FALSE){

                    if ($this->jasr->validaTipoString($passnew,8)){

                        if ($passnew == $passnewconf){
                            
                            /*Enviar datos al modelo para actualizar la clave*/
                            $dataPass = $this->MPrincipal->change_pass($this->session->userdata('userid'),$passnew);
                            
                            if ($dataPass == TRUE) {
                                
                                $this->session->sess_destroy(); /*Cierra la sesion*/
                                $info['message'] = 'Contraseña actualizada exitosamente. Ingrese nuevamente';
                                $info['stateMessage'] = 1;
                                $this->load->view('login',$info); /*Envia usuario al login*/
                                
                            } else {
                                
                                $info['message'] = 'No es posible actualizar. Comuniquese con el administrador de la Aplicación.';
                                $info['alert'] = 2;
                                $this->module($info);
                                
                            }
                            
                        } else {
                            
                            $info['message'] = 'No es posible actualizar. Contraseña nueva no coincide con la confirmación.';
                            $info['alert'] = 2;
                            $this->module($info);
                            
                        }

                    } else {

                        $info['message'] = 'No es posible actualizar. La nueva contraseña no cumple con los requisitos minimos de seguridad.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }

                } else {

                    $info['message'] = 'No es posible actualizar. Contraseña actual incorrecta.';
                    $info['alert'] = 2;
                    $this->module($info);

                }
                
            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: logout
     * Descripcion: Cerrar de Sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function logout() {

        /*Borra los datos cargados en memoria Cache [tablas tipo]*/
        $this->cache->memcached->delete('mListgroupservice');
        $this->cache->memcached->delete('mListtypeproduct');
        $this->cache->memcached->delete('mListroles');
        $this->cache->memcached->delete('mListsedes');
        $this->cache->memcached->delete('mTypeProveedor');
        $this->cache->memcached->delete('mListFormaPago');
        $this->cache->memcached->delete('mClientInList');
        $this->cache->memcached->delete('mStateGasto');
        $this->cache->memcached->delete('mTypeGasto');
        $this->cache->memcached->delete('mCategoriaGasto');
        $this->cache->memcached->delete('mListundmedida');
        $this->cache->memcached->delete('mListboards');
        $this->cache->memcached->delete('mListProductSale');
        $this->cache->memcached->delete('mListServiceSale');
        $this->cache->memcached->delete('mListproducts');
        $this->cache->memcached->delete('mListservices');
        
        //lineas para eliminar el historico de navegacion./
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        
        /*Destruye los datos de sesion*/
        $this->session->unset_userdata('validated');
        $this->session->sess_destroy();
        //$this->load->view('login');
        redirect('', 'refresh');
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: dataedit
     * Descripcion: Editar registro
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function dataedit($module,$value) {

        if ($module == 'service'){
                
            /*Consulta el modelo*/
            $dataService = $this->MService->get_service($value);
            
            if ($dataService != FALSE){
                
                /*Obtiene Parametro Intervalo de Tiempo para los servicios*/
                $data = file_get_contents(base_url().'public/bower_components/parametros/config.json');
                $configuracion = json_decode($data, true);
                $parametroTime = $configuracion['parametros']['intervaloMinutosServicio'];
                
                $info['id'] = $value;
                $info['data_service'] = $dataService;
                $info['parametroTime'] = $parametroTime;
                $this->load->view('services/serviceget',$info); 
                
            } else {
                
                show_404();
                
            }

        } else {  
            
            if ($module == 'product'){

                /*Consulta el modelo*/
                $dataProduct = $this->MProduct->get_product($value);
                
                if ($dataProduct != FALSE){
                    
                    $info['id'] = $value;
                    $info['data_product'] = $dataProduct;
                    $this->load->view('products/productget',$info);

                } else {

                    show_404();

                } 

            } else {
                
                if ($module == 'user'){
                    
                    /*Consulta el modelo*/
                    $dataUser = $this->MUser->get_user($value);
                    $dataSede = $this->MUser->list_sedes();
                    
                    if ($dataUser != FALSE){
                        
                        $info['id'] = $value;
                        $info['data_user'] = $dataUser;
                        $info['data_sede'] = $dataSede;
                        $this->load->view('users/userget',$info);
                        
                    } else {
                        
                        show_404();
                        
                    }
                    
                } else {
                    
                    if ($module == 'gastos'){
                        
                        /*Consulta el modelo*/
                        $dataGasto = $this->MReport->gastos_sedes(null,null,2,$value);
                        $listTypeGasto = $this->MReport->list_type_gasto();
                        $listStateGasto = $this->MReport->list_state_gasto();
                        $listProveedores = $this->MReport->list_proveedor();
                        $listCategoriaGasto = $this->MReport->list_categoria_gasto();
                        
                        if ($value != FALSE){
                        
                            $info['idGasto'] = $value;
                            $info['data_gasto'] = $dataGasto;
                            $info['list_type'] = $listTypeGasto;
                            $info['list_state'] = $listStateGasto;
                            $info['listProveedores'] = $listProveedores;
                            $info['listCategoria'] = $listCategoriaGasto;
                            $this->load->view('reports/gastoset',$info);

                        } else {

                            show_404();

                        }
                        
                    } else {
                        
                        if ($module == 'board'){

                            /*Consulta el modelo*/
                            $dataBoard = $this->MBoard->get_board($value);

                            if ($dataBoard != FALSE){

                                $info['id'] = $value;
                                $info['data_board'] = $dataBoard;
                                $this->load->view('boards/boardget',$info);

                            } else {

                                show_404();

                            } 

                        }
                        
                    }
                    
                }
                
            }
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: backup
     * Descripcion: Genera Backup de la Base de datos.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function backup() {
        
        if ($this->session->userdata('validated')) {
            
            /*captura variables*/
            $pass = $this->input->post('pass');
            $typeBackup = $this->input->post('db_backup');
            
            $validateLogin = $this->MPrincipal->login_verify($this->session->userdata('userid'),$pass);
            
            if ($validateLogin != FALSE){
                
                if ($typeBackup == 1) { /*BD Aplicacion*/
                    
                    // Load the DB utility class
                    $this->load->dbutil();
                    // Backup your entire database and assign it to a variable
                    $backup = $this->dbutil->backup();
                    // Load the download helper and send the file to your desktop
                    $this->load->helper('download');
                    force_download('freya-'.date('Ymd-His').'.gz', $backup);
                    
                } else {
                    
                    if ($typeBackup == 2){ /*BD Auditoria*/
                        
                        // Load the DB utility class
                        $this->load->dbutil();
                        /*Carga Auditoria BD*/
                        $this->db = $this->MAuditoria->db_set_audit();
                        // Backup your entire database and assign it to a variable
                        $backup_aud = $this->dbutil->backup();
                        // Load the download helper and send the file to your desktop
                        $this->load->helper('download');
                        force_download('auditoria_freya-'.date('Ymd-His').'.gz', $backup_aud);
                        
                    }
                    
                }
                                             
                $info['message'] = 'Se genero el backup de datos exitosamente. Por favor elija la ubicacion en la USB y guardelo.';
                $info['alert'] = 1;
                $this->module($info);
                
            } else {
                
                $info['message'] = 'La contraseña ingresada no es correcta.';
                $info['alert'] = 2;
                $this->module($info);
                
            }
            
        } else {
            
            show_404();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: optimize
     * Descripcion: Optimiza la Base de Datos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function optimize() {
        
        if ($this->session->userdata('validated')) {
                        
            // Load the DB utility class
            $this->load->dbutil();
            
            $result = $this->dbutil->optimize_database();

            if ($result !== FALSE)
            {
                    print_r($result);
            }

//            $info['message'] = 'Se genero el backup de datos exitosamente. Por favor elija la ubicacion en la USB y guardelo.';
//            $info['alert'] = 1;
//            $this->module($info);
            
        } else {
            
            show_404();
            
        }
        
    }
    
}
