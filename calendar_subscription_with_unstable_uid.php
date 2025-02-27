<?php

declare(strict_types=1);

use Sabre\VObject\Component\VCalendar;
use Sabre\VObject\Component\VEvent;

require __DIR__ . '/vendor/autoload.php';

$today = new DateTime();
$today->setTime(14, 00, 00);

$vcalendar = new VCalendar();

for ($i = 1; $i <= 10000; $i++) {
    $today->add(new DateInterval('P1D'));

    /** @var VEvent $vevent */
    $vevent = $vcalendar->create('VEVENT');
    $vevent->__set('SUMMARY', 'Test Event ' . $i);
    $vevent->__set('DTSTAMP', $today);
    $vevent->__set('DTSTART', $today);

    $vcalendar->add($vevent);
}

$result = $vcalendar->serialize();

if (PHP_SAPI !== 'cli') {
    header('Content-Type: text/calendar');
    header('Content-Length: ' . strlen($result));
}

echo $result;
