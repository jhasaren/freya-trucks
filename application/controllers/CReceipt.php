<?php
/**************************************************************************
* Nombre de la Clase: CReceipt
* Version: 1.0
* Descripcion: Es el controlador para gestionar el Modulo de Recibos
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 07/04/2017
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CReceipt extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        
        /*Carga Modelos*/
        $this->load->model('MReceipt'); /*Modelo para los Productos*/
        $this->load->model('MPrincipal'); /*Modelo para las Ventas*/
        
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
     * Fecha Creacion: 07/04/2017, Ultima modificacion: 
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
     * Fecha Creacion: 07/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(8)){
                
                $info['recibosDisponibles'] = $this->MPrincipal->rango_recibos(1); /*Consulta el Modelo Cantidad de recibos disponibles*/
                $info['recibosConsumidos'] = $this->MPrincipal->rango_recibos(6); /*Consulta el Modelo Cantidad de recibos consumidos*/
                $info['detalleResolucion'] = $this->MReceipt->detail_resolucion(); /*Consulta el Modelo Relacion de Resoluciones*/

                $this->load->view('receipts/receipts',$info);
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: createrange
     * Descripcion: Crear nuevo rango de recibos para la facturacion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 07/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function createrange(){
        
        if ($this->session->userdata('validated')) {
        
            /*Valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(8)){
                
                    /*Captura Variables*/
                    $resolucion = strtoupper($this->input->post('resolucion'));
                    $inicio = $this->input->post('inicio');
                    $final = $this->input->post('final');

                    if ($this->jasr->validaTipoString($inicio,9) && $this->jasr->validaTipoString($final,9)){

                        if ($final > $inicio){

                            /*Envia datos al modelo para el registro*/
                            $registerRange = $this->MReceipt->create_range($resolucion,$inicio,$final);

                            if ($registerRange == TRUE){

                                $info['message'] = 'Rango creado Exitosamente con la resolución '.$resolucion;
                                $info['alert'] = 1;
                                $this->module($info);

                            } else {

                                $info['message'] = 'No fue posible crear el Rango';
                                $info['alert'] = 2;
                                $this->module($info);

                            }

                        } else {

                            $info['message'] = 'No fue posible crear el rango. Numeración Final no puede ser menor o igual que la Inicial.';
                            $info['alert'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'No fue posible crear el rango. Dato Inicial/Final incorrecto';
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
