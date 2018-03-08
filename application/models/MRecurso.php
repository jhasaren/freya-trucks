<?php
/**************************************************************************
* Nombre de la Clase: MRecurso
* Descripcion: Valida recursos del usuario en sesion
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 08/04/2017
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MRecurso extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: validaRecurso
     * Descripcion: valida recurso asignado al usuario de la sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 08/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function validaRecurso($idRecurso) {

        $recursos = $this->session->userdata('recursos');
        $n = 0;
        
        foreach ($recursos as $value){

            $recursosUsuario[$n] = $value['idRecurso'];
            $n++;

        }
        
        if (in_array($idRecurso, $recursosUsuario)){
            
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }

    }
    
}
