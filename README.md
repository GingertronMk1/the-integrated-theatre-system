# The Integrated Theatre System

The Integrated Theatre System is a Laravel application for keeping a theatre's productions, people, performances and training records together. Its signed-in workspace provides a dashboard and simple browsing pages; a Filament panel provides forms and related-record managers for maintaining the data. A versioned JSON interface is also available for the domain records.

The application uses Laravel 13 and PHP 8.5 in Laravel Sail, with Livewire 4, Flux UI, Filament 5, Tailwind CSS 4 and Vite. Composer and npm lockfiles specify the installed dependency versions.

## What the site does

- **Dashboard:** counts shows, performances, people and training items, and links to recently added shows.
- **Shows:** lists productions and displays their season, playwright, description, cast, crew and performances.
- **Performances:** lists shows, their performance times, venues and capacities.
- **People:** lists people and their start and end years. A person may optionally be linked to a user account.
- **Training:** lists training items, categories and whether an item is marked hazardous. Sessions record trainers and trainees.
- **Administration:** Filament provides management screens for users, people, roles, shows, cast, crew, venues, seasons, playwrights, performances, tickets, and training records. Related records can also be managed from the relevant resource pages.
- **Accounts:** Laravel Fortify provides registration, login, email verification, password reset, two-factor authentication and passkeys. Signed-in users can update their profile, security settings and appearance.

Tickets belong to performances and have an `available`, `reserved` or `bought` status; their optional cost is stored in pence. The application stores performance start times as strings, so it displays the supplied value rather than treating it as a structured date and time. Most domain records use UUID primary keys; users, venues, seasons and playwrights support soft deletion.

## Local setup

### Prerequisites

- Git and Docker with Docker Compose, running on macOS, Linux or Windows with WSL2.
- Available ports for the services in `compose.yaml`, or configured overrides in `.env`.
- Composer dependencies in `vendor/`, including the development dependencies that provide Sail. On a fresh clone without `vendor/`, bootstrap them once from the project root using Docker:

  ```sh
  docker run --rm -v "$PWD:/app" -w /app composer:2 composer install --ignore-platform-reqs --no-scripts
  ```

  This first install only makes Sail available; the normal Composer install below runs inside the project's PHP 8.5 container and checks its platform requirements. On Linux, files created by the bootstrap container may need their ownership adjusted to your local user.

### Configure and start Sail

1. Copy the example environment file:

   ```sh
   cp .env.example .env
   ```

2. Edit `.env`. The example defaults to SQLite and a log mailer; for the MySQL service in `compose.yaml`, set matching database credentials, for example:

   ```dotenv
   APP_ENV=local
   APP_URL=http://localhost
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=theatre
   DB_USERNAME=sail
   DB_PASSWORD=choose-a-local-password
   REDIS_HOST=redis
   ```

   MySQL creates the configured database and user when its volume is first initialized. Set `APP_PORT` if port 80 is unavailable, and set `APP_URL` to the corresponding browser URL. The passkey relying party and allowed origin derive from `APP_URL`.

3. Start the containers and complete installation:

   ```sh
   vendor/bin/sail up -d
   vendor/bin/sail composer install
   vendor/bin/sail artisan key:generate
   vendor/bin/sail artisan migrate
   vendor/bin/sail npm install
   vendor/bin/sail npm run dev
   ```

   Keep the Vite development server running while working on frontend assets. To build assets instead, run `vendor/bin/sail npm run build`. Open the application with `vendor/bin/sail open` and stop the containers with `vendor/bin/sail stop`.

Sail also starts Redis, Typesense, Mailtrap Local, Selenium and Soketi. Their ports and persistent volumes are defined in `compose.yaml`. To receive verification and password-reset emails in Mailtrap Local rather than the default application log, configure the mailer in `.env`, for example:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=mailtrap-local
MAIL_PORT=3535
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

