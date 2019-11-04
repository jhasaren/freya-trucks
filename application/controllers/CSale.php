<?php
/**************************************************************************
* Nombre de la Clase: CSale
* Version: 1.0 
* Descripcion: Es el controlador para el Modulo de ventas
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 26/03/2017
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CSale extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->helper('Mike42_helper'); /*Lib Mike42 Impresion Tickets*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        $this->load->library('pdf'); /*Libreria mPDF*/
        
        /*Carga Modelos*/
        $this->load->model('MSale'); /*Modelo para las Ventas*/
        $this->load->model('MUser'); /*Modelo para los Usuarios*/
        $this->load->model('MPrincipal'); /*Modelo principal para consultar recibos disponibles*/
        $this->load->model('MNotify'); /*Modelo para las notificaciones*/
        $this->load->model('MReport'); /*Modelo para los reportes*/
        $this->load->model('MBoard'); /*Modelo para las Mesas*/
        
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
     * Fecha Creacion: 26/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){

                $listUserSale = $this->MSale->list_users_sale(); /*Consulta Modelo para obtener lista de usuarios*/
                $listServiceSale = $this->MSale->list_service_sale(); /*Consulta Modelo para obtener lista de Servicios*/
                $listEmpleadoSale = $this->MSale->list_empleado_sale(); /*Consulta Modelo para obtener lista de Empleados*/
                $listProductSale = $this->MSale->list_product_sale(); /*Consulta Modelo para obtener lista de Productos*/
                //$listProductInterno = $this->MSale->list_product_int(); /*Consulta Modelo para obtener lista de Productos de Consumo Interno*/
                $receiptSale = $this->MPrincipal->rango_recibos(1);  /*Consulta el Modelo Cantidad de recibos disponibles*/
                
                $clientInList = $this->MSale->client_in_list(); /*datos del cliente agregados a la venta*/
                $serviceInList = $this->MSale->service_in_list(); /*lista de servicios agregados a la venta*/
                $productInList = $this->MSale->product_in_list(); /*lista de productos agregados a la venta*/
                $adicionalInList = $this->MSale->adicional_in_list(); /*lista cargos adicionales agregados a la venta*/
                $consumoInList = $this->MSale->consumo_in_list(); /*lista consumo interno agregados a la venta*/
                $porcenInList = $this->MSale->porcen_in_list(); /*recupera descuento, servicio y idempleado que atiende que estan agregados en la venta*/

                /*Retorna a la vista con los datos obtenidos*/
                $info['list_user'] = $listUserSale;
                $info['list_service'] = $listServiceSale;
                $info['list_empleado'] = $listEmpleadoSale;
                $info['list_product'] = $listProductSale;
                //$info['list_interno'] = $listProductInterno;
                $info['clientInList'] = $clientInList;
                $info['serviceInList'] = $serviceInList;
                $info['productInList'] = $productInList;
                $info['adicionalInList'] = $adicionalInList;
                $info['consumoInList'] = $consumoInList;
                $info['porcenInList'] = $porcenInList;
                $info['receiptSale'] = $receiptSale;
                $this->load->view('sale/sale',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: createsale
     * Descripcion: crea la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function createsale($board,$flagBoard) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
            
                if ($flagBoard == 0){ /*mesa libre*/
                    
                    /*Consulta Modelo para crear el id de venta*/
                    $createSale = $this->MSale->create_sale($this->session->userdata('userid'),$board);
                    /*Envia datos al modelo para el registro del Cliente por Default*/
                    $this->MSale->add_user('999999',$this->session->userdata('idSale'));
                    
                    if ($createSale == TRUE){
                        
                        /*Crea el Turno*/
                        $this->MSale->consecutivo_turno_sale(1,$this->session->userdata('idSale'));
                        $this->module($info);

                    } else {

                        show_404();

                    }
                    
                } else {
                    
                    /*Registra el id de venta de la mesa como variable de sesion*/
                    $datos_session = array(
                        'idSale' => $flagBoard
                    );
                    $this->session->set_userdata($datos_session);
                    
                    $this->module($info);
                    
                }
                
                /*Valida si ya existe un id de venta registrado en la sesion*/
                //if ($this->session->userdata('idSale') == NULL){

                    /*Consulta Modelo para crear el id de venta*/
                    //$createSale = $this->MSale->create_sale($this->session->userdata('userid'));
                    
                    /*Envia datos al modelo para el registro del Cliente por Default*/
                    //$this->MSale->add_user('999999',$this->session->userdata('idSale'));

                    //if ($createSale == TRUE){

                        //$this->module($info);

                    //} else {

                        //show_404();

                    //}

                //} else {

                    //$this->module($info);

                //}
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->module($info);
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: boards
     * Descripcion: visualiza el estado de las mesas
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function boards($type) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
                
                if ($type == 2){ /*tablero de mesas*/
                    
                    /*Consulta Modelo para obtener listado de disponibilidad de mesas*/
                    $listBoards = $this->MSale->list_board_sale();
                    /*Retorna a la vista con los datos obtenidos*/
                    $info['list_board'] = $listBoards;
                    /*Carga el tablero de mesas*/
                    $this->load->view('sale/boards',$info);
                
                } else {
                    
                    if ($type == 1){ /*listado*/
                        
                        /*Consulta Modelo para obtener listado de Mesas creadas*/
                        $listBoards = $this->MBoard->list_boards();
                        /*Consulta Modelo para obtener listado de Tipo de Mesas creadas*/
                        $listTypeBoards = $this->MBoard->list_type_board();
                        /*Retorna a la vista con los datos obtenidos*/
                        $info['list_board'] = $listBoards;
                        $info['list_type_board'] = $listTypeBoards;
                        /*Carga la lista de mesas*/
                        $this->load->view('boards/boardlist',$info);
                        
                    } else {
                        
                        show_404();
                        
                    }
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->module($info);
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: pendientespago
     * Descripcion: lista los recibos liquidados pendientes de pago colocados en
     * espera
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 05/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function pendientespago() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
            
                /*Consulta Modelo para obtener recibos pendientes de Pago*/
                $info['listaLiquidados'] = $this->MPrincipal->recibos_pendiente_pago(); /*Consulta el Modelo Lista de recibos liquidados*/

                $this->load->view('sale/sale_pending',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->module($info);
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: liquidasale
     * Descripcion: Liquida la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 01/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function liquidasale() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
            
                /*Valida si ya existe un id de venta registrado en la sesion*/
                if ($this->session->userdata('idSale') != NULL){

                    /*Consulta Modelo para liquidar la venta*/
                    $liquidacion = $this->MSale->liquida_sale();

                    $totalServicios = $liquidacion[0]->totalServicios;
                    //$porcenDescuento = $liquidacion[0]->porcenDescuento;
                    $totalDescuento = $liquidacion[0]->totalDescuento;
                    $totalProductos = $liquidacion[1]->totalProductos;
                    $totalAdicional = $liquidacion[2]->totalAdicional;

                    if ($totalServicios <= 0 && $totalProductos <= 0 && $totalAdicional <= 0){

                        $info['idmessage'] = 2;
                        $info['message'] = "No se puede liquidar. Por favor agregue conceptos a la venta.";
                        $this->module($info);

                    } else {

                        if (($this->session->userdata('sclient') !== NULL) && ($this->session->userdata('sempleado') !== NULL)){

                            if (($this->session->userdata('sservicio') !== NULL)){
                            
                                $valorPagoServicios = $totalServicios-$totalDescuento;
                                $valorTotalVenta = $totalServicios+$totalProductos+$totalAdicional;
                                $valorLiquidaVenta = $valorPagoServicios+$totalProductos+$totalAdicional;

                                /*Consulta Modelo para generar recibo*/
                                $numeracion = $this->MSale->genera_recibo();

                                if ($numeracion == FALSE){

                                    $info['idmessage'] = 2;
                                    $info['message'] = "No se puede liquidar. No hay numeros de recibo disponibles.";
                                    $this->module($info);

                                } else {

                                    $nroRecibo = $numeracion->nroRecibo;
                                    $estadoRecibo = $numeracion->idEstadoRecibo;
                                    
                                    /*si recibo es cuenta x cobrar, dejar como cuenta x cobrar*/
                                    if ($estadoRecibo == 8){
                                        $estadoActualiza = 8;
                                    } else { /*si no dejar como estado 2-liquidado*/
                                        $estadoActualiza = 2;
                                    }
                                        
                                        
                                    /*Consulta Modelo para actualizar la venta maestro*/
                                    $maestroventa = $this->MSale->update_salemaster($valorTotalVenta,$valorLiquidaVenta,$nroRecibo,$estadoActualiza);

                                    if ($maestroventa == TRUE){

                                        /*Obtiene detalle del recibo*/
                                        $detailRecibo = $this->MReport->detalle_recibo($this->session->userdata('idSale'));

                                        /*Asignacion de Turno*/
                                        if ($detailRecibo['general']->nroTurno == NULL){

                                            $turno = $this->MSale->consecutivo_turno_sale(1,$this->session->userdata('idSale'));

                                        } else {

                                           $turno = $detailRecibo['general']->nroTurno; 

                                        }

                                        $info['list_forma_pago'] = $this->MSale->list_forma_pago(); /*lista formas de pago*/
                                        $info['idmessage'] = 1;
                                        $info['message'] = $valorLiquidaVenta+($valorLiquidaVenta*$this->session->userdata('sservicio'))/100;
                                        $info['descuento'] = $totalDescuento;
                                        $info['totalservicios'] = $valorPagoServicios;
                                        $info['totalproductos'] = $totalProductos;
                                        $info['totaladicional'] = $totalAdicional;
                                        $info['detalleRecibo'] = $detailRecibo;
                                        $info['nrorecibo'] = $nroRecibo;
                                        $info['turno'] = $turno;

                                        $this->load->view('sale/sale_liquida',$info);

                                    } else {

                                        $info['idmessage'] = 2;
                                        $info['message'] = "No se puede generar la liquidacion. Contacte al administrador";
                                        $this->module($info);

                                    }

                                }
                            
                            } else {
                                
                                $info['idmessage'] = 2;
                                $info['message'] = "No se puede liquidar. Por favor registre el % del servicio.";
                                $this->module($info);
                                
                            }

                        } else {

                            $info['idmessage'] = 2;
                            $info['message'] = "No se puede liquidar. Por favor verifique que haya seleccionado un cliente y un empleado.";
                            $this->module($info);

                        }

                    }

                } else {

                    $this->module($info);

                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->module($info);
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: deletedetailsale
     * Descripcion: Elimina un concepto del detalle de venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/03/2017, 
     * Ultima modificacion: 27/09/2018 eliminacion con clave admin y motivos
     **************************************************************************/
    public function deletedetailsale() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
                
                /*Captura Variables*/
                $motivoDel = $this->input->post('motivoanulaitem');
                $pass = $this->input->post('passadmin');
                $id = $this->input->post('idregdetalle');
                $type = $this->input->post('typereg');
                
                if ($this->config->item('permiso_elim_item') == 1){ /*parametro activado*/
                    
                    /*Consulta Modelo para validar la contraseña admin*/
                    $passAdminValidate = $this->MPrincipal->admin_pass_verify($pass,$id);
                    
                    if ($passAdminValidate){
                             
                        /*Consulta Modelo para eliminar el id del detalle, y registrar motivo de eliminacion*/
                        $delRegistro = $this->MSale->delete_detail_sale($id,$type,$motivoDel);
                        
                    }
                    
                } else {
                    
                    if ($this->config->item('permiso_elim_item') == 0){
                        
                        /*Consulta Modelo para eliminar el id del detalle, y registrar motivo de eliminacion*/
                        $delRegistro = $this->MSale->delete_detail_sale($id,$type,$motivoDel);
                        
                    } else {
                        
                        $info['idmessage'] = 2;
                        $info['message'] = "No es posible eliminar el concepto de la venta. El valor parametrizado no es valido";
                        $this->module($info);
                        
                    }
                    
                }
                
                if ($delRegistro == TRUE){

                    $info['idmessage'] = 1;
                    $info['message'] = "Concepto de la venta eliminado exitosamente";
                    $this->module($info);

                } else {

                    $info['idmessage'] = 2;
                    $info['message'] = "No es posible eliminar el concepto de la venta";
                    $this->module($info);

                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: restoresale
     * Descripcion: Recupera venta con el detalle para continuar proceso
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function restoresale($idVenta,$usuario,$porcent,$porcentServ,$idEmpleado) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
            
                /*Setea variables de sesion*/
                $datos_session = array(
                    'idSale' => $idVenta,
                    'sclient' => $usuario,
                    'sdescuento' => ($porcent*100),
                    'sservicio' => ($porcentServ*100),
                    'sempleado' => $idEmpleado
                );

                $this->session->set_userdata($datos_session);

                $this->module($info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: waitdatasale
     * Descripcion: Elimina las variables de sesion creadas para la venta y deja
     * recibo en espera.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function waitdatasale() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
            
                /*Consulta Modelo para eliminar el id del detalle*/
                $updrecibo = $this->MSale->cuenta_x_cobrar($this->session->userdata('idSale'));
                
                if ($updrecibo == TRUE){
                
                    $this->session->unset_userdata('sclient');
                    $this->session->unset_userdata('sempleado');
                    $this->session->unset_userdata('idSale'); 
                    $this->session->unset_userdata('sdescuento');
                    $this->session->unset_userdata('sservicio');

                    //$this->boards(2);
                    redirect('CSale/boards/2', 'refresh');
            
                } else {
                    
                    show_404();
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            show_404();
            
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: canceldatasale
     * Descripcion: Cancela el registro de la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function canceldatasale() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
                
                /*Envia al modelo para eliminar los datos y liberar recibo*/
                $deldata = $this->MSale->cancel_data_sale();

                if ($deldata == TRUE){

                    $this->session->unset_userdata('sclient'); 
                    $this->session->unset_userdata('sempleado');
                    $this->session->unset_userdata('idSale'); 
                    $this->session->unset_userdata('sdescuento');
                    $this->session->unset_userdata('sservicio');

                    //$this->boards(2);
                    redirect('CSale/boards/2', 'refresh');
                    
                } else {

                    $info['idmessage'] = 2;
                    $info['message'] = "No es posible cancelar la venta. Elimine primero todos los conceptos de la venta. Si la venta ya registra un Pago Parcial debe anular el recibo";
                    $this->module($info);

                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            show_404();
            
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: payregistersale
     * Descripcion: Registra el Pago de un recibo Liquidado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 02/04/2017, Ultima modificacion: 12/05/2017
     **************************************************************************/
    public function payregistersale() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
            
                if ($this->session->userdata('idSale') !== NULL) {

                    if (!$this->input->post()){

                        $this->module($info);

                    } else {

                        /*captura variables*/
                        $pagavalor = str_replace(".", "", $this->input->post('pagavalor')); /*valor que paga*/
                        log_message("debug", "*****************************");
                        log_message("debug", "Valor Pagado: ".$pagavalor);
                        log_message("debug", "*****************************");
                        $refPago = $this->input->post('ref_pago'); /*referencia del pago*/
                        $valuePayFormas = $this->input->post('valuepagado'); /*valor ya pagado*/
                        $totalPago = $this->input->post('totalPago'); /*valor total que debe pagar*/
                        $saldopay = $this->input->post('saldopay'); /*valor del saldo que debe pagar*/
                        $porcServiceVenta = $this->input->post('porcServiceVenta'); /*porcentaje del servicio*/
                        $recibo = $this->input->post('recibo'); /*numero de recibo*/
                        $formaPago = $this->input->post('formapago'); /*tipo de forma de pago*/
                        $mixpayment = $this->input->post('mixpayment'); /*si el pago es parcial (pago mixto)*/
                        
                        if ($mixpayment != 'on'){
                        
                            log_message("debug", "*****************************");
                            log_message("debug", "Valor a Pagar: ".$totalPago);
                            log_message("debug", "*****************************");
                            
                            if (((int)$pagavalor+(int)$valuePayFormas) < (int)$totalPago){

                                $info['idmessage'] = 2;
                                $info['message'] = "No es posible registrar pago de la venta. El valor recibido es menor que el total a pagar";
                                $this->module($info);

                            } else {

                                /*Enviar al modelo para registrar pago*/
                                $registerPay = $this->MSale->pay_register_sale($formaPago,((int)$totalPago-(int)$valuePayFormas),$refPago,$mixpayment);

                                if ($registerPay == TRUE){

                                    /*Obtiene datos del cliente*/
                                    $datosCliente = $this->MUser->get_user($this->session->userdata('sclient')); 

                                    /*Obtiene detalle del recibo*/
                                    $detailRecibo = $this->MReport->detalle_recibo($this->session->userdata('idSale'));

                                    /*Asignacion de Turno*/
                                    if ($detailRecibo['general']->nroTurno == NULL){

                                        $turno = $this->MSale->consecutivo_turno_sale(1,$this->session->userdata('idSale'));

                                    } else {

                                       $turno = $detailRecibo['general']->nroTurno; 

                                    }

                                    /*Crea PDF del Recibo / imprime ticket*/
                                    $reciboPDF = $this->detallerecibopdf($this->session->userdata('idSale'),$recibo,$detailRecibo);

                                    /*Envia datos al Modelo para notificar al cliente por correo*/
                                    //$notificaPago = $this->MNotify->notifica_pago_venta($recibo,$datosCliente->nombre." ".$datosCliente->apellido,$datosCliente->idUsuario,$datosCliente->email);

                                    if ($reciboPDF == TRUE){

                                        log_message("DEBUG", "-----------------------------------");
                                        log_message("DEBUG", "PDF Recibo generado correctamente");
                                        log_message("DEBUG", "-----------------------------------");

                                    }

                                    /*if ($notificaPago == TRUE){

                                        log_message("DEBUG", "-----------------------------------");
                                        log_message("DEBUG", "Email Notificacion enviada exitosamente");
                                        log_message("DEBUG", "-----------------------------------");

                                    }*/

                                    /*elimina variables de sesion de la venta*/
                                    $this->session->unset_userdata('sclient'); 
                                    $this->session->unset_userdata('sempleado');
                                    $this->session->unset_userdata('idSale'); 
                                    $this->session->unset_userdata('sdescuento');
                                    $this->session->unset_userdata('sservicio');

                                    $info['totalventa'] = $totalPago;
                                    $info['porcServiceVenta'] = $porcServiceVenta;
                                    $info['pagacon'] = $pagavalor;
                                    $info['cambio'] = ($pagavalor-($saldopay));
                                    $info['detalleRecibo'] = $detailRecibo; 
                                    $info['turno'] = $turno; 
                                    $info['idmessage'] = 1;
                                    $info['message'] = "Pago registrado exitosamente";

                                    $this->load->view('sale/sale_payment',$info);

                                } else {

                                    $info['idmessage'] = 2;
                                    $info['message'] = "No es posible registrar pago de la venta. Por favor intente nuevamente";
                                    $this->module($info);

                                }

                            }
                            
                        } else {
                            
                            if (($pagavalor+$valuePayFormas) < $totalPago){ /*si el pago parcial es menor que la totalidad de lo que debe pagar*/
                            
                                /*Enviar al modelo para registrar pago*/
                                $registerPay = $this->MSale->pay_register_sale($formaPago,$pagavalor,$refPago,$mixpayment);

                                if ($registerPay){

                                    $this->liquidasale();

                                } else {

                                    $info['idmessage'] = 2;
                                    $info['message'] = "No es posible registrar la forma de pago. Por favor intente nuevamente";
                                    $this->module($info);

                                }
                            
                            } else { /*si el pago parcial es igual o mayor que la totalidad de lo que debe pagar*/
                                
                                $info['idmessage'] = 2;
                                $info['message'] = "No es posible registrar la forma de pago. La sumatoria de los pagos parciales es igual o superior al monto total de la factura";
                                $this->module($info);
                                
                            }
                            
                        }
                        
                    }

                } else {

                    show_404();

                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            show_404();
            
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: addusersale
     * Descripcion: Agregar Cliente a la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function addusersale(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(9)){
                
                    /*Captura Variables*/
                    $dataUsuario = explode('|', $this->input->post('idcliente'));
                    $idusuario = $dataUsuario[1];
                    $idventa = $this->session->userdata('idSale'); 

                    /*Valida si el usuario/cliente existe*/
                    $validateClient = $this->MUser->verify_user($idusuario);

                    if ($validateClient != FALSE){

                        /*Envia datos al modelo para el registro*/
                        $registerData = $this->MSale->add_user($idusuario,$idventa);

                        if ($registerData == TRUE){

                            $info['idmessage'] = 1;
                            $info['message'] = "Cliente Agregado Exitosamente";
                            $this->module($info);

                        } else {

                            $info['idmessage'] = 2;
                            $info['message'] = "No fue posible agregar el cliente";
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'El Cliente no existe, por favor digite y seleccione de la lista.';
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
     * Nombre del Metodo: addempleadosale
     * Descripcion: Agregar Empleado a la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 19/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function addempleadosale(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(9)){
                
                    /*Captura Variables*/
                    $dataUsuario = explode('|', $this->input->post('idempleadoventa'));
                    $idusuario = $dataUsuario[0];
                    $idventa = $this->session->userdata('idSale'); 

                    /*Valida si el empleado existe*/
                    $validateClient = $this->MUser->verify_user($idusuario);

                    if ($validateClient != FALSE){

                        /*Envia datos al modelo para el registro*/
                        $registerData = $this->MSale->add_empleado_sale($idusuario,$idventa);

                        if ($registerData == TRUE){

                            $info['idmessage'] = 1;
                            $info['message'] = "Empleado Agregado Exitosamente a la venta";
                            $this->module($info);

                        } else {

                            $info['idmessage'] = 2;
                            $info['message'] = "No fue posible agregar el empleado a esta venta";
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'El Empleado no existe, por favor seleccione de la lista.';
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
     * Nombre del Metodo: addservicesale
     * Descripcion: Agregar Servicio a la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function addservicesale(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(9)){
                                        
                    /*Captura Variables*/
                    $servicio = $this->input->post('idservice');
                    $varserv = explode('|', $servicio);
                    $idService = $varserv[0];
                    $valueService = $varserv[1];
                    $valueEmpleado = 0;
                    $idempleado = $this->input->post('idempleado');
                    $cantidad = $this->input->post('cantidad');

                    if ($valueService != NULL){

                        /*Valida el servicio y valor*/
                        $validateService = $this->MSale->validate_select_sale($idService,$valueService,1);

                        if ($validateService){            
                            
                            /*Envia datos al modelo para el registro*/
                            $registerData = $this->MSale->add_service($idService,($valueService*$cantidad),$valueEmpleado,$idempleado,$cantidad);

                            if ($registerData == TRUE){

                                $info['idmessage'] = 1;
                                $info['loadModal'] = 1;
                                $info['message'] = "Servicio Agregado Exitosamente";
                                $this->module($info);

                            } else {

                                $info['idmessage'] = 2;
                                $info['message'] = "No fue posible agregar el servicio";
                                $this->module($info);

                            }

                        } else {

                            $info['idmessage'] = 2;
                            $info['message'] = "No fue posible agregar el Plato. Los datos no son correctos";
                            $this->module($info);

                        }

                    } else {

                        $info['idmessage'] = 2;
                        $info['message'] = "No fue posible agregar a la venta. Busque y Seleccione de la lista.";
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
     * Nombre del Metodo: addproductsale
     * Descripcion: Agregar Producto a la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function addproductsale(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(9)){
                
                    /*Captura Variables*/
                    $producto = $this->input->post('idproducto');
                    $varprod = explode('|', $producto);
                    $idProducto = $varprod[0];
                    $valueProducto = $varprod[1];
                    $porcentEmpleado = 0;
                    $cantidad = $this->input->post('cantidad');
                    $valueEmpleado = ($valueProducto*$cantidad)*$porcentEmpleado;
                    //$valueTotal = $valueProducto = $varprod[1]*$cantidad;
                    $valueTotal = $valueProducto*$cantidad;
                    $idempleado = $this->input->post('idempleado');

                    if ($this->jasr->validaTipoString($cantidad,2)){
                        
                        if ($valueProducto != NULL){
                        
                            /*Valida el producto y valor*/
                            $validateProduct = $this->MSale->validate_select_sale($idProducto,$valueProducto,2);

                            if ($validateProduct){

                                /*Envia datos al modelo para el registro*/
                                $registerData = $this->MSale->add_product($idProducto,$valueTotal,$valueEmpleado,$idempleado,$cantidad);

                                if ($registerData == TRUE){

                                    $info['idmessage'] = 1;
                                    $info['loadModal'] = 2;
                                    $info['message'] = "Producto de Venta Agregado Exitosamente";
                                    $this->module($info);

                                } else {

                                    $info['idmessage'] = 2;
                                    $info['message'] = "No fue posible agegar el Producto de venta";
                                    $this->module($info);

                                }

                            } else {

                                $info['idmessage'] = 2;
                                $info['message'] = "No fue posible agregar el Producto. Los datos no son correctos";
                                $this->module($info);

                            }
                        
                        } else {
                        
                            $info['idmessage'] = 2;
                            $info['message'] = "No fue posible agregar a la venta. Busque y Seleccione de la lista.";
                            $this->module($info);

                        }
                        
                    } else {

                        $info['idmessage'] = 2;
                        $info['message'] = "No fue posible agegar el Producto a la venta. Cantidad incorrecta";
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
     * Nombre del Metodo: addproductint
     * Descripcion: Agregar Producto de Consumo interno
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function addproductint(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {
                
                if ($this->MRecurso->validaRecurso(9)){

                    /*Captura Variables*/
                    $idProducto = $this->input->post('idpinterno');
                    $cantidadcons = $this->input->post('cantidadcons');
                    $idempleado = $this->input->post('idempleadoint');

                    if ($this->jasr->validaTipoString($cantidadcons,2)){

                        /*Envia datos al modelo para el registro*/
                        $registerData = $this->MSale->add_product_int($idProducto,$cantidadcons,$idempleado);

                        if ($registerData == TRUE){

                            $info['idmessage'] = 1;
                            $info['message'] = "Consumo Interno Agregado Exitosamente";
                            $this->module($info);

                        } else {

                            $info['idmessage'] = 2;
                            $info['message'] = "No fue posible agegar el Consumo Interno";
                            $this->module($info);

                        }

                    } else {

                        $info['idmessage'] = 2;
                        $info['message'] = "No fue posible agegar el Consumo Interno. Unidosis incorrecta";
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
     * Nombre del Metodo: addcargoadc
     * Descripcion: Agregar Cargo Adicional a la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 30/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function addcargoadc(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(9)){
                
                    /*Captura Variables*/
                    $motivo = strtoupper($this->input->post('motivo'));
                    $valorCargo = $this->input->post('valorCargo');
                    $porcentaje = $this->input->post('porcentEmpleado');
                    $valorEmpleado = $valorCargo * ($porcentaje/100);
                    $idempleado = $this->input->post('idempleado');

                    if ($this->jasr->validaTipoString($motivo,1)){

                        if ($this->jasr->validaTipoString($valorCargo,2)){

                            if ($this->jasr->validaTipoString($porcentaje,3)){

                            /*Envia datos al modelo para el registro*/
                            $registerData = $this->MSale->add_consumo_adc($motivo,$valorCargo,$idempleado,$valorEmpleado);

                                if ($registerData == TRUE){

                                    $info['idmessage'] = 1;
                                    $info['message'] = "Cargo Adicional agregado exitosamente";
                                    $this->module($info);

                                } else {

                                    $info['idmessage'] = 2;
                                    $info['message'] = "No fue posible agegar el Cargo Adicional";
                                    $this->module($info);

                                }

                            } else {

                                $info['idmessage'] = 2;
                                $info['message'] = "No fue posible agegar el Cargo Adicional. Porcentaje incorrecto.";
                                $this->module($info);

                            }

                        } else {

                            $info['idmessage'] = 2;
                            $info['message'] = "No fue posible agegar el Cargo Adicional. Valor incorrecto.";
                            $this->module($info);

                        }

                    } else {

                        $info['idmessage'] = 2;
                        $info['message'] = "No fue posible agegar el Cargo Adicional. Descripcion del Motivo es incorrecta";
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
     * Nombre del Metodo: addporcentdesc
     * Descripcion: Agregar Porcentaje de descuento
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 30/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function addporcentdesc(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(9)){
                
                    /*Captura Variables*/
                    $descuento = $this->input->post('procentaje');
                    $porcentaje = $descuento / 100;
                    
                    $servicio = $this->input->post('porcen_servicio');
                    $porcentajeServ = $servicio / 100;

                    //if ($this->jasr->validaTipoString($descuento,3) && $this->jasr->validaTipoString($servicio,3)){
                    if ($this->jasr->validaTipoString($descuento,3) ){

                        /*Envia datos al modelo para el registro*/
                        $registerData = $this->MSale->add_porcentaje_desc($porcentaje,$porcentajeServ);

                        if ($registerData == TRUE){

                            $info['idmessage'] = 1;
                            $info['message'] = "Servicio/Descuento registrado exitosamente";
                            $this->module($info);

                        } else {

                            $info['idmessage'] = 2;
                            $info['message'] = "No fue posible registrar Servicio/Descuento";
                            $this->module($info);

                        }

                    } else {

                        $info['idmessage'] = 2;
                        $info['message'] = "No fue posible registrar Descuento. Porcentaje incorrecto";
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
     * Nombre del Metodo: saleclean
     * Descripcion: Limpia todos los registros de venta en Proceso Liquidacion.
     * Ejecucion: CRONTAB diariamente
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function saleclean(){
        
        if ($this->session->userdata('validated')) {
        
            /*Envia datos al modelo para el registro*/
            $deleteData = $this->MSale->sale_clean();

            if ($deleteData == TRUE){

                log_message("debug", "*******************************************");
                log_message("debug", "Ejecucion CRONTAB -> Status OK");
                log_message("debug", "*******************************************");

            } else {

                log_message("debug", "*******************************************");
                log_message("debug", "Ejecucion CRONTAB -> Status FAILED");
                log_message("debug", "*******************************************");

            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: adduser
     * Descripcion: Crear Usuario (Tomado del controller CUser)
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function adduser($tipo){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(9)){
                
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

                    /*Valida si el usuario ya existe y recupera el estado*/
                    $validateClient = $this->MUser->verify_user($identificacion);

                    if ($validateClient == FALSE){

                        if ($this->jasr->validaTipoString($identificacion,5)){

                            if ($this->jasr->validaTipoString($name,1) && $this->jasr->validaTipoString($lastname,1)){

                                if ($this->jasr->validaTipoString($email,6)){

                                    if ($this->jasr->validaTipoString($diacumple,7)){

                                        if ($tipo === 'cliente'){

                                            /*Envia datos al modelo para el registro*/
                                            $registerData = $this->MUser->create_user($name,$lastname,$identificacion,$direccion,$celular,$email,2,$diacumple,$mescumple,'12345',3,$this->session->userdata('sede'),0,NULL);
                                            if ($registerData == TRUE){

                                                /*aagrega usuario a la venta*/
                                                $registerUserSale = $this->MSale->add_user($identificacion,$this->session->userdata('idSale'));

                                                if ($registerUserSale != FALSE){

                                                    /*Setea el usuario como variable de sesion*/
                                                    $datos_session = array(
                                                        'sclient' => $identificacion
                                                    );
                                                    $this->session->set_userdata($datos_session);

                                                    $info['message'] = 'Usuario registrado Exitosamente';
                                                    $info['idmessage'] = 1;
                                                    $this->module($info);

                                                } else {

                                                    $info['message'] = 'Usuario creado Exitosamente. No fue posible agregarlo a la venta';
                                                    $info['idmessage'] = 2;
                                                    $this->module($info);

                                                }

                                            } else {

                                                $info['message'] = 'No fue posible crear el usuario';
                                                $info['idmessage'] = 2;
                                                $this->module($info);

                                            }
                                        }

                                    } else {

                                        $info['message'] = 'No fue posible agregar el Usuario. Dia Cumpleaños incorrecto.';
                                        $info['idmessage'] = 2;
                                        $this->module($info);

                                    }

                                } else {

                                    $info['message'] = 'No fue posible agregar el Usuario. Email incorrecto.';
                                    $info['idmessage'] = 2;
                                    $this->module($info);

                                }

                            } else {

                                $info['message'] = 'No fue posible agregar el Usuario. Nombre/Apellido incorrecto.';
                                $info['idmessage'] = 2;
                                $this->module($info);

                            }

                        } else {

                            $info['message'] = 'No fue posible agregar el Usuario. Numero de identificación incorrecto.';
                            $info['idmessage'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'El usuario '.$identificacion.' ya existe. Su estado actual es '.$validateClient->activo;
                        $info['idmessage'] = 2;
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
     * Nombre del Metodo: detallerecibopdf
     * Descripcion: Genera recibo de pago en PDF
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 12/05/2017, Ultima modificacion: 18/02/2018
     **************************************************************************/
    public function detallerecibopdf($idVenta,$recibo,$detailRecibo) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
            
                ini_set('memory_limit', '256M');

                /*Carga Libreria*/
                $pdf = $this->pdf->load();

                /*Consulta Modelo detalle de Recibo*/
                $reciboDetalle = $detailRecibo;
                $reciboDetalle['venta'] = $idVenta;
                $reciboDetalle['recibo'] = $recibo;

                /*Carga la vista para Imprimir en PDF*/
                $html = $this->load->view('sale/receipt_detail_pdf',$reciboDetalle, true);
                $pdf->SetDisplayMode('fullpage');

                /*Escribo el HTML en el PDF*/
                $pdf->WriteHTML($html);

                /*Genera el documento pdf y lo almacena*/
                $output = 'recibo_' . $recibo . '.pdf';
                $pdf->Output("./files/recibos/$output", 'F');
                
                /*Consecutivo Turno (1-99)*/
                //$turno = $this->MSale->consecutivo_turno_sale(1,$this->session->userdata('idSale'));
                
                /*Imprime Ticket Cliente*/
                //$this->imprimeticket($reciboDetalle,$turno);

                if (file_exists("./files/recibos/$output")){

                    return TRUE;

                } else {

                    return FALSE;

                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    
    /**************************************************************************
     * Nombre del Metodo: imprimeticketco
     * Descripcion: Imprime Ticket para Cocina
     * Consideraciones:
     *  - Impresora Termica Instalada
     *  - Impresora debe estar configurada como predeterminada en Windows
     *  - Impresora debe estar compartida en Windows
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/07/2019
     **************************************************************************/
    public function imprimeticketco() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
                
                /*Obtiene detalle del recibo*/
                $detailRecibo = $this->MReport->detalle_recibo($this->session->userdata('idSale'));
                
                /*Invoca funcion de Mike42_Helper (Cocina)*/
                escposticketco($detailRecibo,$this->session->userdata('nombre_sede'),$this->session->userdata('printer_sede'));
                $this->module($info);   
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    
    /**************************************************************************
     * Nombre del Metodo: imprimeticketliq
     * Descripcion: Imprime Ticket Liquidacion para Pago.
     * Consideraciones:
     *  - Impresora Termica Instalada
     *  - Impresora debe estar configurada como predeterminada en Windows
     *  - Impresora debe estar compartida en Windows
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 12/11/2018, 
     * Ultima modificacion: 26/07/2019 se cambio el nombre del metodo imprimeticketcoc
     * por imprimeticketliq, y se ajusto el form de la vista para llamar a este metodo.
     **************************************************************************/
    public function imprimeticketliq() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
                
                /*Obtiene detalle del recibo*/
                $detailRecibo = $this->MReport->detalle_recibo($this->session->userdata('idSale'));
                $detailRecibo['atencion'] = $this->session->userdata('sservicio');
                $detailRecibo['impuesto'] = $this->config->item('impo_add_factura');
                $nitRecibo = $this->config->item('nit_recibo');
                
                /*Log de Impresion*/
                $this->MSale->sale_printlog($detailRecibo['general']->nroRecibo);
                
                /*Invoca funcion de Mike42_Helper (Liquidacion para Pago)*/
                escposticket($detailRecibo,$this->session->userdata('nombre_sede'),$this->session->userdata('dir_sede'),$this->session->userdata('tel_sede'),$this->session->userdata('printer_sede'),$turno,$nitRecibo);
                $this->liquidasale();    
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    
    /**************************************************************************
     * Nombre del Metodo: resetconsecutivoturno
     * Descripcion: Reinicia el consecutivo de turnos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 19/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function resetconsecutivoturno(){
        
        if ($this->session->userdata('validated')) {
        
                if ($this->MRecurso->validaRecurso(9)){
                    
                    /*Invoca el modelo para reiniciar consecutivo Turno*/
                    $resetData = $this->MSale->consecutivo_turno_sale(2,NULL);

                    if ($resetData == 200){

                        $info['idmessage'] = 1;
                        $info['message'] = "Consecutivo Turno Reiniciado Exitosamente";
                        //$this->module($info);
                        $this->boards(2);

                    } else {

                        $info['idmessage'] = 2;
                        $info['message'] = "No fue posible reiniciar el Consecutivo Turno";
                        //$this->module($info);
                        $this->boards(2);
                        
                    }
                
                } else {
                    
                    show_404();
                    
                }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
}
