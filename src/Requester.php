<?php

declare(strict_types=1);

namespace Opaige;

/**
 * How every call is made: the key, the JSON or the file, retries and errors. Written by hand; the API methods (Operations.php) are
 * generated from the API description. Needs only PHP's curl and json extensions.
 */
final class Requester
{
    public const VERSION = '2.0.0';
    private const RETRY = [429, 500, 502, 503, 504];
    private string $base;

    public function __construct(private string $key, string $baseUrl = 'https://opaige.com/api/company/v1', private int $timeout = 120, private int $maxRetries = 2)
    {
        if ($key === '') {
            throw new \InvalidArgumentException('An Opaige API key is required: create one in the portal under Developers.');
        }
        $this->base = rtrim($baseUrl, '/');
    }

    /** @return mixed The decoded JSON answer, or the PDF's bytes as a string. */
    public function request(string $method, string $path, array $query = [], ?array $body = null, ?string $file = null, ?string $filename = null, array $fields = [], ?string $idempotencyKey = null): mixed
    {
        $query = array_filter($query, fn ($v) => $v !== null && $v !== '');
        $url = $this->base . $path . ($query ? '?' . http_build_query($query) : '');
        $headers = ['Authorization: Bearer ' . $this->key, 'User-Agent: opaige-php/' . self::VERSION, 'Accept: application/json'];
        if ($idempotencyKey !== null) {
            $headers[] = 'Idempotency-Key: ' . $idempotencyKey;
        }
        $payload = null;
        if ($file !== null) {
            $boundary = 'opaige' . bin2hex(random_bytes(12));
            $parts = '';
            foreach ($fields as $k => $v) {
                $parts .= "--{$boundary}\r\nContent-Disposition: form-data; name=\"{$k}\"\r\n\r\n{$v}\r\n";
            }
            $name = $filename ?? 'file.pdf';
            $parts .= "--{$boundary}\r\nContent-Disposition: form-data; name=\"file\"; filename=\"{$name}\"\r\nContent-Type: application/pdf\r\n\r\n{$file}\r\n--{$boundary}--\r\n";
            $payload = $parts;
            $headers[] = 'Content-Type: multipart/form-data; boundary=' . $boundary;
        } elseif ($body !== null) {
            $payload = json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
            $headers[] = 'Content-Type: application/json';
        }
        $retryable = $method === 'GET' || $idempotencyKey !== null;
        for ($attempt = 0; ; $attempt++) {
            $responseHeaders = [];
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_TIMEOUT => $this->timeout,
                CURLOPT_HEADERFUNCTION => function ($ch, string $line) use (&$responseHeaders) {
                    $p = strpos($line, ':');
                    if ($p !== false) {
                        $responseHeaders[strtolower(trim(substr($line, 0, $p)))] = trim(substr($line, $p + 1));
                    }
                    return strlen($line);
                },
            ]);
            if ($payload !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            }
            $raw = curl_exec($ch);
            $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            $error = curl_error($ch);
            if ($raw === false) {
                if ($retryable && $attempt < $this->maxRetries) {
                    usleep((int) (500000 * 2 ** $attempt));
                    continue;
                }
                throw new OpaigeException('Could not reach Opaige: ' . $error, 0, 'network_error');
            }
            if (in_array($status, self::RETRY, true) && $retryable && $attempt < $this->maxRetries) {
                $wait = (float) ($responseHeaders['retry-after'] ?? 0);
                usleep((int) (($wait > 0 ? min($wait, 30) : 0.5 * 2 ** $attempt) * 1000000));
                continue;
            }
            $requestId = $responseHeaders['opaige-request-id'] ?? null;
            if ($status < 400 && str_contains($responseHeaders['content-type'] ?? '', 'application/pdf')) {
                return $raw;
            }
            $data = json_decode($raw === '' ? '{}' : $raw, true) ?? [];
            if ($status >= 400) {
                throw new OpaigeException($data['error'] ?? "Opaige answered {$status}", $status, $data['code'] ?? null, $requestId, $data['details'] ?? null);
            }
            return $data;
        }
    }
}
