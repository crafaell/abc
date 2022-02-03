<?php

namespace App\Http\Controllers;

class ctr_funciones extends Controller{

    public function Sanitizar( $var, $type = false ){
        #type = true for array 
        $sanitize = new \stdClass(); 
        if ($type){ 
            foreach ($var as $key => $value) { 
                $sanitize->$key = $this->_clearString( $value ); 
            }
            return $sanitize;
        } else { 
            return $this->_clearString( $var ); 
        }
    }  

    private function _clearString( $string ){
        $string = strip_tags($string); 
        $string = htmlspecialchars($string); 
        $string = addslashes($string); 
        #$string = quotemeta($string); 
        return $string; 
    }
}
