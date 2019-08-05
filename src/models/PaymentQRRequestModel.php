<?php
namespace Barion\models;

use Barion\models\BaseRequestModel;

use Barion\common\QRCodeSize;

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