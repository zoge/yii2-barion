<?php
namespace Barion\models;

use Barion\models\BaseResponseModel;
use Barion\models\TransactionResponseModel;

use Barion\helpers\iBarionModel;

class PreparePaymentResponseModel extends BaseResponseModel implements iBarionModel
{
    public $PaymentId;
    public $PaymentRequestId;
    public $Status;
    public $Transactions;
    public $QRUrl;
    public $RecurrenceResult;
    public $PaymentRedirectUrl;

    function __construct()
    {
        parent::__construct();
        $this->PaymentId = "";
        $this->PaymentRequestId = "";
        $this->Status = "";
        $this->QRUrl = "";
        $this->RecurrenceResult = "";
        $this->PaymentRedirectUrl = "";
        $this->Transactions = array();
    }

    public function fromJson($json)
    {
        if (!empty($json)) {
            parent::fromJson($json);
            $this->PaymentId = $json['PaymentId'];
            $this->PaymentRequestId = $json['PaymentRequestId'];
            $this->Status = $json['Status'];
            $this->QRUrl = $json['QRUrl'];
            $this->RecurrenceResult = $json['RecurrenceResult'];
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
}

?>