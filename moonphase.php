<?php

// For example, if you were to load 
// /12-15-2017.png it would query: https://domain.com/moonphase.php?year=2017&month=12&day=15


// lordy https://aa.quae.nl/en/reken/hemelpositie.html

// Centralized response handling
function sendHttpResponse($code, $message = '', $contentType = 'text/plain') {
    header("HTTP/1.1 $code");
    header("Content-Type: $contentType");
    if (!empty($message)) {
        echo $message;
    }
    exit;
}

// Error logging function
function logError($message) {
    // Assuming a writable directory 'logs' exists. Adjust the path as needed.
    error_log($message . "\n", 3, __DIR__ . '/logs/error_log.txt');
}

require_once 'suncalc.php';

use AurorasLive\SunCalc;

function getMoonPhaseImage($year, $month, $day) {
    $dateString = "$year-$month-$day";
    $date = new DateTime($dateString);
    
    // Specify your latitude and longitude values
    $lat = 40.821287; // Example latitude
    $lng = -73.923168; // Example longitude

    // Create an instance of SunCalc with the date, latitude, and longitude
    $sunCalc = new SunCalc($date, $lat, $lng);

    // Calculate the moon illumination for the given date
    $moonIllumination = $sunCalc->getMoonIllumination();

    // Determine the moon phase based on the phase value
    $phase = $moonIllumination['phase'];
    if ($phase < 0.03) {
        return 'new_moon.png';
    } elseif ($phase < 0.22) {
        return 'waxing_crescent.png';
    } elseif ($phase < 0.28) {
        return 'first_quarter.png';
    } elseif ($phase < 0.47) {
        return 'waxing_gibbous.png';
    } elseif ($phase < 0.53) {
        return 'full_moon.png';
    } elseif ($phase < 0.72) {
        return 'waning_gibbous.png';
    } elseif ($phase < 0.78) {
        return 'last_quarter.png';
    } elseif ($phase < 0.97) {
        return 'waning_crescent.png';
    } else {
        return 'new_moon.png';
    }
}

$month = $_GET['month'] ?? null;
$day = $_GET['day'] ?? null;
$year = $_GET['year'] ?? null;

// More robust date validation
if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', "$month-$day-$year") || !checkdate($month, $day, $year)) {
    sendHttpResponse(400, 'Invalid date provided.');
}

$moonPhaseImage = getMoonPhaseImage($year, $month, $day);
$imagePath = __DIR__ . '/moon_phases/' . $moonPhaseImage;


if (file_exists($imagePath)) {
    header('Content-Type: image/png');
    // Set cache control: max-age is in seconds (example here is for one year)
    header('Cache-Control: public, max-age=31536000');
    // Set Expires header for 1 year in the future
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    readfile($imagePath);
} else {
    logError('Moon phase image not found for date: ' . "$year-$month-$day");
    sendHttpResponse(404, 'Moon phase image not found.');
}
