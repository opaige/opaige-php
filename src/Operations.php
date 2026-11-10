<?php
// Generated from the Opaige API description, https://opaige.com/api/company/v1/openapi.json (version 2026-11-01). Do not edit by hand.

declare(strict_types=1);

namespace Opaige;

abstract class Operations
{
    abstract protected function http(): Requester;

    /** A day’s appointments with the file state and the counter stage. GET /appointments */
    public function listAppointments(string|int|null $date = null): mixed
    {
        return $this->http()->request('GET', '/appointments', ['date' => $date], null, null, null, []);
    }

    /** Appointments, from a visa centre’s booking system. POST /appointments */
    public function sendAppointments(array $body): mixed
    {
        return $this->http()->request('POST', '/appointments', [], $body, null, null, []);
    }

    /** Your bookings with every nudge sent or due. GET /bookings */
    public function listBookings(string|int|null $updatedSince = null): mixed
    {
        return $this->http()->request('GET', '/bookings', ['updated_since' => $updatedSince], null, null, null, []);
    }

    /** Bookings, from an airline’s or travel platform’s reservation system: who needs a visa or travel permission, and when each passenger is nudged. POST /bookings */
    public function sendBookings(array $body): mixed
    {
        return $this->http()->request('POST', '/bookings', [], $body, null, null, []);
    }

    /** One booking by your reference. GET /bookings/{ref} */
    public function getBooking(string $ref): mixed
    {
        return $this->http()->request('GET', '/bookings/' . rawurlencode($ref), [], null, null, null, []);
    }

    /** Where the Canada forms stand on a case, and the forms filed, each with a 10-minute link. GET /cases/{id}/canada-forms */
    public function getCanadaForms(string $id): mixed
    {
        return $this->http()->request('GET', '/cases/' . rawurlencode($id) . '/canada-forms', [], null, null, null, []);
    }

    /** Queue Canada’s IMM 5257 and IMM 5707 on a case: filled from the case, validated and read back. POST /cases/{id}/canada-forms */
    public function requestCanadaForms(string $id): mixed
    {
        return $this->http()->request('POST', '/cases/' . rawurlencode($id) . '/canada-forms', [], null, null, null, []);
    }

    /** A case’s finished file, with fresh links. GET /cases/{id}/file */
    public function getCaseFile(string $id): mixed
    {
        return $this->http()->request('GET', '/cases/' . rawurlencode($id) . '/file', [], null, null, null, []);
    }

    /** Send file.ready again. POST /cases/{id}/file */
    public function resendCaseFile(string $id): mixed
    {
        return $this->http()->request('POST', '/cases/' . rawurlencode($id) . '/file', [], null, null, null, []);
    }

    /** An itinerary, cover letter, submission brief or third-party letter. POST /documents */
    public function makeDocument(array $body, string|int|null $format = null): mixed
    {
        return $this->http()->request('POST', '/documents', ['format' => $format], $body, null, null, []);
    }

    /** Your government fee balance, and what each route asks for. GET /fee-balance */
    public function getFeeBalance(): mixed
    {
        return $this->http()->request('GET', '/fee-balance', [], null, null, null, []);
    }

    /** Ask to add to the balance by bank transfer; a person confirms the money before it counts. POST /fee-balance/top-ups */
    public function createFeeTopUp(array $body, ?string $idempotencyKey = null): mixed
    {
        return $this->http()->request('POST', '/fee-balance/top-ups', [], $body, null, null, [], $idempotencyKey);
    }

    /** Every inconsistency in a whole visa file. POST /file-review */
    public function reviewFile(?array $body = null, ?string $file = null, string $filename = 'file.pdf', array $fields = [], ?string $idempotencyKey = null): mixed
    {
        return $this->http()->request('POST', '/file-review', [], $body, $file, $filename, $fields, $idempotencyKey);
    }

