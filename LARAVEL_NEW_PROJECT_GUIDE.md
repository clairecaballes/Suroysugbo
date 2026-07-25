# Creating a NEW Laravel Project - Step by Step

## Prerequisites
Ensure you have the following installed:
- **PHP 8.2+** - Backend language
- **Composer** - PHP dependency manager
- **Node.js & npm** - Frontend build tools
- **MySQL** - Database (or SQLite as alternative)
- **Git** - Version control

## Step 1: Create a New Laravel Project

**Option A: Using Composer (Recommended)**
```bash
composer create-project laravel/laravel MyProjectName
cd MyProjectName
```

**Option B: Using Laravel Installer**
```bash
laravel new MyProjectName
cd MyProjectName
```

Replace `MyProjectName` with your desired project name.

## Step 2: Install Node Dependencies
```bash
npm install
```
This installs frontend dependencies including Vite, Vue.js (if using Inertia), and Tailwind CSS.

## Step 3: Setup Environment Variables
```bash
copy .env.example .env
```

Edit the `.env` file and configure your project settings:
```
APP_NAME="MyProjectName"
APP_ENV=local
APP_DEBUG=true
APP_KEY=
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_database_name
DB_USERNAME=root
DB_PASSWORD=root
```

## Step 4: Generate Application Key
```bash
php artisan key:generate
```
This creates a unique encryption key stored in the `.env` file.

## Step 5: Create Database
**Option A: MySQL**
```bash
# Open MySQL client
mysql -u root -p
```
Then in MySQL:
```sql
CREATE DATABASE my_database_name;
```

**Option B: SQLite (No setup needed)**
Just change `.env`:
```
DB_CONNECTION=sqlite
```

## Step 6: Run Database Migrations
```bash
php artisan migrate
```
This creates default Laravel tables (users, migrations, jobs, etc.) in your database.

## Step 7: (Optional) Install Additional Packages

**For Vue.js + Inertia Stack:**
```bash
composer require inertiajs/inertia-laravel
composer require laravel/breeze --dev
php artisan breeze:install vue
npm install
```

**For Tailwind CSS:**
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

**For Authentication:**
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

## Step 8: Build Frontend Assets
```bash
npm run build
```

Or for development with hot reload:
```bash
npm run dev
```

## Step 9: Start the Development Server
```bash
php artisan serve
```
The application will run at `http://localhost:8000`

Visit http://localhost:8000 in your browser to see your new Laravel app.

## Step 10: Create Your First Model & Migration

```bash
php artisan make:model Post -m
```
This creates a `Post` model with a migration file. Edit the migration file:

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->timestamps();
});
```

Then run the migration:
```bash
php artisan migrate
```

## Step 11: Create a Controller
```bash
php artisan make:controller PostController --resource
```
This creates a controller with resource methods (index, create, store, show, edit, update, destroy).

## Step 12: Define Routes
Edit `routes/web.php`:
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts', PostController::class);
```

## Step 13: Run Tests (Optional)
```bash
php artisan test
```

## Project Structure (New Project)
```
MyProjectName/
├── app/                    # Models, Controllers, Business Logic
├── bootstrap/              # Bootstrap files
├── config/                 # Configuration files
├── database/               # Migrations, Seeders, Factories
├── public/                 # Public web root
├── resources/
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript/Vue components
│   └── views/             # Blade templates
├── routes/                # Route definitions (web.php, api.php)
├── storage/               # Logs, cache
├── tests/                 # Test files
├── .env                   # Environment variables
├── artisan                # Laravel CLI tool
├── composer.json          # PHP dependencies
├── package.json           # Node.js dependencies
└── vite.config.js         # Vite configuration
```

## Common Commands for New Projects

```bash
php artisan make:model ModelName              # Create a model
php artisan make:model ModelName -m           # Model with migration
php artisan make:controller NameController    # Create controller
php artisan make:migration create_table_name  # Create migration
php artisan make:seeder NameSeeder            # Create seeder
php artisan migrate                           # Run migrations
php artisan migrate:rollback                  # Undo migrations
php artisan tinker                            # Interactive shell
php artisan route:list                        # View all routes
php artisan config:cache                      # Cache configuration
php artisan storage:link                      # Create storage symlink
```

## Troubleshooting

| Issue | Solution |
|-------|----------|
| "Failed to create project" | Ensure Composer is up to date: `composer self-update` |
| "Class not found" | Run `composer dump-autoload` |
| "Database connection error" | Verify MySQL is running and `.env` credentials are correct |
| "APP_KEY not set" | Run `php artisan key:generate` |
| "npm install fails" | Delete `node_modules` and `package-lock.json`, then `npm install` |
| "Port 8000 in use" | Use `php artisan serve --port=8001` |
| "Storage directory is not writable" | Run `chmod -R 775 storage` (Linux/Mac) or check permissions (Windows) |

## Next Steps

1. **Learn Laravel Fundamentals:**
   - [Laravel Documentation](https://laravel.com/docs)
   - Controllers and Routing
   - Database and Models (Eloquent ORM)

2. **Build Features:**
   - Create models and migrations
   - Write controllers with business logic
   - Define routes
   - Create Blade templates

3. **Deploy:**
   - Test with `php artisan test`
   - Build frontend: `npm run build`
   - Configure production `.env`
   - Deploy to hosting (Laravel Forge, Heroku, AWS, etc.)

## Quick Start Example

```bash
# 1. Create project
composer create-project laravel/laravel MyBlog
cd MyBlog

# 2. Install frontend dependencies
npm install

# 3. Setup env
copy .env.example .env
php artisan key:generate

# 4. Configure database in .env
# Then create database:
# CREATE DATABASE myblog;

# 5. Run migrations
php artisan migrate

# 6. Start development
php artisan serve
npm run dev
```

Visit http://localhost:8000 and you're ready to go!
