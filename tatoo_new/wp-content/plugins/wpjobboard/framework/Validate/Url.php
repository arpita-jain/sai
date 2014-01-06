<?php
/**
 * Description of Url
 *
 * @author greg
 * @package 
 */

class Daq_Validate_Url
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{
    public function isValid($value)
    {
        $err = __('Invalid URL. Provide valid URL', DAQ_DOMAIN);
        //if(!preg_match("#^http://[A-z0-9\-\_\./\?&;=]+$#i",$value)) {
        //if( !filter_var ( $value, FILTER_VALIDATE_URL ) ) {
           // $this->setError($err);
           // return false;
        //}

        return true;
    }
}

?>