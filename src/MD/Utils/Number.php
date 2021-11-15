<?php

namespace MD\Utils;

class Number {
    
    /*
     * @version      : 1
     * @author       : Peter Soliman <peter.samy@gmail.com>
     * Description   : function to Display Money Formate 
     */
    public static function money($number, $currency = 'USD', $dec_point = '.', $thousands_sep='') {
        if($currency)
            return number_format($number, 2,$dec_point,$thousands_sep) . $currency;        
        return number_format($number, 2,$dec_point,$thousands_sep);
    }
    
    /*
     * @version      : 1
     * @author       : Peter Soliman <peter.samy@gmail.com>
     * Description   : function to Display Orders, Bookings, ... Formate 
     */
    public static function code( $number, $prefix = "#" , $padLengt = 12, $padString = '0') {
        return $prefix . str_pad( $number, $padLengt, $padString, STR_PAD_LEFT);
    }

}