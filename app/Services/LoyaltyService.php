<?php
    namespace App\Services;

use App\Models\Config;
use App\Models\Loyalty;
use Illuminate\Support\Facades\Auth;

class LoyaltyService {
    public $points; // initial points
    public $singlePointAmount; // single point amount
    public $checkPoint; // setted point default = 10
    public $checkPointAmount; // the amount of setted point default = 20000

    public function __construct(){
        $this->singlePointAmount = Config::where('name','loyalty_single_point_amount')->pluck('value')->first();
        $this->checkPoint = Config::where('name','loyalty_check_point')->pluck('value')->first();
        $this->checkPointAmount = Config::where('name','loyalty_check_point_amount')->pluck('value')->first();
        $this->points = Auth::user()->royalty_points;
    }

    /**
     * set and save user point
     * @param $price
     */
    public function setUserPoints($price){
        if($price >= $this->singlePointAmount){
            $this->points += 1;
            return $this->point;
        }
        $this->saveUserLoyaltyPoint();
        return $this;
    }

    /**
     * save user points in DB
     */
    public function saveUserLoyaltyPoint(){
        Auth::user()->update(['royalty_points' => $this->points]);
        return $this;
    }

    /**
     * calculate user's point and return the amount based on points
     * over 10 point
     */
    public function totalUserLoyaltyAmount($points){
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
