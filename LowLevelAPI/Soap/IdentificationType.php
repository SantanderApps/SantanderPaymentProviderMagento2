<?php

/**
 * IdentificationType
 *
 * @file IdentificationType.php
 * @author Consid S5 AB <henrik.soderlind@consid.se>
 * @version 2.0.0
 * @created 2015-aug-04
 */

namespace Santander\Easycontract\LowLevelAPI\Soap;

class IdentificationType {
    const User = 'User';
    const UserAndPassword = 'UserAndPassword';
    const Pincode = 'Pincode';
    const Certificate = 'Certificate';
}
