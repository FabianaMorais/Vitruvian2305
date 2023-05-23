<?php

namespace App\ServerTools\ChartPointClasses;

use App\ServerTools\ChartPointClasses\SimpleChartPoint;


class StatisticsChartPoint
{

    private $min;
    private $max;
    private $avg;
    private $timestamp;

    public function __construct($min,$max,$avg,$timestamp){
        $this->min = $min;
        $this->max = $max;
        $this->avg = $avg;
        $this->timestamp = $timestamp;
    }

    //TODO: add a function to get 3 streams of data with x and y points , 1 stream for min, 1 mor max, 1 for avg
    public function getMin(){
        return $this->min;
    }

    public function getMax(){
        return $this->max;
    }

    public function getAvg(){
        return $this->avg;
    }

    public function getTimestamp(){
        return $this->timestamp;
    }

    public function setMin($min){
        $this->min = $min;
    }

    public function setMax($max){
        $this->max = $max;
    }

    public function setAvg($avg){
        $this->avg = $avg;
    }

    public function setTimestamp($timestamp){
        $this->timestamp = $timestamp;
    }

    public function getSimpleChartPointForMin(){
        return new SimpleChartPoint($timestamp,$min);
    }

    public function getSimpleChartPointForMax(){
        return new SimpleChartPoint($timestamp,$max);
    }
    public function getSimpleChartPointForAvg(){
        return new SimpleChartPoint($timestamp,$avg);
    }
}

