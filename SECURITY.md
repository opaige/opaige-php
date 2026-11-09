# Security

## Reporting a vulnerability

Email **help@opaige.com** with "Security" in the subject. Please include what you found, how to reproduce it, and the
`Opaige-Request-Id` of any call involved. Do not open a public issue for a vulnerability, and do not test against data that
is not yours. We acknowledge every report and keep you told until it is fixed.

## Using this library safely

- Keep API keys and webhook secrets on your server, in environment variables. Never in a browser, a mobile app or a repository.
- Verify every webhook's `Opaige-Signature` against the raw body before acting on it, and drop repeated `Opaige-Delivery` ids.
- Use test keys and fictional applicants while you build. Test keys never touch live data and are never billed.
- Revoke a key in your account the moment you suspect it has leaked, and create a new one.

Only the latest release of this library receives security fixes.
