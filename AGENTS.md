# Repository Guidelines

## Project Structure & Module Organization
- Source code lives in `src/` (PSR-4: `Joehoel\\Combell\\`). Key files: `src/Combell.php`, `src/HmacAuthenticator.php`.
- Tests live in `tests/` (Pest). Vendor dependencies in `vendor/` (Composer).
- Keep classes in files that match their class name and namespace, e.g. `Joehoel\\Combell\\Combell` → `src/Combell.php`.

## Build, Test, and Development Commands
- `composer install` – Install dependencies (PHP 8.3+).
- `composer test` – Run the test suite with Pest.
- `composer test-coverage` – Run tests with code coverage enabled.
- `composer format` – Format code with Pint.

## Coding Style & Naming Conventions
- Style: PSR-12 via Laravel Pint. Use 4-space indentation, Unix line endings, and one class per file.
- Naming: Classes `PascalCase`, methods/properties `camelCase`, constants `UPPER_SNAKE_CASE`.
- Namespaces follow PSR-4: `Joehoel\\Combell\\...` under `src/`.
- Run `composer format` before committing. Keep imports ordered and remove unused imports.

## Testing Guidelines
- Framework: Pest (`tests/`). Prefer small, fast, deterministic tests.
- Naming: Mirror the subject under test, e.g. `HmacAuthenticator` behaviors in `tests/HmacAuthenticatorTest.php`.
- Coverage: Aim to cover happy paths and failure modes of authentication and request building.
- Run locally with `composer test` before pushing; use `composer test-coverage` to inspect gaps.

## Commit & Pull Request Guidelines
- Commit style: Conventional Commits preferred (e.g., `feat: add HMAC authenticator`, `chore: update tooling`). Keep messages in imperative mood.
- Pull Requests should include:
  - A clear description and rationale.
  - Linked issues (e.g., `Fixes #123`).
  - Tests for new/changed behavior.
  - Any relevant screenshots or logs for behavior changes.

## Security & Configuration Tips
- Do not commit secrets. Provide API keys via env vars or your application config; never hardcode in `src/` or tests.
- When adding HTTP features, prefer Saloon abstractions and avoid leaking sensitive headers in logs.
- Validate inputs on public APIs and guard against timing/encoding differences in signatures.
