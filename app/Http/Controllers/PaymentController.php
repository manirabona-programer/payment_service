<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Models\Product;

class PaymentController extends Controller {
    public $Payment_service;

    public function __construct() {
       $this->Payment_service = new PaymentService();
    }

    /**
     * calculate net amount of given price
     * and make or not a loyalty point
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function processPayment(Product $product) {
        $netAmount = $this->Payment_service->setProductPrice($product->price)->calculateAmount();
        return redirect()->route('products.show', $product->id)->with("success", "Product ({$product->name}) paid successfully");
    }
}
