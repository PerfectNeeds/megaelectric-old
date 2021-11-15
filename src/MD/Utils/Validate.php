<?php

namespace MD\Utils;

class Validate {
    
    /*
     * @version      : 1
     * @author       : Alex Seif <alex.seif@gmail.com>
     * Description   : function to test null for any type 
     */
    public static function not_null($value) {
        if (is_array($value)) {
            if (sizeof($value) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            if (($value != '') && (@strtolower($value) != 'null') && (@strlen(@trim($value)) > 0)) {
                return true;
            } else {
                return false;
            }
        }
    }

}