<?php
namespace zoge\barion\models;
use zoge\barion\models\BaseRequestModel;

class PaymentStateRequestModel extends BaseRequestModel
{
    public $PaymentId;

    function __construct($paymentId)
    {
        $this->PaymentId = $paymentId;
    }
}

?>