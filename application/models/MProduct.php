<?php
/**************************************************************************
* Nombre de la Clase: MProduct
* Descripcion: Es el Modelo para las interacciones en BD del modulo Productos
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 25/03/2017
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MProduct extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        $this->load->model('MAuditoria'); /*Carga Modelo para Auditoria*/
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_products
     * Descripcion: Obtiene todos los productos creados
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_products() {
        
        $dataCache = $this->cache->memcached->get('mListproducts');
        $dataFilter = $this->cache->memcached->get('mIdsede');
        
        if (($dataCache) && ($dataFilter == $this->session->userdata('sede'))){
            
            $this->cache->memcached->save('memcached3', 'cache', 30);
            return $dataCache;
            
        } else {
        
            /*Recupera los productos creados*/
            $query = $this->db->query("SELECT
                                    p.idProducto,
                                    p.descProducto,
                                    p.costoProducto,
                                    p.valorProducto,
                                    p.distribucionProducto,
                                    p.uniDosis,
                                    p.activo,
                                    t.descTipoProducto,
                                    s.unidades,
                                    s.disponibles,
                                    u.aliasUnidad,
                                    g.descGrupoServicio,
                                    p.inventario
                                    FROM productos p
                                    JOIN tipo_producto t ON t.idTipoProducto = p.idTipoProducto
                                    JOIN stock_productos s ON s.idProducto = p.idProducto
                                    JOIN unidad_medida u ON u.idUnidadMedida = p.idUnidadMedida
                                    JOIN grupo_servicio g ON g.idGrupoServicio = p.idGrupoServicio 
                                    WHERE p.idSede = ".$this->session->userdata('sede')."
                                    ORDER BY g.descGrupoServicio,t.descTipoProducto DESC");
            
            $this->cache->memcached->save('mListproducts', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('mIdsede', $this->session->userdata('sede'), 28800);
            $this->cache->memcached->save('memcached3', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: get_product
     * Descripcion: Obtiene un producto creado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function get_product($idproduct) {
        
        /*Recupera los productos creados*/
        $query = $this->db->query("SELECT
                                p.descProducto,
                                p.costoProducto,
                                p.valorProducto,
                                p.distribucionProducto,
                                p.uniDosis,
                                p.activo,
                                t.descTipoProducto,
                                s.unidades,
                                s.disponibles,
                                p.idUnidadMedida,
                                u.nombreUnidad,
                                u.aliasUnidad,
                                p.inventario
                                FROM productos p
                                JOIN tipo_producto t ON t.idTipoProducto = p.idTipoProducto
                                JOIN stock_productos s ON s.idProducto = p.idProducto
                                JOIN unidad_medida u ON u.idUnidadMedida = p.idUnidadMedida
                                WHERE p.idProducto = ".$idproduct."");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_type_product
     * Descripcion: Obtiene todos los tipos de producto creados
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_type_product() {
        
        $dataCache = $this->cache->memcached->get('mListtypeproduct');
        
        if ($dataCache){
            
            $this->cache->memcached->save('memcached4', 'cache', 30);
            return $dataCache;
            
        } else {
            
            /*Recupera los grupos creados*/
            $query = $this->db->query("SELECT
                                    idTipoProducto,
                                    descTipoProducto
                                    FROM
                                    tipo_producto t
                                    WHERE activo = 'S'");
            
            $this->cache->memcached->save('mListtypeproduct', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached4', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_und_medida
     * Descripcion: Obtiene todas las unidades de medida creadas
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/02/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_und_medida() {
        
        $dataCache = $this->cache->memcached->get('mListundmedida');
        
        if ($dataCache){
            
            $this->cache->memcached->save('memcached32', 'cache', 30);
            return $dataCache;
            
        } else {
            
            /*Recupera las unidades de medida creados*/
            $query = $this->db->query("SELECT
                                    idUnidadMedida,
                                    nombreUnidad,
                                    aliasUnidad
                                    FROM unidad_medida
                                    ORDER BY 2 DESC");
            
            $this->cache->memcached->save('mListundmedida', $query->result_array(), 28800); /*8 horas en Memoria*/
            $this->cache->memcached->save('memcached32', 'real', 30);

            if ($query->num_rows() == 0) {

                return false;

            } else {

                return $query->result_array();

            }
        }
    }
    
    /**************************************************************************
     * Nombre del Metodo: create_product
     * Descripcion: Registra un Producto en BD
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function create_product($name,$valor,$distributionproduct,$stock,$unidosis,$typeproduct,$costo,$undmedida,$groupservice) {
        
        /*Setea usuario de conexion - Auditoria BD*/
        $this->db = $this->MAuditoria->db_user_audit($this->session->userdata('userid'));
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query1 = $this->db->query("INSERT INTO
                                    productos (
                                    descProducto,
                                    costoProducto,
                                    valorProducto,
                                    distribucionProducto,
                                    uniDosis,
                                    activo,
                                    idTipoProducto,
                                    idSede,
                                    idUnidadMedida,
                                    idGrupoServicio,
                                    inventario
                                    ) VALUES (
                                    '".$name."',
                                    ".$costo.",
                                    ".$valor.",
                                    ".$distributionproduct.",
                                    ".$unidosis.",
                                    'S',
                                    ".$typeproduct.",
                                    ".$this->session->userdata('sede').",
                                    ".$undmedida.",
                                    ".$groupservice.",
                                    'N'
                                    )");
        
        $idProduct = $this->db->insert_id();

        $query2 = $this->db->query("INSERT INTO
                                    stock_productos (
                                    idProducto,
                                    unidades,
                                    disponibles,
                                    fecha_registro
                                    ) VALUES (
                                    ".$idProduct.",
                                    ".$stock.",
                                    ".$stock.",
                                    NOW()
                                    )");

        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            $this->cache->memcached->delete('mListproducts');
            $this->cache->memcached->delete('mListProductSale');
            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: update_product
     * Descripcion: Actualiza un Producto en BD
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function update_product($idproduct,$name,$valor,$procent_empleado,$stock,$unidosis,$valueState,$costo,$inventario) {
        
        /*Setea usuario de conexion - Auditoria BD*/
        $this->db = $this->MAuditoria->db_user_audit($this->session->userdata('userid'));
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query1 = $this->db->query("UPDATE
                                    productos SET
                                    descProducto = '".$name."',
                                    costoProducto = ".$costo.",
                                    valorProducto = ".$valor.",
                                    distribucionProducto = ".$procent_empleado.",
                                    uniDosis = ".$unidosis.",
                                    activo = '".$valueState."',
                                    inventario = '".$inventario."'
                                    WHERE
                                    idProducto = ".$idproduct."");

        $query2 = $this->db->query("UPDATE
                                    stock_productos SET
                                    unidades = ".$stock.",
                                    disponibles = ".$stock.",
                                    fecha_registro = NOW()
                                    WHERE
                                    idProducto = ".$idproduct."");

        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            $this->cache->memcached->delete('mListproducts');
            $this->cache->memcached->delete('mListProductSale');
            return true;

        }

    }
    
}
