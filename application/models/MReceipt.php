<?php
/**************************************************************************
* Nombre de la Clase: MReceipt
* Descripcion: Es el Modelo para las interacciones en BD del modulo Facturas
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 07/04/2017
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MReceipt extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: create_range
     * Descripcion: Registra un nuevo rango de recibos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 07/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function create_range($resolucion,$inicio,$final) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        
        for($i=$inicio;$i<=$final;$i++){
            
            $verify = $this->db->query("SELECT nroRecibo
                                        FROM rango_recibos
                                        WHERE nroRecibo = ".$i."");
            
            $cant = $verify->num_rows();
            
            if($cant > 0){
                
                return FALSE;

            } else {

                $this->db->query("INSERT INTO
                                rango_recibos (
                                nroRecibo,
                                idEstadoRecibo,
                                fechaRango,
                                resolucionExpide
                                ) VALUES (
                                ".$i.",
                                1,
                                NOW(),
                                '".$resolucion."'
                                )");

            }
            
        }
        
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            $this->cache->memcached->delete('mDetailResol');
            return true;

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: rango_disp_resolucion
     * Descripcion: Obtiene la cantidad de recibos 1-disponibles por resolucion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 07/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function detail_resolucion() {
        
        $dataCache = $this->cache->memcached->get('mDetailResol');
        
        if ($dataCache){
            
            $this->cache->memcached->save('memcached9', 'cache', 30);
            return $dataCache;
            
        } else {
        
            /*Recupera los usuarios creados*/
            $query = $this->db->query("SELECT
                                    r.resolucionExpide,
                                    r.fechaRango,
                                    count(1) as cantidadRecibos,
                                    (SELECT count(1)
                                      FROM rango_recibos re
                                      WHERE re.idEstadoRecibo = 1
                                      AND re.resolucionExpide = r.resolucionExpide) as disponibles,
                                    (SELECT count(1)
                                      FROM rango_recibos re
                                      WHERE re.idEstadoRecibo = 6
                                      AND re.resolucionExpide = r.resolucionExpide) as consumidos,
                                    min(r.nroRecibo) as inicio,
                                    max(r.nroRecibo) as final
                                    FROM rango_recibos r
                                    GROUP BY r.resolucionExpide");
            
            $this->cache->memcached->save('mDetailResol', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached9', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
}
