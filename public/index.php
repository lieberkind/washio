<?php
    require '../vendor/autoload.php';

    $number17 = new Washio\Laundromat('http://93.163.25.78', 'Nr. 17');
    $number25 = new Washio\Laundromat('http://93.163.45.78', 'Nr. 25');

    // Get the login credentials from the environment variables
    $nr17Username = getenv('NR_17_USERNAME');
    $nr17Password = getenv('NR_17_PASSWORD');
    $nr25Username = getenv('NR_25_USERNAME');
    $nr25Password = getenv('NR_25_PASSWORD');

    $number17->login($nr17Username, $nr17Password);
    $number25->login($nr25Username, $nr25Password);

    $times17 = $number17->getOwnWashingTimes();
    $times25 = $number25->getOwnWashingTimes();

    $times = array_merge($times17, $times25);

    // Sort the washing times so they appear in ascending order
    usort($times, function($time1, $time2) {
        return $time1->getTime() > $time2->getTime();
    });

    include '../views/index.php';
?>
