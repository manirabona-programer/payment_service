<?php
    namespace App\Services;

use App\Models\Config;
use App\Models\Loyalty;

class LoyaltyService {
        public $points = 2; // initial points
        public $singlePointAmount; // single point amount
        public $checkPoint; // setted point default = 10
        public $checkPointAmount; // the amount of setted point default = 20000
        public $configs;

        public function setRequiredScope(){
            $this->configs = Config::all();
            $this->singlePointAmount = $this->configs->loyalty_single_point_amount;
            $this->checkPoint = $this->configs->loyalty_check_point;
            $this->checkPointAmount = $this->configs->loyalty_check_point_amount;
            return $this;
        }

        public function setUserPoints($price){
            if($price >= $this->singlePointAmount){
               $this->points += 1;
               return $this->point;
            }
            return $this;
        }

        public function saveUserPoint(){
            Loyalty::create(['user_id' => 1, 'points' => $this->points ]);
            return $this->points;
        }

        public function totalLoyaltyAmount($points){
            if($points == 0){
                $loyalty_point_amount = 0;
                return $loyalty_point_amount;
            }else if($points < 10){
                $loyalty_point_amount = 0;
                return $loyalty_point_amount;
            }else{
                if($points >= $this->checkPoint){
                    $loyalty_point_amount = 0;
                    $checkLimit = 0;
                    foreach(range(0, $points) as $number){
                        $checkLimit += 1;
                        if($checkLimit == 10){
                            $loyalty_point_amount += $this->checkPointAmount;
                            $checkLimit = 0;
                        }
                    }
                    return $loyalty_point_amount;
                }
            }
        }
    }
