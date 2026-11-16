# OfficeWill JP

Laravel 11 application for company-managed employee, course, attendance, and questionnaire workflows.

## Requirements

- PHP 8.2+, Composer, MySQL 8+, Node.js 20+, and npm.

## Local installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
npm install
npm run build
php artisan serve
```

Configure the database, mail, and application URL in `.env` first. For an existing production dump, import it according to the deployment runbook rather than blindly running all migrations.

## Authentication and access

Public account registration is disabled. Accounts must be provisioned by an authorized administrator. Login, password reset, employee lockout, authority checks, and company tenant scoping are enforced server-side.

## Production checklist

Use HTTPS, a non-default database account, a production mail transport, persistent cache/session/queue backends, and a secret `APP_KEY`. Set `APP_ENV=production`, `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`, `SESSION_HTTP_ONLY=true`, and `SESSION_SAME_SITE=lax`. Never commit `.env`, credentials, or database dumps. During deployment run `php artisan config:cache`, `php artisan route:cache`, and `php artisan view:cache`.

## Testing

After installing dependencies, run `php artisan test`. Tests must use an isolated database and never a production database.
