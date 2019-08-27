<?php
/**************************************************************************
* Nombre de la Clase: MReport
* Descripcion: Es el Modelo para las interacciones en BD del modulo Reportes
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 05/04/2017
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MReport extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: payment_recibos
     * Descripcion: Recupera los recibos Pagados en un periodo de tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 05/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function payment_recibos($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                m.idVenta,
                                m.fechaLiquida,
                                m.fechaPideCuenta,
                                m.nroRecibo,
                                m.valorTotalVenta as valorVenta,
                                m.valorLiquida,
                                (m.valorLiquida*m.porcenServicio) as popina_servicio,
                                (select sum(valorPago) from forma_de_pago where idVenta = m.idVenta) as forma_pago,
                                t.descEstadoRecibo,
                                /*(m.valorLiquida*m.impoconsumo) as impoconsumo*/
                                ((m.valorLiquida/(m.impoconsumo+1))*m.impoconsumo) as impoconsumo
                                FROM venta_maestro m
                                JOIN tipo_estado_recibo t ON t.idEstadoRecibo = m.idEstadoRecibo
                                WHERE
                                m.idEstadoRecibo IN (5,3)
                                AND m.idSede = ".$this->session->userdata('sede')."
                                AND m.fechaPideCuenta BETWEEN '".$fechaIni."' AND '".$fechaFin."'");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: payment_recibos_form
     * Descripcion: Recupera los recibos Pagados/anulados con formas de pago en un periodo 
     * de tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function payment_recibos_form($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                m.idVenta,
                                m.fechaLiquida,
                                m.nroRecibo,
                                p.descTipoPago,
                                f.valorPago,
                                t.descEstadoRecibo,
                                f.referenciaPago
                                FROM venta_maestro m
                                JOIN tipo_estado_recibo t ON t.idEstadoRecibo = m.idEstadoRecibo
                                LEFT JOIN forma_de_pago f ON f.idVenta = m.idVenta
                                LEFT JOIN tipo_forma_pago p ON p.idTipoPago = f.idTipoPago
                                WHERE
                                m.idEstadoRecibo IN (5,3)
                                AND m.idSede = ".$this->session->userdata('sede')."
                                AND m.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: payment_consolida_form
     * Descripcion: Recupera consolidado de pagos por formas de pago en un periodo 
     * de tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function payment_consolida_form($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                f.idTipoPago,
                                t.descTipoPago,
                                sum(f.valorPago) as valor_pago
                                FROM forma_de_pago f
                                JOIN tipo_forma_pago t ON t.idTipoPago = f.idTipoPago
                                JOIN venta_maestro v ON v.idVenta = f.idVenta
                                WHERE
                                v.idEstadoRecibo IN (5)
                                AND v.idSede = ".$this->session->userdata('sede')."
                                AND v.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                GROUP BY f.idTipoPago" );
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: detalle_recibo
     * Descripcion: Recupera el detalle de un recibo pagado de la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 01/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function detalle_recibo($idventa) {
        
        $queryServ = $this->db->query("SELECT
                                v.idRegistroDetalle,
                                v.idVenta,
                                v.idServicio,
                                s.descServicio,
                                v.valor,
                                v.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado,
                                v.cantidad
                                FROM
                                venta_detalle v
                                JOIN servicios s ON s.idServicio = v.idServicio
                                JOIN app_usuarios a ON a.idUsuario = v.idEmpleado
                                WHERE
                                v.idVenta = ".$idventa."");
        
        $queryProd = $this->db->query("SELECT
                                v.idRegistroDetalle,
                                v.idVenta,
                                v.idProducto,
                                p.descProducto,
                                v.valor,
                                v.cantidad,
                                v.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado
                                FROM
                                venta_detalle v
                                JOIN productos p ON p.idProducto = v.idProducto
                                JOIN app_usuarios a ON a.idUsuario = v.idEmpleado
                                WHERE
                                v.idVenta = ".$idventa."
                                AND productoInterno = 'N'");
        
        $queryAdic = $this->db->query("SELECT
                                v.idRegistroDetalle,
                                v.cargoEspecial,
                                v.valor,
                                v.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado
                                FROM 
                                venta_detalle v
                                JOIN app_usuarios a ON a.idUsuario = v.idEmpleado
                                WHERE
                                v.idVenta = ".$idventa."
                                and v.cargoEspecial IS NOT NULL");
        
        $queryGeneral = $this->db->query("SELECT
                                vm.idVenta,
                                vm.nroRecibo,
                                rr.resolucionExpide,
                                vm.fechaLiquida,
                                vm.fechaPideCuenta,
                                vm.idEstadoRecibo,
                                t.descEstadoRecibo,
                                vm.idUsuarioLiquida,
                                CONCAT(au.nombre,' ',au.apellido) as personaLiquida,
                                vm.idUsuarioCliente,
                                CONCAT(ac.nombre,' ',ac.apellido) as personaCliente,
                                ac.numCelular as tel_cliente,
                                ac.direccion as dir_cliente,
                                vm.porcenDescuento,
                                vm.valorTotalVenta,
                                vm.valorLiquida,
                                vm.motivoAnula,
                                vm.usuarioAnula,
                                vm.fechaAnula,
                                vm.nroTurno,
                                vm.idEmpleadoAtiende,
                                CONCAT(ae.nombre,' ',ae.apellido) as personaAtiende,
                                vm.porcenServicio,
                                vm.impoconsumo,
                                m.nombreMesa
                                FROM
                                venta_maestro vm
                                JOIN tipo_estado_recibo t ON t.idEstadoRecibo = vm.idEstadoRecibo
                                JOIN app_usuarios au ON au.idUsuario = vm.idUsuarioLiquida
                                JOIN app_usuarios ac ON ac.idUsuario = vm.idUsuarioCliente
                                LEFT JOIN rango_recibos rr ON rr.nroRecibo = vm.nroRecibo
                                LEFT JOIN app_usuarios ae ON ae.idUsuario = vm.idEmpleadoAtiende
                                LEFT JOIN mesas m ON m.idMesa = vm.idMesa
                                WHERE
                                vm.idVenta = ".$idventa."");
        
        $queryFormaPago = $this->db->query("SELECT
                                f.idTipoPago,
                                t.descTipoPago,
                                f.valorPago,
                                f.referenciaPago
                                FROM forma_de_pago f
                                JOIN tipo_forma_pago t ON t.idTipoPago = f.idTipoPago
                                WHERE f.idVenta = ".$idventa."");
        
        $data['servicios'] = $queryServ->result_array();
        $data['productos'] = $queryProd->result_array();
        $data['adicional'] = $queryAdic->result_array();
        $data['general'] = $queryGeneral->row();
        $data['formaPago'] = $queryFormaPago->result_array();
        
        return $data;
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: payment_sedes
     * Descripcion: Recupera los recibos Pagados en un periodo de tiempo por Sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function payment_sedes($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                m.idVenta,
                                m.fechaPideCuenta,
                                m.nroRecibo,
                                m.valorTotalVenta as valorVenta,
                                m.valorLiquida,
                                m.idSede,
                                s.nombreSede,
                                m.porcenServicio,
                                (m.valorLiquida*m.porcenServicio) as popina_servicio,
                                m.idEmpleadoAtiende,
                                concat(u.nombre,' ',u.apellido) as empleado,
                                m.impoconsumo
                                FROM venta_maestro m
                                JOIN sede s ON s.idSede = m.idSede
                                LEFT JOIN app_usuarios u ON u.idUsuario = m.idEmpleadoAtiende
                                WHERE
                                m.idEstadoRecibo = 5
                                AND m.fechaPideCuenta BETWEEN '".$fechaIni."' AND '".$fechaFin."'");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: gastos_sedes
     * Descripcion: 
     *  Tipo 1->Recupera los gastos registrados en un periodo de tiempo por Sede
     *  Tipo 2->Recupera el registro de un gasto puntual
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function gastos_sedes($fechaIni,$fechaFin,$type,$idValue) {
        
        if ($type == 1){
            
            $query = $this->db->query("SELECT
                                    g.idGasto,
                                    g.descGasto,
                                    g.valorGasto,
                                    g.fechaPago,
                                    g.nroFactura,
                                    g.idTipoGasto,
                                    tg.descTipoGasto,
                                    g.idEstadoGasto,
                                    eg.descEstadoGasto,
                                    g.idSede,
                                    s.nombreSede,
                                    g.idProveedor,
                                    g.idCategoriaGasto,
                                    cg.descCategoria,
                                    concat(u.nombre,' ',u.apellido) as proveedor
                                    FROM gasto_maestro g
                                    JOIN tipo_gasto tg ON tg.idTipoGasto = g.idTipoGasto
                                    JOIN tipo_estado_gasto eg ON eg.idEstadoGasto = g.idEstadoGasto
                                    JOIN sede s ON s.idSede = g.idSede
                                    JOIN app_usuarios u ON u.idUsuario = g.idProveedor
                                    JOIN categoria_gasto cg ON cg.idCategoriaGasto = g.idCategoriaGasto
                                    WHERE
                                    g.fechaPago BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'");
            
            if ($query->num_rows() == 0) {
            
                return false;

            } else {

                return $query->result_array();

            }
            
        } else if ($type == 2){
            
            $query = $this->db->query("SELECT
                                g.idGasto,
                                g.descGasto,
                                g.valorGasto,
                                g.fechaPago,
                                g.nroFactura,
                                g.idTipoGasto,
                                tg.descTipoGasto,
                                g.idEstadoGasto,
                                eg.descEstadoGasto,
                                g.idSede,
                                s.nombreSede,
                                g.idProveedor,
                                g.idCategoriaGasto,
                                cg.descCategoria,
                                concat(u.nombre,' ',u.apellido) as proveedor
                                FROM gasto_maestro g
                                JOIN tipo_gasto tg ON tg.idTipoGasto = g.idTipoGasto
                                JOIN tipo_estado_gasto eg ON eg.idEstadoGasto = g.idEstadoGasto
                                JOIN sede s ON s.idSede = g.idSede
                                JOIN app_usuarios u ON u.idUsuario = g.idProveedor
                                JOIN categoria_gasto cg ON cg.idCategoriaGasto = g.idCategoriaGasto
                                WHERE
                                g.idGasto =".$idValue."");
            
            if ($query->num_rows() == 0) {
            
                return false;

            } else {

                return $query->row();

            }
            
        }
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: payment_consolidado_sedes
     * Descripcion: Recupera consolidado de los recibos Pagados en un periodo de 
     * tiempo por Sede.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function payment_consolidado_sedes($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                m.idSede,
                                s.nombreSede,
                                sum(m.valorTotalVenta) as valorVenta,
                                sum(m.valorLiquida) as valorLiquida,
                                /*sum(m.valorLiquida*m.impoconsumo) as impoconsumo,*/
                                sum((m.valorLiquida/(m.impoconsumo+1))*m.impoconsumo) as impoconsumo,
                                (sum(m.valorTotalVenta)-sum(m.valorLiquida)) as valorDesctoServ,
                                (
                                    SELECT
                                    sum(ve.valorEmpleado)
                                    FROM venta_detalle ve
                                    JOIN venta_maestro ma ON ma.idVenta = ve.idVenta
                                    WHERE
                                    ma.idEstadoRecibo = 5
                                    and ma.idSede = m.idSede
                                    AND ma.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                ) as valorEmpleado,
                                (avg(m.porcenDescuento)*100) as promDescuento,
                                (
                                    SELECT
                                    sum(g.valorGasto)
                                    FROM gasto_maestro g
                                    WHERE
                                    g.idEstadoGasto = 2
                                    AND g.idSede = m.idSede
                                    AND g.fechaPago BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                ) as valorGastos,
                                sum(m.valorLiquida*m.porcenServicio) as propina_servicio
                                FROM venta_maestro m
                                JOIN sede s ON s.idSede = m.idSede
                                WHERE
                                m.idEstadoRecibo = 5
                                AND m.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                GROUP BY m.idSede");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: ingreso_sede
     * Descripcion: Recupera ingreso por sede en un periodo de tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function estado_pyg($fechaIni,$fechaFin, $sede) {
        
        $queryServicios = $this->db->query("SELECT
                                        vd.idServicio,
                                        sum(vd.valor) as valorLiquida
                                        FROM venta_maestro m
                                        JOIN venta_detalle vd ON vd.idVenta = m.idVenta
                                        WHERE
                                        m.idEstadoRecibo = 5
                                        AND m.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                        AND m.idSede = ".$sede."
                                        AND vd.idServicio IS NOT NULL
                                        group by vd.idServicio");
        
        $queryProductos = $this->db->query("SELECT
                                        vd.idProducto,
                                        sum(vd.valor) as valorLiquida
                                        FROM venta_maestro m
                                        JOIN venta_detalle vd ON vd.idVenta = m.idVenta
                                        WHERE
                                        m.idEstadoRecibo = 5
                                        AND m.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                        AND m.idSede = ".$sede."
                                        AND vd.idProducto IS NOT NULL
                                        group by vd.idProducto");
        
        $queryAdicionales = $this->db->query("SELECT
                                        vd.cargoEspecial,
                                        sum(vd.valor) as valorLiquida
                                        FROM venta_maestro m
                                        JOIN venta_detalle vd ON vd.idVenta = m.idVenta
                                        WHERE
                                        m.idEstadoRecibo = 5
                                        AND m.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                        AND m.idSede = ".$sede."
                                        AND vd.cargoEspecial IS NOT NULL
                                        group by vd.cargoEspecial");
        
        $queryGastosVariables = $this->db->query("SELECT
                                        g.idTipoGasto,
                                        sum(g.valorGasto) as valorgasto
                                        FROM gasto_maestro g
                                        WHERE
                                        g.idEstadoGasto = 2
                                        AND g.idSede = ".$sede."
                                        AND g.fechaPago BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                        AND g.idTipoGasto = 2
                                        GROUP BY g.idTipoGasto");
        
        $queryGastosFijos = $this->db->query("SELECT
                                        g.descGasto,
                                        g.valorGasto as valorgasto
                                        FROM gasto_maestro g
                                        WHERE
                                        g.idEstadoGasto = 2
                                        AND g.idSede = ".$sede."
                                        AND g.fechaPago BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                        AND g.idTipoGasto = 1");
        
        $queryDescuentos = $this->db->query("SELECT
                                        sum(v.valorTotalVenta)-sum(v.valorLiquida) as valordescuento,
                                        sum(v.valorLiquida*v.porcenServicio) as valorpropina
                                        FROM
                                        venta_maestro v
                                        WHERE
                                        v.idEstadoRecibo = 5
                                        AND v.idSede = ".$sede."
                                        AND v.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'");
        
        $queryImpuesto = $this->db->query("SELECT
                                        /*sum(v.valorLiquida*v.impoconsumo) as valorimpoconsumo*/
                                        sum((v.valorLiquida/(v.impoconsumo+1))*v.impoconsumo) as valorimpoconsumo
                                        FROM
                                        venta_maestro v
                                        WHERE
                                        v.idEstadoRecibo = 5
                                        AND v.idSede = ".$sede."
                                        AND v.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'");
        
        if ($queryServicios->num_rows() == 0) {
            
            return false;
            
        } else {
            
            $data['servicios'] = $queryServicios->result_array();
            $data['productos'] = $queryProductos->result_array();
            $data['adicional'] = $queryAdicionales->result_array();
            $data['gastosVariables'] = $queryGastosVariables->result_array();
            $data['gastosFijos'] = $queryGastosFijos->result_array();
            $data['descuentos'] = $queryDescuentos->row();
            $data['impoconsumo'] = $queryImpuesto->row();

            return $data;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: gastos_consolidado_sedes
     * Descripcion: Recupera consolidado de los Gastos en un periodo de 
     * tiempo por Sede.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function gastos_consolidado_sedes($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                    s.nombreSede,
                                    tg.descTipoGasto,
                                    sum(g.valorGasto) as valor
                                    FROM gasto_maestro g
                                    JOIN tipo_gasto tg ON tg.idTipoGasto = g.idTipoGasto
                                    JOIN sede s ON s.idSede = g.idSede
                                    WHERE
                                    g.idEstadoGasto = 2
                                    AND g.fechaPago BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                    GROUP BY s.nombreSede,tg.descTipoGasto");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: ganancia_neta
     * Descripcion: Recupera el ingreso y gastos y calcula ganancia neta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function ganancia_neta($fechaIni,$fechaFin,$sede) {
        
        $query = $this->db->query("SELECT
                                'ingreso' as tipo,
                                sum(m.valorLiquida) as valor
                                FROM venta_maestro m
                                WHERE
                                m.idEstadoRecibo = 5
                                AND m.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                AND m.idSede = ".$sede."
                                UNION ALL
                                SELECT
                                'gasto' as tipo,
                                sum(g.valorGasto) as valor
                                FROM gasto_maestro g
                                WHERE
                                g.idEstadoGasto = 2
                                AND g.idSede = ".$sede."
                                AND g.fechaPago BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            $result = $query->result_array();
            foreach ($result as $value) {
                         
                if ($value['tipo'] == 'ingreso'){
                    $ingreso = $ingreso + $value['valor'];
                }
                
                if ($value['tipo'] == 'gasto'){
                    $gasto = $gasto + $value['valor'];
                }

            }
            
            return ($ingreso-$gasto);
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: payment_detalle_empleado
     * Descripcion: Recupera detalle de pagos por empleado en un periodo de tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 05/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function payment_detalle_empleado($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                m.idSede,
                                s.nombreSede,
                                v.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado,
                                v.idVenta,
                                m.nroRecibo,
                                re.ordenCierre,
                                sum(v.valor) as valorVenta,
                                sum(v.valorEmpleado) as valorEmpleado,
                                m.fechaLiquida
                                FROM venta_detalle v
                                JOIN venta_maestro m ON m.idVenta = v.idVenta
                                JOIN app_usuarios a ON a.idUsuario = v.idEmpleado
                                JOIN sede s ON s.idSede = m.idSede
                                LEFT JOIN rango_recibos re ON re.nroRecibo = m.nroRecibo
                                WHERE m.idEstadoRecibo = 5
                                AND m.fechaLiquida BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                GROUP BY v.idEmpleado, v.idVenta
                                ORDER BY v.idEmpleado");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: liquida_payment_empleado
     * Descripcion: Recupera detalle de pagos por empleado en un periodo de tiempo
     * y una sede especifica para hacer la liquidacion.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 05/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function liquida_payment_empleado($fechaIni,$fechaFin, $empleado, $sede) {
        
        $query = $this->db->query("SELECT
                                m.idSede,
                                s.nombreSede,
                                s.nitSede,
                                s.direccionSede,
                                s.telefonoSede,
                                v.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado,
                                a.numCelular,
                                a.direccion,
                                a.email,
                                v.idVenta,
                                m.nroRecibo,
                                re.idEstadoRecibo,
                                re.ordenCierre,
                                sum(v.valorEmpleado) as valorEmpleado,
                                m.fechaLiquida
                                FROM venta_detalle v
                                JOIN venta_maestro m ON m.idVenta = v.idVenta
                                JOIN app_usuarios a ON a.idUsuario = v.idEmpleado
                                JOIN sede s ON s.idSede = m.idSede
                                LEFT JOIN rango_recibos re ON re.nroRecibo = m.nroRecibo
                                WHERE m.idEstadoRecibo = 5
                                AND m.fechaLiquida BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                AND v.idEmpleado = ".$empleado."
                                AND m.idSede = ".$sede."
                                AND v.valorEmpleado <> 0
                                GROUP BY v.idEmpleado, v.idVenta");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: payment_cierre
     * Descripcion: Cierra un recibo (pago de nomina)
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function payment_cierre($recibos,$orden) {
              
        $this->db->trans_start();
        foreach ($recibos as $rowRecibo => $id) {
            
            /*actualiza recibos*/
            $this->db->query("UPDATE
                            rango_recibos SET
                            ordenCierre = '".$orden."',
                            idEstadoRecibo = 7
                            WHERE
                            nroRecibo = ".$id."");

        }

        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            return true;

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: payment_total_empleado
     * Descripcion: Recupera consolidado de pago por empleado en un periodo de tiempo
     * por cada sede donde haya prestado servicio.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 05/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function payment_total_empleado($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                m.idSede,
                                s.nombreSede,
                                v.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado,
                                sum(v.valorEmpleado) as valorEmpleado
                                FROM venta_detalle v
                                JOIN venta_maestro m ON m.idVenta = v.idVenta
                                JOIN app_usuarios a ON a.idUsuario = v.idEmpleado
                                JOIN sede s ON s.idSede = m.idSede
                                WHERE m.idEstadoRecibo = 5
                                AND m.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                GROUP BY v.idEmpleado, m.idSede");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: payment_entidades
     * Descripcion: Recupera consolidado de pago por entidad (forma de pago) en un
     * periodo de tiempo.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function payment_entidades($fechaIni,$fechaFin) {
                    
        $querySede = $this->db->query("SELECT
                                    f.idTipoPago,
                                    t.descTipoPago,
                                    sum(f.valorPago) as sumPago
                                    FROM forma_de_pago f
                                    JOIN tipo_forma_pago t ON t.idTipoPago = f.idTipoPago
                                    JOIN venta_maestro v ON v.idVenta = f.idVenta
                                    WHERE v.idEstadoRecibo = 5
                                    AND v.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                    GROUP BY f.idTipoPago");
        
        if ($querySede->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $querySede->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: payment_fechadia
     * Descripcion: Recupera consolidado de pago por fecha/dia en un
     * periodo de tiempo.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function payment_fechadia($fechaIni,$fechaFin) {
                    
        $queryFecha = $this->db->query("SELECT
                                        v.fechaPideCuenta as fechaLiquida,
                                        DATE_FORMAT(v.fechaPideCuenta,'%d-%b-%y') as fecha,
                                        sum(v.valorLiquida+(v.valorLiquida*v.porcenServicio)) AS sumPago
                                        FROM
                                        venta_maestro v
                                        WHERE
                                        v.idEstadoRecibo = 5
                                        AND v.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                        GROUP BY DATE_FORMAT(v.fechaPideCuenta,'%d-%b-%y')
                                        ORDER BY 1 ASC");
        
        if ($queryFecha->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $queryFecha->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: payment_clients
     * Descripcion: Recupera los recibos Pagados en un periodo de tiempo por Cliente
     * en todas las sedes.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function payment_clients($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                m.idUsuarioCliente,
                                concat(a.nombre,' ',a.apellido) AS nombre,
                                a.numCelular,
                                a.email,
                                f.mes AS mesCumple,
                                f.dia AS diaCumple,
                                (SELECT max(date(vma.fechaLiquida)) 
                                FROM venta_maestro vma 
                                WHERE vma.idUsuarioCliente = m.idUsuarioCliente
                                AND vma.idSede = ".$this->session->userdata('sede').") AS fechaUltimaAtencion,
                                count(1) AS cantidadPagos,
                                sum(m.valorLiquida) AS valorPagos
                                FROM
                                venta_maestro m
                                JOIN app_usuarios a ON a.idUsuario = m.idUsuarioCliente
                                JOIN fecha_cumple_usuario f ON f.idUsuario = a.idUsuario
                                WHERE
                                m.idEstadoRecibo = 5
                                AND a.activo = 'S'
                                AND m.fechaLiquida BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                GROUP BY m.idUsuarioCliente
                                ORDER BY 8 DESC");

        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: birthday_clients
     * Descripcion: Recupera los clientes que cumplen años en un mes determinado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function birthday_clients($mes) {
        
        $query = $this->db->query("SELECT
                                f.dia,
                                a.idUsuario,
                                concat(a.nombre,' ',a.apellido) AS nombre,
                                a.numCelular,
                                a.email,
                                a.direccion
                                FROM
                                app_usuarios a
                                JOIN fecha_cumple_usuario f ON f.idUsuario = a.idUsuario
                                WHERE a.activo = 'S'
                                AND a.idTipoUsuario IN (2,1)
                                AND f.mes = ".$mes."");

        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_type_gasto
     * Descripcion: Recupera lista de tipo de gastos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_type_gasto() {
        
        $dataCache = $this->cache->memcached->get('mTypeGasto');
        
        if ($dataCache){
            
            $this->cache->memcached->save('memcached20', 'cache', 30);
            return $dataCache;
            
        } else {
        
            $query = $this->db->query("SELECT
                                    idTipoGasto,
                                    descTipoGasto
                                    FROM
                                    tipo_gasto t
                                    WHERE
                                    activo = 'S'");
            
            $this->cache->memcached->save('mTypeGasto', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached20', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_state_gasto
     * Descripcion: Recupera lista de estado de gastos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_state_gasto() {
        
        $dataCache = $this->cache->memcached->get('mStateGasto');
        
        if ($dataCache){
            
            $this->cache->memcached->save('memcached21', 'cache', 30);
            return $dataCache;
            
        } else {
        
            $query = $this->db->query("SELECT
                                    idEstadoGasto,
                                    descEstadoGasto
                                    FROM
                                    tipo_estado_gasto
                                    ORDER BY 1 DESC");
            
            $this->cache->memcached->save('mStateGasto', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached21', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_categoria_gasto
     * Descripcion: Recupera lista de categorias de gastos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 19/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_categoria_gasto() {
        
        $dataCache = $this->cache->memcached->get('mCategoriaGasto');
        
        if ($dataCache){
            
            $this->cache->memcached->save('memcached23', 'cache', 30);
            return $dataCache;
            
        } else {
        
            $query = $this->db->query("SELECT
                                    idCategoriaGasto,
                                    descCategoria
                                    FROM categoria_gasto
                                    WHERE
                                    activo = 'S'
                                    ORDER BY 2 ASC");
            
            $this->cache->memcached->save('mCategoriaGasto', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached23', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_proveedor
     * Descripcion: Obtiene los usuarios 'Proveedores' activos para registrar
     * en el Gasto
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_proveedor() {
        
        $dataCache = $this->cache->memcached->get('mListProveedor');
        
        if ($dataCache){
            
            $this->cache->memcached->save('memcached22', 'cache', 30);
            return $dataCache;
            
        } else {
            
            /*Recupera los usuarios Prveedores creados*/
            $query = $this->db->query("SELECT
                                    a.idUsuario,
                                    concat(a.nombre,' ',a.apellido) as nombre_usuario,
                                    a.numCelular
                                    FROM
                                    app_usuarios a
                                    WHERE
                                    a.idTipoUsuario = 3
                                    AND a.activo = 'S'
                                    ORDER BY 2");
            
            $this->cache->memcached->save('mListProveedor', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached22', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: add_gasto
     * Descripcion: Registra Gasto
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function add_gasto($typeGasto,$idProveedor,$nameGasto,$valueGasto,$nroFactura,$fechaPago,$stateGasto,$typeAction,$idGasto,$idCatGasto) {
        
        $this->db->trans_start();
        
        if ($typeAction == 1){
            $query = $this->db->query("INSERT INTO
                                        gasto_maestro (
                                        descGasto,
                                        valorGasto,
                                        fechaPago,
                                        nroFactura,
                                        fechaRegistroGasto,
                                        idTipoGasto,
                                        idEstadoGasto,
                                        idSede,
                                        idProveedor,
                                        idUsuarioRegistra,
                                        descModificacion,
                                        idCategoriaGasto
                                        ) VALUES(
                                        '".$nameGasto."',
                                        ".$valueGasto.",
                                        '".$fechaPago."',
                                        '".$nroFactura."',
                                        NOW(),
                                        ".$typeGasto.",
                                        ".$stateGasto.",
                                        ".$this->session->userdata('sede').",
                                        ".$idProveedor.",
                                        ".$this->session->userdata('userid').",
                                        0,
                                        ".$idCatGasto."
                                        )
                                        ");
        
        } else if ($typeAction == 2){
            $query = $this->db->query("UPDATE
                                        gasto_maestro 
                                        SET
                                        descGasto = '".$nameGasto."',
                                        valorGasto = ".$valueGasto.",
                                        fechaPago = '".$fechaPago."',
                                        nroFactura = '".$nroFactura."',
                                        idTipoGasto = ".$typeGasto.",
                                        idEstadoGasto = ".$stateGasto.",
                                        idProveedor = ".$idProveedor.",
                                        descModificacion = concat(descModificacion,' | ','".$this->session->userdata('userid')."->".date('Y-m-d h:i:s')."'),
                                        idCategoriaGasto = ".$idCatGasto."
                                        WHERE
                                        idGasto = ".$idGasto."
                                        ");
            
        }
        
        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            $this->cache->memcached->delete('mDetailGastosPend');
            $this->cache->memcached->delete('mGastosPend');
            return true;

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: anula_recibo
     * Descripcion: Anula un recibo registrando observacion y usuario anula
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function anula_recibo($recibo,$motivoAnula) {
        
        $this->db->trans_start();
        
        $query = $this->db->query("UPDATE
                                    venta_maestro 
                                    SET
                                    motivoAnula = '".$motivoAnula."',
                                    usuarioAnula = ".$this->session->userdata('userid').",
                                    idEstadoRecibo = 3,
                                    fechaAnula = NOW()
                                    WHERE
                                    nroRecibo = ".$recibo."
                                    ");
            
        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            return true;

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: get_gasto
     * Descripcion: Obtiene los datos del registro de un gasto
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function get_gasto($idGasto) {
        
        /*Recupera los usuarios creados*/
        $query = $this->db->query("SELECT
                                a.idUsuario,
                                a.nombre,
                                a.apellido,
                                a.numCelular,
                                a.direccion,
                                a.email,
                                a.activo,
                                a.idTipoUsuario,
                                t.descTipoUsuario,
                                f.dia,
                                f.mes,
                                u.idRol,
                                r.descRol,
                                a.idSede,
                                s.nombreSede
                                FROM app_usuarios a
                                JOIN tipo_usuario t ON t.idTipoUsuario = a.idTipoUsuario
                                JOIN fecha_cumple_usuario f ON f.idUsuario = a.idUsuario
                                LEFT JOIN usuario_acceso u ON u.idUsuario = a.idUsuario
                                LEFT JOIN roles r ON r.idRol = u.idRol
                                LEFT JOIN sede s ON s.idSede = a.idSede
                                WHERE a.idUsuario = ".$user."");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: top_services
     * Descripcion: Recupera los primeros 5 servicios con mayor realizacion en
     * la sede.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function top_services($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                v.idServicio,
                                g.descGrupoServicio,
                                s.descServicio,
                                count(1) AS cantidad
                                FROM venta_detalle v
                                JOIN servicios s ON s.idServicio = v.idServicio
                                JOIN grupo_servicio g ON g.idGrupoServicio = s.idGrupoServicio
                                JOIN venta_maestro m ON m.idVenta = v.idVenta
                                WHERE v.idServicio > 0
                                AND m.idEstadoRecibo IN (5,2)
                                AND m.fechaLiquida BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                AND m.idSede = ".$this->session->userdata('sede')."
                                GROUP BY v.idServicio
                                ORDER BY 4 ASC
                                LIMIT 5");

        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: tendencia_diasemana
     * Descripcion: Recupera la tendencia de pagos/visitas por dia de la semana
     * en la sede.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 30/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function tendencia_diasemana($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                DAYOFWEEK(date(v.fechaLiquida)) as diasemana,
                                COUNT(distinct(idUsuarioCliente)) as cantidad
                                FROM
                                venta_maestro v
                                WHERE
                                v.fechaLiquida BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                AND idEstadoRecibo = 5
                                AND idSede = ".$this->session->userdata('sede')."
                                GROUP BY DAYOFWEEK(date(fechaLiquida))
                                ORDER BY 1 DESC");

        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: tendencia_venta_cliente
     * Descripcion: Recupera la tendencia general de ventas a los clientes en la sede.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 01/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function tendencia_venta_cliente($fechaIni,$fechaFin) {
        
        $query = $this->db->query("SELECT
                                    vd.idVenta,
                                    COUNT(vd.idServicio) as cantServicios,
                                    (SELECT
                                    COUNT(idProducto)
                                    FROM
                                    venta_detalle
                                    WHERE productoInterno = 'N'
                                    AND idVenta = vd.idVenta) as cantProductos,
                                    (SELECT
                                    COUNT(cargoEspecial)
                                    FROM
                                    venta_detalle
                                    WHERE cargoEspecial IS NOT NULL
                                    AND idVenta = vd.idVenta) as cantAdicional
                                    FROM
                                    venta_detalle vd
                                    JOIN venta_maestro vm ON vm.idVenta = vd.idVenta
                                    WHERE
                                    vm.idEstadoRecibo = 5
                                    AND vm.idSede = ".$this->session->userdata('sede')."
                                    AND vm.fechaLiquida BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                    GROUP BY vd.idVenta");

        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            $data = $query->result_array();
            
            $cant = 0;
            $est1 = 0;
            $est2 = 0;
            $est3 = 0;
            $est4 = 0;
            foreach ($data as $rowData){
                
                /*ventas con mas de un servicio*/
                if ($rowData['cantServicios'] > 1){
                    $est1 = $est1 + 1;
                }
                
                /*ventas con mas de dos servicio*/
                if ($rowData['cantServicios'] > 2){
                    $est2 = $est2 + 1;
                }
                
                /*ventas con servicio y producto*/
                if ($rowData['cantServicios'] > 0 && $rowData['cantProductos'] > 0){
                    $est3 = $est3 + 1;
                }
                
                /*Servicios con cargo adicional*/
                if ($rowData['cantServicios'] > 0 && $rowData['cantAdicional'] > 0){
                    $est4 = $est4 + 1;
                }
                
                $cant++;
                
            }
            
            $result['est1'] = $est1;
            $result['est2'] = $est2;
            $result['est3'] = $est3;
            $result['est4'] = $est4;
            $result['cant'] = $cant;
            
            return $result;
            
        }
        
    }
    
}
