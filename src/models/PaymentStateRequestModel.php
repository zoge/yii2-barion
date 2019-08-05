<?php
namespace Barion\models;
use Barion\models\BaseRequestModel;

class PaymentStateRequestModel extends BaseRequestModel
{
    public $PaymentId;

    function __construct($paymentId)
    {
        $this->PaymentId = $paymentId;
    }
}

?>