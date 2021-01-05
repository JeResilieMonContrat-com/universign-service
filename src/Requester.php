<?php

namespace Globalis\Universign;

use Globalis\Universign\Request\AccountMatch;
use Globalis\Universign\Request\ValidationRequest;
use Globalis\Universign\Response\AccountMatchResult;
use Globalis\Universign\Response\TransactionDocument;
use Globalis\Universign\Response\TransactionInfo;
use Globalis\Universign\Request\TransactionRequest;
use Globalis\Universign\Request\StandaloneRegistrationRequest;
use Globalis\Universign\Response\TransactionResponse;
use Globalis\Universign\Response\ValidatorResult;
use PhpXmlRpc\Value;

class Requester extends Base
{
    /**
     * Requests a new transaction for the client signature service.
     *
     * Sends the document to be signed and other parameters and returns an URL where the end
     * user should be redirected to. A transaction must be completed whithin 14
     * days after its request.
     *
     * @param   \Globalis\Universign\Request\TransactionRequest  $request
     * @return  \Globalis\Universign\Response\TransactionResponse
     */
    public function requestTransaction(TransactionRequest $request)
    {
        return new TransactionResponse(
            $this->sendRequest(
                'requester.requestTransaction',
                $request->buildRpcValues()
            )
        );
    }

    /**
     * Requests signed documents (after their transaction is completed) by their transaction id.
     *
     * @param   string  $transactionId
     * @return  array
     */
    public function getDocuments($transactionId)
    {
        $data = [];
        $values = $this->sendRequest(
            'requester.getDocuments',
            new Value($transactionId, 'string')
        );

        foreach ($values as $key => $value) {
            $data[] = new TransactionDocument($value);
        }

        return $data;
    }

    /**
     * Requests signed documents (after their transaction is finished) by their custom id.
     *
     * @param   string  $customerId
     * @return  array
     */
    public function getDocumentsByCustomId($customerId)
    {
        $data = [];
        $values = $this->sendRequest(
            'requester.getDocumentsByCustomId',
            new Value($customerId, 'string')
        );

        foreach ($values as $key => $value) {
            $data[] = new TransactionDocument($value);
        }

        return $data;
    }

    /**
     * Requests information about the status of the transaction with this id.
     *
     * @param   string  $transactionId
     * @return  TransactionInfo
     */
    public function getTransactionInfo($transactionId)
    {
        return new TransactionInfo(
            $this->sendRequest(
                'requester.getTransactionInfo',
                new Value($transactionId, 'string')
            )
        );
    }

    /**
     * Requests information about the status of the transaction with this id.
     *
     * @param   string  $customerId
     * @return  TransactionInfo
     */
    public function getTransactionInfoByCustomId($customerId)
    {
        return new TransactionInfo(
            $this->sendRequest(
                'requester.getTransactionInfoByCustomId',
                new Value($customerId, 'string')
            )
        );
    }

    /**
     * Cancel a transaction in progress with this id.
     *
     * @param   string  $transactionId
     * @return  TransactionInfo
     */
    public function cancelTransaction($transactionId)
    {
        return new TransactionInfo(
            $this->sendRequest(
                'requester.cancelTransaction',
                new Value($transactionId, 'string')
            )
        );
    }



    /**
     * Requests the standalone registration of the signer (level 2).
     *
     * Sends the signer identity to be certified and returns an URL where the signer should be redirected to.
     * The registration process is similar to the transaction one but without documents to sign.
     *
     * @param   \Globalis\Universign\Request\StandaloneRegistrationRequest  $request
     */
    public function requestRegistration(StandaloneRegistrationRequest $request)
    {
        return new TransactionResponse(
            $this->sendRequest(
                'requester.requestRegistration',
                $request->buildRpcValues()
            )
        );
    }




    /**
     * Validate a user by identity card (level 2).
     *
     * Cette méthode permet d’activer les services de validation d’identité Universign :
     * à partir des éléments transmis nom, prénom, date de naissance et documents justificatifs de l’identité.
     *
     * @param   \Globalis\Universign\Request\ValidationRequest  $request
     */
    public function requestValidation(ValidationRequest $request)
    {
        return new ValidatorResult(
            $this->sendRequest(
            'validator.validate',
                    $request->buildRpcValues()
            )
        );
    }


    /**
     * Verify if the account exists in universign bases or not (level 2).
     *
     * Le service de Matching est un outil permettant d’identifier un compte existant dans les bases Universign à partir d’un couple Nom/Prénom,
     * ainsi qu'au moins un moyen de contact parmi le couple email /téléphone mobile.
     * La méthode renvoie également l'info sur l'existence d'un certificat (none, advanced, certified).
     * Cette méthode est en général utilisée en amont de la pré-validation puisque dans le cas d’un utilisateur déjà certifié la pré-validation est inutile.
     *
     * @param   \Globalis\Universign\Request\AccountMatch  $request
     */
    public function matchAccount(AccountMatch $request)
    {
        $values = $this->sendRequest(
    'matcher.matchAccount',
            $request->buildRpcValues()
        );

        $data = [];
        foreach ($values as $key => $value) {
            $data[] = new AccountMatchResult($value);
        }

        return $data;
    }


    /**
     * Refreshes the creation date for the transaction.
     *
     * The invitation email is sent again if the parameters allow it (chainingMode equals email and in the case of the first signer, mustContactFirstSigner equals true).
     * This method can be used to postpone the expiration date of the transaction.
     *
     * @param   $transactionId
     */
    public function relaunchTransaction($transactionId)
    {
        return $this->sendRequest(
            'requester.relaunchTransaction',
            new Value($transactionId, 'string')
        );
    }


    /**
     * Returns the operator status. The return value can be:
     *
     *
     *
     * @param   $email
     */
    public function checkOperatorStatus($email)
    {
        return $this->sendRequest(
            'ra.checkOperatorStatus',
            new Value($email, 'string')
        );
    }


    /**
     * This service allows the admin of an organization to revoke a user’s certificate identified by its emails or phone number.
     *
     *
     *
     * @param   $emailOrPhoneNumber
     */
    public function revokeCertificate($emailOrPhoneNumber)
    {
        return $this->sendRequest(
            'ra.revokeCertificate',
            new Value($emailOrPhoneNumber, 'string')
        );
    }
}