The Mailtrap Local dashboard uses host port `3550` by default (`FORWARD_MAILTRAP_LOCAL_DASHBOARD_PORT` overrides it). Register an account and verify its email to enter the workspace. The optional `vendor/bin/sail artisan db:seed` command creates a verified local `test@example.com` user with password `password`; it does not seed the theatre domain by default. Individual domain seeders are available in `database/seeders` and generate sample records through factories. Use the sample account only in a local environment.

The original user and passkey migrations use UUID user IDs and were edited in place. A database that ran an earlier version of those migrations needs to be rebuilt or otherwise migrated before using this version. Do not run a destructive database reset against data you need to keep.

## Routes

### Browser pages

The home page is public. The workspace pages require an authenticated user with a verified email address.

| Method and path | Purpose |
| --- | --- |
| `GET /` | Welcome page |
| `GET /dashboard` | Workspace overview |
| `GET /shows` | Browse shows |
| `GET /shows/{show}` | Show details, cast, crew and performances |
| `GET /performances` | Browse performances |
| `GET /people` | Browse people |
| `GET /training` | Browse training items |
| `GET /admin` | Filament administration panel |
| `GET /settings` | Redirect to profile settings |
| `GET /settings/profile` | Profile settings; authentication required |
| `GET /settings/appearance` | Appearance settings; authentication and verification required |
| `GET /settings/security` | Security settings; authentication, verification and password confirmation required |
| `GET /.well-known/passkey-endpoints` | Passkey enrollment and management endpoints |
| `GET /up` | Application health endpoint |

Fortify also registers authentication routes, including `/login`, `/register`, `/forgot-password`, `/reset-password`, `/email/verify` and `/logout`. Filament registers its own login and resource pages under `/admin`. To inspect the complete route list, including package routes, use:

```sh
vendor/bin/sail artisan route:list
```

Filament requires authentication. The current `User` model does not implement Filament's `FilamentUser` contract, so Filament permits panel access in the `local` environment and denies it outside local; an explicit panel access policy is needed for other environments.

### JSON resource routes

The following resources are registered under `/api/v1`:

```text
people                 roles                  shows
show-cast              show-crew              venues
seasons                playwrights            performances
tickets                training-categories    training-items
training-sessions      training-session-people
```

Each resource supports the same routes, with `{id}` representing the record's UUID:

| Method and path | Action |
| --- | --- |
| `GET /api/v1/{resource}` | List paginated records |
| `POST /api/v1/{resource}` | Create a record |
| `GET /api/v1/{resource}/{id}` | Retrieve a record |
| `PUT` or `PATCH /api/v1/{resource}/{id}` | Update supplied fields |
| `DELETE /api/v1/{resource}/{id}` | Delete a record |

These routes are registered in `routes/web.php`: they use the web session, CSRF protection for state-changing requests, and `auth` and `verified` middleware. They are not token-authenticated API routes. Use an authenticated, verified session and provide the session's CSRF token for writes. Responses use Laravel JSON resources; list responses are paginated, validation failures return JSON errors, and successful deletes return `204 No Content`.

The current routes allow any authenticated, verified user to manage all these domain records; they do not yet apply per-record or role-based permissions. Review that access model before exposing the application to users who should have different privileges.

## Testing and checks

Tests use Pest and Laravel's test runner. With Sail running, execute the full suite or a focused test file:

```sh
vendor/bin/sail artisan test --compact
vendor/bin/sail artisan test --compact tests/Feature/TheatrePagesTest.php
```

`phpunit.xml` selects the `testing` database. A fresh Sail MySQL volume creates it on initialization; ensure it exists and that the configured database user can access it if using an existing volume. Tests using `RefreshDatabase` migrate and change the testing database, so do not point it at a database containing data you need.

Other project checks:

```sh
vendor/bin/sail bin pint --dirty --format agent  # Format changed PHP files
vendor/bin/sail composer types:check             # Larastan / PHPStan
vendor/bin/sail npm run build                   # Build frontend assets
vendor/bin/sail composer test                    # Formatting check, static analysis and tests with coverage
```

The Composer test script clears the configuration cache and enforces a minimum 90% coverage threshold. It may have different requirements from running the test suite alone.
