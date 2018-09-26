<?php
/**************************************************************************
* Nombre de la Clase: MBoard
* Descripcion: Es el Modelo para las interacciones en BD del modulo Mesas
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 09/22/2018
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MBoard extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        $this->load->model('MAuditoria'); /*Carga Modelo para Auditoria*/
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_boards
     * Descripcion: Obtiene todas los mesas creadas
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_boards() {
        
        $dataCache = $this->cache->memcached->get('mListboards');
        $dataFilter = $this->cache->memcached->get('mIdsede');
        
        if (($dataCache) && ($dataFilter == $this->session->userdata('sede'))){
            
            $this->cache->memcached->save('memcached80', 'cache', 30);
            return $dataCache;
            
        } else {
        
            /*Recupera los productos creados*/
            $query = $this->db->query("SELECT
                                    m.idMesa,
                                    m.nombreMesa,
                                    m.activo,
                                    t.descTipoMesa
                                    FROM mesas m
                                    JOIN tipo_mesa t ON t.idTipoMesa = m.idTipoMesa
                                    WHERE
                                    m.idSede = ".$this->session->userdata('sede')."
                                    ORDER BY 2 ASC");
            
            $this->cache->memcached->save('mListboards', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('mIdsede', $this->session->userdata('sede'), 28800);
            $this->cache->memcached->save('memcached80', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: get_board
     * Descripcion: Obtiene una mesa creada
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function get_board($idboard) {
        
        /*Recupera la mesa creada*/
        $query = $this->db->query("SELECT
                                m.idMesa,
                                m.nombreMesa,
                                m.activo,
                                t.descTipoMesa
                                FROM mesas m
                                JOIN tipo_mesa t ON t.idTipoMesa = m.idTipoMesa
                                WHERE
                                idMesa = ".$idboard."");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_type_board
     * Descripcion: Obtiene todos los tipos de mesas creados
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_type_board() {
                    
        /*Recupera los tipos creados*/
        $query = $this->db->query("SELECT
                                idTipoMesa,
                                descTipoMesa
                                FROM tipo_mesa
                                WHERE activo = 'S'");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }
        
    }
    
    
    /**************************************************************************
     * Nombre del Metodo: create_board
     * Descripcion: Registra un Producto en BD
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function create_board($name,$type) {
        
        /*Setea usuario de conexion - Auditoria BD*/
        $this->db = $this->MAuditoria->db_user_audit($this->session->userdata('userid'));
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query1 = $this->db->query("INSERT INTO
                                    mesas (
                                    nombreMesa,
                                    activo,
                                    idSede,
                                    idTipoMesa
                                    ) VALUES (
                                    '".$name."',
                                    'S',
                                    ".$this->session->userdata('sede').",
                                    ".$type."
                                    )");

        $this->db->trans_complete();
        $this->db->trans_off();
        
        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            $this->cache->memcached->delete('mListboards');
            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: update_board
     * Descripcion: Actualiza una mesa en BD
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function update_board($idboard,$name,$valueState) {
                    
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query1 = $this->db->query("UPDATE
                                    mesas SET
                                    nombreMesa = '".$name."',
                                    activo = '".$valueState."'
                                    WHERE
                                    idMesa = ".$idboard."");

        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            $this->cache->memcached->delete('mListboards');
            return true;

        }

    }
        
}
