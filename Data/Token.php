<?php

/**
 * Token
 *
 * @file Token.php
 * @author Consid AB <henrik.soderlind@consid.se>
 * @created 2015-dec-03
 */

namespace Santander\Easycontract\Data;

class Token
{
    /**
     * @var \Santander\LowLevelAPI\Model\Token 
     */
    public $token;
    
    /**
     * @var int
     */
    public $orderNumber;
}
