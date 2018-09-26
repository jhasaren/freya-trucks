<?php
/**************************************************************************
* Nombre de la Clase: CUser
* Version: 1.0
* Descripcion: Es el controlador para el Modulo de Usuarios
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 29/03/2017
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CUser extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        
        /*Carga Modelos*/
        $this->load->model('MUser'); /*Modelo para los Usuarios*/
        
        date_default_timezone_set('America/Bogota'); /*Zona horaria*/

        //lineas para eliminar el historico de navegacion./
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: index
     * Descripcion: Direcciona al usuario segun la sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function index() {
        
        if ($this->session->userdata('validated')) {

            $this->module($info);
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: module
     * Descripcion: Redirecciona respuesta al usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(7)){
            
                /*Consulta Modelo para obtener listado de Usuarios creados*/
                $listUsers = $this->MUser->list_users();
                /*Consulta Modelo para obtener listado de Roles creados*/
                $listRoles = $this->MUser->list_roles();
                /*Consulta Modelo para obtener listado de Sedes creadas*/
                $listSedes = $this->MUser->list_sedes();
                /*Consulta Modelo para obtener listado de Tipo Proveedor*/
                $listTipoProveedor = $this->MUser->list_tproveedor();
                /*Retorna a la vista con los datos obtenidos*/
                $info['list_user'] = $listUsers;
                $info['list_rol'] = $listRoles;
                $info['list_sede'] = $listSedes;
                $info['list_tprov'] = $listTipoProveedor;
                $this->load->view('users/users',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: adduser
     * Descripcion: Crear Usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function adduser($tipo){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(7)){
                
                    /*Captura Variables*/
                    $name = strtoupper($this->input->post('nameclient'));
                    $lastname = strtoupper($this->input->post('lastnameclient'));
                    $identificacion = $this->input->post('identificacion');
                    $direccion = strtoupper($this->input->post('direccion'));
                    $celular = $this->input->post('celular');
                    $email = $this->input->post('email');    
                    $diacumple = $this->input->post('diacumple');
                    $mescumple = $this->input->post('mescumple');
                    $contrasena = $this->input->post('contrasena');
                    $rol = $this->input->post('rol');
                    $dataSede = explode('|', $this->input->post('sede'));
                    $sede = $dataSede[0];
                    $horario = $dataSede[1];
                    $tproveedor = $this->input->post('tproveedor');

                    /*Valida si el usuario ya existe y recupera el estado*/
                    $validateClient = $this->MUser->verify_user($identificacion);

                    if ($validateClient == FALSE){

                        if ($this->jasr->validaTipoString($identificacion,5)){

                            if ($this->jasr->validaTipoString($name,1) && $this->jasr->validaTipoString($lastname,1)){

                                if ($this->jasr->validaTipoString($email,6)){

                                    if ($this->jasr->validaTipoString($diacumple,7)){

                                        if ($tipo === 'cliente'){

                                            /*Envia datos al modelo para el registro*/
                                            $registerData = $this->MUser->create_user($name,$lastname,$identificacion,$direccion,$celular,$email,2,$diacumple,$mescumple,'12345',3,$sede,$horario,null);
                                            if ($registerData == TRUE){

                                                $info['message'] = 'Usuario registrado Exitosamente';
                                                $info['alert'] = 1;
                                                $this->module($info);

                                            } else {

                                                $info['message'] = 'No fue posible crear el usuario';
                                                $info['alert'] = 2;
                                                $this->module($info);

                                            }

                                        }
                                        
                                        if ($tipo === 'proveedor'){

                                            /*Envia datos al modelo para el registro*/
                                            $registerData = $this->MUser->create_user($name,$lastname,$identificacion,$direccion,$celular,$email,3,$diacumple,$mescumple,'12345',4,$sede,$horario,$tproveedor);
                                            if ($registerData == TRUE){

                                                $info['message'] = 'Proveedor registrado Exitosamente';
                                                $info['alert'] = 1;
                                                $this->module($info);

                                            } else {

                                                $info['message'] = 'No fue posible crear el Proveedor';
                                                $info['alert'] = 2;
                                                $this->module($info);

                                            }

                                        }

                                        if ($tipo === 'empleado'){ /*si es empleado se valida la contraseña*/

                                            $empRegistrados = $this->MUser->cantidad_empleados(); /*Consulta Modelo obtiene cantidad empleados*/

                                            if ($empRegistrados->cantidadEmpleados > $this->config->item('empleados')){

                                                $message = 'No fue posible crear el Empleado debido que supero el máximo permitido según el Plan seleccionado. Comuniquese con el PROVEEDOR del Software.';

                                                log_message('DEBUG', '----------------------------------');
                                                log_message('DEBUG', '****PLAN ADQUIRIDO SUPERADO****');
                                                log_message('DEBUG', $message);
                                                log_message('DEBUG', 'Registrados: '.$empRegistrados->cantidadEmpleados);
                                                log_message('DEBUG', 'Permitidos: '.$this->config->item('empleados'));
                                                log_message('DEBUG', '----------------------------------');

                                                $info['message'] = $message;
                                                $info['alert'] = 2;
                                                $this->module($info);

                                            } else {

                                                if ($this->jasr->validaTipoString($contrasena,8)){

                                                    /*Envia datos al modelo para el registro*/
                                                    $registerData = $this->MUser->create_user($name,$lastname,$identificacion,$direccion,$celular,$email,1,$diacumple,$mescumple,$contrasena,$rol,$sede,$horario,null);
                                                    if ($registerData == TRUE){

                                                        $info['message'] = 'Usuario registrado Exitosamente';
                                                        $info['alert'] = 1;
                                                        $this->module($info);

                                                    } else {

                                                        $info['message'] = 'No fue posible crear el usuario';
                                                        $info['alert'] = 2;
                                                        $this->module($info);

                                                    }

                                                } else {

                                                    $info['message'] = 'No es posible agregar el usuario. La contraseña no cumple con los requisitos minimos de seguridad.';
                                                    $info['alert'] = 2;
                                                    $this->module($info);

                                                }

                                            }

                                        }

                                    } else {

                                        $info['message'] = 'No fue posible agregar el Usuario. Dia Cumpleaños incorrecto.';
                                        $info['alert'] = 2;
                                        $this->module($info);

                                    }

                                } else {

                                    $info['message'] = 'No fue posible agregar el Usuario. Email incorrecto.';
                                    $info['alert'] = 2;
                                    $this->module($info);

                                }

                            } else {

                                $info['message'] = 'No fue posible agregar el Usuario. Nombre/Apellido incorrecto.';
                                $info['alert'] = 2;
                                $this->module($info);

                            }

                        } else {

                            $info['message'] = 'No fue posible agregar el Usuario. Numero de identificación incorrecto.';
                            $info['alert'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'El usuario '.$identificacion.' ya existe. Su estado actual es '.$validateClient->activo;
                        $info['alert'] = 2;
                        $this->module($info);

                    }
                
                } else {
                    
                    show_404();
                    
                }

            }
        
        } else {
            
            $this->module($info);
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: upduser
     * Descripcion: Actualizar Usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function upduser(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(7)){
                
                    /*Captura Variables*/
                    $name = strtoupper($this->input->post('nameuser'));
                    $lastname = strtoupper($this->input->post('lastnameuser'));
                    $identificacion = $this->input->post('identificacion');
                    $direccion = strtoupper($this->input->post('direccion'));
                    $celular = $this->input->post('celular');
                    $email = $this->input->post('email');
                    $contrasena = $this->input->post('contrasena');
                    $estado = $this->input->post('estado');
                    $rol = $this->input->post('idrol');
                    $tipouser = $this->input->post('tipouser');
                    if ($estado == 'on'){ $valueState = 'S'; } else $valueState = 'N';
                    $restorepass = $this->input->post('restorepass');
                    $sede = $this->input->post('sede');

                    if ($this->jasr->validaTipoString($name,1) && $this->jasr->validaTipoString($lastname,1)){

                        if ($this->jasr->validaTipoString($email,6)){

                            /*Si esta marcada la casilla restablecer contraseña, se valida el campo contraseña*/
                            if ($restorepass == 1){

                                if ($this->jasr->validaTipoString($contrasena,8)){

                                    /*Envia datos al modelo para el registro*/
                                    $updateData = $this->MUser->update_user($name,$lastname,$identificacion,$direccion,$celular,$email,$contrasena,$rol,$valueState,$restorepass,$sede);

                                    if ($updateData == TRUE){

                                        $info['message'] = 'Usuario '.$identificacion.' Actualizado Exitosamente';
                                        $info['alert'] = 1;
                                        $this->module($info);

                                    } else {

                                        $info['message'] = 'No fue posible Actualizar el usuario';
                                        $info['alert'] = 2;
                                        $this->module($info);

                                    }

                                } else {

                                    $info['message'] = 'No fue posible actualizar el Usuario. La contraseña no cumple con los requisitos minimos de seguridad.';
                                    $info['alert'] = 2;
                                    $this->module($info);

                                }

                            } else {

                                /*Envia datos al modelo para el registro*/
                                $updateData = $this->MUser->update_user($name,$lastname,$identificacion,$direccion,$celular,$email,$contrasena,$rol,$valueState,$restorepass,$sede);

                                if ($updateData == TRUE){

                                    $info['message'] = 'Usuario '.$identificacion.' Actualizado Exitosamente';
                                    $info['alert'] = 1;
                                    $this->module($info);

                                } else {

                                    $info['message'] = 'No fue posible Actualizar el usuario';
                                    $info['alert'] = 2;
                                    $this->module($info);

                                }

                            }

                        } else {

                            $info['message'] = 'No fue posible actualizar el Usuario. Email incorrecto.';
                            $info['alert'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'No fue posible actualizar el Usuario. Nombre/Apellido incorrecto.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }
                
                } else {
                    
                    show_404();
                    
                }
                
            }
        
        } else {
            
            $this->module($info);
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: calendarempleado
     * Descripcion: Obtiene el calendario de atencion del empleado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 15/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function calendarempleado($idUsuario){
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(7)){
            
                $dataUser = $this->MUser->get_user($idUsuario);
                $horarioUser = json_decode(json_encode($this->MUser->horario_user($idUsuario)));

                $info['id'] = $idUsuario;
                $info['data_user'] = $dataUser;
                $info['horario_user'] = $horarioUser;
                $this->load->view('users/usercalendar',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->module($info);
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: updhorario
     * Descripcion: Guarda el horario laboral del empleado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 18/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function updhorario(){
        
        if ($this->session->userdata('validated')) {
            
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                show_404();

            } else {
            
                if ($this->MRecurso->validaRecurso(7)){
                
                    /*Captura Variables*/
                    $empleado = $this->input->post('idEmpleado');
                    /*Lunes*/
                    $lunes['horaIni'] = $this->input->post('horaIniLun');
                    $lunes['horaFin'] = $this->input->post('horaFinLun');
                    $lunes['horaIniAlm'] = $this->input->post('horaIniLunAlm');
                    $lunes['horaFinAlm'] = $this->input->post('horaFinLunAlm');
                    /*Martes*/
                    $martes['horaIni'] = $this->input->post('horaIniMar');
                    $martes['horaFin'] = $this->input->post('horaFinMar');
                    $martes['horaIniAlm'] = $this->input->post('horaIniMarAlm');
                    $martes['horaFinAlm'] = $this->input->post('horaFinMarAlm');
                    /*Miercoles*/
                    $miercoles['horaIni'] = $this->input->post('horaIniMie');
                    $miercoles['horaFin'] = $this->input->post('horaFinMie');
                    $miercoles['horaIniAlm'] = $this->input->post('horaIniMieAlm');
                    $miercoles['horaFinAlm'] = $this->input->post('horaFinMieAlm');
                    /*Jueves*/
                    $jueves['horaIni'] = $this->input->post('horaIniJue');
                    $jueves['horaFin'] = $this->input->post('horaFinJue');
                    $jueves['horaIniAlm'] = $this->input->post('horaIniJueAlm');
                    $jueves['horaFinAlm'] = $this->input->post('horaFinJueAlm');
                    /*Viernes*/
                    $viernes['horaIni'] = $this->input->post('horaIniVie');
                    $viernes['horaFin'] = $this->input->post('horaFinVie');
                    $viernes['horaIniAlm'] = $this->input->post('horaIniVieAlm');
                    $viernes['horaFinAlm'] = $this->input->post('horaFinVieAlm');
                    /*Sabado*/
                    $sabado['horaIni'] = $this->input->post('horaIniSab');
                    $sabado['horaFin'] = $this->input->post('horaFinSab');
                    $sabado['horaIniAlm'] = $this->input->post('horaIniSabAlm');
                    $sabado['horaFinAlm'] = $this->input->post('horaFinSabAlm');
                    /*Domingo*/
                    $domingo['horaIni'] = $this->input->post('horaIniDom');
                    $domingo['horaFin'] = $this->input->post('horaFinDom');
                    $domingo['horaIniAlm'] = $this->input->post('horaIniDomAlm');
                    $domingo['horaFinAlm'] = $this->input->post('horaFinDomAlm');

                    /*Envia datos al modelo para guardar el horario del empleado*/
                    $dataSave = $this->MUser->save_horario($empleado,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);

                    if ($dataSave == TRUE){

                        $info['message'] = 'Horario del Empleado '.$empleado.' actualizado exitosamente.';
                        $info['alert'] = 1;
                        $this->module($info);

                    } else {

                        $info['message'] = 'No fue posible Actualizar el horario del empleado.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }

                } else {
                    
                    show_404();
                    
                }
                
            }
            
        } else {
            
            $this->module($info);
            
        }
        
    }
    
}