    /** A review made earlier. GET /file-review/{id} */
    public function getFileReview(string $id): mixed
    {
        return $this->http()->request('GET', '/file-review/' . rawurlencode($id), [], null, null, null, []);
    }

    /** A place to PUT a large PDF before reviewing it. POST /file-review/uploads */
    public function createUpload(): mixed
    {
        return $this->http()->request('POST', '/file-review/uploads', [], null, null, null, []);
    }

    /** Every file that became ready since a moment: the daily batch. GET /files */
    public function listReadyFiles(string|int|null $since = null): mixed
    {
        return $this->http()->request('GET', '/files', ['since' => $since], null, null, null, []);
    }

    /** The official visa form, filled from answers. POST /forms */
    public function fillForm(array $body, string|int|null $format = null): mixed
    {
        return $this->http()->request('POST', '/forms', ['format' => $format], $body, null, null, []);
    }

    /** Every case billed, due or paid. GET /invoices */
    public function listInvoices(string|int|null $status = null, string|int|null $from = null, string|int|null $to = null): mixed
    {
        return $this->http()->request('GET', '/invoices', ['status' => $status, 'from' => $from, 'to' => $to], null, null, null, []);
    }

    /** Who on a flight needs a visa, and by when to file. POST /passengers/check */
    public function checkPassengers(array $body): mixed
    {
        return $this->http()->request('POST', '/passengers/check', [], $body, null, null, []);
    }

    /** Give a passenger their visa file (billed per file). POST /passengers/file */
    public function givePassengerFile(array $body, ?string $idempotencyKey = null): mixed
    {
        return $this->http()->request('POST', '/passengers/file', [], $body, null, null, [], $idempotencyKey);
    }

    /** Your page for buying the file, and where passengers get help. GET /passengers/settings */
    public function getPassengerSettings(): mixed
    {
        return $this->http()->request('GET', '/passengers/settings', [], null, null, null, []);
    }

    /** Change them (null clears). PATCH /passengers/settings */
    public function updatePassengerSettings(array $body): mixed
    {
        return $this->http()->request('PATCH', '/passengers/settings', [], $body, null, null, []);
    }

    /** Stages of passengers who chose to share. GET /passengers/status */
    public function passengerStatus(string|int|null $ref = null): mixed
    {
        return $this->http()->request('GET', '/passengers/status', ['ref' => $ref], null, null, null, []);
    }

    /** What a passport needs for a destination. GET /requirements */
    public function checkRequirements(string|int|null $passport = null, string|int|null $destination = null, string|int|null $residence = null, string|int|null $stayDays = null): mixed
    {
        return $this->http()->request('GET', '/requirements', ['passport' => $passport, 'destination' => $destination, 'residence' => $residence, 'stay_days' => $stayDays], null, null, null, []);
    }

    /** Who takes the application, where, and who decides it. GET /routes */
    public function whereToApply(string|int|null $residence = null, string|int|null $destination = null): mixed
    {
        return $this->http()->request('GET', '/routes', ['residence' => $residence, 'destination' => $destination], null, null, null, []);
    }

    /** Every destination the rules cover, with versions. GET /rules */
    public function listRules(): mixed
    {
        return $this->http()->request('GET', '/rules', [], null, null, null, []);
    }

    /** One destination: every passport grouped by what it needs, with sources. GET /rules/{destination} */
    public function getRules(string $destination): mixed
    {
        return $this->http()->request('GET', '/rules/' . rawurlencode($destination), [], null, null, null, []);
    }

    /** Rule changes announced, in force or coming up. GET /rules/notices */
    public function listRuleNotices(string|int|null $since = null): mixed
    {
        return $this->http()->request('GET', '/rules/notices', ['since' => $since], null, null, null, []);
    }

    /** Prepare a skilled application (Australia 189/190/491, Canada Express Entry, Germany EU Blue Card, UK Skilled Worker): every field filled or marked missing, the claim worked from what the profile proves, each fact tied to its document (billed as one form). POST /skilled/applications */
    public function prepareSkilledApplication(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/applications', [], $body, null, null, []);
    }

