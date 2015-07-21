<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
    $number17 = new Washio\Laundromat('http://93.163.25.78', 'Nr. 17');
    $number25 = new Washio\Laundromat('http://93.163.45.78', 'Nr. 25');

    $nr17Username = env('NR_17_USERNAME');
    $nr17Password = env('NR_17_PASSWORD');
    $nr25Username = env('NR_25_USERNAME');
    $nr25Password = env('NR_25_PASSWORD');

    $number17->login($nr17Username, $nr17Password);
    $number25->login($nr25Username, $nr25Password);

    $times17 = $number17->getOwnWashingTimes();
    $times25 = $number25->getOwnWashingTimes();

    $number17AvailableTimes = $number17->getNextAvailableTimes();
    $number25AvailableTimes = $number25->getNextAvailableTimes();

    $times = array_merge($times17, $times25);
    $availableTimes = array_merge($number17AvailableTimes, $number25AvailableTimes);

    // Sort the washing times so they appear in ascending order
    usort($times, function($time1, $time2) {
        return $time1->getTime() > $time2->getTime();
    });

    // Sort the next available washing times so they appear in ascending order
    usort($availableTimes, function($time1, $time2) {
        return $time1->getTime() > $time2->getTime();
    });

    return view('index', [
        'times'             => $times,
        'availableTimes'    => $availableTimes
    ]);
});
