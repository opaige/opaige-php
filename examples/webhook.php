<?php
// Verifying a webhook, offline: signs a sample delivery with a test secret, then checks it the way your endpoint will.
//   php examples/webhook.php
require __DIR__ . '/../vendor/autoload.php';

use Opaige\Webhook;

$secret = 'whsec_example_only';
$raw = json_encode(['event' => 'lodgement.updated', 'data' => ['lodgement_id' => 'lg_example', 'status' => 'submitted']]);
$t = time();
$signature = "t={$t},v1=" . hash_hmac('sha256', "{$t}.{$raw}", $secret);

$event = Webhook::verify($raw, $signature, $secret); // pass the RAW body, exactly as received
echo "Verified: {$event['event']} {$event['data']['status']}\n";

try {
    Webhook::verify(str_replace('submitted', 'changed', $raw), $signature, $secret);
} catch (Throwable $e) {
    echo "A changed body is refused: {$e->getMessage()}\n";
}
