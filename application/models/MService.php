<?php
/**************************************************************************
* Nombre de la Clase: MService
* Descripcion: Es el Modelo para las interacciones en BD del modulo servicios
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 23/03/2017
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MService extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_services
     * Descripcion: Obtiene todos los servicios registrados
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_services() {
        
        $dataCache = $this->cache->memcached->get('mListservices');
        $dataFilter = $this->cache->memcached->get('mIdsede');
        
        if (($dataCache) && ($dataFilter == $this->session->userdata('sede'))){
            
            $this->cache->memcached->save('memcached2', 'cache', 30);
            return $dataCache;
            
        } else {
        
            /*Recupera los servicios creados*/
            $query = $this->db->query("SELECT
                                    idServicio,
                                    descServicio,
                                    tiempoAtencion,
                                    valorServicio,
                                    distribucion,
                                    activo,
                                    agenda
                                    FROM
                                    servicios
                                    WHERE idSede = ".$this->session->userdata('sede')."
                                    ORDER BY 2");

            $this->cache->memcached->save('mListservices', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('mIdsede', $this->session->userdata('sede'), 28800);
            $this->cache->memcached->save('memcached2', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_group_service
     * Descripcion: Obtiene los grupos de servicios
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_group_service() {
        
        $dataCache = $this->cache->memcached->get('mListgroupservice');
        
        if ($dataCache){
            
            $this->cache->memcached->save('memcached', 'cache', 30);
            return $dataCache;
            
        } else {
        
            /*Recupera los grupos creados*/
            $query = $this->db->query("SELECT
                                    idGrupoServicio,descGrupoServicio
                                    FROM
                                    grupo_servicio
                                    WHERE
                                    activo = 'S'
                                    ORDER BY 2");

            $this->cache->memcached->save('mListgroupservice', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: create_service
     * Descripcion: Registra un servicio en BD
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function create_service($name,$time,$value,$distribution,$group,$calendar) {
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                    servicios (
                                    descServicio,
                                    tiempoAtencion,
                                    valorServicio,
                                    distribucion,
                                    activo,
                                    fechaCreacion,
                                    idGrupoServicio,
                                    agenda,
                                    idSede
                                    ) VALUES (
                                    '".$name."',
                                    ".$time.",
                                    ".$value.",
                                    ".$distribution.",
                                    'S',
                                    NOW(),
                                    ".$group.",
                                    '".$calendar."',
                                    ".$this->session->userdata('sede')."
                                    )");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            $this->cache->memcached->delete('mListServiceSale');
            $this->cache->memcached->delete('mListservices');
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: get_service
     * Descripcion: Obtiene los datos de un servicio existente
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function get_service($idservice) {
        
        /*Recupera la informacion del servicio*/
        $query = $this->db->query("SELECT
                                s.descServicio,
                                s.tiempoAtencion,
                                s.valorServicio,
                                s.distribucion,
                                s.activo,
                                g.descGrupoServicio,
                                s.agenda
                                FROM
                                servicios s
                                JOIN grupo_servicio g ON g.idGrupoServicio = s.idGrupoServicio
                                WHERE
                                s.idServicio = ".$idservice."");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: update_service
     * Descripcion: Actualiza un servicio en BD
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function update_service($idservice,$name,$time,$value,$distPorcent,$estado,$calendar) {
        
        $this->db->trans_start();
        $query = $this->db->query("UPDATE
                                servicios SET
                                descServicio = '".$name."',
                                tiempoAtencion = ".$time.",
                                valorServicio = ".$value.",
                                distribucion = ".$distPorcent.",
                                activo = '".$estado."',
                                fechaModifica = NOW(),
                                agenda = '".$calendar."'
                                WHERE
                                idServicio = ".$idservice."
                                ");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            $this->cache->memcached->delete('mListServiceSale');
            $this->cache->memcached->delete('mListservices');
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_service_empleados
     * Descripcion: Obtiene los empleados de la sede que atienden el servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_service_empleados($idService,$idsede) {
        
        /*Recupera los empleados que atienden el servicio*/
        $query = $this->db->query("SELECT
                                e.idEmpleadoServicio,
                                e.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado,
                                e.idServicio
                                FROM
                                empleados_servicio e
                                JOIN app_usuarios a ON a.idUsuario = e.idEmpleado
                                WHERE e.idServicio = ".$idService."
                                AND a.idTipoUsuario = 1
                                AND a.idSede = ".$idsede."
                                ORDER BY 2");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_service_productos
     * Descripcion: Obtiene los productos de la sede que atienden el servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 04/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_service_productos($idService,$idsede) {
        
        /*Recupera los productos asignados al servicio*/
        $query = $this->db->query("SELECT
                                p.idProducto,
                                pr.descProducto,
                                p.idServicio
                                FROM productos_servicio p
                                JOIN productos pr ON pr.idProducto = p.idProducto
                                WHERE p.idServicio = ".$idService."
                                AND pr.idTipoProducto IN (1,2)
                                AND pr.idSede = ".$idsede."
                                ORDER BY 2");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: datos_servicio
     * Descripcion: Obtiene los datos de un servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function datos_servicio($idService) {
        
        /*Recupera los datos de un servicio*/
        $query = $this->db->query("SELECT
                                s.idServicio,
                                s.descServicio,
                                s.activo,
                                s.agenda,
                                s.tiempoAtencion
                                FROM servicios s
                                WHERE s.idServicio = ".$idService."");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: del_empleados_servicio
     * Descripcion: Borra el registro de empleados asignados a un servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function del_empleados_servicio($idservice) {
        
        $this->db->trans_start();
        $query = $this->db->query("DELETE FROM empleados_servicio WHERE idServicio = ".$idservice."");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: del_productos_servicio
     * Descripcion: Borra el registro de empleados asignados a un servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 04/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function del_productos_servicio($idservice) {
        
        $this->db->trans_start();
        $query = $this->db->query("DELETE FROM productos_servicio WHERE idServicio = ".$idservice."");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: ins_empleados_servicio
     * Descripcion: Inserta el registro de empleados asignados a un servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 11/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function ins_empleados_servicio($idempleado,$idservice) {
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                empleados_servicio (
                                idEmpleado,
                                idServicio)
                                VALUES (
                                ".$idempleado.",
                                ".$idservice."
                                )");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: ins_productos_servicio
     * Descripcion: Inserta el registro de productos asignados a un servicio
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 04/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function ins_productos_servicio($idproducto,$idservice) {
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                productos_servicio (
                                idProducto,
                                idServicio)
                                VALUES (
                                ".$idproducto.",
                                ".$idservice."
                                )");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
}
