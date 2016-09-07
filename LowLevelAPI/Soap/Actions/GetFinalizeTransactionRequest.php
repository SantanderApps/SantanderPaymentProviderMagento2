<?php

/**
 * GetFinalizeTransactionRequest
 *
 * @file GetFinalizeTransactionRequest.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap\Actions;

class GetFinalizeTransactionRequest {
    public $StoreId; // string
    public $Token; // string
    public $StoreIdentifier; // string
    public $SettledAmount; // long
}
