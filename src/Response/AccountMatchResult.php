<?php

namespace Globalis\Universign\Response;

use PhpXmlRpc\Value;

/**
 * Class AccountMatchResult
 * @package Globalis\Universign\Response
 *
 * @method string|null getFirstname()
 * @method string|null getLastname()
 * @method string|null getMobile()
 * @method string getEmail()
 * @method string getCertificateLevel()
 * @method string getCertificateStatus()
 * @method CertificateInfo|null getCertificateInfo()
 */
class AccountMatchResult extends Base
{
    const CERTIFICATE_STATUS_VALID = 'valid';
    const CERTIFICATE_STATUS_REVOKED = 'revoked';
    const CERTIFICATE_STATUS_AWAITING_VALIDATION = 'awaiting-validation';
    const CERTIFICATE_STATUS_AWAITING_AGREEMENT = 'awaiting-agreement';

    const CERTIFICATE_TYPE_NONE = 'none';
    const CERTIFICATE_TYPE_CERTIFIED = 'certified';
    const CERTIFICATE_TYPE_ADVANCED = 'advanced';

    protected $attributesDefinitions = [
        /**
         * The user’s last name if set, null otherwise.
         */
        'firstname' => true,
        /**
         * The user’s first name if set, null otherwise.
         */
        'lastname' => true,
        /**
         * The user’s mobile phone number if set, null otherwise.
         */
        'mobile' => true,
        /**
         * The user’s e-mail address.
         */
        'email' => true,
        /**
         * The certification level if this user. The possible values are:
         * - none: The user does not have a currently valid certificate.
         * - advanced
         * - certified
         */
        'certificateLevel' => true,
        /**
         * The possible values are:
         * - valid: The certificate is valid
         * - revoked: The certificate was revoked
         * - awaiting-validation: The certificate needs validation
         * - awaiting-agreement: The agreements need to be signed
         */
        'certificateStatus' => true,
        /**
         * If certificateLevel is not none, informations about the certificate used by the user, null otherwise.
         */
        'certificateInfo' => 'parseCertificateInfo'
    ];

    protected function parseCertificateInfo(Value $value)
    {
        return new AccountMatchCertificateInfo($value);
    }
}
