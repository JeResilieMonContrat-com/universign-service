<?php

namespace Globalis\Universign\Response;

use PhpXmlRpc\Value;

/**
 * Class AccountMatchCertificateInfo
 * @package Globalis\Universign\Response
 *
 * @method string|null getSubjectDN()
 * @method string|null getChain()
 * @method string|null getSerialNumber()
 */
class AccountMatchCertificateInfo extends Base
{
    protected $attributesDefinitions = [
        /**
         * The certificate subject DN
         */
        'subjectDN' => true,
        /**
         * The whole chain of the certificate.
         * The first element in the array is the root certificate and the last element is the end entity
         */
        'chain' => true,
        /**
         * The certificate serial number
         */
        'serialNumber' => true,
    ];
}
