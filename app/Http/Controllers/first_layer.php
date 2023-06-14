<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class first_layer extends Controller
{
    //Key value pair of profit and loss
    private $day_profit_loss  = [];

    private $total_profit = 0;
    private $max_profit = PHP_INT_MIN;
    private $max_loss = PHP_INT_MAX;
    private $total_days = 0;

    public function __construct(){
        //fills the day profit after fetching the data
        $this->$total_days=count($this->$day_profit_loss);
        foreach($this->$day_profit_loss as $key=>$value){
            if($value>0)
                $this->$total_profit+=$value;
        }
    }
    function formula_1(){
    }


    //Formula 2
    function avg_day_profit(){
        $total_profit = $this->$total_profit;
        $total_days = $this->$total_days;
        $final_value = $total_profit/$total_days;
        return final_value;
    }

    //formula 3
    function max_profit(){
        foreach($this->$day_profit_loss as $key=>$value){
            if($value>$this->$max_profit)
                $this->$max_profit = $value;
        }
        return $this->$max_profit;
    }

    //formula 4
    function max_loss(){
        foreach($this->$day_profit_loss as $key=>$value){
            if($value<$this->$max_loss)
                $this->$max_profit = $value;
        }
        return $this->$max_loss;
    }

    //formula 5
    function win_percent_days(){
        $count =0;
        foreach($this->$day_profit_loss as $key=>$value){
            if($value > 0)
                $count++;
        }

        return ($count/$this->$total_days)*100;
    }

    //formula 6
    function loss_percent_days(){
        $count =0;
        foreach($this->$day_profit_loss as $key=>$value){
            if($value < 0)
                $count++;
        }

        return ($count/$this->$total_days)*100;
    }

    //formula 7
    function avg_monthly_profit(){
        return avg_day_profit()*30;
    }

    //formula 8
    function avg_profit_on_win_days(){
        $profit_sum=0;
        foreach($this->$day_profit_loss as $key=>$value){
            if($value > 0)
                $profit_sum+=$value;
        }
        return ($profit_sum/$this->win_percent_days());
    }

    //formula 9
    function avg_loss_On_loss_days(){
        $loss_sum=0;
        foreach($this->$day_profit_loss as $key=>$value){
            if($value < 0)
                $loss_sum+=$value;
        }
        return ($loss_sum/$this->loss_percent_days());
    }

    //formula 10
    function mdd(){
        //compare all high with lows after them
        //max diff will be the mdd head
        //return max diff/peak * 100
    }


    function mdd_recovery(){
        $total_loss_by_mdd = $loss_under_mdd;
        /* loop after mdd
            $total_loss_by_mdd-=$value
            count++;
        if(total_loss_by_mdd<=0){
            break
        }*/
        return $count;
    }


}
