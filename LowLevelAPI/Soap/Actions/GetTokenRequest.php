<?php

/**
 * GetTokenRequest
 *
 * @file GetTokenRequest.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap\Actions;

class GetTokenRequest {
    public $StoreId; // string
    public $StoreIdentifier; // string
    public $MerchantNumber; // string
    public $Currency; // string
    public $CampaignCode; // string
    public $PurchaseAmount; // decimal
    public $DynamicReturnURL; // string
}
