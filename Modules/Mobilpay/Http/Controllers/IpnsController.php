<?php

namespace Modules\Mobilpay\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Netopia\Payment\Address;
use Netopia\Payment\Invoice;
use Netopia\Payment\Request\Card;
use Netopia\Payment\Request\Notify;
use Netopia\Payment\Request\PaymentAbstract;

class IpnsController extends Controller
{
    public $errorCode;
    public $errorType;
    public $errorMessage;
    public $paymentUrl;
    public $x509FilePath;

    public function confirm()
    {
        dd('confirm');
    }

    public function return(Request $request)
    {
        try {
            $env = $request->env;
            $data = $request->data;
            $this->paymentUrl = 'http://sandboxsecure.mobilpay.ro';
            $this->x509FilePath = 'C:\\laragonOffice\\www\\373_infixlms_opt\\public\\mobilpay\\sandbox.6RFP-7XUS-DFSW-RXHH-W9QHprivate.key';

            $paymentRequestIpn = PaymentAbstract::factoryFromEncrypted($env, $data, $this->x509FilePath);

            $rrn = $paymentRequestIpn->objPmNotify->rrn;

            if ($paymentRequestIpn->objPmNotify->errorCode == 0) {
                switch ($paymentRequestIpn->objPmNotify->action) {
                    case 'confirmed':
                        //update DB, SET status = "confirmed/captured"
                        $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                        break;
                    case 'confirmed_pending':
                        //update DB, SET status = "pending"
                        $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                        break;
                    case 'paid_pending':
                        //update DB, SET status = "pending"
                        $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                        break;
                    case 'paid':
                        //update DB, SET status = "open/preauthorized"
                        $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                        break;
                    case 'canceled':
                        //update DB, SET status = "canceled"
                        $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                        break;
                    case 'credit':
                        //update DB, SET status = "refunded"
                        $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                        break;
                    default:
                        $errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
                        $this->errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_ACTION;
                        $this->errorMessage = 'mobilpay_refference_action paramaters is invalid';
                }
            } else {
                //update DB, SET status = "rejected"
                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
            }
        } catch (\Exception $e) {
            $this->errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_TEMPORARY;
            $this->errorCode = $e->getCode();
            $this->errorMessage = $e->getMessage();
        }
    }

    public function index()
    {

        $this->errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_NONE;
        $this->errorCode = 0;
        $this->errorMessage = '';

        $this->paymentUrl = 'http://sandboxsecure.mobilpay.ro';
        $this->x509FilePath = '/home/certificates/sandbox.XXXX-XXXX-XXXX-XXXX-XXXXprivate.key';


        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') == 0) {
            if (isset($_POST['env_key']) && isset($_POST['data'])) {
                try {
                    $paymentRequestIpn = PaymentAbstract::factoryFromEncrypted($_POST['env_key'], $_POST['data'], $this->x509FilePath);
                    $rrn = $paymentRequestIpn->objPmNotify->rrn;
                    if ($paymentRequestIpn->objPmNotify->errorCode == 0) {
                        switch ($paymentRequestIpn->objPmNotify->action) {
                            case 'confirmed':
                                //update DB, SET status = "confirmed/captured"
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'confirmed_pending':
                                //update DB, SET status = "pending"
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'paid_pending':
                                //update DB, SET status = "pending"
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'paid':
                                //update DB, SET status = "open/preauthorized"
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'canceled':
                                //update DB, SET status = "canceled"
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'credit':
                                //update DB, SET status = "refunded"
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            default:
                                $errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
                                $this->errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_ACTION;
                                $this->errorMessage = 'mobilpay_refference_action paramaters is invalid';
                        }
                    } else {
                        //update DB, SET status = "rejected"
                        $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                    }
                } catch (\Exception $e) {
                    $this->errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_TEMPORARY;
                    $this->errorCode = $e->getCode();
                    $this->errorMessage = $e->getMessage();
                }

            } else {
                $this->errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
                $this->errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_POST_PARAMETERS;
                $this->errorMessag = 'mobilpay.ro posted invalid parameters';
            }

        } else {
            $this->errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
            $this->errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_POST_METHOD;
            $this->errorMessage = 'invalid request metod for payment confirmation';
        }

        /**
         * Communicate with NETOPIA Payments server
         */

        header('Content-type: application/xml');
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if ($this->errorCode == 0) {
            echo "<crc>{$this->errorMessage}</crc>";
        } else {
            echo "<crc error_type=\"{$this->errorType}\" error_code=\"{$this->errorCode}\">{$this->errorMessage}</crc>";
        }

    }
}
