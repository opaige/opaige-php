# Opaige for PHP

The Opaige API from PHP 8.1 or later. Needs only the curl and json extensions.

```bash
composer require opaige/opaige-php
```

```php
use Opaige\Opaige;
use Opaige\OpaigeException;

$opaige = new Opaige(getenv('OPAIGE_KEY'));

$answer = $opaige->checkRequirements(passport: 'IN', destination: 'FR');

$opaige->sendBookings(body: ['bookings' => [[
    'ref' => 'QX7K2M',
    'flight' => ['number' => 'OP412', 'destination' => 'GB', 'depart_date' => '2026-12-18'],
    'passengers' => [['ref' => 'QX7K2M-1', 'passport' => 'IN', 'residence' => 'AE']],
]]]);

$review = $opaige->reviewFile(file: file_get_contents('file.pdf'), fields: ['destination' => 'FR', 'purpose' => 'business'], idempotencyKey: 'file-8841');
```

Every method is one API call, named as in the [API reference](https://opaige.com/developers), with named arguments. JSON goes in
`body` as an array; a PDF comes back as a string of bytes.

**Errors** throw `OpaigeException` with `status`, `errorCode`, `requestId` (quote it to support) and `details`.
**Retries:** reads, and writes sent with an `idempotencyKey`, are tried again after 429 and 5xx answers.
**Sandbox:** a sandbox key answers in the same shape, is never billed and never touches live data. Bookings, students and appointments it sends are kept as test data.

## Webhooks

```php
$event = Opaige\Webhook::verify(file_get_contents('php://input'), $_SERVER['HTTP_OPAIGE_SIGNATURE'] ?? null, getenv('OPAIGE_WEBHOOK_SECRET'));
```

Pass the raw body: a parsed and re-encoded body no longer matches its signature.
