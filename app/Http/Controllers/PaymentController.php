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
     * the main index rendered every time user try to access
     */
    public function ProcessPayment() {
       $netAmount = $this->Payment_service->setProductPrice(1600)->calculateAmount();
       $view_report = [
          'Provided_price' => $this->Payment_service->product_price,
          'VAT_value' => $this->Payment_service->vat,
          'coupon_value' => $this->Payment_service->coupon_rate,
          'Discout_value' => $this->Payment_service->discount_rate,
          'Transaction_fees' => $this->Payment_service->transaction_fees,
          'Product Net Amount' => round($netAmount),
       ];
       dd($view_report);
    }
}
