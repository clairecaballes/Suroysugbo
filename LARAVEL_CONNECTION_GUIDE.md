# Laravel Setup Guide - Suroysugbo Project

## Prerequisites
Ensure you have the following installed:
- **PHP 8.2+** - Backend language
- **Composer** - PHP dependency manager
- **Node.js & npm** - Frontend build tools
- **MySQL** - Database (or SQLite as alternative)
- **Git** - Version control

## Step 1: Clone the Repository
```bash
git clone <repository-url>
cd Suroysugbo
```

## Step 2: Install PHP Dependencies
```bash
composer install
```
This installs all Laravel packages and libraries defined in `composer.json`.

## Step 3: Install Node Dependencies
```bash
npm install
```
This installs frontend dependencies including Vue.js, Tailwind CSS, and Vite.

## Step 4: Setup Environment Variables
```bash
copy .env.example .env
```

Edit the `.env` file and configure:
```
APP_NAME=Suroysugbo
APP_ENV=local
APP_DEBUG=true
APP_KEY=
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=suroydb
DB_USERNAME=root
DB_PASSWORD=root
```

## Step 5: Generate Application Key
```bash
php artisan key:generate
```
This creates a unique encryption key for the application.

## Step 6: Create & Configure Database
**Option A: MySQL**
- Create a new database in MySQL:
```sql
CREATE DATABASE suroydb;
```
- Update `DB_*` variables in `.env` with your credentials

**Option B: SQLite**
- Set `DB_CONNECTION=sqlite` in `.env`
- The database file will be created automatically during migrations

## Step 7: Run Database Migrations
```bash
php artisan migrate
```
This creates all database tables defined in the `database/migrations` folder.

## Step 8: Seed the Database (Optional)
```bash
php artisan db:seed
```
This populates the database with sample data if seeders exist.

## Step 9: Build Frontend Assets
```bash
npm run build
```
Or for development with hot reload:
```bash
npm run dev
```

## Step 10: Start the Development Server
```bash
php artisan serve
```
The application will run at `http://localhost:8000`

## Step 11: Run Tests (Optional)
```bash
php artisan test
```
This runs Pest tests in the `tests/` directory.

## Using Docker (Alternative)
If you prefer Docker:
```bash
docker-compose up
```
This builds and runs the application in containers.

## Troubleshooting

| Issue | Solution |
|-------|----------|
| "Composer not found" | Install Composer from [getcomposer.org](https://getcomposer.org) |
| "MySQL connection error" | Check DB credentials in `.env` and ensure MySQL is running |
| "APP_KEY not set" | Run `php artisan key:generate` |
| "npm install fails" | Delete `node_modules` and `package-lock.json`, then run `npm install` again |
| "Port 8000 already in use" | Use `php artisan serve --port=8001` |

## Quick Reference Commands
```bash
php artisan migration        # Create new migration
php artisan make:model Name  # Create model
php artisan make:controller NameController  # Create controller
php artisan tinker          # Interactive shell
npm run build               # Build frontend for production
php artisan optimize        # Cache configuration for production
```

## Project Structure
- **app/** - Controllers, Models, Business Logic
- **database/** - Migrations, Seeders, Factories
- **resources/js/** - Vue.js components
- **routes/** - Application routes
- **config/** - Configuration files
- **vendor/** - Composer packages
- **node_modules/** - NPM packages

## Next Steps
1. Explore [Laravel Documentation](https://laravel.com/docs)
2. Review your [Vue.js Components](resources/js/)
3. Check the [API Routes](routes/api.php)
4. Run tests with `php artisan test`
