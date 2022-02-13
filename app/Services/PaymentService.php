<?php
    namespace App\Services;
    use App\Services\LoyaltyService;

    class PaymentService {
        public $transaction_fees; // transaction fees (each transaction)
        public $coupon_rate; // coupon rate as 2%
        public $discount_rate; // membership discount rate as 3%
        public $vat;  // the VAT of product price as 18%
        public $product_price; // a given price
        public $amount; // the net amount after all calculation
        public $Loyalty_service;
        public $points;

        public function __construct() {
            $this->transaction_fees = config('Payment.transaction_fees');
            $this->coupon_rate = config('Payment.coupon');
            $this->discount_rate = config('Payment.discount');
            $this->vat = config('Payment.VAT');
            $this->Loyalty_service = new LoyaltyService();
        }

        /**
         * set the product price (given)
         */
        public function setProductPrice($product_price){
            $this->product_price = $product_price;
            return $this;
        }

        /**
         * calculate the VAT on product price (given price)
         */
        public function calculateVAT(){
            if($this->vat){
                $this->amount += ($this->amount * $this->vat);
            }
            return $this;
        }

        /**
         * calculate the coupon of the given price
         */
        public function calculateCoupon($product_price){
            if(!$this->coupon_rate['enabled']) return $product_price;
            return $product_price - ($product_price * $this->coupon_rate['value']);
        }

        /**
         * calculate the net ammount of product price
         * where every required fees removed
         */
        public function calculateAmount(){
            $this->amount = $this->calculateCoupon($this->product_price);
            $this->applyTransactionFees();
            $this->calculateDiscount();
            $this->calculateVAT();
            $this->points = $this->Loyalty_service->setRequiredScope()
                           ->setUserPoints($this->product_price)
                           ->saveUserPoint();
            $total_point_amount = $this->Loyalty_service->totalLoyaltyAmount($this->points);
            return ['net_amount' => $this->amount, 'earned_point' => $this->points, 'earned_amount' => $total_point_amount];
        }

        /**
         * apply transaction fees on each transaction
         */
        public function applyTransactionFees(){
            $this->amount += $this->transaction_fees;
            return $this;
        }

        /**
         * calculate the discount of product price (if user exist in membership storage)
         */
        public function calculateDiscount(){
            $this->amount -= ($this->amount * $this->discount_rate['value']);
            return $this;
        }
    }
