<?php
/**************************************************************************
* Nombre de la Clase: MSale
* Descripcion: Es el Modelo para las interacciones en BD del modulo Ventas
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 26/03/2017
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MSale extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: create_sale
     * Descripcion: Crea un registro inicial de venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function create_sale($idusuario) {
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                    venta_maestro (
                                    fechaLiquida,
                                    nroRecibo,
                                    idEstadoRecibo,
                                    idUsuarioLiquida,
                                    porcenDescuento,
                                    idSede
                                    ) VALUES (
                                    NOW(),
                                    0,
                                    4,
                                    ".$idusuario.",
                                    0,
                                    ".$this->session->userdata('sede')."
                                    )");
        
        $idSale = $this->db->insert_id();
        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            /*Registra el id de venta como variable de sesion*/
            $datos_session = array(
                'idSale' => $idSale
            );
            
            $this->session->set_userdata($datos_session);
            return true;

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_users_sale
     * Descripcion: Obtiene los usuarios 'Clientes' activo para registrar
     * la venta.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_users_sale() {
        
        $dataCache = $this->cache->memcached->get('mListusersale');
        
        if ($dataCache){
            
            $this->cache->memcached->save('memcached10', 'cache', 30);
            return $dataCache;
            
        } else {
            
            /*Recupera los usuarios creados*/
            $query = $this->db->query("SELECT
                                    a.idUsuario,
                                    concat(a.nombre,' ',a.apellido) as nombre_usuario,
                                    a.numCelular
                                    FROM
                                    app_usuarios a
                                    WHERE
                                    a.idTipoUsuario = 2
                                    AND a.activo = 'S'
                                    ORDER BY 2");

            $this->cache->memcached->save('mListusersale', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached10', 'real', 30);
            
            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: client_in_list
     * Descripcion: Obtiene los datos del Cliente agregado en la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 05/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function client_in_list() {
        
        if ($this->session->userdata('sclient') != NULL){
            
            $dataCache = $this->cache->memcached->get('mClientInList');
            $dataFilter = $this->cache->memcached->get('mIdclient');
        
            if (($dataCache) && ($dataFilter == $this->session->userdata('sclient'))){

                $this->cache->memcached->save('memcached11', 'cache', 30);
                return $dataCache;

            } else {
            
                /*Recupera los usuarios creados*/
                $query = $this->db->query("SELECT
                                        a.idUsuario,
                                        concat(a.nombre,' ',a.apellido) as nombre_usuario,
                                        a.numCelular,
                                        a.direccion,
                                        a.email
                                        FROM
                                        app_usuarios a
                                        WHERE
                                        a.idUsuario = ".$this->session->userdata('sclient')."");

                $this->cache->memcached->save('mClientInList', $query->row(), 28800); /*8 horas en Memoria*/
                $this->cache->memcached->save('mIdclient', $this->session->userdata('sclient'), 28800);
                $this->cache->memcached->save('memcached11', 'real', 30);
                
                if ($query->num_rows() == 0) {

                    return false;

                } else {

                    return $query->row();

                }
            
            }
            
        } else {
            
            return FALSE;
            
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_service_sale
     * Descripcion: Obtiene los servicios activos para registrar
     * la venta.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_service_sale() {
        
        $dataCache = $this->cache->memcached->get('mListServiceSale');

        if ($dataCache){

            $this->cache->memcached->save('memcached12', 'cache', 30);
            return $dataCache;

        } else {
        
            /*Recupera los servicios creados*/
            $query = $this->db->query("SELECT
                                    s.idServicio,
                                    g.descGrupoServicio,
                                    s.descServicio,
                                    s.valorServicio,
                                    (s.valorServicio * s.distribucion) as valorEmpleado
                                    FROM
                                    servicios s
                                    JOIN grupo_servicio g ON g.idGrupoServicio = s.idGrupoServicio
                                    WHERE
                                    s.activo = 'S'
                                    ORDER BY 2,3");
            
            $this->cache->memcached->save('mListServiceSale', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached12', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: service_in_list
     * Descripcion: Obtiene los servicios en lista para liquidar
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 30/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function service_in_list() {
                
        /*Recupera los servicios de la venta*/
        $query = $this->db->query("SELECT
                                v.idRegistroDetalle,
                                v.idVenta,
                                v.idServicio,
                                s.descServicio,
                                v.valor,
                                v.idEmpleado,
                                v.cantidad
                                FROM
                                venta_detalle v
                                JOIN servicios s ON s.idServicio = v.idServicio
                                WHERE
                                v.idVenta = ".$this->session->userdata('idSale')."");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: product_in_list
     * Descripcion: Obtiene los Productos en lista para liquidar
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 30/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function product_in_list() {
                
        /*Recupera los Productos de la venta*/
        $query = $this->db->query("SELECT
                                v.idRegistroDetalle,
                                v.idVenta,
                                v.idProducto,
                                p.descProducto,
                                v.valor,
                                v.cantidad,
                                v.idEmpleado
                                FROM
                                venta_detalle v
                                JOIN productos p ON p.idProducto = v.idProducto
                                WHERE
                                v.idVenta = ".$this->session->userdata('idSale')."
                                AND productoInterno = 'N'");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: adicional_in_list
     * Descripcion: Obtiene los Cargos adicionales en lista para liquidar
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 30/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function adicional_in_list() {
        
        /*Recupera los cargos adicionales de la venta*/
        $query = $this->db->query("SELECT
                                v.idRegistroDetalle,
                                v.cargoEspecial,
                                v.valor
                                FROM venta_detalle v
                                WHERE
                                v.idVenta = ".$this->session->userdata('idSale')."
                                and v.cargoEspecial IS NOT NULL");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: liquida_sale
     * Descripcion: Liquida la venta (obtiene total)
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 01/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function liquida_sale() {
        
        /*Liquida servicios de la venta*/
        $service = $this->db->query("SELECT
                                    sum(v.valor) as totalServicios,
                                    m.porcenDescuento,
                                    (sum(v.valor)*m.porcenDescuento) as totalDescuento
                                    FROM
                                    venta_detalle v
                                    JOIN servicios s ON s.idServicio = v.idServicio
                                    JOIN venta_maestro m ON m.idVenta = v.idVenta
                                    WHERE
                                    v.idVenta = ".$this->session->userdata('idSale')."");
        
        $values[0] = $service->row();
        
        /*Liquida Productos de la venta*/
        $product = $this->db->query("SELECT
                                    sum(v.valor) as totalProductos
                                    FROM
                                    venta_detalle v
                                    JOIN productos p ON p.idProducto = v.idProducto
                                    WHERE
                                    v.idVenta = ".$this->session->userdata('idSale')."
                                    AND productoInterno = 'N'");
        
        $values[1] = $product->row();
        
        /*Liquida Adicionales de la venta*/
        $adicional = $this->db->query("SELECT
                                    sum(v.valor) as totalAdicional
                                    FROM venta_detalle v
                                    WHERE
                                    v.idVenta = ".$this->session->userdata('idSale')."
                                    and v.cargoEspecial IS NOT NULL");
        
        $values[2] = $adicional->row();
        
        return $values;

    }
    
    /**************************************************************************
     * Nombre del Metodo: consumo_in_list
     * Descripcion: Obtiene los Productos de consumo interno de la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 31/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function consumo_in_list() {
        
        /*Recupera los Productos de la venta*/
        $query = $this->db->query("SELECT
                                v.idRegistroDetalle,
                                v.idVenta,
                                v.idProducto,
                                p.descProducto,
                                v.valor,
                                v.cantidad,
                                v.idEmpleado
                                FROM
                                venta_detalle v
                                JOIN productos p ON p.idProducto = v.idProducto
                                WHERE
                                v.idVenta = ".$this->session->userdata('idSale')."
                                AND productoInterno = 'S'");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_product_sale
     * Descripcion: Obtiene los productos activos para registrar en
     * la venta.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_product_sale() {
        
        $dataCache = $this->cache->memcached->get('mListProductSale');

        if ($dataCache){

            $this->cache->memcached->save('memcached16', 'cache', 30);
            return $dataCache;

        } else {
        
            /*Recupera los usuarios creados*/
            $query = $this->db->query("SELECT
                                    p.idProducto,
                                    p.descProducto,
                                    p.valorProducto,
                                    p.distribucionProducto as valorEmpleado
                                    FROM productos p
                                    WHERE
                                    activo = 'S'
                                    AND idTipoProducto = 2
                                    ORDER BY 2");
            
            $this->cache->memcached->save('mListProductSale', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached16', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_product_int
     * Descripcion: Obtiene lista de Productos de consumo interno
     * la venta.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_product_int() {
        
        /*Recupera los usuarios creados*/
        $query = $this->db->query("SELECT
                                p.idProducto,
                                p.descProducto
                                FROM productos p
                                WHERE
                                activo = 'S'
                                AND idTipoProducto IN (1,2)
                                ORDER BY 2");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_empleado_sale
     * Descripcion: Obtiene los empleados activos para registrar
     * la venta.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_empleado_sale() {
        
        /*Recupera los empleados creados activos*/
        $query = $this->db->query("SELECT
                                a.idUsuario,
                                concat(a.nombre,' ',a.apellido) as nombre_usuario
                                FROM
                                app_usuarios a
                                WHERE
                                a.activo = 'S'
                                AND idTipoUsuario = 1
                                AND idSede = ".$this->session->userdata('sede')."
                                ORDER BY 2");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_forma_pago
     * Descripcion: Obtiene las formas de pago
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 03/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_forma_pago() {
        
        $dataCache = $this->cache->memcached->get('mListFormaPago');

        if ($dataCache){

            $this->cache->memcached->save('memcached17', 'cache', 30);
            return $dataCache;

        } else {
        
            /*Recupera los servicios creados*/
            $query = $this->db->query("SELECT
                                    f.idFormaPago,
                                    f.descFormaPago,
                                    f.distribucionPago
                                    FROM
                                    forma_de_pago f
                                    WHERE activo = 'S'
                                    ORDER BY 1 ASC");

            $this->cache->memcached->save('mListFormaPago', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached17', 'real', 30);
            
            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: delete_detail_sale
     * Descripcion: Elimina registro del detalle de la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function delete_detail_sale($idRegistro) {
        
        $this->db->trans_start();
        $query = $this->db->query("SELECT
                                m.idEstadoRecibo
                                FROM
                                venta_detalle v
                                JOIN venta_maestro m ON m.idVenta = v.idVenta
                                WHERE idRegistroDetalle = ".$idRegistro."");
        $result = $query->row();
        
        if ($result->idEstadoRecibo != 5){
            
            $this->db->query("DELETE
                            FROM venta_detalle 
                            WHERE idRegistroDetalle = ".$idRegistro."
                            and idVenta = ".$this->session->userdata('idSale')."");
            
            $this->db->trans_complete();
            $this->db->trans_off();
            
            return TRUE;
            
        } else {
            
            $this->db->trans_complete();
            $this->db->trans_off();
            
            return FALSE;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: cancel_data_sale
     * Descripcion: Cancela la venta y libera el recibo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function cancel_data_sale() {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("SELECT
                                m.nroRecibo
                                FROM
                                venta_maestro m
                                WHERE m.idVenta = ".$this->session->userdata('idSale')."");
        $result = $query->row();
        
        if ($result->nroRecibo != 0){
            
            $this->db->query("DELETE
                            FROM venta_detalle 
                            WHERE idVenta = ".$this->session->userdata('idSale')."");
            
            $this->db->query("DELETE
                            FROM venta_maestro
                            WHERE idVenta = ".$this->session->userdata('idSale')."");
            
            $this->db->query("UPDATE
                            rango_recibos
                            SET idEstadoRecibo = 1
                            WHERE nroRecibo = ".$result->nroRecibo."");
            
            $this->db->trans_complete();
            $this->db->trans_off();
            
            if ($this->db->trans_status() === FALSE){
                
                return FALSE;
                
            } else {
                
                $this->cache->memcached->delete('mClientInList');
                return TRUE;
                
            }
            
        } else {
            
            $this->db->query("DELETE
                            FROM venta_detalle 
                            WHERE idVenta = ".$this->session->userdata('idSale')."");
            
            $this->db->query("DELETE
                            FROM venta_maestro
                            WHERE idVenta = ".$this->session->userdata('idSale')."");
            
            $this->db->trans_complete();
            $this->db->trans_off();
            
            if ($this->db->trans_status() === FALSE){
                
                return FALSE;
                
            } else {
                
                $this->cache->memcached->delete('mClientInList');
                return TRUE;
                
            }
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: add_user
     * Descripcion: Registra cliente a la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function add_user($idusuario,$idventa) {
        
        $this->db->trans_start();
        $query = $this->db->query("UPDATE
                                venta_maestro SET
                                idUsuarioCliente = ".$idusuario."
                                WHERE
                                idVenta = ".$idventa."");

        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            /*Setea el usuario como variable de sesion*/
            $datos_session = array(
                'sclient' => $idusuario
            );
            
            $this->session->set_userdata($datos_session);
            return true;

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: add_service
     * Descripcion: Registra servicio a la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function add_service($idService,$valueService,$valueEmpleado,$idempleado,$cantidad) {
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                    venta_detalle (
                                    idVenta,
                                    idServicio,
                                    valor,
                                    idEmpleado,
                                    valorEmpleado,
                                    cantidad
                                    ) VALUES(
                                    ".$this->session->userdata('idSale').",
                                    ".$idService.",
                                    ".$valueService.",
                                    ".$idempleado.",
                                    ".$valueEmpleado.",
                                    ".$cantidad."
                                    )
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
     * Nombre del Metodo: add_service
     * Descripcion: Registra servicio a la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function add_product($idProducto,$valueProducto,$valueEmpleado,$idempleado,$cantidad) {
        
        $this->db->trans_start();
        $this->db->query("INSERT INTO
                        venta_detalle (
                        idVenta,
                        idProducto,
                        valor,
                        idEmpleado,
                        valorEmpleado,
                        cantidad,
                        productoInterno
                        ) VALUES(
                        ".$this->session->userdata('idSale').",
                        ".$idProducto.",
                        ".$valueProducto.",
                        ".$idempleado.",
                        ".$valueEmpleado.",
                        ".$cantidad.",
                        'N')");
        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
                        
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: add_product_int
     * Descripcion: Registra producto de consumo interno
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function add_product_int($idProducto,$cantidadcons,$idempleado) {
        
        $this->db->trans_start();
        $this->db->query("INSERT INTO
                        venta_detalle (
                        idVenta,
                        idProducto,
                        valor,
                        idEmpleado,
                        valorEmpleado,
                        cantidad,
                        productoInterno
                        ) VALUES(
                        ".$this->session->userdata('idSale').",
                        ".$idProducto.",
                        0,
                        ".$idempleado.",
                        0,
                        ".$cantidadcons.",
                        'S')");
        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: update_sale_master
     * Descripcion: Actualiza la venta maestro
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 02/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function update_salemaster($total,$liquidado,$nrorecibo) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $this->db->query("UPDATE
                        rango_recibos SET
                        idEstadoRecibo = 6
                        WHERE
                        nroRecibo = ".$nrorecibo."
                        ");
        
        $this->db->query("UPDATE
                        venta_maestro SET
                        valorTotalVenta = ".$total.",
                        valorLiquida = ".$liquidado.",
                        idEstadoRecibo = 2,
                        nroRecibo = '".$nrorecibo."',
                        fechaLiquida = NOW()
                        WHERE
                        idVenta = ".$this->session->userdata('idSale')."
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
     * Nombre del Metodo: pay_register_sale
     * Descripcion: Registra pago de la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 02/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function pay_register_sale($formaPago,$porcenFormaPago) {
        
        $this->db->trans_start();        
        $this->db->query("UPDATE
                        venta_maestro SET
                        idEstadoRecibo = 5,
                        idFormaPago = ".$formaPago.",
                        porcenFormaPago = ".$porcenFormaPago."
                        WHERE
                        idVenta = ".$this->session->userdata('idSale')."
                        ");
        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            /*Recupera los productos en la lista de venta*/
            $query1 = $this->db->query("SELECT
                                    v.idProducto,
                                    v.cantidad
                                    FROM
                                    venta_detalle v
                                    JOIN productos p ON p.idProducto = v.idProducto
                                    WHERE
                                    v.idVenta = ".$this->session->userdata('idSale')."");
            
            /*Recupera los productos de los servicios en la lista de venta*/
            $query2 = $this->db->query("SELECT
                                        ps.idServicio,
                                        ps.idProducto,
                                        p.descProducto,
                                        (SELECT
                                        sum(v.cantidad)
                                        FROM venta_detalle v
                                        WHERE v.idVenta = ".$this->session->userdata('idSale')."
                                        AND v.idServicio = ps.idServicio) as cantidad
                                        FROM productos_servicio ps
                                        JOIN productos p ON p.idProducto = ps.idProducto
                                        WHERE ps.idServicio IN (
                                            SELECT
                                            idServicio
                                            FROM venta_detalle v
                                            WHERE idVenta = ".$this->session->userdata('idSale')."
                                            AND idServicio IS NOT NULL
                                        )");
            
            $this->cache->memcached->delete('mClientInList');
            
            if ($query1->num_rows() == 0 && $query2->num_rows() == 0) {
                
                return true;
                
            } else {
                
                /*Query1 - Productos en la venta*/
                $productsSale = $query1->result_array(); /*devuelve registros de productos en la venta*/
                if ($productsSale != FALSE){
                    foreach ($productsSale as $productCantidad){

                        /*Actualiza el stock de cada producto*/
                        $this->stock_min($productCantidad['idProducto'], $productCantidad['cantidad']);
                        
                    }
                }
                
                /*Query2 - Productos en el servicio*/
                $productsService = $query2->result_array(); /*devuelve registros de productos del servicio*/
                if ($productsService != FALSE){
                    foreach ($productsService as $productCantidadServ){

                        /*Actualiza el stock de cada producto*/
                        $this->stock_min($productCantidadServ['idProducto'], $productCantidadServ['cantidad']);

                    }
                }
                
                $this->cache->memcached->delete('mDetailResol');
                return true;
                
            }
             
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: genera_recibo
     * Descripcion: genera nro. recibo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 02/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function genera_recibo() {
        
        $queryRecibo = $this->db->query("SELECT
                                        nroRecibo 
                                        FROM 
                                        venta_maestro 
                                        WHERE 
                                        idVenta = ".$this->session->userdata('idSale')."");
        
        $salemaestro = $queryRecibo->row();
                
        if ($salemaestro->nroRecibo == 0){ /*no tiene recibo asignado*/
            
            /*obtiene un recibo disponible del rango creado*/
            $query = $this->db->query("SELECT
                                    nroRecibo
                                    FROM
                                    rango_recibos
                                    WHERE
                                    idEstadoRecibo = 1
                                    ORDER BY nroRecibo ASC
                                    LIMIT 1");

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->row();

            }
            
        } else {
            
            return $queryRecibo->row();
            
        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: add_porcentaje_desc
     * Descripcion: Registra descuento a la venta
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 30/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function add_porcentaje_desc($porcentaje) {
        
        $this->db->trans_start();
        $this->db->query("UPDATE
                        venta_maestro SET
                        porcenDescuento = ".$porcentaje."
                        WHERE
                        idVenta = ".$this->session->userdata('idSale')."
                        ");
        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            /*Setea el usuario como variable de sesion*/
            $datos_session = array(
                'sdescuento' => ($porcentaje*100)
            );
            
            $this->session->set_userdata($datos_session);
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: add_product_int
     * Descripcion: Registra producto de consumo interno
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function add_consumo_adc($motivo,$valorCargo,$idempleado,$valorEmpleado) {
        
        $this->db->trans_start();
        $this->db->query("INSERT INTO
                        venta_detalle (
                        idVenta,
                        cargoEspecial,
                        valor,
                        idEmpleado,
                        valorEmpleado
                        ) VALUES(
                        ".$this->session->userdata('idSale').",
                        '".$motivo."',
                        ".$valorCargo.",
                        ".$idempleado.",
                        ".$valorEmpleado.")");
        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: stock_min
     * Descripcion: Actualiza el stock de un producto segun la cantidad vendida
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function stock_min($idProducto,$cantidad) {
                
        $this->db->trans_start();
        $query1 = $this->db->query("SELECT
                                    s.disponibles,
                                    p.uniDosis
                                    FROM
                                    stock_productos s
                                    JOIN productos p ON p.idProducto = s.idProducto
                                    WHERE
                                    s.idProducto = ".$idProducto."");
        $row = $query1->row_array();
        
        $query2 = $this->db->query("UPDATE
                                stock_productos 
                                SET
                                disponibles = ".($row['disponibles']-($cantidad*$row['uniDosis']))."
                                WHERE
                                idProducto = ".$idProducto."");

        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {
            
            $this->cache->memcached->delete('mListproducts');
            return true;

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: sale_clean
     * Descripcion: Limpia todos los registros de venta que hayan quedado en
     * proceso liquidacion. Este es ejecutado por Proceso Automatico.
     * Ejecucion: CRONTAB (Todos los dias a las 02:00AM)
     * php -f /datos/www/html/[APP]/index.php /CSale/saleclean
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function sale_clean() {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        
        $this->db->query("DELETE FROM
                        venta_detalle
                        WHERE
                        idVenta IN (SELECT idVenta FROM venta_maestro WHERE idEstadoRecibo = 4)");
        
        $this->db->query("DELETE FROM venta_maestro WHERE idEstadoRecibo = 4");

        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return FALSE;

        } else {
            
            return TRUE;

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: consecutivo_turno_sale
     * Descripcion: Obtiene consecutivo del turno en la venta
     *  $action:
     *      1 - Obtener numero de Turno
     *      2 - Reiniciar Consecutivo Turno
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 19/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function consecutivo_turno_sale($action) {
        
        if ($action == 1) { /*obtiene turno*/
        
            $this->db->trans_start();
            $query = $this->db->query("SELECT
                                        s.seqTurno
                                        FROM sede s
                                        WHERE s.idSede = ".$this->session->userdata('sede')."");
            $result = $query->row();

            if ($result->seqTurno != NULL){

                if ($result->seqTurno == 99){

                    $this->db->query("UPDATE
                                    sede
                                    SET seqTurno = 1
                                    WHERE idSede = ".$this->session->userdata('sede')."");

                    $this->db->trans_complete();
                    $this->db->trans_off();

                } else {

                    $this->db->query("UPDATE
                                    sede
                                    SET seqTurno = ".$result->seqTurno."+1
                                    WHERE idSede = ".$this->session->userdata('sede')."");

                    $this->db->trans_complete();
                    $this->db->trans_off();

                }

                return $result->seqTurno;

            } else {

                $this->db->trans_complete();
                $this->db->trans_off();

                return FALSE;

            }
            
        } else {
            
            if ($action == 2){ /*reinicia*/
                
                $this->db->trans_start();
                $this->db->query("UPDATE
                                sede
                                SET seqTurno = 1
                                WHERE idSede = ".$this->session->userdata('sede')."");

                $this->db->trans_complete();
                $this->db->trans_off();
                
                return 200;
                
            }
            
        }
        
    }
    
}
