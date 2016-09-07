<?php

/**
 * TestConnectionRequest
 *
 * @file TestConnectionRequest.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap\Actions;

class TestConnectionRequest {
    public $StoreId; // string
    public $CampaignId; // string
    public $Status; // int
}
