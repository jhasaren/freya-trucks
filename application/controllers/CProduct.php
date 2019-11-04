<?php
/**************************************************************************
* Nombre de la Clase: CProduct
* Version: 1.0.1
* Descripcion: Es el controlador para gestionar el Modulo de Productos
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 27/03/2017
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CProduct extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        
        /*Carga Modelos*/
        $this->load->model('MProduct'); /*Modelo para los Productos*/
        $this->load->model('MService'); /*Modelo para los Servicios*/
        
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
            
            if ($this->MRecurso->validaRecurso(2)){

                /*Consulta Modelo para obtener listado de Productos creados*/
                $listProducts = $this->MProduct->list_products();
                /*Consulta Modelo para obtener listado de tipos de producto*/
                $listType = $this->MProduct->list_type_product();
                /*Consulta Modelo para obtener listado de unidades Medida*/
                $list_und = $this->MProduct->list_und_medida();
                /*Consulta Modelo para obtener listado de Grupos del Servicio*/
                $listGroups = $this->MService->list_group_service();
                /*Retorna a la vista con los datos obtenidos*/
                $info['list_products'] = $listProducts;
                $info['list_type'] = $listType;
                $info['list_und'] = $list_und;
                $info['group_service'] = $listGroups;
                $this->load->view('products/products',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: stock
     * Descripcion: Carga el stock de productos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function stock() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(2)){

                /*Consulta Modelo para obtener listado de Productos creados*/
                $listProducts = $this->MProduct->list_products();
                /*Consulta Modelo para obtener listado de Grupos creados*/
                $listGroups = $this->MService->list_group_service();
                /*Retorna a la vista con los datos obtenidos*/
                $info['list_products'] = $listProducts;
                $info['list_groups'] = $listGroups;
                $this->load->view('products/stock',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addproduct
     * Descripcion: Crear Producto
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function addproduct(){
        
        if ($this->session->userdata('validated')) {
            
            /*Valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(2)){
                
                    /*Captura Variables*/
                    $name = strtoupper($this->input->post('nameproduct'));
                    $valor = $this->input->post('valueproduct');
                    $costo = $this->input->post('costoProducto');
                    $distributionproduct = $this->input->post('distributionproduct');
                    $porcent_empleado = $distributionproduct/100;
                    $stock = $this->input->post('stock');
                    $unidosis = $this->input->post('unidosis');
                    $typeproduct = $this->input->post('typeproduct');
                    $undmedida = $this->input->post('undmedida');
                    $groupservice = $this->input->post('groupservice');

                    if ($this->jasr->validaTipoString($name,1)){

                        if ($this->jasr->validaTipoString($valor,2) && $this->jasr->validaTipoString($stock,2) && $this->jasr->validaTipoString($unidosis,2) && $this->jasr->validaTipoString($costo,2)){

                            if ($this->jasr->validaTipoString($distributionproduct,3)){

                                /*Envia datos al modelo para el registro*/
                                $registerData = $this->MProduct->create_product($name,$valor,$porcent_empleado,$stock,$unidosis,$typeproduct,$costo,$undmedida,$groupservice);

                                if ($registerData == TRUE){

                                    $info['message'] = 'Producto creado Exitosamente';
                                    $info['alert'] = 1;
                                    $this->module($info);

                                } else {

                                    $info['message'] = 'No fue posible crear el Producto';
                                    $info['alert'] = 2;
                                    $this->module($info);

                                }

                            } else {

                                $info['message'] = 'No fue posible agregar el Producto. Porcentaje incorrecto.';
                                $info['alert'] = 2;
                                $this->module($info);

                            }

                        } else {

                            $info['message'] = 'No fue posible agregar el Producto. Costo, Valor, Stock y/o Unidosis incorrecto.';
                            $info['alert'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'No fue posible agregar el Producto. Nombre incorrecto.';
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
     * Nombre del Metodo: updproduct
     * Descripcion: Actualiza un Producto
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function updproduct(){
        
        if ($this->session->userdata('validated')) {
        
            /*Valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(2)){
                
                    /*Captura Variables*/
                    $name = strtoupper($this->input->post('nameproduct'));
                    $costo = $this->input->post('costoProducto');
                    $valor = $this->input->post('valueproduct');
                    $distributionproduct = $this->input->post('distributionproduct');
                    $porcent_empleado = $distributionproduct/100;
                    $stock = $this->input->post('stock');
                    $unidosis = $this->input->post('unidosis');
                    $estado = $this->input->post('estado');
                    if ($estado == 'on'){ $valueState = 'S'; } else $valueState = 'N';
                    $inventario = $this->input->post('inventario');
                    if ($inventario == 'on'){ $valueInvent = 'S'; } else $valueInvent = 'N';
                    $idproduct = $this->input->post('idproduct'); 

                    if ($this->jasr->validaTipoString($name,1)){

                        if ($this->jasr->validaTipoString($valor,2) && $this->jasr->validaTipoString($stock,2) && $this->jasr->validaTipoString($unidosis,2) && $this->jasr->validaTipoString($costo,2)){

                            if ($this->jasr->validaTipoString($distributionproduct,3)){

                                /*Envia datos al modelo para la actualizacion del producto*/
                                $updateData = $this->MProduct->update_product($idproduct,$name,$valor,$porcent_empleado,$stock,$unidosis,$valueState,$costo,$valueInvent);

                                if ($updateData == TRUE){

                                    $info['message'] = "Producto ".$name." Actualizado Exitosamente";
                                    $info['alert'] = 1;
                                    $this->module($info);

                                } else {

                                    $info['message'] = 'No fue posible Actualizar el Producto';
                                    $info['alert'] = 2;
                                    $this->module($info);

                                }

                            } else {

                                $info['message'] = 'No fue posible actualizar el Producto. Porcentaje incorrecto.';
                                $info['alert'] = 2;
                                $this->module($info);

                            }

                        } else {

                            $info['message'] = 'No fue posible actualizar el Producto. Valor, Stock y/o Unidosis incorrecto.';
                            $info['alert'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'No fue posible actualizar el Producto. Nombre incorrecto.';
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
    
}
