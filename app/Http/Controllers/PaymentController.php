<?php

namespace App\Http\Controllers;

use App\Services\PaymentService as ServicesPaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public $Payment_service;

    public function __construct() {
       $this->Payment_service = new ServicesPaymentService();
    }

    /**
     * the main index rendered every time user try to access the
     * system
     */
    public function ProcessPayment() {
       $netAmount = $this->Payment_service->setProductPrice(1600)->calculateNetAmmount();
       dd($netAmount);
    }
}
