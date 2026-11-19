# The Integrated Theatre System

A Laravel application using Livewire, Flux UI and Filament. The repository currently contains application scaffolding, authentication and account settings.

## Local development

The project uses Laravel Sail and Docker. With dependencies installed and a `.env` file configured, start the services and prepare the application:

```sh
vendor/bin/sail up -d
vendor/bin/sail artisan key:generate
vendor/bin/sail artisan migrate
vendor/bin/sail npm install
vendor/bin/sail npm run dev
```

Use `.env.example` as a starting point for local configuration. Sail's Compose file includes MySQL, Redis, Typesense, Mailtrap Local, Selenium and Soketi; configure the services your environment needs in `.env`.

## Checks

Run the application tests with:

```sh
vendor/bin/sail artisan test --compact
```

The Composer test script also runs formatting and static analysis checks:

```sh
vendor/bin/sail composer test
```
