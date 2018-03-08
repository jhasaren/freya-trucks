<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Jasr
 *
 * Funciones externas desarrolladas para procesos de apoyo
 * 
 * Autor: jhonalexander90@gmail.com
 * 
 **/

class Jasr {
	
    /***************************************************************************
     * Metodo: validaTipoString
     * Autor: jasanchez@consorciopst.com
     * Fecha de Creación: 04/04/2017
     * Descripcion: valida string por expresion regular
     **************************************************************************/
    public function validaTipoString($dato,$type) {

        if ($type == 1){
            /* Alfanumerico entre 3 y 50 caracteres con espacios */
            $reg = "/^[A-Za-z0-9 ]{3,50}+$/";
            return preg_match($reg, $dato);

        }
        
        if ($type == 2){
            /* Numeros de 1 a 7 digitos */
            $reg = "/^[0-9]{1,7}+$/";
            return preg_match($reg, $dato);

        }
        
        if ($type == 3){
            /* Porcentaje <= 100 y solo numeros de 1 a 3 digitos */
            if ($dato > 100){
                return FALSE;
            } else {
                $reg = "/^[0-9]{1,3}+$/";
                return preg_match($reg, $dato);
            }
        }
        
        if ($type == 4){
            /* Contraseña Alfanumerica minimo 8 digitos */
            $reg = "/^[A-Za-z0-9]{8,15}+$/";
            return preg_match($reg, $dato);

        }
        
        if ($type == 5){
            /* Numeros de 5 a 11 digitos */
            $reg = "/^[0-9]{5,11}+$/";
            return preg_match($reg, $dato);

        }
        
        if ($type == 6){
            /* Email */
            if ($dato == NULL){
                return TRUE;
            } else {
                $reg = "/^[a-z0-9](\.?[a-z0-9_-]){0,}@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}+$/";
                return preg_match($reg, $dato);
            }
        }
        
        if ($type == 7){
            /* Dia cumpleaños solo numeros entre 1 y 31 solo 2 digitos */
            if ($dato >= 1 && $dato <= 31){
                $reg = "/^[0-9]{1,2}+$/";
                return preg_match($reg, $dato);
            } else {
                return FALSE;
            }
        }
        
        if ($type == 8) {
            /* 
             * Password
             * Contraseñas que contengan al menos una letra mayúscula.
             * Contraseñas que contengan al menos una letra minúscula.
             * Contraseñas que contengan al menos un número.
             * Contraseñas cuya longitud sea como mínimo 8 a 20 caracteres.
             */
            $reg = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}+$/";
            return preg_match($reg, $dato);
        } 
        
        if ($type == 9){
            /* Rango de recibos solo numeros entre 1 y 20 digitos */
            $reg = "/^[0-9]{1,20}+$/";
            return preg_match($reg, $dato);
        }

    }
    
    /***************************************************************************
     * Metodo: toHours
     * Autor: jasanchez@consorciopst.com
     * Fecha de Creación: 30/04/2017
     * Descripcion: Convierte minutos en horas
     **************************************************************************/
    public function toHours($min, $type) {
        //obtener segundos
        $sec = $min * 60;
        //dias es la division de n segs entre 86400 segundos que representa un dia
        $dias = floor($sec / 86400);
        //mod_hora es el sobrante, en horas, de la division de días; 
        $mod_hora = $sec % 86400;
        //hora es la division entre el sobrante de horas y 3600 segundos que representa una hora;
        $horas = floor($mod_hora / 3600);
        //mod_minuto es el sobrante, en minutos, de la division de horas; 
        $mod_minuto = $mod_hora % 3600;
        //minuto es la division entre el sobrante y 60 segundos que representa un minuto;
        $minutos = floor($mod_minuto / 60);
        
        if ($horas <= 0) {
            $text = $minutos;
        } elseif ($dias <= 0) {
            if ($type == 'round') {
                //nos apoyamos de la variable type para especificar si se muestra solo las horas
                $text = $horas . ' hrs';
            } else {
                $text = $horas . " hrs " . $minutos;
            }
        } else {
            //nos apoyamos de la variable type para especificar si se muestra solo los dias
            if ($type == 'round') {
                $text = $dias . ' dias';
            } else {
                $text = $dias . " dias " . $horas . " hrs " . $minutos . " min";
            }
        }
        return $text;
    }

}