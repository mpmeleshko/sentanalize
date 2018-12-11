<?php

namespace App\Services;

use Charts;

class ReviewsChart
{
    /**
     * @param $reviews
     * @return mixed
     */
    public function makeDonutChart($reviews)
    {
//        foreach ($reviews as $review) {
//            if ($review->review != null) {
//                $this->reviews[] = $result;
//            }
//        }

        $chart = Charts::create('donut', 'highcharts')
            ->title('Анализ отзывов')
            ->labels(['Позитивные', 'Негавные'])
            ->values([6,6])
            ->responsive(false);

        return $chart;
    }
}