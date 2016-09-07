<?php

/**
 * Result
 *
 * @file Result.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-05
 */

namespace Santander\Easycontract\LowLevelAPI\Model;

class Result {
    /**
     *
     * @var \Santander\Easycontract\LowLevelAPI\Model\Address 
     */
    public $address;
    
    /**
     *
     * @var boolean 
     */
    public $isAbortedByCustomer = FALSE;
    
    /**
     *
     * @var string 
     */
    public $humanFailureMessage;
    
    /**
     *
     * @var boolean 
     */
    public $isOk = FALSE;
    
    /**
     *
     * @var integer 
     */
    public $resultCode;
    
    /**
     *
     * @var string 
     */
    public $authorizationCode;
}
