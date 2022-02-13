<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Services\PaymentService as ServicesPaymentService;
use Illuminate\Http\Request;
class PaymentController extends Controller {
    public $Payment_service;

    public function __construct() {
       $this->Payment_service = new ServicesPaymentService();
    }

    /**
     * the main index rendered every time user try to access
     */
    public function processPayment($price) {
        $netAmount = $this->Payment_service->setProductPrice($price)->calculateAmount();
        return $netAmount;
    }
}
