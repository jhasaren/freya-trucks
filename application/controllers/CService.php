<?php
/**************************************************************************
* Nombre de la Clase: CService
* Version: 1.0
* Descripcion: Es el controlador para el Modulo de Servicios
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 29/03/2017
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CService extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        
        /*Carga Modelos*/
        $this->load->model('MService'); /*Modelo para los Servicios*/
        $this->load->model('MSale'); /*Modelo para la venta*/
        
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
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
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
     * Fecha Creacion: 21/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(1)){
            
                /*Consulta Modelo para obtener listado de Grupos del Servicio*/
                $listGroups = $this->MService->list_group_service();
                /*Consulta Modelo para obtener listado de Servicios creados*/
                $listServices = $this->MService->list_services();
                
                /*Obtiene Parametro Intervalo de Tiempo para los servicios*/
                $data = file_get_contents(base_url().'public/bower_components/parametros/config.json');
                $configuracion = json_decode($data, true);
                $parametroTime = $configuracion['parametros']['intervaloMinutosServicio'];

                /*Retorna a la vista con los datos obtenidos*/
                $info['group_service'] = $listGroups;
                $info['list_service'] = $listServices;
                $info['parametroTime'] = $parametroTime;
                $this->load->view('services/services',$info); 
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addservice
     * Descripcion: Crear Servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function addservice(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(1)){
                
                    /*Captura Variables*/
                    $name = strtoupper($this->input->post('nameservice'));
                    $time = $this->input->post('timeservice');
                    $value = $this->input->post('valueservice');
                    $distribution = $this->input->post('distributionservice');
                    $distPorcent = $distribution/100;
                    $group = $this->input->post('groupservice');  
                    $calendar = $this->input->post('serviceCalendar');

                    if ($this->jasr->validaTipoString($name,1)){

                        if ($this->jasr->validaTipoString($time,2) && $this->jasr->validaTipoString($value,2)){

                            if ($this->jasr->validaTipoString($distribution,3)){

                                /*Envia datos al modelo para el registro*/
                                $registerData = $this->MService->create_service($name,$time,$value,$distPorcent,$group,$calendar);

                                if ($registerData == TRUE){

                                    $info['message'] = 'Servicio Agregado Exitosamente';
                                    $info['alert'] = 1;
                                    $this->module($info);

                                } else {

                                    $info['message'] = 'No fue posible agregar el servicio';
                                    $info['alert'] = 2;
                                    $this->module($info);

                                }

                            } else {

                                $info['message'] = 'No fue posible agregar el servicio. Porcentaje incorrecto.';
                                $info['alert'] = 2;
                                $this->module($info);

                            }

                        } else {

                            $info['message'] = 'No fue posible agregar el servicio. Tiempo y/o Valor incorrecto.';
                            $info['alert'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'No fue posible agregar el servicio. Nombre incorrecto.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }
                
                } else {
                    
                    show_404();
                    
                }
                
            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: updservice
     * Descripcion: Actualizar un Servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function updservice(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {
                
                if ($this->MRecurso->validaRecurso(1)){

                    /*Captura Variables*/
                    $name = strtoupper($this->input->post('nameservice'));
                    $time = $this->input->post('timeservice');
                    $value = $this->input->post('valueservice');
                    $distribution = $this->input->post('distributionservice');
                    $distPorcent = $distribution/100;
                    $estado = $this->input->post('estado');
                    if ($estado == 'on'){ $valueState = 'S'; } else $valueState = 'N';
                    $idservice = $this->input->post('idservice');  
                    $calendar = $this->input->post('serviceCalendar'); 

                    if ($this->jasr->validaTipoString($name,1)){

                        if ($this->jasr->validaTipoString($time,2) && $this->jasr->validaTipoString($value,2)){

                            if ($this->jasr->validaTipoString($distribution,3)){

                                /*Envia datos al modelo para el registro*/
                                $updateData = $this->MService->update_service($idservice,$name,$time,$value,$distPorcent,$valueState,$calendar);

                                if ($updateData == TRUE){

                                    $info['message'] = "Servicio ".$name." Actualizado Existosamente";
                                    $info['alert'] = 1;
                                    $this->module($info);

                                } else {

                                    $info['message'] = 'No fue posible Actualizar el servicio';
                                    $info['alert'] = 2;
                                    $this->module($info);

                                }

                            } else {

                                $info['message'] = 'No fue posible actualizar el servicio. Porcentaje incorrecto.';
                                $info['alert'] = 2;
                                $this->module($info);

                            }

                        } else {

                            $info['message'] = 'No fue posible actualizar el servicio. Tiempo y/o Valor incorrecto.';
                            $info['alert'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'No fue posible actualizar el servicio. Nombre incorrecto.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }
                
                } else {
                    
                    show_404();
                    
                }

            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: empleadoservicio
     * Descripcion: Obtiene los empleados que atienden dicho servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function empleadoservicio($idServicio) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(1)){
            
                /*Consulta Modelo para obtener listado de Empleados que atienden el servicio*/
                $listEmpleadosAsigned = $this->MService->list_service_empleados($idServicio,$this->session->userdata('sede'));
                if ($listEmpleadosAsigned == FALSE){
                    
                    $info['rowasg'] = 0;
                    
                } else {
                    
                    $info['rowasg'] = 1;
                    
                }
                
                /*Consulta Modelo para obtener listado de empleados*/
                $listEmpleados = $this->MSale->list_empleado_sale();
                if ($listEmpleados == FALSE){
                    
                    $info['rowemp'] = 0;
                    
                } else {
                    
                    $info['rowemp'] = 1;
                    
                }
                
                /*Obtiene datos del servicio*/
                $dataServicio = $this->MService->datos_servicio($idServicio);

                $info['dataServicio'] = $dataServicio;
                $info['listEmpleados'] = $listEmpleados;
                $info['listEmpleadosAsg'] = $listEmpleadosAsigned;
                $this->load->view('services/service_empleados',$info);
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: asignaempleado
     * Descripcion: Registra los empleados que atienden dicho servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function asignaempleado() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(1)){
                
                if (!$this->input->post()){
                    
                    $this->module($info);
                    
                } else {

                    /*Captura variable del servicio*/
                    $servicio = $this->input->post('idServicio');
                    
                    /*Modelo para borrar listado de empleados asignados al servicio*/
                    if ($this->MService->del_empleados_servicio($servicio)){
                    
                        /*Consulta Modelo para obtener listado de empleados*/
                        $listEmpleados = $this->MSale->list_empleado_sale();

                        foreach ($listEmpleados as $empleado){

                            $asignacion = $this->input->post($empleado['idUsuario']);

                            if ($asignacion == 'on'){

                                /*inserta registro de empleados que atienden en servicio*/
                                $this->MService->ins_empleados_servicio($empleado['idUsuario'],$servicio);
                                
                            } 

                        }
                        
                        $info['message'] = 'Servicio Actualizado Exitosamente.';
                        $info['alert'] = 1;
                        $this->module($info);
                    
                    } else {
                        
                        $info['message'] = 'No fue posible actualizar los empleados que atienden el servicio. Comuniquese con el administrador.';
                        $info['alert'] = 2;
                        $this->module($info);
                        
                    }
                
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: productoservicio
     * Descripcion: Obtiene los productos que hacen parte de dicho servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function productoservicio($idServicio) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(1)){
            
                /*Consulta Modelo para obtener listado de Productos del servicio*/
                $listProductAsigned = $this->MService->list_service_productos($idServicio,$this->session->userdata('sede'));
                if ($listProductAsigned == FALSE){
                    
                    $info['rowasg'] = 0;
                    
                } else {
                    
                    $info['rowasg'] = 1;
                    
                }
                
                /*Consulta Modelo para obtener listado de productos internos y de venta*/
                $listProductos = $this->MSale->list_product_int();
                if ($listProductos == FALSE){
                    
                    $info['rowemp'] = 0;
                    
                } else {
                    
                    $info['rowemp'] = 1;
                    
                }
                
                /*Obtiene datos del servicio*/
                $dataServicio = $this->MService->datos_servicio($idServicio);

                $info['dataServicio'] = $dataServicio;
                $info['listProductos'] = $listProductos;
                $info['listProductosAsg'] = $listProductAsigned;
                $this->load->view('services/service_productos',$info);
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: asignaproducto
     * Descripcion: Registra los productos que hacen parte del servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 04/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function asignaproducto() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(1)){
                
                if (!$this->input->post()){
                    
                    $this->module($info);
                    
                } else {

                    /*Captura variable del servicio*/
                    $servicio = $this->input->post('idServicio');
                    
                    /*Modelo para borrar listado de productos asignados al servicio*/
                    if ($this->MService->del_productos_servicio($servicio)){
                    
                        /*Consulta Modelo para obtener listado de productos*/
                        $listProductos = $this->MSale->list_product_int();

                        foreach ($listProductos as $producto){

                            $asignacion = $this->input->post($producto['idProducto']);

                            if ($asignacion == 'on'){

                                /*inserta registro de producto del servicio*/
                                $this->MService->ins_productos_servicio($producto['idProducto'],$servicio);
                                
                            } 

                        }
                        
                        $info['message'] = 'Servicio Actualizado Exitosamente.';
                        $info['alert'] = 1;
                        $this->module($info);
                    
                    } else {
                        
                        $info['message'] = 'No fue posible actualizar los Productos del servicio. Comuniquese con el administrador.';
                        $info['alert'] = 2;
                        $this->module($info);
                        
                    }
                
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
}
