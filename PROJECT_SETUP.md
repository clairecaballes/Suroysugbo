# Suroysugbo Project Setup

## 1. Project Overview
This repository is a Laravel + Vue.js web application for Cebu tourism. It uses:
- Laravel 12 backend
- Vue 3 + Inertia frontend
- Tailwind CSS and Vite for assets
- MySQL / SQLite database
- Docker configuration for optional container deployment

## 2. Key folders and their purpose
- `app/`
  - Laravel backend logic
  - `Http/Controllers/` handles requests
  - `Models/` contains database models
  - `Providers/` config providers and bindings
- `bootstrap/`
  - Laravel bootstrap files and cached services
- `config/`
  - Application and database configuration files
- `database/`
  - Migrations, seeders, and factories
- `docker/`
  - Docker configuration files for nginx and process management
- `public/`
  - Public web root and static assets
- `resources/`
  - Frontend resources for Vue and CSS
- `routes/`
  - Route definitions for web, API, auth, and settings
- `storage/`
  - Logs, cache, and generated files
- `tests/`
  - Pest test suites
- `vendor/`
  - Composer dependencies (generated after install)
- Root files:
  - `composer.json` PHP dependency manifest
  - `package.json` Node dependency manifest
  - `vite.config.ts` Vite build config
  - `Dockerfile` Docker image setup

## 3. Preparation
1. Open the repository root in your terminal.
2. Ensure these prerequisites are installed:
   - PHP 8.2+
   - Composer
   - Node.js
   - npm
   - MySQL or SQLite
   - Docker (optional)

## 4. Install dependencies
1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Install Node dependencies:

   ```bash
   npm install
   ```

## 5. Configure environment
1. Copy `.env.example` to `.env`:

   ```bash
   copy .env.example .env
   ```

2. Update `.env` for your database and app settings.
   - `DB_CONNECTION=mysql`
   - `DB_DATABASE=your_database`
   - `DB_USERNAME=your_username`
   - `DB_PASSWORD=your_password`

3. Optionally use SQLite by creating the database file and setting `DB_CONNECTION=sqlite`.

## 6. Laravel application setup
1. Generate the application key:

   ```bash
   php artisan key:generate
   ```

2. Run database migrations:

   ```bash
   php artisan migrate
   ```

3. Optionally seed the database if seeders are present:

   ```bash
   php artisan db:seed
   ```

## 7. Build frontend assets
1. For development:

   ```bash
   npm run dev
   ```

2. For production build:

   ```bash
   npm run build
   ```

## 8. Run the application locally
1. Start Laravel server:

   ```bash
   php artisan serve
   ```

2. Open the browser at the address shown by the command.

## 9. Optional Docker usage
1. If you want to use Docker, inspect `Dockerfile` and `docker/` for configuration.
2. Build and run the container using your preferred Docker commands.

## 10. Notes by folder
- `app/Models/` includes models like `User.php`, `CebuLegacy.php`, `Message.php`, `Review.php`, `TourSite.php`, and `VehicleRoute.php`.
- `resources/js/` contains Vue pages, components, and Inertia setup.
- `routes/web.php` and `routes/api.php` define the public and authenticated routes.
- `database/migrations/` define the schema for tourism sites, messages, reviews, and auth tables.
- `tests/` contains test cases to validate features.

## 11. Useful commands
- `npm run dev` — start Vite development server
- `npm run build` — compile frontend assets
- `php artisan migrate` — apply database migrations
- `php artisan test` — run application tests
- `php artisan tinker` — interact with the app in the console

## 12. Summary
The basic process is:
1. install backend deps
2. install frontend deps
3. configure `.env`
4. generate app key
5. migrate database
6. build frontend
7. run server

This file is intended as a simple, folder-aware setup guide for the Suroysugbo project.