<?php

/**
 * Token
 *
 * @file Token.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-05
 */

namespace Santander\Easycontract\LowLevelAPI\Model;

class Token {
    /**
     * The token from web service
     * @var string 
     */
    public $token;
    
    /**
     * Boolean indicating the whether the web service call was successfull and if
     * we have a token.
     * @var boolean 
     */
    public $isOk = FALSE;
    
    /**
     * The result code from the web service
     * @var integer 
     */
    public $resultCode;
    
    /**
     * The error message if the web service call failed.
     * @var string 
     */
    public $errorMessage;
}
