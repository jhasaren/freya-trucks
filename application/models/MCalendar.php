<?php
/**************************************************************************
* Nombre de la Clase: MCalendar
* Descripcion: Es el Modelo para las interacciones en BD del modulo Agendas
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 09/04/2017
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MCalendar extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_service_calendar
     * Descripcion: Obtiene los servicios activos para registrar agendar cita
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 10/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_service_calendar($sede) {
        
        /*Recupera los servicios creados*/
        $query = $this->db->query("SELECT
                                s.idServicio,
                                g.descGrupoServicio,
                                s.descServicio
                                FROM
                                servicios s
                                JOIN grupo_servicio g ON g.idGrupoServicio = s.idGrupoServicio
                                WHERE
                                s.activo = 'S'
                                AND s.agenda = 'S'
                                AND s.idSede = ".$sede."
                                ORDER BY 2,3");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: add_event
     * Descripcion: Registra un Evento para la agenda de un Empleado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 16/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function add_event($empleado,$cliente,$servicio,$tiempo,$fechainicio,$fechafin,$sede) {
                    
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                    eventos_empleado (
                                    idEmpleado,
                                    idCliente,
                                    idServicio,
                                    tiempoAtencion,
                                    fechaInicioEvento,
                                    fechaFinEvento,
                                    fechaRegistro,
                                    usuarioRegistro,
                                    idSede
                                    ) VALUES (
                                    ".$empleado.",
                                    ".$cliente.",
                                    ".$servicio.",
                                    ".$tiempo.",
                                    '".$fechainicio."',
                                    '".$fechafin."',
                                    NOW(),
                                    ".$this->session->userdata('userid').",
                                    ".$sede."
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
     * Nombre del Metodo: verify_calendar
     * Descripcion: Recupera las citas registradas para el empleado en determinado 
     * periodo de tiempo para determinar la viabilidad del registro de un nuevo evento
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 16/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function verify_calendar($empleado,$fechaini,$fechafin) {
        
        $tiempoAten1 = strtotime("-1 minute", strtotime($fechafin));
        $fechaFinaliza = date('Y-m-d H:i:s',$tiempoAten1);
        
        /*Recupera las citas registradas para el empleado*/
        $query = $this->db->query("SELECT
                                e.idEvento
                                FROM
                                eventos_empleado e
                                WHERE
                                e.idEmpleado = ".$empleado."
                                AND fechaInicioEvento 
                                BETWEEN '".$fechaini."' 
                                AND '".$fechaFinaliza."'");
        
        if ($query->num_rows() == 0) {
            
            $tiempoAten2 = strtotime("+1 minute", strtotime($fechaini));
            $fechaInicio = date('Y-m-d H:i:s',$tiempoAten2);
            
            $query2 = $this->db->query("SELECT
                                    e.idEvento
                                    FROM
                                    eventos_empleado e
                                    WHERE
                                    e.idEmpleado = ".$empleado."
                                    AND fechaFinEvento 
                                    BETWEEN '".$fechaInicio."' 
                                    AND '".$fechafin."'");
            
            if ($query2->num_rows() == 0) {
            
                return false;
            
            } else {
                
                return $query2->result_array();
                
            }
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: eventos_empleado
     * Descripcion: Recupera las citas registradas para el empleado en determinado 
     * periodo de tiempo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 16/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function eventos_empleado($empleado,$fecha) {
                
        /*Recupera las citas registradas para el empleado*/
        $query = $this->db->query("SELECT
                                e.idEvento,
                                e.idServicio,
                                e.fechaInicioEvento,
                                e.fechaFinEvento
                                FROM
                                eventos_empleado e
                                WHERE
                                e.idEmpleado = ".$empleado."
                                AND e.fechaInicioEvento 
                                BETWEEN '".$fecha." 00:00:00' 
                                AND '".$fecha." 23:59:59'");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: horario_empleado
     * Descripcion: Obtiene el horario del empleado para un dia de la semana
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 16/04/2017, Ultima modificacion: 
    **************************************************************************/
    public function horario_empleado($diaSemana,$idEmpleado) {
        
        /*Recupera los servicios creados*/
        $query = $this->db->query("SELECT
                                h.horaIniciaTurno,
                                h.horaFinTurno,
                                h.horaIniciaAlmuerzo,
                                h.horaFinAlmuerzo
                                FROM
                                horario_empleado h
                                WHERE
                                h.idEmpleado = ".$idEmpleado."
                                AND h.idDia = ".$diaSemana."");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_event_cliente
     * Descripcion: Obtiene los eventos/citas reservadas del cliente
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_event_cliente($idUsuario) {
        
        /*Recupera los eventos creados*/
        $query = $this->db->query("SELECT
                                e.idEvento,
                                e.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado,
                                e.idCliente,
                                e.idServicio,
                                s.descServicio,
                                e.fechaInicioEvento,
                                e.fechaFinEvento,
                                e.tiempoAtencion,
                                e.idSede,
                                d.nombreSede,
                                d.direccionSede,
                                d.telefonoSede
                                FROM
                                eventos_empleado e
                                JOIN app_usuarios a ON a.idUsuario = e.idEmpleado
                                JOIN servicios s ON s.idServicio = e.idServicio
                                JOIN sede d ON d.idSede = e.idSede
                                WHERE
                                e.idCliente = ".$idUsuario."
                                ORDER BY e.fechaInicioEvento 
                                AND fechaInicioEvento >= CURDATE()");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_event_sede
     * Descripcion: Obtiene los eventos/citas reservadas de la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function list_event_sede() {
        
        /*Recupera los eventos creados*/
        $query = $this->db->query("SELECT
                                e.idEvento,
                                e.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado,
                                e.idCliente,
                                concat(c.nombre,' ',c.apellido) as nombreCliente,
                                c.numCelular,
                                e.idServicio,
                                s.descServicio,
                                e.fechaInicioEvento,
                                e.fechaFinEvento,
                                e.tiempoAtencion,
                                e.idSede,
                                d.nombreSede,
                                d.direccionSede,
                                d.telefonoSede
                                FROM
                                eventos_empleado e
                                JOIN app_usuarios a ON a.idUsuario = e.idEmpleado
                                JOIN servicios s ON s.idServicio = e.idServicio
                                JOIN sede d ON d.idSede = e.idSede
                                JOIN app_usuarios c ON c.idUsuario = e.idCliente
                                WHERE
                                e.idSede = ".$this->session->userdata('sede')."
                                AND fechaInicioEvento >= CURDATE()");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->result_array();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: event_cancel
     * Descripcion: Cancela una cita reservada (elimina)
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function event_cancel($idevento) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("DELETE FROM eventos_empleado WHERE idEvento = ".$idevento."");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: detail_event
     * Descripcion: Obtiene el detalle de un evento/cita reservada en la sede
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function detail_event($idevento) {
        
        /*Recupera los eventos creados*/
        $query = $this->db->query("SELECT
                                e.idEvento,
                                e.idEmpleado,
                                concat(a.nombre,' ',a.apellido) as nombreEmpleado,
                                e.idCliente,
                                concat(c.nombre,' ',c.apellido) as nombreCliente,
                                c.numCelular,
                                e.idServicio,
                                s.descServicio,
                                e.fechaInicioEvento,
                                e.fechaFinEvento,
                                e.tiempoAtencion,
                                e.idSede,
                                d.nombreSede,
                                d.direccionSede,
                                d.telefonoSede
                                FROM
                                eventos_empleado e
                                JOIN app_usuarios a ON a.idUsuario = e.idEmpleado
                                JOIN servicios s ON s.idServicio = e.idServicio
                                JOIN sede d ON d.idSede = e.idSede
                                JOIN app_usuarios c ON c.idUsuario = e.idCliente
                                WHERE
                                e.fechaInicioEvento >= CURDATE()
                                AND e.idEvento = '".$idevento."'");
        
        if ($query->num_rows() == 0) {
            
            return false;
            
        } else {
            
            return $query->row();
            
        }
        
    }
        
}
