<?php

namespace App\Http\Controllers;
use App\Http\Controllers\first_layer;
use Illuminate\Http\Request;
use DB;
class zero_layer extends Controller
{
    function generateDateRange($startDate, $endDate)
        {
            $dates = [];

            $currentDate = new DateTime($startDate);
            $endDate = new DateTime($endDate);

            while ($currentDate <= $endDate) {
                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->modify('+1 day');
            }

            return $dates;
        }
    function isTimeBetween($givenTime, $startTime, $endTime)
    {
        // Convert time strings to DateTime objects
        $givenDateTime = \DateTime::createFromFormat('H:i', $givenTime);
        $startDateTime = \DateTime::createFromFormat('H:i', $startTime);
        $endDateTime = \DateTime::createFromFormat('H:i', $endTime);

        // Check if the given time is between the start and end times
        return $givenDateTime >= $startDateTime && $givenDateTime <= $endDateTime;
    }

    function manipulateTime($timeInSeconds, $minutes)
        {
            // Convert seconds to minutes
            $totalMinutes = $timeInSeconds / 60;

            // Perform addition
            $addedMinutes = $totalMinutes + $minutes;
            $addedTimeInSeconds = $addedMinutes * 60;
            $addedTime = gmdate('H:i:s', $addedTimeInSeconds);

            // Perform subtraction
            $subtractedMinutes = $totalMinutes - $minutes;
            $subtractedTimeInSeconds = $subtractedMinutes * 60;
            $subtractedTime = gmdate('H:i:s', $subtractedTimeInSeconds);

            // Return the results
            return [
                'added_time' => $addedTime,
                'subtracted_time' => $subtractedTime,
            ];
        }

    function splitDateTime($dateTime)
    {
        $date = date('Y-m-d', strtotime($dateTime));
        $time = date('H:i:s', strtotime($dateTime));

        return compact('date', 'time');
    }
    function findLongestAndSmallestTime($date, $times)
{
    $registeredTimes = [];

    // Filter and collect the times for the given date
    foreach ($times as $time) {
        if (substr($time, 0, 10) === $date) {
            $registeredTimes[] = substr($time, 11);
        }
    }

    if (empty($registeredTimes)) {
        return ['longest' => null, 'smallest' => null];
    }

    $longestTime = max($registeredTimes);
    $smallestTime = min($registeredTimes);

    return ['longest' => $longestTime, 'smallest' => $smallestTime];
}
    function calculate(){
        $obj = app()->make(first_layer::class);

        $entry = '09:13:46';
        $exit = '09:13:46';

        $start = '2023-06-14';
        $Begin= $this->splitDateTime($start);
        $Begin_open = $this->manipulateTime($entry,5);

        $end = '2023-06-16';
        $end_open = $this->manipulateTime($exit,5);
        $ending= $this->splitDateTime($end);

        $range_date = $this->generateDateRange($start,$end);

        $price = 18600.00;
        $expiry = '2023-08-31';
        $option_type = 'CE';

        $data = $this->fetch_data($start,$end,$entry,$exit,$price,$expiry,$option_type,$range_date);
        $obj->setter($data);
        print_r($obj->avg_day_profit().'\n');
        print_r($obj->max_profit().'\n');
        print_r($obj->max_loss().'\n');
    }

    function fetch_data($start,$end,$entry,$exit,$price,$expiry,$option_type,$range_date){

    foreach($range_date as $date){
        $open =0;
        $close =0;
        $data=DB::table('option_chain')->select('created_at','last_price')->whereDate('created_at','=',$date)->where('strike_price','=',$price)->where('expiry_date','=',$expiry)->where('option_type','=','CE')->get();
        $data
    }

    }
}
