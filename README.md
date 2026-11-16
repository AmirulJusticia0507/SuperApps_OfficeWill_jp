# OfficeWill JP

Laravel **11.57.1** application for company-managed employee, course, attendance, and questionnaire workflows.

The project uses Laravel 11 with Vite/Tailwind CSS as a gradual transition layer. Existing Bootstrap and AdminLTE components remain enabled while screens are migrated incrementally.

## Requirements

- PHP 8.2+, Composer, PostgreSQL, Node.js 20+, and npm.

## Local installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
npm install
npm run build
php artisan serve
```

Configure the database, mail, and application URL in `.env` first. Import the existing PostgreSQL legacy schema/dump according to the deployment runbook; do not blindly run all migrations against an existing production database. For a fresh database, run `php artisan migrate` after configuring the connection.

The application is currently verified with Laravel Framework 11.57.1 and PHP 8.5. The database contains legacy PostgreSQL column names in some tables, so migrations and model/controller queries must preserve those names unless a deliberate schema migration is performed.

## Authentication and access

Public account registration is disabled. Accounts must be provisioned by an authorized administrator. Login, password reset, employee lockout, authority checks, and company tenant scoping are enforced server-side.

## Production checklist

Use HTTPS, a non-default database account, a production mail transport, persistent cache/session/queue backends, and a secret `APP_KEY`. Set `APP_ENV=production`, `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`, `SESSION_HTTP_ONLY=true`, and `SESSION_SAME_SITE=lax`. Never commit `.env`, credentials, or database dumps. During deployment run `php artisan config:cache`, `php artisan route:cache`, and `php artisan view:cache`.

## Testing

After installing dependencies, run `php artisan test`. Tests must use an isolated database and never a production database.