    /** Check EU Blue Card eligibility for Germany (qualification, job offer, salary threshold). POST /skilled/blue-card-check */
    public function checkBlueCard(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/blue-card-check', [], $body, null, null, []);
    }

    /** The documents a Germany EU Blue Card application asks for, tailored to the candidate. POST /skilled/blue-card-checklist */
    public function blueCardChecklist(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/blue-card-checklist', [], $body, null, null, []);
    }

    /** Score a candidate on Canada's Express Entry Comprehensive Ranking System (CRS), out of 1200. POST /skilled/crs-check */
    public function checkCrsPoints(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/crs-check', [], $body, null, null, []);
    }

    /** The documents an Australian skilled application (189, 190, 491) asks for, tailored to the applicant. POST /skilled/document-checklist */
    public function skilledDocumentChecklist(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/document-checklist', [], $body, null, null, []);
    }

    /** The documents a Canada Express Entry application (FSW, CEC, FST) asks for, tailored to the candidate. POST /skilled/express-entry-checklist */
    public function expressEntryChecklist(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/express-entry-checklist', [], $body, null, null, []);
    }

    /** Check US H-1B eligibility: specialty occupation, degree or 3-for-1 equivalency, prevailing wage level, cap pool and weighted-selection entries. POST /skilled/h1b-check */
    public function checkH1b(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/h1b-check', [], $body, null, null, []);
    }

    /** The documents a US H-1B petition is built from, tailored to the case. POST /skilled/h1b-checklist */
    public function h1bChecklist(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/h1b-checklist', [], $body, null, null, []);
    }

    /** Score a person on Australia's General Skilled Migration points test (subclasses 189, 190, 491). POST /skilled/points-check */
    public function checkSkilledPoints(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/points-check', [], $body, null, null, []);
    }

    /** Check UK Skilled Worker eligibility (sponsor, skill level, and the higher of the general threshold and the going rate). POST /skilled/uk-skilled-worker-check */
    public function checkSkilledWorker(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/uk-skilled-worker-check', [], $body, null, null, []);
    }

    /** The documents a UK Skilled Worker application asks for, tailored to the candidate. POST /skilled/uk-skilled-worker-checklist */
    public function ukSkilledWorkerChecklist(array $body): mixed
    {
        return $this->http()->request('POST', '/skilled/uk-skilled-worker-checklist', [], $body, null, null, []);
    }

    /** Admitted students, with the visa stage where each agreed to share it. GET /students */
    public function listStudents(): mixed
    {
        return $this->http()->request('GET', '/students', [], null, null, null, []);
    }

    /** Admitted students, from a school’s admissions system; each gets a visa link. POST /students */
    public function sendStudents(array $body): mixed
    {
        return $this->http()->request('POST', '/students', [], $body, null, null, []);
    }

    /** A UK sponsor’s refusal, enrolment and completion rates as the Basic Compliance Assessment works them. GET /students/compliance */
    public function sponsorCompliance(string|int|null $asOf = null): mixed
    {
        return $this->http()->request('GET', '/students/compliance', ['as_of' => $asOf], null, null, null, []);
    }

    /** A student’s money against the study country’s rules (GB, CA, AU, US), each finding with its source. POST /students/funds-check */
    public function studentFundsCheck(array $body): mixed
    {
        return $this->http()->request('POST', '/students/funds-check', [], $body, null, null, []);
    }

    /** Your submissions, newest first. GET /submissions */
    public function listSubmissions(): mixed
    {
        return $this->http()->request('GET', '/submissions', [], null, null, null, []);
    }

    /** Fill a visa application on the government portal, stopping before the declarations (au-600, au-500), at the applicant's signature (us-ds160), or completed with its reference (fr-schengen). POST /submissions */
    public function createSubmission(array $body, ?string $idempotencyKey = null): mixed
    {
        return $this->http()->request('POST', '/submissions', [], $body, null, null, [], $idempotencyKey);
    }

