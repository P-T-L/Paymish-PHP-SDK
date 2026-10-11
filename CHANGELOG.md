# Changelog

All notable changes to `bhekor/paymish-php` will be documented in this file.

## 1.0.0 - 2026-10-11

### Added

- Initial framework-agnostic PHP SDK for the Paymish API
- `PaymishClient` with automatic bearer authentication and optional PSR-16 token cache
- API resources: auth, transactions, transfers, recipients, virtual accounts, subscriptions, plans, payment pages, products, customers, business, split pages, subaccounts, disputes
- `ApiResponse` helper with dot-notation access
- Optional webhook HMAC-SHA512 verification helper
- Documentation under `docs/`
