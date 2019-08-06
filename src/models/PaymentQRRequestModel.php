<?php
namespace zoge\barion\models;

use zoge\barion\models\BaseRequestModel;

use zoge\barion\common\QRCodeSize;

class PaymentQRRequestModel extends BaseRequestModel
{
    public $PaymentId;
    public $Size;
    
    function __construct($paymentId)
    {
        $this->PaymentId = $paymentId;
        $this->Size = QRCodeSize::Normal;
    }
}

?>