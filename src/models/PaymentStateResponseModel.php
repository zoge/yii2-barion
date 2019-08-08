<?php
namespace zoge\barion\models;
use zoge\barion\models\BaseResponseModel;
use zoge\barion\helpers\iBarionModel;

/**
 * Copyright 2016 Barion Payment Inc. All Rights Reserved.
 * <p/>
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * <p/>
 * http://www.apache.org/licenses/LICENSE-2.0
 * <p/>
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
class PaymentStateResponseModel extends BaseResponseModel implements iBarionModel
{
    public $PaymentId;
    public $PaymentRequestId;
    public $OrderNumber;
    public $POSId;
    public $POSName;
    public $POSOwnerEmail;
    public $Status;
    public $PaymentType;
    public $FundingSource;
    public $FundingInformation;
    public $AllowedFundingSources;
    public $GuestCheckout;
    public $CreatedAt;
    public $ValidUntil;
    public $CompletedAt;
    public $ReservedUntil;
    public $Total;
    public $Currency;
    public $Transactions;
    public $RecurrenceResult;
    public $SuggestedLocale;
    public $FraudRiskScore;
    public $RedirectUrl;
    public $CallbackUrl;

    function __construct()
    {
        parent::__construct();
        $this->PaymentId = "";
        $this->PaymentRequestId = "";
        $this->OrderNumber = "";
        $this->POSId = "";
        $this->POSName = "";
        $this->POSOwnerEmail = "";
        $this->Status = "";
        $this->PaymentType = "";
        $this->FundingSource = "";
        $this->FundingInformation = new FundingInformationModel();
        $this->AllowedFundingSources = "";
        $this->GuestCheckout = "";
        $this->CreatedAt = "";
        $this->ValidUntil = "";
        $this->CompletedAt = "";
        $this->ReservedUntil = "";
        $this->Total = 0;
        $this->Currency = "";
        $this->Transactions = array();
        $this->RecurrenceResult = "";
        $this->SuggestedLocale ="";
        $this->FraudRiskScore = 0;
        $this->RedirectUrl = "";
        $this->CallbackUrl = "";
    }

    public function fromJson($json)
    {
        if (!empty($json)) {
            parent::fromJson($json);

            $this->PaymentId = BarionHelper::jget($json, 'PaymentId');
            $this->PaymentRequestId = BarionHelper::jget($json, 'PaymentRequestId');
            $this->OrderNumber = BarionHelper::jget($json, 'OrderNumber');
            $this->POSId = BarionHelper::jget($json, 'POSId');
            $this->POSName = BarionHelper::jget($json, 'POSName');
            $this->POSOwnerEmail = BarionHelper::jget($json, 'POSOwnerEmail');
            $this->Status = BarionHelper::jget($json, 'Status');
            $this->PaymentType = BarionHelper::jget($json, 'PaymentType');
            $this->FundingSource = BarionHelper::jget($json, 'FundingSource');
            if(!empty($json['FundingInformation'])) {
                $this->FundingInformation = new FundingInformationModel();
                $this->FundingInformation->fromJson(BarionHelper::jget($json, 'FundingInformation'));
            }
            $this->AllowedFundingSources = BarionHelper::jget($json, 'AllowedFundingSources');
            $this->GuestCheckout = BarionHelper::jget($json, 'GuestCheckout');
            $this->CreatedAt = BarionHelper::jget($json, 'CreatedAt');
            $this->ValidUntil = BarionHelper::jget($json, 'ValidUntil');
            $this->CompletedAt = BarionHelper::jget($json, 'CompletedAt');
            $this->ReservedUntil = BarionHelper::jget($json, 'ReservedUntil');
            $this->Total = BarionHelper::jget($json, 'Total');
            $this->Currency = BarionHelper::jget($json, 'Currency');
            $this->RecurrenceResult = BarionHelper::jget($json, 'RecurrenceResult');
            $this->SuggestedLocale = BarionHelper::jget($json, 'SuggestedLocale');
            $this->FraudRiskScore = BarionHelper::jget($json, 'FraudRiskScore');
            $this->RedirectUrl = BarionHelper::jget($json, 'RedirectUrl');
            $this->CallbackUrl = BarionHelper::jget($json, 'CallbackUrl');

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
}