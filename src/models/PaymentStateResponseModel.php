<?php
namespace Barion\models;
use Barion\models\BaseResponseModel;
use Barion\helpers\iBarionModel;

class PaymentStateResponseModel extends BaseResponseModel implements iBarionModel
{
    public $PaymentId;
    public $PaymentRequestId;
    public $POSId;
    public $POSName;
    public $Status;
    public $PaymentType;
    public $FundingSource;
    public $AllowedFundingSources;
    public $GuestCheckout;
    public $CreatedAt;
    public $ValidUntil;
    public $CompletedAt;
    public $ReservedUntil;
    public $Total;
    public $Transactions;
    public $RecurrenceResult;
    
    function __construct()
    {
        $this->PaymentId = "";
        $this->PaymentRequestId = "";
        $this->POSId = "";
        $this->POSName = "";
        $this->Status = "";
        $this->PaymentType = "";
        $this->FundingSource = "";
        $this->AllowedFundingSources = "";
        $this->GuestCheckout = "";
        $this->CreatedAt = "";
        $this->ValidUntil = "";
        $this->CompletedAt = "";
        $this->ReservedUntil = "";
        $this->Total = 0;
        $this->Transactions = array();
        $this->RecurrenceResult = "";
    }

    public function fromJson($json)
    {
        if (!empty($json)) {
            parent::fromJson($json);

            $this->PaymentId = $this->jget($json, 'PaymentId');
            $this->PaymentRequestId = $this->jget($json, 'PaymentRequestId');
            $this->Status = $this->jget($json, 'Status');
            $this->PaymentType = $this->jget($json, 'PaymentType');
            $this->FundingSource = $this->jget($json, 'FundingSource');
            $this->GuestCheckout = $this->jget($json, 'GuestCheckout');
            $this->CreatedAt = $this->jget($json, 'CreatedAt');
            $this->ValidUntil = $this->jget($json, 'ValidUntil');
            $this->CompletedAt = $this->jget($json, 'CompletedAt');
            $this->ReservedUntil = $this->jget($json, 'ReservedUntil');
            $this->Total = $this->jget($json, 'Total');
            $this->AllowedFundingSources = $this->jget($json, 'AllowedFundingSources');
            $this->RecurrenceResult = $this->jget($json, 'RecurrenceResult');

            $this->Transactions = array();

            if (!empty($json['Transactions'])) {
                foreach ($json['Transactions'] as $key => $value) {
                    $tr = new TransactionDetailModel();
                    $tr->fromJson($value);
                    array_push($this->Transactions, $tr);
                }
            }
        }
    }
    
    public function jget($json, $propertyName)
    {
        return isset($json[$propertyName]) ? $json[$propertyName] : null;
    }
}

?>