    /** Where a submission stands, with the government reference once there is one. GET /submissions/{id} */
    public function getSubmission(string $id): mixed
    {
        return $this->http()->request('GET', '/submissions/' . rawurlencode($id), [], null, null, null, []);
    }

    /** us-ds160 with code_by partner: the US site's security code your staff read in code.image. POST /submissions/{id}/code */
    public function sendSubmissionCode(string $id, array $body): mixed
    {
        return $this->http()->request('POST', '/submissions/' . rawurlencode($id) . '/code', [], $body, null, null, []);
    }

    /** Attach supporting documents. POST /submissions/{id}/documents */
    public function attachSubmissionDocuments(string $id, array $body): mixed
    {
        return $this->http()->request('POST', '/submissions/' . rawurlencode($id) . '/documents', [], $body, null, null, []);
    }

    /** us-ds160: the US site's own PDF once submitted: the confirmation, or the full application as submitted. GET /submissions/{id}/filed/{kind} */
    public function getFiledDocument(string $id, string $kind): mixed
    {
        return $this->http()->request('GET', '/submissions/' . rawurlencode($id) . '/filed/' . rawurlencode($kind), [], null, null, null, []);
    }

    /** Submit and pay the government fee (requires authorize: true). POST /submissions/{id}/submit */
    public function submitAndPay(string $id, array $body, ?string $idempotencyKey = null): mixed
    {
        return $this->http()->request('POST', '/submissions/' . rawurlencode($id) . '/submit', [], $body, null, null, [], $idempotencyKey);
    }

    /** us-ds160: a hosted link where the applicant completes what you do not hold, with their passport and photo, and signs. POST /submissions/intakes */
    public function createIntake(array $body): mixed
    {
        return $this->http()->request('POST', '/submissions/intakes', [], $body, null, null, []);
    }

    /** Whether the applicant has finished, and the submission it became. GET /submissions/intakes/{id} */
    public function getIntake(string $id): mixed
    {
        return $this->http()->request('GET', '/submissions/intakes/' . rawurlencode($id), [], null, null, null, []);
    }

    /** The questions a DS-160 submission answers, as a case asks them. GET /submissions/questions */
    public function submissionQuestions(string|int|null $visa = null, string|int|null $purpose = null): mixed
    {
        return $this->http()->request('GET', '/submissions/questions', ['visa' => $visa, 'purpose' => $purpose], null, null, null, []);
    }

    /** us-ds160: open an application already on the US site with its recovery details and print its confirmation again (not billed). POST /submissions/retrieve */
    public function retrieveDs160(array $body, ?string $idempotencyKey = null): mixed
    {
        return $this->http()->request('POST', '/submissions/retrieve', [], $body, null, null, [], $idempotencyKey);
    }

    /** Trips and where each case stands. GET /trips */
    public function listTrips(string|int|null $status = null, string|int|null $updatedSince = null): mixed
    {
        return $this->http()->request('GET', '/trips', ['status' => $status, 'updated_since' => $updatedSince], null, null, null, []);
    }

    /** Plan a trip; it follows your approval rules. POST /trips */
    public function createTrip(array $body): mixed
    {
        return $this->http()->request('POST', '/trips', [], $body, null, null, []);
    }

    /** One trip, with its case. GET /trips/{id} */
    public function getTrip(string $id): mixed
    {
        return $this->http()->request('GET', '/trips/' . rawurlencode($id), [], null, null, null, []);
    }

    /** A month’s measured uptime against the 99.9% commitment. GET /uptime */
    public function getUptime(string|int|null $month = null): mixed
    {
        return $this->http()->request('GET', '/uptime', ['month' => $month], null, null, null, []);
    }

    /** This month’s paid API use and what it comes to. GET /usage */
    public function getUsage(string|int|null $month = null): mixed
    {
        return $this->http()->request('GET', '/usage', ['month' => $month], null, null, null, []);
    }

}
