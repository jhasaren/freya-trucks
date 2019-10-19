<?php
/**************************************************************************
* Nombre de la Clase: CReport
* Version: 1.0.1 
* Descripcion: Es el controlador para el Modulo de Reportes
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 05/04/2017
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CReport extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->helper('Mike42_helper'); /*Lib Mike42 Impresion Tickets*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        $this->load->library('pdf'); /*Libreria mPDF*/
        
        /*Carga Modelos*/
        $this->load->model('MReport'); /*Modelo para las Ventas*/
        $this->load->model('MNotify'); /*Modelo para las Notificaciones*/
        $this->load->model('MUser'); /*Modelo para los Usuarios*/
        $this->load->model('MSale'); /*Modelo para los Usuarios*/
        
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

            $this->load->view('home');
            
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
    public function module($report) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
            
                if ($report == 'reportPayment'){

                    $info['dataRow'] = 0;
                    $this->load->view('reports/report_payment',$info);

                }
                
                if ($report == 'reportPaymentForms'){

                    $info['dataRow'] = 0;
                    $this->load->view('reports/report_payment_formas',$info);

                }

                if ($report == 'reportFide'){

                    $info['dataRow'] = 0;
                    $this->load->view('reports/report_fidelization',$info);

                }
                
                if ($report == 'reportSedes'){

                    $info['dataRow'] = 0;
                    $this->load->view('reports/report_sedes',$info);

                }
                
                if ($report == 'reportNomina'){

                    $info['dataRow'] = 0;
                    $this->load->view('reports/report_nomina',$info);

                }
                
                if ($report == 'reportBirthday'){

                    /*Consulta Modelo*/
                    $birthdayClients = $this->MReport->birthday_clients(date('m'));
                    
                    $info['birthdayClients'] = $birthdayClients;
                    $this->load->view('reports/report_birthday',$info);

                }
                
                if ($report == 'reportGastos'){
                    
                    /*Consulta Modelo*/
                    $listTypeGasto = $this->MReport->list_type_gasto();
                    $listStateGasto = $this->MReport->list_state_gasto();
                    $listProveedores = $this->MReport->list_proveedor();
                    $listCategoriaGasto = $this->MReport->list_categoria_gasto();
                    
                    $info['dataRow'] = 0;
                    $info['listTypeGasto'] = $listTypeGasto;
                    $info['listStateGasto'] = $listStateGasto;
                    $info['listProveedores'] = $listProveedores;
                    $info['listCategoria'] = $listCategoriaGasto;
                    $this->load->view('reports/report_gastos',$info);

                }
                
                if ($report == 'reportGYP'){
                    
                    /*Consulta Modelo*/
                    $listSedes = $this->MUser->list_sedes();                    
                    
                    $info['dataRow'] = 0;
                    $info['listSedes'] = $listSedes;
                    $this->load->view('reports/report_ganperd',$info);

                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: paymentrecibos
     * Descripcion: genera reporte recibos pagados, pagos por empleado consolidado
     * y detalle.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function paymentrecibos() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
                
                /*Captura Variables*/
                $dateRange = explode("|",$this->input->post('dateRangeInput'));
                                
                $date1 = new DateTime($dateRange[0]); 
                $fechaini = $date1->format('Y-m-d H:i:s'); 
                
                $date2 = new DateTime($dateRange[1]); 
                $fechafin = $date2->format('Y-m-d H:i:s');
                
                log_message("DEBUG", "----------------------------------");
                log_message("DEBUG", "***Reporte Recibos***");
                log_message("DEBUG", $fechaini);
                log_message("DEBUG", $fechafin);
                log_message("DEBUG", "*********************************");

                /*Consulta Modelo*/
                $paymentClient = $this->MReport->payment_recibos($fechaini,$fechafin);

                if ($paymentClient != FALSE){

                    $info['dataRow'] = 1;
                    $info['paymentClient'] = $paymentClient;
                    $this->load->view('reports/report_payment',$info);

                } else {

                    $info['dataRow'] = 2;
                    $info['message'] = "No existen recibos pagados en el periodo seleccionado.";
                    $this->load->view('reports/report_payment',$info);

                }
                
            } else {
                
                show_404();
                
            }
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: paymentrecibosforms
     * Descripcion: genera reporte recibos discriminando la forma de pago
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function paymentrecibosforms() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
                
                /*Captura Variables*/
                $date1 = new DateTime($this->input->post('fechaini')); 
                $fechaini = $date1->format('Y-m-d'); 

                $date2 = new DateTime($this->input->post('fechafin')); 
                $fechafin = $date2->format('Y-m-d');

                /*Consulta Modelo*/
                $paymentClientForm = $this->MReport->payment_recibos_form($fechaini,$fechafin);

                if ($paymentClientForm != FALSE){

                    $paymentConsolForm = $this->MReport->payment_consolida_form($fechaini,$fechafin);
                    
                    $info['fechaIni'] = $fechaini;
                    $info['fechaFin'] = $fechafin;
                    $info['dataRow'] = 1;
                    $info['paymentClient'] = $paymentClientForm;
                    $info['paymentConsol'] = $paymentConsolForm;
                    $this->load->view('reports/report_payment_formas',$info);

                } else {

                    $info['dataRow'] = 2;
                    $info['message'] = "No existen recibos pagados en el periodo seleccionado.";
                    $this->load->view('reports/report_payment_formas',$info);

                }
                
            } else {
                
                show_404();
                
            }
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: anularecibo
     * Descripcion: Anula un recibo pagado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function anularecibo() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(8)){
                
                /*Captura Variables*/
                $motivoAnula = $this->input->post('motivoanula'); 
                $recibo = $this->input->post('recibo'); 

                /*Consulta Modelo*/
                $anulaRecibo = $this->MReport->anula_recibo($recibo,$motivoAnula);

                if ($anulaRecibo != FALSE){

                    $info['dataRow'] = 3;
                    $info['message'] = "El recibo Nro.".$recibo." se anulo correctamente.";
                    $this->load->view('reports/report_payment',$info);

                } else {

                    $info['dataRow'] = 2;
                    $info['message'] = "No fue posible anular el recibo.";
                    $this->load->view('reports/report_payment',$info);

                }
                
            } else {
                
                show_404();
                
            }
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: paymentnomina
     * Descripcion: genera reporte de pagos a empleados
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 04/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function paymentnomina() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
                
                /*Captura Variables*/
                $date1 = new DateTime($this->input->post('fechaini')); 
                $fechaini = $date1->format('Y-m-d'); 

                $date2 = new DateTime($this->input->post('fechafin')); 
                $fechafin = $date2->format('Y-m-d');

                /*Consulta Modelo*/
                $paymentEmpleado = $this->MReport->payment_total_empleado($fechaini,$fechafin);
                $detailPayEmpleado = $this->MReport->payment_detalle_empleado($fechaini,$fechafin);

                if ($paymentEmpleado != FALSE){

                    $info['fechaIni'] = $fechaini;
                    $info['fechaFin'] = $fechafin;
                    $info['dataRow'] = 1;
                    $info['paymentEmpleado'] = $paymentEmpleado;
                    $info['detailPayEmpleado'] = $detailPayEmpleado;
                    $this->load->view('reports/report_nomina',$info);

                } else {

                    $info['dataRow'] = 2;
                    $info['message'] = "No se encontro información de pagos por empleado.";
                    $this->load->view('reports/report_nomina',$info);

                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: detallerecibo
     * Descripcion: recupera el detalle de conceptop de un recibo pagado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 01/05/2017, 
     * Ultima modificacion: 25/07/2019 - Se agrego la variable idSale como sesion
     * para que el proceso de impresion opere correctamente.
     **************************************************************************/
    public function detallerecibo($venta,$recibo) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
            
                /*Consulta Modelo detalle de Recibo*/
                $reciboDetalle = $this->MReport->detalle_recibo($venta);

                $reciboDetalle['venta'] = $venta;
                $reciboDetalle['recibo'] = $recibo;
                
                /*Registra el id de venta como variable de sesion*/
                $datos_session = array(
                    'idSale' => $venta
                );
                $this->session->set_userdata($datos_session);

                $this->load->view('reports/receipt_detail',$reciboDetalle);
                
            } else {
                
                show_404();
                
            }
                
        } else {
            
            $this->index();
            
        }
        
    }
    
    
    /**************************************************************************
     * Nombre del Metodo: reimprimeticket
     * Descripcion: Reimprime Ticket de Factura
     * Consideraciones:
     *  - Impresora Termica Instalada
     *  - Impresora debe estar configurada como predeterminada en Windows
     *  - Impresora debe estar compartida en Windows
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/07/2019
     **************************************************************************/
    public function reimprimeticket() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(9)){
                
                /*Obtiene detalle del recibo*/
                $detailRecibo = $this->MReport->detalle_recibo($this->session->userdata('idSale'));
                $detailRecibo['atencion'] = ($detailRecibo['general']->porcenServicio*100);
                $detailRecibo['impuesto'] = $this->config->item('impo_add_factura');
                $nitRecibo = $this->config->item('nit_recibo');
                
                /*Log de Impresion*/
                $this->MSale->sale_printlog($detailRecibo['general']->nroRecibo);
                
                log_message('DEBUG', '-----------------------------------');
                log_message('DEBUG', 'Reimprime Factura');
                /*Invoca funcion de Mike42_Helper*/
                escposticket($detailRecibo,$this->session->userdata('nombre_sede'),$this->session->userdata('dir_sede'),$this->session->userdata('tel_sede'),$this->session->userdata('printer_sede'),$turno,$nitRecibo);

                /*Redirecciona al detalle del recibo*/
                $this->detallerecibo($detailRecibo['general']->idVenta,$detailRecibo['general']->nroRecibo);
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    
    /**************************************************************************
     * Nombre del Metodo: detalleliquida
     * Descripcion: recupera el detalle de pagos para liquidar un empleado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function detalleliquida($fechaIni,$fechaFin,$empleado,$sede) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
            
                /*Consulta Modelo detalle de Recibo*/
                $liquidaDetalle = $this->MReport->liquida_payment_empleado($fechaIni,$fechaFin,$empleado,$sede);

                $info['liquidaDetalle'] = $liquidaDetalle;
                $info['fechaDesde'] = $fechaIni;
                $info['fechaHasta'] = $fechaFin;

                $this->load->view('reports/liquida_detail',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: paymentcierre
     * Descripcion: Cierra los recibos debido a la liquidacion de nomina, genera 
     * comprobante pdf y envia adjunto al correo electronico del empleado.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function paymentcierre() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
            
                /*Valida que la peticion http sea POST*/
                if (!$this->input->post()){

                    $this->module('reportNomina');

                } else {

                    /*Captura Variables*/
                    $orden = $this->input->post('orden');
                    $empleado = $this->input->post('empleado');
                    $nombreEmpleado = $this->input->post('nombreEmpleado');
                    $email = $this->input->post('email');
                    $sede = $this->input->post('sede');
                    $inicio = $this->input->post('fechaini');
                    $final = $this->input->post('fechafin');
                    $arrayRecibo = $this->input->post('recibos');

                    if (is_array($arrayRecibo)) {

                        /*crea el comprobante pdf*/
                        $comprobante = $this->comprobante_pdf($inicio, $final, $empleado, $sede, $orden);

                        if ($comprobante == TRUE){

                            /*Envia al Modelo para cerrar los recibos*/
                            $cierreRecibos = $this->MReport->payment_cierre($arrayRecibo,$orden);

                            if ($cierreRecibos == TRUE){

                                /*Envia Correo Electronico al empleado con el Documento del Comprobante*/
                                $notifica = $this->MNotify->notifica_pago_empleado($orden,$nombreEmpleado,$empleado,$email);

                                if ($notifica == TRUE){

                                    $info['dataRow'] = 2;
                                    $info['message'] = "Liquidación de Nómina realizado exitosamente. El comprobante fue generado correctamente.";
                                    $this->load->view('reports/report_nomina',$info);

                                } else {

                                    $info['dataRow'] = 2;
                                    $info['message'] = "Liquidación de Nómina realizado exitosamente. El comprobante fue generado correctamente [No se pudo enviar Email].";
                                    $this->load->view('reports/report_nomina',$info);

                                }

                            } else {

                                $info['dataRow'] = 3;
                                $info['message'] = "No fue posible realizar la Liquidación de Nómina. Cierre de recibos falló.";
                                $this->load->view('reports/report_nomina',$info);

                            }

                        } else {

                            $info['dataRow'] = 3;
                            $info['message'] = "No fue posible realizar la Liquidación de Nómina. Comprobante no generado.";
                            $this->load->view('reports/report_nomina',$info);

                        }

                    } else {

                        $this->module('reportNomina');

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
     * Nombre del Metodo: paymentsedes
     * Descripcion: genera reporte de pagos por sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function paymentsedes() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
                
                /*Captura Variables*/
                $dateRange = explode("|",$this->input->post('dateRangeInput'));
                                
                $date1 = new DateTime($dateRange[0]); 
                $fechaini = $date1->format('Y-m-d H:i:s'); 
                
                $date2 = new DateTime($dateRange[1]); 
                $fechafin = $date2->format('Y-m-d H:i:s');
                
                log_message("DEBUG", "----------------------------------");
                log_message("DEBUG", "***Reporte Consolidado General***");
                log_message("DEBUG", $fechaini);
                log_message("DEBUG", $fechafin);
                log_message("DEBUG", "*********************************");
                
                /*Consulta Modelo detalle pagos por sede*/
                $paymentDataSedes = $this->MReport->payment_sedes($fechaini,$fechafin);

                if ($paymentDataSedes == TRUE){

                    /*Consulta Modelo consolidado pagos por sede*/
                    $paymentConsolidaSede = $this->MReport->payment_consolidado_sedes($fechaini,$fechafin);

                    if ($paymentConsolidaSede == TRUE){

                        /*Consulta Modelo ingreso por Forma de Pago*/
                        $paymentEntidades = $this->MReport->payment_entidades($fechaini,$fechafin);
                        /*Consulta Modelo ingreso por Fecha/Dia*/
                        $paymentFechaDia = $this->MReport->payment_fechadia($fechaini,$fechafin);


                        $info['fechaIni'] = $fechaini;
                        $info['fechaFin'] = $fechafin;
                        $info['dataRow'] = 1;
                        $info['paymentDataSedes'] = $paymentDataSedes;
                        $info['paymentConsolidaSedes'] = $paymentConsolidaSede;
                        $info['paymenEntidades'] = $paymentEntidades;
                        $info['paymentFechaDia'] = $paymentFechaDia;
                        $this->load->view('reports/report_sedes',$info);

                    } else {

                        $info['dataRow'] = 2;
                        $info['message'] = "No fue posible obtener consolidado de recibos pagados en el periodo seleccionado.";
                        $this->load->view('reports/report_sedes',$info);

                    }   

                } else {

                    $info['dataRow'] = 2;
                    $info['message'] = "No existen recibos pagados en el periodo seleccionado.";
                    $this->load->view('reports/report_sedes',$info);

                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: gastossedes
     * Descripcion: genera reporte de gastos por sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function gastossedes() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
                
                /*Captura Variables*/
                $date1 = new DateTime($this->input->post('fechaini')); 
                $fechaini = $date1->format('Y-m-d'); 

                $date2 = new DateTime($this->input->post('fechafin')); 
                $fechafin = $date2->format('Y-m-d');

                /*Consulta Modelo detalle gastos por sede*/
                $gastosDataSedes = $this->MReport->gastos_sedes($fechaini,$fechafin,1,null);
                /*Consulta Modelo Consolidado gastos por sede*/
                $consGastosSede = $this->MReport->gastos_consolidado_sedes($fechaini,$fechafin,1,null);
                
                /*Consulta Modelo, datos para formulario*/
                $listTypeGasto = $this->MReport->list_type_gasto();
                $listStateGasto = $this->MReport->list_state_gasto();
                $listProveedores = $this->MReport->list_proveedor();
                $listCategoriaGasto = $this->MReport->list_categoria_gasto();
                $info['listTypeGasto'] = $listTypeGasto;
                $info['listStateGasto'] = $listStateGasto;
                $info['listProveedores'] = $listProveedores;
                $info['listCategoria'] = $listCategoriaGasto;

                if ($gastosDataSedes == TRUE){
                    
                    $info['fechaIni'] = $fechaini;
                    $info['fechaFin'] = $fechafin;
                    $info['dataRow'] = 1;
                    $info['gastosDataSedes'] = $gastosDataSedes;
                    $info['consGastosSede'] = $consGastosSede;
                    
                } else {

                    $info['dataRow'] = 2;
                    $info['alert'] = 1;
                    $info['message'] = "No existen gastos registrados en el periodo seleccionado.";

                }
                
                $this->load->view('reports/report_gastos',$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: ganperdidas
     * Descripcion: genera estado de ganancias y perdidas general
     * (todas las sedes, en un periodo de tiempo)
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function ganperdidas() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
                
                /*Captura Variables*/
                $date1 = new DateTime($this->input->post('fechaini')); 
                $fechaini = $date1->format('Y-m-d'); 

                $date2 = new DateTime($this->input->post('fechafin')); 
                $fechafin = $date2->format('Y-m-d');
                
                $sede = $this->input->post('sede');

                /*Consulta Modelo Estado de Perdidas y Ganancias*/
                $dataPYGSede = $this->MReport->estado_pyg($fechaini,$fechafin,$sede);
                
                /*Consulta Modelo*/
                $listSedes = $this->MUser->list_sedes();  
                $dataPYGSede['listSedes'] = $listSedes;
                $dataPYGSede['fechaIni'] = $fechaini;
                $dataPYGSede['fechaFin'] = $fechafin;
                
                /*Calcula Impuesto de Renta*/
                $valorRenta = $this->calculaimptorenta($fechaini,$fechafin,$sede);
                $dataPYGSede['valorRenta'] = $valorRenta;
                
                if ($dataPYGSede == TRUE){
                    
                    $dataPYGSede['dataRow'] = 1;
                    
                    /*===========Genera PDF==========*/
                    ini_set('memory_limit', '256M');
                    /*Carga Libreria*/
                    $pdf = $this->pdf->load();
                    /*Carga la vista para Imprimir en PDF*/
                    $html = $this->load->view('reports/report_ganperd_pdf',$dataPYGSede, true);
                    $pdf->SetDisplayMode('fullpage');
                    /*Password del Documento PDF*/
                    $pdf->SetProtection(array(), 'username', $this->session->userdata('userid'));
                    /*Footer del documento PDF*/
                    $pdf->SetHTMLFooter('Generado: '.date('Y-m-d h:i:s').'<br />
                                         Freya Trucks - Software');

                    /*Escribo el HTML en el PDF*/
                    $pdf->WriteHTML($html);

                    /*Genera el documento y lo guarda*/
                    $output = 'Estado-GYP-'.$this->session->userdata('userid').'.pdf';
                    $pdf->Output("./files/$output", 'F');
                    /*=================================*/
                    
                    $this->load->view('reports/report_ganperd',$dataPYGSede);
                    
                } else {

                    $dataPYGSede['dataRow'] = 2;
                    $dataPYGSede['alert'] = 1;
                    $dataPYGSede['message'] = "No existen Servicios registrados en el periodo seleccionado.";
                    $this->load->view('reports/report_ganperd',$dataPYGSede);

                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: calculaimptorenta
     * Descripcion: Calcula valor del impuesto de renta para el estado
     * de ganancias y perdidas, ese segun ley 1819 de 2016
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function calculaimptorenta($fechaIni,$fechaFin,$sede) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
            
                /*Obtiene Configuracion de Parametros*/
                $data = file_get_contents(base_url().'public/bower_components/parametros/config.json');
                $configuracion = json_decode($data, true);
                $valorUVT = $configuracion['parametros']['valorVigenteUVT'];
                $tipoRenta = $configuracion['parametros']['origenRenta'];
                $calcularImptoRenta = $configuracion['parametros']['calcularImptoRenta'];
                                
                if ($calcularImptoRenta == 'S') { /*Si calcula impuesto*/
                    
                    /*Consulta Modelo para obtener Ganancia Neta*/
                    $gananciaNeta = $this->MReport->ganancia_neta($fechaIni,$fechaFin,$sede);
                
                    if ($gananciaNeta != FALSE){
                    
                        if ($tipoRenta == 1){ /*Tarifas para las rentas laboral y de pensiones*/

                            if (($gananciaNeta > 0) && ($gananciaNeta <= ($valorUVT*1090))){

                                $valorRenta = ($gananciaNeta * (0/100));

                            } else if ($gananciaNeta > ($valorUVT*1090) && $gananciaNeta <= ($valorUVT*1700)){

                                $valorRenta = ($gananciaNeta * (19/100));

                            } else if ($gananciaNeta > ($valorUVT*1700) && $gananciaNeta <= ($valorUVT*4100)){

                                $valorRenta = ($gananciaNeta * (28/100));

                            } else {

                                $valorRenta = ($gananciaNeta * (33/100));

                            }

                        } else if ($tipoRenta == 2){ /*Tarifas para las rentas no laborales y de capital*/

                            if (($gananciaNeta > 0) && ($gananciaNeta <= ($valorUVT*600))){

                                $valorRenta = ($gananciaNeta * (0/100));

                            } else if ($gananciaNeta > ($valorUVT*600) && $gananciaNeta <= ($valorUVT*1000)){

                                $valorRenta = ($gananciaNeta * (10/100));

                            } else if ($gananciaNeta > ($valorUVT*1000) && $gananciaNeta <= ($valorUVT*2000)){

                                $valorRenta = ($gananciaNeta * (20/100));

                            } else if ($gananciaNeta > ($valorUVT*2000) && $gananciaNeta <= ($valorUVT*3000)){

                                $valorRenta = ($gananciaNeta * (30/100));

                            } else if ($gananciaNeta > ($valorUVT*3000) && $gananciaNeta <= ($valorUVT*4000)){

                                $valorRenta = ($gananciaNeta * (33/100));

                            } else {

                                $valorRenta = ($gananciaNeta * (35/100));

                            }
                            
                            return $valorRenta;

                        }
                    
                    } else {
                        
                        return 0;
                        
                    }
                
                } else {
                    
                    return 0;
                    
                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addgasto
     * Descripcion: 
     *  tipo 1 -> Registrar Gasto
     *  tipo 2 -> Actualizar Gasto
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function addgasto($type){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(10)){
                
                    /*Captura Variables*/
                    $typeGasto = $this->input->post('tipo_gasto'); 
                    $dataProveedor = explode('|', $this->input->post('idproveedor'));
                    $idProveedor = $dataProveedor[1];
                    $nameGasto = strtoupper($this->input->post('describe_gasto'));
                    $valueGasto = $this->input->post('valor_gasto');
                    $nroFactura = $this->input->post('nro_factura');
                    $date = new DateTime($this->input->post('fecha_pago')); 
                    $fechaPago = $date->format('Y-m-d');
                    $stateGasto = $this->input->post('estado_gasto'); 
                    $idGasto = $this->input->post('id_gasto');
                    $idCatGasto = $this->input->post('categoria_gasto');
                                        
                    /*Consulta Modelo, datos para formulario*/
                    $listTypeGasto = $this->MReport->list_type_gasto();
                    $listStateGasto = $this->MReport->list_state_gasto();
                    $listProveedores = $this->MReport->list_proveedor();
                    $listCategoriaGasto = $this->MReport->list_categoria_gasto();
                    $info['dataRow'] = 0;
                    $info['listTypeGasto'] = $listTypeGasto;
                    $info['listStateGasto'] = $listStateGasto;
                    $info['listProveedores'] = $listProveedores;
                    $info['listCategoria'] = $listCategoriaGasto;
                    
                    /*Valida si el Proveedor existe*/
                    $validateProveedor = $this->MUser->verify_user($idProveedor);
                    
                    if ($validateProveedor != FALSE){
                        
                        if ($this->jasr->validaTipoString($nameGasto,1)){

                            if ($this->jasr->validaTipoString($valueGasto,2)){
                                
                                if ($type == 1){
                                    
                                    /*Envia datos al modelo para el registro*/
                                    $registerDataGasto = $this->MReport->add_gasto($typeGasto,$idProveedor,$nameGasto,$valueGasto,$nroFactura,$fechaPago,$stateGasto,$type,null,$idCatGasto);

                                    if ($registerDataGasto == TRUE){

                                        $info['message'] = 'Gasto Registrado Exitosamente';
                                        $info['alert'] = 1;

                                    } else {

                                        $info['message'] = 'No fue posible registrar el Gasto';
                                        $info['alert'] = 2;

                                    }
                                    
                                } else if ($type == 2){
                                    
                                    /*Envia datos al modelo para el actualizar el registro*/
                                    $updDataGasto = $this->MReport->add_gasto($typeGasto,$idProveedor,$nameGasto,$valueGasto,$nroFactura,$fechaPago,$stateGasto,$type,$idGasto,$idCatGasto);

                                    if ($updDataGasto == TRUE){

                                        $info['message'] = 'Gasto Actualizado Exitosamente';
                                        $info['alert'] = 1;

                                    } else {

                                        $info['message'] = 'No fue posible actualizar el Gasto';
                                        $info['alert'] = 2;

                                    }
                                    
                                }
                                
                                
                                $this->load->view('reports/report_gastos',$info);

                            } else {

                                $info['message'] = 'No fue posible registrar el gasto. Valor incorrecto.';
                                $info['alert'] = 2;
                                $this->load->view('reports/report_gastos',$info);

                            }

                        } else {

                            $info['message'] = 'No fue posible registrar el gasto. Nombre incorrecto.';
                            $info['alert'] = 2;
                            $this->load->view('reports/report_gastos',$info);

                        }
                    
                    } else {

                        $info['message'] = 'El Proveedor no existe, por favor digite y seleccione de la lista.';
                        $info['alert'] = 2;
                        $this->load->view('reports/report_gastos',$info);

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
     * Nombre del Metodo: fidelizationclients
     * Descripcion: genera reporte de clientes para fidelizacion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function fidelizationclients() {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
            
                /*Captura Variables*/
                $date1 = new DateTime($this->input->post('fechaini')); 
                $fechaini = $date1->format('Y-m-d'); 

                $date2 = new DateTime($this->input->post('fechafin')); 
                $fechafin = $date2->format('Y-m-d');

                /*Consulta Modelo*/
                $paymentClient = $this->MReport->payment_clients($fechaini,$fechafin);
                $topServices = $this->MReport->top_services($fechaini,$fechafin);
                $diaSemana = $this->MReport->tendencia_diasemana($fechaini,$fechafin);
                $tendVentaCliente = $this->MReport->tendencia_venta_cliente($fechaini,$fechafin);

                if ($paymentClient == TRUE){

                    $info['fechaIni'] = $fechaini;
                    $info['fechaFin'] = $fechafin;
                    $info['dataRow'] = 1;
                    $info['paymentClient'] = $paymentClient;
                    $info['topServices'] = $topServices;
                    $info['diaSemana'] = $diaSemana;
                    $info['tendVentaCliente'] = $tendVentaCliente;
                    $this->load->view('reports/report_fidelization',$info);

                } else {

                    $info['dataRow'] = 2;
                    $info['message'] = "No existen recibos pagados en el periodo seleccionado.";
                    $this->load->view('reports/report_fidelization',$info);

                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: comprobante_pdf
     * Descripcion: Genera comprobante de pago en PDF
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 09/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function comprobante_pdf($fechaIni,$fechaFin,$empleado,$sede,$orden) {
        
        if ($this->session->userdata('validated')) {
            
            if ($this->MRecurso->validaRecurso(10)){
            
                ini_set('memory_limit', '256M');

                /*Carga Libreria*/
                $pdf = $this->pdf->load();

                /*Consulta Modelo detalle de Recibo*/
                $liquidaDetalle = $this->MReport->liquida_payment_empleado($fechaIni,$fechaFin,$empleado,$sede);
                $info['liquidaDetalle'] = $liquidaDetalle;
                $info['fechaDesde'] = $fechaIni;
                $info['fechaHasta'] = $fechaFin;
                $info['ordenExpide'] = $orden;

                /*Carga la vista para Imprimir en PDF*/
                $html = $this->load->view('reports/comprobante_pdf', $info, true);
                $pdf->SetDisplayMode('fullpage');

                /*Escribo el HTML en el PDF*/
                $pdf->WriteHTML($html);

                /*Genera el documento y lo guarda*/
                $output = 'comprobante_' . $orden . '.pdf';
                $pdf->Output("./files/comprobantes/$output", 'F');

                if (file_exists("./files/comprobantes/$output")){

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
        
}
