# Opaige for PHP

[![Packagist](https://img.shields.io/packagist/v/opaige/opaige-php.svg)](https://packagist.org/packages/opaige/opaige-php) [![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

The official PHP library for the [Opaige API](https://opaige.com/developers): visa rules, passenger checks, file review,
official forms and government filing. PHP 8.1 or later, with the curl and json extensions.

## Install

```bash
composer require opaige/opaige-php
```

## Quick start (no account needed)

```php
use Opaige\Opaige;

$opaige = new Opaige(getenv('OPAIGE_KEY') ?: 'opco_public_test_key');

$answer = $opaige->checkRequirements(passport: 'NG', destination: 'DE');
echo $answer['visa']['level'], ' ', $answer['visa']['reason'];
```

`opco_public_test_key` is a public test key for trying the API before you sign up: the requirements check, passenger checks,
bookings and forms, 20 calls a minute. It is never billed and keeps nothing. Two runnable examples are in [`examples/`](examples):

```bash
php examples/quickstart.php   # a requirements check, a passenger check and an error
php examples/webhook.php      # verifying a signed webhook, offline
```

## Authentication

Open an account at [opaige.com](https://opaige.com) (two minutes, no card) and create a key under **Developer**. A key is shown
once and stored only as a hash; it carries only the scopes it was created with, and a new key is read-only until you add more.

Keep keys on your server, in an environment variable such as `OPAIGE_KEY`. Never put a key in a browser, a mobile app or a
public repository. If one leaks, revoke it in your account and create another.

**Test keys** answer in the same shape as live ones, are never billed and never touch live data. Bookings, students and
appointments they send are kept as test data you can read back; every other write is checked and answered without being saved,
with `"sandbox": true` in the answer. Test data never sends a webhook.

## Calling the API

Every method is one API call, named as in the [API reference](https://opaige.com/developers). Use named arguments (`stayDays:`); JSON goes in `body` as an array; a PDF comes back as a string of bytes.

### Visa rules

| Method | Endpoint | What it does |
| --- | --- | --- |
| `checkRequirements` | `GET /requirements` | What a passport needs for a destination. |
| `whereToApply` | `GET /routes` | Who takes the application, where, and who decides it. |
| `listRules` | `GET /rules` | Every destination the rules cover, with versions. |
| `getRules` | `GET /rules/{destination}` | One destination: every passport grouped by what it needs, with sources. |
| `listRuleNotices` | `GET /rules/notices` | Rule changes announced, in force or coming up. |

### Airlines and travel platforms

| Method | Endpoint | What it does |
| --- | --- | --- |
| `checkPassengers` | `POST /passengers/check` | Who on a flight needs a visa, and by when to file. |
| `sendBookings` | `POST /bookings` | Bookings, from an airline’s or travel platform’s reservation system: who needs a visa or travel permission, and when each passenger is nudged. |
| `listBookings` | `GET /bookings` | Your bookings with every nudge sent or due. |
| `getBooking` | `GET /bookings/{ref}` | One booking by your reference. |
| `givePassengerFile` | `POST /passengers/file` | Give a passenger their visa file (billed per file). |
| `getPassengerSettings` | `GET /passengers/settings` | Your page for buying the file, and where passengers get help. |
| `updatePassengerSettings` | `PATCH /passengers/settings` | Change them (null clears). |
| `passengerStatus` | `GET /passengers/status` | Stages of passengers who chose to share. |

### Files, forms and documents

| Method | Endpoint | What it does |
| --- | --- | --- |
| `reviewFile` | `POST /file-review` | Every inconsistency in a whole visa file. |
| `getFileReview` | `GET /file-review/{id}` | A review made earlier. |
| `createUpload` | `POST /file-review/uploads` | A place to PUT a large PDF before reviewing it. |
| `fillForm` | `POST /forms` | The official visa form, filled from answers. |
| `makeDocument` | `POST /documents` | An itinerary, cover letter, submission brief or third-party letter. |
| `listReadyFiles` | `GET /files` | Every file that became ready since a moment: the daily batch. |

### Government filing

| Method | Endpoint | What it does |
| --- | --- | --- |
| `createLodgement` | `POST /lodgements` | Fill a visa application on the government portal, parked before the declarations (au-600, au-500) or the photo and signature (us-ds160). |
| `getLodgement` | `GET /lodgements/{id}` | Where a filing stands, with the government reference once there is one. |
| `listLodgements` | `GET /lodgements` | Your government filings, newest first. |
| `attachLodgementDocuments` | `POST /lodgements/{id}/documents` | Attach supporting documents. |
| `submitLodgement` | `POST /lodgements/{id}/submit` | Submit it to the government and pay the fee (requires `authorize: true`). |
| `lodgementQuestions` | `GET /lodgements/questions` | The questions a DS-160 filing answers, as a case asks them. |

### Companies and trips

| Method | Endpoint | What it does |
| --- | --- | --- |
| `createTrip` | `POST /trips` | Plan a trip; it follows your approval rules. |
| `getTrip` | `GET /trips/{id}` | One trip, with its case. |
| `listTrips` | `GET /trips` | Trips and where each case stands. |
| `getCaseFile` | `GET /cases/{id}/file` | A case’s finished file, with fresh links. |
| `resendCaseFile` | `POST /cases/{id}/file` | Send file.ready again. |
| `requestCanadaForms` | `POST /cases/{id}/canada-forms` | Queue Canada’s IMM 5257 and IMM 5707 on a case: filled from the case, validated and read back. |
| `getCanadaForms` | `GET /cases/{id}/canada-forms` | Where the Canada forms stand on a case, and the forms filed, each with a 10-minute link. |

### Schools

| Method | Endpoint | What it does |
| --- | --- | --- |
| `sendStudents` | `POST /students` | Admitted students, from a school’s admissions system; each gets a visa link. |
| `listStudents` | `GET /students` | Admitted students, with the visa stage where each agreed to share it. |
| `studentFundsCheck` | `POST /students/funds-check` | A student’s money against the study country’s rules (GB, CA, AU, US), each finding with its source. |
| `sponsorCompliance` | `GET /students/compliance` | A UK sponsor’s refusal, enrolment and completion rates as the Basic Compliance Assessment works them. |

### Visa centres

| Method | Endpoint | What it does |
| --- | --- | --- |
| `sendAppointments` | `POST /appointments` | Appointments, from a visa centre’s booking system. |
| `listAppointments` | `GET /appointments` | A day’s appointments with the file state and the counter stage. |

### Your account

| Method | Endpoint | What it does |
| --- | --- | --- |
| `listInvoices` | `GET /invoices` | Every case billed, due or paid. |
| `getUsage` | `GET /usage` | This month’s paid API use and what it comes to. |
| `getUptime` | `GET /uptime` | A month’s measured uptime against the 99.9% commitment. |

## Errors

Every error is JSON with a sentence you can show and a `code` your code can branch on. `OpaigeException` has `status`, `errorCode`, `requestId` and `details`; `getMessage()` is the sentence.

```php
use Opaige\OpaigeException;

try {
    $opaige->createTrip(body: $trip);
} catch (OpaigeException $e) {
    if ($e->errorCode === 'rate_limited') { /* wait, then retry */ }
    error_log("{$e->status} {$e->errorCode} {$e->getMessage()} {$e->requestId}"); // quote requestId to support
}
```

| Status | `code` | Meaning |
| --- | --- | --- |
| 400 | `invalid_request` | A parameter is missing or malformed. The sentence says which. |
| 401 | `unauthorized` | No key, or a key that is not valid. |
| 402 | `billing_required` | Paid calls need an invoiced account. A test key is never refused for this. |
| 402 | `account_suspended` | A statement is 21 or more days overdue. Paid calls resume once it is settled. |
| 402 | `credit_limit_reached` | The account is at its credit limit. |
| 403 | `scope` | The key does not carry the scope this endpoint needs. |
| 404 | `not_found` | Not found in your company. |
| 413 | `too_large` | Over 40 MB. |
| 429 | `rate_limited` | Over the rate limit. The library waits for `Retry-After` and tries again. |

## Retries, timeouts and idempotency

Reads, and writes sent with an idempotency key, are tried again after a 429 or 5xx answer. `new Opaige($key, baseUrl: ..., timeout: 120, maxRetries: 2)`. Pass `idempotencyKey:` on a write to make it safe to retry. A write repeated with
the same key within 24 hours returns the first answer (`Idempotent-Replay: true`) instead of doing the work twice.

## Rate limits

120 requests a minute per key, over a sliding minute. Every answer carries `X-RateLimit-Limit`, `X-RateLimit-Remaining` and
`X-RateLimit-Reset`. Calls without a key (the requirements check) are limited to 30 a minute per address.

## Webhooks

Add an endpoint in your account and choose its events. Every delivery is signed with that endpoint's secret; verify it before
trusting it, using the **raw** request body (a parsed and re-serialised body no longer matches its signature).

```php
$event = Opaige\Webhook::verify(
    file_get_contents('php://input'),
    $_SERVER['HTTP_OPAIGE_SIGNATURE'] ?? null,
    getenv('OPAIGE_WEBHOOK_SECRET'),
);
// $event['event'], $event['data']
```

A failed delivery is retried after 5 minutes, 30 minutes, 2 hours, 8 hours and 24 hours with the same `Opaige-Delivery` id, so
you can drop duplicates. The [event list](https://opaige.com/developers#webhooks) is in the API reference.

## Versions

This library follows [semantic versioning](https://semver.org); every change is in [CHANGELOG.md](CHANGELOG.md). The API itself
is versioned by date (now `2026-11-01`, sent on every answer as `Opaige-Api-Version`): within a version we only add endpoints,
optional fields, events and code values, so write your code to ignore fields it does not know.

## Support

Every answer carries `Opaige-Request-Id`. Quote it to [help@opaige.com](mailto:help@opaige.com) and we find the call at once.
Live status and measured uptime: [opaige.com/status](https://opaige.com/status). Security reports: see [SECURITY.md](SECURITY.md).

## License

MIT. Copyright Opaige Inc.
