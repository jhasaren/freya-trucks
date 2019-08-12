<?php
/*
 * ==================================================================
 * Nombre: Mike42 | Tipo: Helper
 * Funcion: escposticket
 * Descripcion: Recibe parametros desde el controlador para imprimir
 * ticket de la venta. Contiene el formato.
 * Autor: Mike42 - https://github.com/mike42/escpos-php
 * Implementado: jhonalexander90@gmail.com
 * Fecha: 18/02/2018
 * Requisitos:
 *  - Impresora Termica Instalada en el SO
 *  - Impresora debe estar configurada como predeterminada en Windows
 *  - Impresora debe estar compartida en Windows
 * ==================================================================
 */
require_once APPPATH .'third_party/tickets/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/*
 * *************************************************************************************
 * Nombre: escposticket
 * Descripcion: recibe parametros desde el controlador para imprimir ticket (Para Pago)
 * *************************************************************************************
 */
function escposticket ($detalleRecibo,$sede,$dirSede,$telsede,$printer,$turno,$nitRecibo){
    
    log_message("DEBUG", "-----------------------------------");
    log_message("DEBUG", "TICKET Impresion [Liquidacion]");
    log_message("DEBUG", "IdVenta: ".$detalleRecibo['general']->idVenta);
    log_message("DEBUG", "Recibo: ".$detalleRecibo['general']->nroRecibo);
    log_message("DEBUG", "Mesa: ".$detalleRecibo['general']->nombreMesa);
    log_message("DEBUG", "Turno: ".$detalleRecibo['general']->nroTurno);
    log_message("DEBUG", "PorcenServicio: ".$detalleRecibo['atencion']);
    log_message("DEBUG", "Impresora: ".$printer);
    
    try {
    
        /*Conexion a la Impresora*/
        $nombre_impresora = $printer; 
        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);

        /* Impresion de Logo */
        /*$logo = EscposImage::load(APPPATH.'third_party/tickets/logo.png', false);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($logo);*/

        /* Nombre del Restaurante (sede) */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text($sede."\n");
        $printer -> selectPrintMode();
        $printer -> text($dirSede."\n");
        $printer -> text("Tel: ".$telsede."\n");
        /*Valida si el parametro de NIT esta habilitado, se muestra en Ticket*/
        if ($nitRecibo != NULL){
            $printer -> setTextSize(1, 1);
            $printer -> text($nitRecibo."\n");
        }
        $printer -> feed();

        /* Turno */
        $printer -> setEmphasis(true);
        //$printer -> setTextSize(2, 2);
        $printer -> text("Factura de Venta #".$detalleRecibo['general']->nroRecibo."\n");
        $printer -> text("Turno: ".$detalleRecibo['general']->nroTurno." | Lugar: ".$detalleRecibo['general']->nombreMesa."\n");
        //$printer -> text("Turno: ".$detalleRecibo['general']->nroTurno."\n");
        $printer -> setEmphasis(false);
        $printer -> feed();
        
        /* Cliente */
        $printer -> setEmphasis(true);
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text("Cliente: ".$detalleRecibo['general']->personaCliente."\n");
        $printer -> text("NIT/CC: ".$detalleRecibo['general']->idUsuarioCliente."\n");
        $printer -> text("DIR: ".$detalleRecibo['general']->dir_cliente." TEL:".$detalleRecibo['general']->tel_cliente."\n");
        $printer -> setEmphasis(false);

        /* Items */
        $printer -> selectPrintMode();
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setEmphasis(true);
        $printer -> text(new item('', '$'));
        $printer -> setEmphasis(false);
        /*Servicios*/
        if ($detalleRecibo['servicios'] != NULL){
            foreach ($detalleRecibo['servicios']  as $valueServ){
                //log_message("DEBUG", $value['descServicio'].'('.$value['cantidad'].') -> '.$value['valor']);
                $printer -> text(new item("(".$valueServ['cantidad'].") ".$valueServ['descServicio'],number_format($valueServ['valor'],0,',','.')));
            }
        }
        /*Productos*/
        if ($detalleRecibo['productos'] != NULL){
            foreach ($detalleRecibo['productos']  as $valueProd){
                //log_message("DEBUG", $value['descServicio'].'('.$value['cantidad'].') -> '.$value['valor']);
                $printer -> text(new item("(".$valueProd['cantidad'].") ".$valueProd['descProducto'],number_format($valueProd['valor'],0,',','.')));
            }
        }
        /*Adicionales*/
        if ($detalleRecibo['adicional'] != NULL){
            foreach ($detalleRecibo['adicional']  as $valueAdc){
                //log_message("DEBUG", $value['descServicio'].'('.$value['cantidad'].') -> '.$value['valor']);
                $printer -> text(new item($valueAdc['cargoEspecial'],number_format($valueAdc['valor'],0,',','.')));
            }
        }
        /*SubTotal 1*/
        $printer -> setEmphasis(true);
        $printer -> text(new item('Subtotal 1',number_format($detalleRecibo['general']->valorTotalVenta,0,',','.')));
        $printer -> text(new item('Descuento('.($detalleRecibo['general']->porcenDescuento*100).'%)','-'.number_format(($detalleRecibo['general']->valorTotalVenta-$detalleRecibo['general']->valorLiquida),0,',','.')));
        $printer -> text(new item('Subtotal 2',number_format($detalleRecibo['general']->valorLiquida,0,',','.')));
        $printer -> text(new item('Servicio('.(round($detalleRecibo['atencion'],2)).'%)',number_format(($detalleRecibo['general']->valorLiquida*$detalleRecibo['atencion']/100),0,',','.')));
        $printer -> setEmphasis(false);
        $printer -> feed();
        
        /* Total */
        //$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> selectPrintMode();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setTextSize(1, 2);
        $printer -> text(new item('Total a Pagar', number_format($detalleRecibo['general']->valorLiquida+($detalleRecibo['general']->valorLiquida*$detalleRecibo['atencion']/100),0,',','.'), true));
        $printer -> selectPrintMode();
        if($detalleRecibo['impuesto'] == 1){
            //$printer -> text(new item('Impoconsumo', number_format(($detalleRecibo['general']->valorLiquida+($detalleRecibo['general']->valorLiquida*$detalleRecibo['atencion']/100))*$detalleRecibo['general']->impoconsumo,0,',','.')));
            $printer -> text(new item('Base:', number_format($detalleRecibo['general']->valorLiquida/($detalleRecibo['general']->impoconsumo + 1),0,',','.') ));
            $printer -> text(new item('Impoconsumo ('.($detalleRecibo['general']->impoconsumo*100).'%):', number_format(($detalleRecibo['general']->valorLiquida/($detalleRecibo['general']->impoconsumo + 1))*$detalleRecibo['general']->impoconsumo,0,',','.') ));
        }
        $printer -> selectPrintMode();
        
        log_message("DEBUG", "*************************************************************");
        log_message("DEBUG", "valor liquida:".$detalleRecibo['general']->valorLiquida);
        log_message("DEBUG", "sobre:".($detalleRecibo['general']->impoconsumo + 1));
        log_message("DEBUG", "impuesto:".$detalleRecibo['general']->impoconsumo);
        log_message("DEBUG", "operacion1_base:".number_format($detalleRecibo['general']->valorLiquida/($detalleRecibo['general']->impoconsumo + 1),0,',','.'));
        log_message("DEBUG", "operacion2_impo:".number_format(($detalleRecibo['general']->valorLiquida/($detalleRecibo['general']->impoconsumo + 1))*$detalleRecibo['general']->impoconsumo,0,',','.'));
        log_message("DEBUG", "*************************************************************");

        /* Pie de Pagina */
        $printer -> feed(2);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text($detalleRecibo['general']->resolucionExpide."\n");
        /*Texto Propina Voluntaria*/
        $printer -> text("Este establecimiento de comercio le sugiere una propina voluntaria del 10% del valor de la cuenta antes de impuestos, el cual podrá ser aceptado, rechazado o modificado por usted, de acuerdo a la valoración del servicio prestado. Al momento de solicitar la cuenta, indíquele a la persona que lo atiende si quiere que dicho valor sea o no incluido en la factura o indíquele el valor que quiere dar como propina.\n");
        $printer -> text("Gracias por Preferirnos!!\n");
        $printer -> feed(2);
        $printer -> text("Freya Software - Amadeus Soluciones\n");
        $printer -> text(date('d/m/Y H:i:s') . "\n");

        /* Corta el Papel y Finaliza */
        //$printer-> pulse(); /*Abre Caja Registradora*/
        $printer -> cut();
        $printer -> close();
        
    } catch (Exception $e){
        
        log_message("DEBUG", "TICKET ERROR -> ".$e);
        
    }
}


