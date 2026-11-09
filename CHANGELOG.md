# Changelog

This library follows [semantic versioning](https://semver.org). The API is versioned by date; see the README.

## Unreleased

- The repository moved to the Opaige organisation: github.com/opaige. Old links redirect.
- README: authentication, every method by area, errors and their codes, retries, rate limits, webhooks, versions and support.
- Runnable examples in `examples/`: a quick start against the public test key, and webhook verification.
- SECURITY.md: how to report a vulnerability and how to use the library safely.

## 1.1.1 (2026-11-06)

- Package description says government filing.

## 1.1.0 (2026-11-03)

- New calls: Canada forms (IMM 5257 and IMM 5707), government filing, students, visa-centre appointments, bookings and the
  newer endpoints of the API reference.

## 1.0.0 (2026-11-03)

- First release: every call of the Opaige API, typed errors, retries with idempotency keys, and webhook verification.
