<?php
namespace zoge\barion\models;

use zoge\barion\models\BaseRequestModel;
use zoge\barion\models\TransactionToRefundModel;

class RefundRequestModel extends BaseRequestModel
{
    public $PaymentId;
    public $TransactionsToRefund;

    function __construct($paymentId)
    {
        $this->PaymentId = $paymentId;
    }

    public function AddTransaction(TransactionToRefundModel $transaction)
    {
        if ($this->TransactionsToRefund == null) {
            $this->TransactionsToRefund = array();
        }
        array_push($this->TransactionsToRefund, $transaction);
    }
    
    public function AddTransactions($transactions){
        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
              if ($transaction instanceof TransactionToRefundModel) {
                $this->AddTransaction($transaction);
              }
            }
        }
    }
    
}

?>