/*
 * *************************************************************************************
 * Nombre: escposticketco
 * Descripcion: recibe parametros desde el controlador para imprimir ticket (Para Cocina)
 * *************************************************************************************
 */
function escposticketco ($detalleRecibo,$sede,$printer){
    
    log_message("DEBUG", "-----------------------------------");
    log_message("DEBUG", "TICKET Impresion [Cocina]");
    log_message("DEBUG", "IdVenta: ".$detalleRecibo['general']->idVenta);
    log_message("DEBUG", "Recibo: ".$detalleRecibo['general']->nroRecibo);
    log_message("DEBUG", "Mesa: ".$detalleRecibo['general']->nombreMesa);
    log_message("DEBUG", "Turno: ".$detalleRecibo['general']->nroTurno);
    log_message("DEBUG", "Impresora: ".$printer);
    
    try {
    
        /*Conexion a la Impresora*/
        $nombre_impresora = $printer; 
        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);

        /* Impresion de Logo */
        /*$logo = EscposImage::load(APPPATH.'third_party/tickets/logo.png', false);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($logo);*/

        /* Nombre del Restaurante (sede) */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text($sede."\n");
        $printer -> text("[Ticket de Cocina]\n");
        $printer -> selectPrintMode();
        $printer -> feed();

        /* Turno */
        $printer -> setEmphasis(true);
        //$printer -> setTextSize(2, 2);
        $printer -> text("Detalle de Venta #".$detalleRecibo['general']->nroRecibo."\n");
        $printer -> text("Lugar: ".$detalleRecibo['general']->nombreMesa."\n");
        $printer -> text("Turno: ".$detalleRecibo['general']->nroTurno."\n");
        $printer -> setEmphasis(false);
        $printer -> feed();
        
        /* Items */
        $printer -> selectPrintMode();
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setEmphasis(true);
        $printer -> text(new item('', '$'));
        $printer -> setEmphasis(false);
        /*Servicios*/
        if ($detalleRecibo['servicios'] != NULL){
            foreach ($detalleRecibo['servicios']  as $valueServ){
                //log_message("DEBUG", $value['descServicio'].'('.$value['cantidad'].') -> '.$value['valor']);
                $printer -> text(new item("(".$valueServ['cantidad'].") ".$valueServ['descServicio'],$valueServ['valor']));
            }
        }
        /*Productos*/
        if ($detalleRecibo['productos'] != NULL){
            foreach ($detalleRecibo['productos']  as $valueProd){
                //log_message("DEBUG", $value['descServicio'].'('.$value['cantidad'].') -> '.$value['valor']);
                $printer -> text(new item("(".$valueProd['cantidad'].") ".$valueProd['descProducto'],$valueProd['valor']));
            }
        }
        /*Adicionales*/
        if ($detalleRecibo['adicional'] != NULL){
            foreach ($detalleRecibo['adicional']  as $valueAdc){
                //log_message("DEBUG", $value['descServicio'].'('.$value['cantidad'].') -> '.$value['valor']);
                $printer -> text(new item($valueAdc['cargoEspecial'],$valueAdc['valor']));
            }
        }
        
        $printer -> selectPrintMode();

        /* Pie de Pagina */
        $printer -> feed(2);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        //$printer -> text("Gracias por Preferirnos!!\n");
        $printer -> text("Freya Software - Amadeus Soluciones\n");
        $printer -> feed(2);
        $printer -> text(date('d/m/Y H:i:s') . "\n");

        /* Corta el Papel y Finaliza */
        $printer -> cut();
        $printer -> close();
        
    } catch (Exception $e){
        
        log_message("DEBUG", "TICKET COCINA ERROR -> ".$e);
        
    }
}


/* Clase para Organizar items de nombres y precios en columnas */
class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }

    public function __toString()
    {
	/*
         * Tamano de Papel para la impresion ajustada de conceptos en la venta
         * Parrillon Valluno: $rightCols = 8; $leftCols = 34;
         */
        //$rightCols = 10;
        //$leftCols = 38;
	$rightCols = 8;
        $leftCols = 34;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;

        $sign = ($this -> dollarSign ? '$ ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}