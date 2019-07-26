<?php
/**************************************************************************
* Nombre de la Clase: MPrincipal
* Descripcion: Es el Modelo principal de consulta a BD
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 23/03/2017
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MPrincipal extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: login_verify
     * Descripcion: Recupera y valida la informacion de inicio de sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function login_verify($username,$password) {
                
        /*Encriptacion de la Clave de Acceso*/
        $pass = sha1($password);
        
        /*Recupera datos del usuario - SOLO EMPLEADO/CLIENTE ROL SUPERADMIN/CLIENTE/EMPLEADO*/
        $query = $this->db->query("SELECT
                                c.idUsuario,
                                c.nombre as nombre_usuario,
                                c.email,
                                c.activo,
                                u.idRol,
                                r.descRol,
                                c.idSede,
                                s.nombreSede,
                                s.direccionSede,
                                s.telefonoSede,
                                s.printer
                                FROM
                                app_usuarios c
                                JOIN usuario_acceso u ON u.idUsuario = c.idUsuario
                                JOIN roles r ON r.idRol = u.idRol
                                JOIN sede s ON s.idSede = c.idSede
                                WHERE
                                c.idUsuario = '".$username."'
                                AND u.claveAcceso = '".$pass."'
                                AND c.idTipoUsuario IN (1,2)
                                AND u.idRol IN (1,2,3)");
        
        $cant = $query->num_rows();
        
        if($cant>0){
            
            return $query->row();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: admin_pass_verify
     * Descripcion: valida el password del administrador para permitir acciones
     * en el sistema.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 27/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function admin_pass_verify($password,$item) {
                
        /*Encriptacion de la Clave de Acceso*/
        $pass = sha1($password);
        
        /*Recupera datos del usuario - SOLO EMPLEADO/CLIENTE ROL SUPERADMIN/CLIENTE/EMPLEADO*/
        $query = $this->db->query("SELECT
                                c.idUsuario,
                                c.activo,
                                u.idRol
                                FROM
                                app_usuarios c
                                JOIN usuario_acceso u ON u.idUsuario = c.idUsuario
                                WHERE u.claveAcceso = '".$pass."'
                                AND u.idRol = 1
                                AND c.activo = 'S'");
        
        $cant = $query->num_rows();
        $data = $query->row();
        
        if($cant>0){
            
            log_message("ERROR", "-------AUTORIZA ELIMINACION ITEM [EXITOSO}--------");
            log_message("ERROR", "idEmpleado Solicita: ".$this->session->userdata('userid'));
            log_message("ERROR", "idUsuario Autoriza: ".$data->idUsuario);
            log_message("ERROR", "Activo: ".$data->activo);
            log_message("ERROR", "ROL: ".$data->idRol);
            log_message("ERROR", "idRegistroDetalle: ".$item);
            log_message("ERROR", "Sede: ".$this->session->userdata('sede'));
            log_message("ERROR", "--------------------------------------------------");
            
            return TRUE;
            
        } else {
            
            log_message("ERROR", "-------AUTORIZA ELIMINACION ITEM [FALLIDO}--------");
            log_message("ERROR", "idEmpleado Solicita: ".$this->session->userdata('userid'));
            log_message("ERROR", "idUsuario Autoriza: ".$data->idUsuario);
            log_message("ERROR", "Activo: ".$data->activo);
            log_message("ERROR", "ROL: ".$data->idRol);
            log_message("ERROR", "idRegistroDetalle: ".$item);
            log_message("ERROR", "Sede: ".$this->session->userdata('sede'));
            log_message("ERROR", "--------------------------------------------------");
            
            return FALSE;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: change_pass
     * Descripcion: Actualiza la constraseña de un usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function change_pass($idusuario,$newpass) {
                    
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        
        $query1 = $this->db->query("UPDATE
                                    usuario_acceso SET
                                    claveAcceso = '".sha1($newpass)."'
                                    WHERE
                                    idUsuario = ".$idusuario."");
        
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: rol_recurso
     * Descripcion: Recupera los recursos asignados al rol del usuario logueado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function rol_recurso($idRol) {
        
        /*Recupera los recursos del rol asignado al usuario logueado*/
        $query = $this->db->query("SELECT
                                ro.idRecurso,
                                re.nombreRecurso
                                FROM roles_recursos ro
                                JOIN recursos re ON re.idRecurso = ro.idRecurso
                                WHERE ro.idRol = ".$idRol."");
        
        $cant = $query->num_rows();
        
        if($cant>0){
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: cantidad_servicios
     * Descripcion: obtiene la cantidad de servicios atendidos en un periodo de
     * tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function cantidad_servicios($fechaIni,$fechaFin) {
        
        /*Recupera los usuarios creados*/
        $query = $this->db->query("SELECT
                                count(v.idServicio) as cantidadServicios
                                FROM venta_detalle v
                                JOIN venta_maestro m ON m.idVenta = v.idVenta
                                WHERE
                                m.fechaLiquida BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                AND m.idSede = ".$this->session->userdata('sede')."
                                AND m.idEstadoRecibo = 5");
        
        return $query->row();
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: cantidad_productos_venta
     * Descripcion: Obtiene los productos vendidos en un determinado periodo
     * de tiempo.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function cantidad_productos_venta($fechaIni,$fechaFin) {
        
        /*Recupera la cantidad*/
        $query = $this->db->query("SELECT
                                sum(v.cantidad) as cantidadProductos
                                FROM venta_detalle v
                                JOIN venta_maestro m ON m.idVenta = v.idVenta
                                WHERE
                                m.fechaLiquida BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                AND v.productoInterno = 'N'
                                AND m.idSede = ".$this->session->userdata('sede')."
                                AND m.idEstadoRecibo = 5");
        
        return $query->row();
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: cantidad_recibos_estado
     * Descripcion: obtiene la cantidad de recibos en determinado estado de
     * un periodo de tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function cantidad_recibos_estado($fechaIni,$fechaFin,$estado) {
        
        /*Recupera la cantidad*/
        $query = $this->db->query("SELECT
                                count(1) as cantidad,
                                sum(m.valorLiquida) as valor_pagado
                                FROM venta_maestro m
                                WHERE
                                /*m.fechaLiquida BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'*/
                                m.fechaPideCuenta BETWEEN '".$fechaIni." 00:00:00' AND '".$fechaFin." 23:59:59'
                                AND m.idSede = ".$this->session->userdata('sede')."
                                AND m.idEstadoRecibo = ".$estado."");
        
        return $query->row();
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: cantidad_recibos_pendientes
     * Descripcion: obtiene la cantidad de recibos pendientes de pago
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 12/05/2017, Ultima modificacion: 
     **************************************************************************/
    public function cantidad_recibos_pendientes() {
        
        /*Recupera la cantidad*/
        $query = $this->db->query("SELECT
                                count(1) as cantidad,
                                sum(m.valorLiquida) as valor_pagado
                                FROM venta_maestro m
                                WHERE
                                m.idSede = ".$this->session->userdata('sede')."
                                AND m.idEstadoRecibo = 8");
        
        return $query->row();
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: cantidad_gastos_pendientes
     * Descripcion: obtiene la cantidad de gastos pendientes para la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function cantidad_gastos_pendientes() {
        
        $dataCache = $this->cache->memcached->get('mGastosPend');
        $dataFilter = $this->cache->memcached->get('mGastosPendSede');
        
        if (($dataCache) && ($dataFilter == $this->session->userdata('sede'))){
            
            $this->cache->memcached->save('memcached27', 'cache', 30);
            return $dataCache;
            
        } else {
        
            /*Recupera los gastos pendiente pago*/
            $query = $this->db->query("SELECT
                                    count(1) as cantidad,
                                    sum(valorGasto) as valorpendiente
                                    FROM gasto_maestro
                                    WHERE
                                    idEstadoGasto = 1
                                    and idSede = ".$this->session->userdata('sede')."");
            
            $this->cache->memcached->save('mGastosPend', $query->row(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('mGastosPendSede', $this->session->userdata('sede'), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached27', 'real', 30);

            return $query->row();
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: gastos_pendiente_detalle
     * Descripcion: obtiene el detalle de gastos pendiente de pago
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function gastos_pendiente_detalle() {
        
        $dataCache = $this->cache->memcached->get('mDetailGastosPend');
        $dataFilter = $this->cache->memcached->get('mGastosPendSede');
        
        if (($dataCache) && ($dataFilter == $this->session->userdata('sede'))){
            
            $this->cache->memcached->save('memcached28', 'cache', 30);
            return $dataCache;
            
        } else {
        
            /*Recupera detalle gastos pendientes*/
            $query = $this->db->query("SELECT
                                    g.idGasto,
                                    g.descGasto,
                                    g.valorGasto,
                                    g.fechaPago,
                                    t.descTipoGasto,
                                    c.descCategoria
                                    FROM gasto_maestro g
                                    JOIN tipo_gasto t ON t.idTipoGasto = g.idTipoGasto
                                    JOIN categoria_gasto c ON c.idCategoriaGasto = g.idCategoriaGasto
                                    WHERE
                                    g.idEstadoGasto = 1
                                    and g.idSede = ".$this->session->userdata('sede')."");

            $this->cache->memcached->save('mDetailGastosPend', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached28', 'real', 30);
            
            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: consumo_productos_80
     * Descripcion: Obtiene los productos que han consumido mas del 80%
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/02/2018, Ultima modificacion:
     **************************************************************************/
    public function consumo_productos_80() {
        
        /*Recupera los productos con mas del 80% de consumo (ROJO)*/
        $query = $this->db->query("SELECT
                                p.idProducto,
                                p.descProducto,
                                p.uniDosis,
                                t.descTipoProducto,
                                s.unidades,
                                s.disponibles,
                                (1-(s.disponibles/s.unidades))*100 as consumo
                                FROM productos p
                                JOIN tipo_producto t ON t.idTipoProducto = p.idTipoProducto
                                JOIN stock_productos s ON s.idProducto = p.idProducto
                                WHERE
                                ((s.disponibles/s.unidades)*100) < 20
                                AND p.idSede = ".$this->session->userdata('sede')."
                                ORDER BY 7 DESC");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: consumo_productos_60
     * Descripcion: Obtiene los productos que han consumido mas del 60% y menos del 80%
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/02/2018, Ultima modificacion:
     **************************************************************************/
    public function consumo_productos_60() {
        
        /*Recupera los productos con mas del 60% y menos del 80% de consumo (AMARILLO)*/
        $query = $this->db->query("SELECT
                                p.idProducto,
                                p.descProducto,
                                p.uniDosis,
                                t.descTipoProducto,
                                s.unidades,
                                s.disponibles,
                                (1-(s.disponibles/s.unidades))*100 as consumo
                                FROM productos p
                                JOIN tipo_producto t ON t.idTipoProducto = p.idTipoProducto
                                JOIN stock_productos s ON s.idProducto = p.idProducto
                                WHERE
                                ((s.disponibles/s.unidades)*100) <= 40
                                AND ((s.disponibles/s.unidades)*100) > 20
                                AND p.idSede = ".$this->session->userdata('sede')."
                                ORDER BY 7 DESC");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: recibos_pendiente_pago
     * Descripcion: Obtiene los recibos pendientes de pago (liquidados) de la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 05/05/2017
     **************************************************************************/
    public function recibos_pendiente_pago() {
        
        /*Recupera los recibos liquidados pendiente de pago*/
        $query = $this->db->query("SELECT
                                m.idVenta,
                                m.fechaLiquida,
                                m.nroRecibo,
                                m.valorTotalVenta as valorVenta,
                                m.valorLiquida,
                                m.idUsuarioCliente,
                                concat(a.nombre,' ',a.apellido) as nombreCliente,
                                a.numCelular,
                                m.porcenDescuento,
                                (m.valorLiquida*m.porcenServicio) as popina_servicio,
                                m.porcenServicio,
                                m.idEmpleadoAtiende
                                FROM venta_maestro m
                                JOIN app_usuarios a ON a.idUsuario = m.idUsuarioCliente
                                WHERE
                                m.idEstadoRecibo = 8
                                AND m.idSede = ".$this->session->userdata('sede')."");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: cantidad_clientes
     * Descripcion: Obtiene cantidad de clientes registrados en un periodo de tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function cantidad_clientes() {
        
        /*Recupera los usuarios creados*/
        $query = $this->db->query("SELECT
                                count(1) as cantidad
                                FROM app_usuarios a
                                WHERE
                                idTipoUsuario = 2");
        
        return $query->row();
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: rango_recibos
     * Descripcion: Obtiene la cantidad de recibos 1-disponible, 6-consumido
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 06/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function rango_recibos($estado) {
        
        /*Recupera los usuarios creados*/
        $query = $this->db->query("SELECT
                                count(1) as cantidad
                                FROM rango_recibos
                                WHERE idEstadoRecibo = ".$estado."");
        
        return $query->row();
        
    }

}
