<?php
namespace zoge\barion\models;

use zoge\barion\models\BaseResponseModel;
use zoge\barion\helpers\iBarionModel;

class FinishReservationResponseModel extends BaseResponseModel implements iBarionModel
{
    public $IsSuccessful;
    public $PaymentId;
    public $PaymentRequestId;
    public $Status;
    public $Transactions;
    
    function __construct()
    {
        $this->IsSuccessful = false;
        $this->PaymentId = "";
        $this->PaymentRequestId = "";
        $this->Status = "";
        $this->Transactions = array();
    }
    
    public function fromJson($json)
    {
        if (!empty($json)) {
            parent::fromJson($json);

            $this->IsSuccessful = $this->jget($json, 'IsSuccessful');
            $this->PaymentId = $this->jget($json, 'PaymentId');
            $this->PaymentRequestId = $this->jget($json, 'PaymentRequestId');
            $this->Status = $this->jget($json, 'Status');

            $this->Transactions = array();

            if (!empty($json['Transactions'])) {
                foreach ($json['Transactions'] as $key => $value) {
                    $tr = new TransactionResponseModel();
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