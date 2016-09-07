<?php

/**
 * Login
 *
 * @file Login.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap;

class Login {
    /**
     * User or store identity
     * @var string 
     */
    public $Identity;
    
    /**
     * User, store password or Pincode
     * @var string 
     */
    public $Password;
    
    /**
     * 
     * @var string 
     */
    public $IdentificationType;
    
    /**
     *
     * @var string 
     */
    public $AuthorizationType;
}
