<?php

/**
 * Authentication
 *
 * @file Authentication.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap;

class Authentication {
    public $Login;
    
    public function __construct(Login $login) {
        $this->Login = $login;
    }
}
