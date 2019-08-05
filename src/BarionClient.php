<?php

/*
*  
*  BarionClient.php
*  PHP library for implementing REST API calls towards the Barion payment system.  
*  
*/
namespace Barion;

use Barion\models\PreparePaymentRequestModel;
use Barion\models\PreparePaymentResponseModel;
use Barion\models\FinishReservationRequestModel;
use Barion\models\FinishReservationResponseModel;
use Barion\models\RefundRequestModel;
use Barion\models\RefundResponseModel;
use Barion\models\PaymentStateRequestModel;
use Barion\models\PaymentStateResponseModel;
use Barion\models\PaymentQRRequestModel;

use Barion\common\BarionEnvironment;
use Barion\common\FundingSourceType;
use Barion\common\PaymentStatus;
use Barion\common\PaymentType;
use Barion\common\QRCodeSize;
use Barion\common\RecurrenceResult;
use Barion\common\UILocale;

DEFINE("BARION_API_URL_PROD", "https://api.barion.com/");
DEFINE("BARION_WEB_URL_PROD", "https://secure.barion.com/Pay");
DEFINE("BARION_API_URL_TEST", "https://api.test.barion.com/");
DEFINE("BARION_WEB_URL_TEST", "https://secure.test.barion.com/Pay");

DEFINE("API_ENDPOINT_PREPAREPAYMENT", "/Payment/Start");
DEFINE("API_ENDPOINT_PAYMENTSTATE", "/Payment/GetPaymentState");
DEFINE("API_ENDPOINT_QRCODE", "/QR/Generate");
DEFINE("API_ENDPOINT_REFUND", "/Payment/Refund");
DEFINE("API_ENDPOINT_FINISHRESERVATION", "/Payment/FinishReservation");

DEFINE("PAYMENT_URL", "/Pay");

class BarionClient
{
    private $POSId;
    private $UserName;
    private $Password;
    private $APIVersion;
    private $POSKey;

    private $BARION_API_URL = "";
    private $BARION_WEB_URL = "";

    function __construct($poskey, $version = 2, $env = BarionEnvironment::Prod)
    {
        $this->POSKey = $poskey;
        $this->APIVersion = $version;
        switch ($env) {
            
            case BarionEnvironment::Test:
            $this->BARION_API_URL = BARION_API_URL_TEST;
            $this->BARION_WEB_URL = BARION_WEB_URL_TEST;
            break;
            
            case BarionEnvironment::Prod:
            default:
            $this->BARION_API_URL = BARION_API_URL_PROD;
            $this->BARION_WEB_URL = BARION_WEB_URL_PROD;
            break;
        }
    }
    
    /* -------- BARION API CALL IMPLEMENTATIONS -------- */

    /* 
    *  Prepare a new payment 
    */
    public function PreparePayment(PreparePaymentRequestModel $model)
    {
        $model->POSKey = $this->POSKey;
        $url = $this->BARION_API_URL . "/v" . $this->APIVersion . API_ENDPOINT_PREPAREPAYMENT;
        $response = $this->PostToBarion($url, $model);
        $rm = new PreparePaymentResponseModel();
        if (!empty($response)) {
            $json = json_decode($response, true);
            $rm->fromJson($json);
            $rm->PaymentRedirectUrl = $this->BARION_WEB_URL . "?" . http_build_query(array("id" => $rm->PaymentId));
        }
        return $rm;
    }

    /* 
    *  Finish an existing reservation 
    */
    public function FinishReservation(FinishReservationRequestModel $model)
    {
        $model->POSKey = $this->POSKey;
        $url = $this->BARION_API_URL . "/v" . $this->APIVersion . API_ENDPOINT_FINISHRESERVATION;
        $response = $this->PostToBarion($url, $model);
        $rm = new FinishReservationResponseModel();
        if (!empty($response)) {
            $json = json_decode($response, true);
            $rm->fromJson($json);
        }
        return $rm;
    }

    /* 
    *  Refund a payment partially or totally
    */
    public function RefundPayment(RefundRequestModel $model)
    {
        $model->POSKey = $this->POSKey;
        $url = $this->BARION_API_URL . "/v" . $this->APIVersion . API_ENDPOINT_REFUND;
        $response = $this->PostToBarion($url, $model);
        $rm = new RefundResponseModel();
        if (!empty($response)) {
            $json = json_decode($response, true);
            $rm->fromJson($json);
        }
        return $rm;
    }

    /* 
    *  Get detailed information about a given payment 
    */
    public function GetPaymentState($paymentId)
    {
        $model = new PaymentStateRequestModel($paymentId);
        $model->POSKey = $this->POSKey;
        $url = $this->BARION_API_URL . "/v" . $this->APIVersion . API_ENDPOINT_PAYMENTSTATE;
        $response = $this->GetFromBarion($url, $model);
        $ps = new PaymentStateResponseModel();
        if (!empty($response)) {
            $json = json_decode($response, true);
            $ps->fromJson($json);
        }
        return $ps;
    }

    /* 
    *  Get the QR code image for a given payment 
    *  NOTE: This call is deprecated and is only working with username & password authentication.
    *  If no username and/or password was set, this method returns NULL.
    */
    public function GetPaymentQRImage($username, $password, $paymentId, $qrCodeSize = QRCodeSize::Large) {
        $model = new PaymentQRRequestModel($paymentId);
        $model->POSKey = $this->POSKey;
        $model->Username = $username;
        $model->Password = $password;
        $model->Size = $qrCodeSize;
        $url = $this->BARION_API_URL . API_ENDPOINT_QRCODE;
        $response = $this->GetFromBarion($url, $model);
        return $response;
    }
    
    /* -------- CURL HTTP REQUEST IMPLEMENTATIONS -------- */

    /* 
    *  Managing HTTP POST requests 
    */
    private function PostToBarion($url, $data)
    {
        $ch = curl_init();

        $postData = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    /* 
    *  Managing HTTP GET requests 
    */
    private function GetFromBarion($url, $data)
    {
        $ch = curl_init();

        $getData = http_build_query($data);
        $fullUrl = $url . '?' . $getData;

        curl_setopt_array($ch, array(
            CURLOPT_URL => $fullUrl,
            CURLOPT_CAPATH => ".",
            CURLOPT_RETURNTRANSFER => true
        ));

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }
}

?>