<?php
    namespace App\Services;
    class PaymentService {
        public $transaction_fees;
        public $coupon_rate;
        public $discount_rate;
        public $vat;
        public $product_price;
        public $amount;

        public function __construct() {
            $this->transaction_fees = config('Payment.transaction_fees');
            $this->coupon_rate = config('Payment.coupon');
            $this->discount_rate = config('Payment.discount');
            $this->vat = config('Payment.VAT');
        }

        public function setProductPrice($product_price){
            $this->product_price = $product_price;
            return $this;
        }

        public function calculateVAT(){
            if($this->vat){
                $this->amount += ($this->amount * $this->vat);
            }
            return $this;
        }

        public function calculateCoupon($product_price){
            if(!$this->coupon_rate['enabled']) return $product_price;
            return $product_price - ($product_price * $this->coupon_rate['value']);
        }

        public function calculateNetAmmount(){
            $this->amount = $this->calculateCoupon($this->product_price);
            $this->applyTransactionFees()->calculateDiscount();
            $this->calculateVAT();
            return $this->amount;
        }

        public function applyTransactionFees(){
            $this->amount += $this->transaction_fees;
            return $this;
        }

        public function calculateDiscount(){
            $this->amount -= ($this->amount * $this->discount_rate['value']);
            return $this;
        }
    }
