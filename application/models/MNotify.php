<?php
/**************************************************************************
* Nombre de la Clase: MNotify
* Version: 1.0
* Descripcion: Es el modelo que controla las notificaciones
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 12/05/2017
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class MNotify extends CI_Model {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->file('application/libraries/class.phpmailer.php'); /*Libreria para el envio de Email*/
                
    }
            
    /**************************************************************************
     * Nombre del Metodo: notifica_pago_empleado
     * Descripcion: Notifica al Empleado la liquidacion de su pago con el respectivo
     * comprobante.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 12/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function notifica_pago_empleado($orden,$nombreEmpleado,$idEmpleado,$email){
        
        if ($this->session->userdata('validated')) {
        
            $archivoComprobante = "./files/comprobantes/comprobante_".$orden.".pdf";
            
            /*Notifica al correo electronico*/
            $notificationMail = new PHPMailer();
            
            //Propiedades del mensaje
            $notificationMail->Host     = "10.1.2.19";
            $notificationMail->From     = "info@freya.com";
            $notificationMail->FromName = "Freya APP";
            $notificationMail->Subject  = "Comprobante de Pago #".$orden;
            $notificationMail->AddAddress($email);
            
            //Cuerpo del mensaje
            $body = " <html>"
                    . "<head>"
                    . "<title>Comprobante de Pago</title>"
                    . "</head>"
                    . "<body>"
                    . "<h4>Sr(a) ".$nombreEmpleado."</h4>"
                    . "<h4>CC. ".$idEmpleado."</h4>"
                    . "Se adjunta soporte de pago correspondiente a la liquidación realizada por los servicios prestados en Centro de Belleza.<br /><br />"
                    . "Cualquier duda o inquietud debe reportarse presentando el documento adjunto.<br />"
                    . "<strong>Freya APP</strong> | Gestión Integral de Centros de Belleza<br />"
                    . "</body>"
                    . "</html>";
            $notificationMail->Body = $body;
            $notificationMail->IsHTML(true);
            $notificationMail->CharSet = 'UTF-8';
            $notificationMail->AddAttachment($archivoComprobante,"comp_$orden.pdf");

            //enviar el correo
            if (($notificationMail->Send()) == TRUE){

                return TRUE;

            } else {

                return FALSE;

            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: notifica_pago_venta
     * Descripcion: Notifica al Cliente el detalle del pago realizado.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 12/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function notifica_pago_venta($recibo,$nombreCliente,$idCliente,$email){
        
        if ($this->session->userdata('validated')) {
        
            $archivoRecibo = "./files/recibos/recibo_".$recibo.".pdf";
            
            /*Notifica al correo electronico*/
            $notificationMail = new PHPMailer();
            
            //Propiedades del mensaje
            $notificationMail->Host     = "10.1.2.19";
            $notificationMail->From     = "info@freya.com";
            $notificationMail->FromName = "Freya APP";
            $notificationMail->Subject  = "Recibo de Pago #".$recibo;
            $notificationMail->AddAddress($email);
            
            //Cuerpo del mensaje
            $body = " <html>"
                    . "<head>"
                    . "<title>Recibo de Pago</title>"
                    . "</head>"
                    . "<body>"
                    . "<h4>Sr(a) ".$nombreCliente."</h4>"
                    . "<h4>CC. ".$idCliente."</h4>"
                    . "Se adjunta recibo de pago correspondiente al servicio brindado en el Centro de Belleza.<br /><br />"
                    . "Cualquier duda o inquietud debe reportarse presentando el documento adjunto.<br />"
                    . "<strong>Freya APP</strong> | Gestión Integral de Centros de Belleza<br />"
                    . "</body>"
                    . "</html>";
            $notificationMail->Body = $body;
            $notificationMail->IsHTML(true);
            $notificationMail->CharSet = 'UTF-8';
            $notificationMail->AddAttachment($archivoRecibo,"recibo_$recibo.pdf");

            //enviar el correo
            if (($notificationMail->Send()) == TRUE){

                return TRUE;

            } else {

                return FALSE;

            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
}
