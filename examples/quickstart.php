<?php
// Quickstart: three calls, nothing saved, nothing billed.
//   composer require opaige/opaige-php
//   php examples/quickstart.php
// Uses the public test key unless OPAIGE_KEY is set. Fictional passengers only.
require __DIR__ . '/../vendor/autoload.php';

use Opaige\Opaige;
use Opaige\OpaigeException;

$opaige = new Opaige(getenv('OPAIGE_KEY') ?: 'opco_public_test_key');

// 1. What does a Nigerian passport need for a visit to Germany?
$answer = $opaige->checkRequirements(passport: 'NG', destination: 'DE');
echo "NG -> DE: {$answer['visa']['level']}. {$answer['visa']['reason']}\n";

// 2. Who on this flight needs a visa, and by when to file?
$check = $opaige->checkPassengers(body: [
    'flight' => ['destination' => 'GB', 'depart_date' => '2027-03-12'],
    'passengers' => [['ref' => '14A', 'passport' => 'CN'], ['ref' => '14B', 'passport' => 'IE']],
]);
foreach ($check['passengers'] as $p) {
    echo "Seat {$p['ref']} ({$p['passport']}): {$p['status']}\n";
}

// 3. Errors carry a status, a code to branch on, and a request id to quote to support.
try {
    $opaige->createTrip(body: []); // the public test key may not plan trips
} catch (OpaigeException $e) {
    echo "Refused as expected: {$e->status} {$e->errorCode} ({$e->getMessage()}) request {$e->requestId}\n";
}
