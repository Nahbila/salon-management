# Nahbi's Hair: Salon Booking System

A bilingual (English / French) web application for a braiding salon. Clients browse a photo catalog of hairstyles and book an appointment without creating an account. The owner manages services, appointments and payments from a private admin area.

Built as a Business Information Systems portfolio project by Nahbila Synthia.

## Screenshots

![Catalog](docs/screenshots/catalog.png)
![Booking](docs/screenshots/booking.png)
![Admin appointments](docs/screenshots/admin-appointments.png)

## Features

**Clients (no account needed)**
- Photo catalog of hairstyles with prices and durations, filterable by Women / Men
- Guest booking: pick a style, a date and leave a phone number
- Custom requests: describe a style and attach a reference photo; the owner calls to agree on the price
- "My appointments" space, opened with a phone number: see status and history, change the date, or cancel
- English / French interface, with browser language detection and a manual switch

**Admin**
- Secure login and dashboard
- Appointment management: confirm, assign an employee, set a quoted price, update status, record cash payment
- Service management: add, edit, upload a photo, deactivate and reactivate
- Every status change is logged, giving a full audit trail per appointment

## Business process

Appointment requested → confirmed → in progress → completed (or cancelled), with each transition recorded in `appointment_status_logs`.

## Tech stack

PHP 8.2, Laravel 12 (MVC, Eloquent, migrations, seeders), MySQL, Blade, Bootstrap 5, vanilla JavaScript, Cropper.js.

Security: hashed passwords, CSRF protection, server-side validation, session regeneration, authentication middleware on all admin routes.

## Local setup

Requirements: PHP 8.2+, Composer, Node.js, MySQL (XAMPP works).

```bash
git clone <repository-url>
cd salon-management
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Create an empty MySQL database named `salon_management`, check the `DB_*` values in `.env`, then:

```bash
php artisan migrate --seed
php artisan storage:link
composer run dev
```

Open http://localhost:8000. The admin area is at `/admin/login`, using `ADMIN_EMAIL` and `ADMIN_PASSWORD` from your `.env`.

## Known limitations

- The client space is opened with a phone number only, which is simple but not private enough for production. A booking code or SMS verification would be the next step.
- No automatic notifications yet; the owner contacts clients by phone.
- Payments are recorded as cash only.
- The admin area is English-only.
- Employee self-service (own schedule and availability) is planned but not built.

## Roadmap

Landing page, translated validation messages, dashboard statistics, employee accounts.