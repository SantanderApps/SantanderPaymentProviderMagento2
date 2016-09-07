<?php

/**
 * Address
 *
 * @file Address.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-05
 */

namespace Santander\Easycontract\LowLevelAPI\Model;

class Address {
    /**
     *
     * @var string 
     */
    public $firstName;
    
    /**
     *
     * @var string 
     */
    public $lastName;
    
    /**
     *
     * @var string 
     */
    public $address;
    
    /**
     *
     * @var string 
     */
    public $postCode;
    
    /**
     *
     * @var string 
     */
    public $city;
}
