<?php

/**
 * GetCampaignValuesRequest
 *
 * @file GetCampaignValuesRequest.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap\Actions;

class GetCampaignValuesRequest {
    public $StoreId; // string
    public $CampaignID; // string
    public $PurchaseAmount; // double
}
