# Source Codes for Suroysugbo Project

This file contains key source code snippets from the project. For full code, refer to the project files.

## 1. Backend: DashboardController.php (app/Http/Controllers/DashboardController.php)
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $props = [
                'totalLegacyItems' => \App\Models\CebuLegacy::count(),
                'totalMessages' => \App\Models\Message::count(),
                'totalReviews' => \App\Models\Review::count(),
            ];
        } catch (Throwable $e) {
            report($e);

            $props = [
                'totalLegacyItems' => 0,
                'totalMessages' => 0,
                'totalReviews' => 0,
            ];
        }

        return inertia('Dashboard', $props);
    }
}
```

## 2. Backend: CebuLegacy.php Model (app/Models/CebuLegacy.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CebuLegacy extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'coordinates',
        'ispublished',
    ];

    public function tourSites()
    {
        return $this->hasMany(TourSite::class);
    }

    public function vehicleRoutes()
    {
        return $this->hasMany(VehicleRoute::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->tourSites->first()?->image ? asset('storage/' . $this->tourSites->first()->image) : null;
    }

    public function getSoundUrlAttribute()
    {
        return $this->bgsound ? asset('storage/' . $this->bgsound) : null;
    }
}
```

## 3. Frontend: Dashboard.vue (resources/js/pages/Dashboard.vue)
```vue
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { CheckCircle, MessageCircle, Star } from 'lucide-vue-next';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale
} from 'chart.js'
import { Line } from 'vue-chartjs'

const props = defineProps({
    totalLegacyItems:  Number,
    totalMessages: Number,
    totalReviews: Number,
});
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Register Chart.js components
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale
)

const chartData = {
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
  datasets: [
    {
      label: 'Requests',
      data: [100, 200, 150, 300, 250],
      borderColor: '#42A5F5',
      backgroundColor: 'rgba(66, 165, 245, 0.2)',
      fill: true,
      tension: 0.4,
    }
  ]
}

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { position: 'top' },
    title: {
      display: true,
      text: 'Monthly visitors',
    }
  }
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-blue-600 dark:bg-blue-700 flex items-center justify-between p-6 shadow">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-2">Total Sites</h2>
                        <p class="text-3xl font-bold text-white">{{ props.totalLegacyItems }}</p>
                    </div>
                    <CheckCircle class="h-24 w-24 text-white" />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-green-600 dark:bg-green-700 flex items-center justify-between p-6 shadow">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-2">Total Messages</h2>
                        <p class="text-3xl font-bold text-white">{{ props.totalMessages }}</p>
                    </div>
                    <MessageCircle class="h-24 w-24 text-white" />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-purple-600 dark:bg-purple-700 flex items-center justify-between p-6 shadow">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-2">Total Reviews</h2>
                        <p class="text-3xl font-bold text-white">{{ props.totalReviews }}</p>
                    </div>
                    <Star class="h-24 w-24 text-white" />
                </div>
            </div>
             <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-6 shadow">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Monthly Visitor</h2>
                <div class="h-[400px]">
                    <Line :data="chartData" :options="chartOptions" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
```

## 4. Routes: web.php (routes/web.php)
```php
<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\TourController::class, 'index'])->name('home');
Route::get('/cebu-legacy/view/{id}', [App\Http\Controllers\TourController::class, 'view'])->name('view');

Route::get('dashboard', [App\Http\Controllers\DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/cebu-legacy', [App\Http\Controllers\CebuLegacyController::class, 'index'])->name('cebu-legacy');
    Route::get('/cebu-legacy/edit', [App\Http\Controllers\CebuLegacyController::class, 'create'])->name('cebu-legacy.create');
    Route::post('/cebu-legacy/store', [App\Http\Controllers\CebuLegacyController::class, 'store'])->name('cebu-legacy.store');
    Route::get('/cebu-legacy/edit/{id}', [App\Http\Controllers\CebuLegacyController::class, 'edit'])->name('cebu-legacy.edit');
    Route::put('/cebu-legacy/update/{id}', [App\Http\Controllers\CebuLegacyController::class, 'update'])->name('cebu-legacy.update');
    Route::delete('/cebu-legacy/route/{id}', [App\Http\Controllers\CebuLegacyController::class, 'destroy'])->name('cebu-legacy.destroy');
    Route::delete('/cebu-legacy/delete/{id}', [App\Http\Controllers\CebuLegacyController::class, 'delete'])->name('cebu-legacy.delete');
    Route::post('/cebu-legacy/image-upload', [App\Http\Controllers\CebuLegacyController::class, 'storeTourSite'])
        ->name('cebu-legacy.image-upload');
    Route::delete('/cebu-legacy/image-delete/{id}', [App\Http\Controllers\CebuLegacyController::class, 'deleteImage'])
        ->name('cebu-legacy.image-delete');
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])
        ->name('messages.index');
    Route::get('/messages/{id}/read/', [App\Http\Controllers\MessageController::class, 'read'])
        ->name('messages.read');
    Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])
        ->name('reviews.index');
    Route::get('/reviews/{id}/read/', [App\Http\Controllers\ReviewController::class, 'read'])
        ->name('reviews.read');
    Route::post('/reviews/{id}/publish/', [App\Http\Controllers\ReviewController::class, 'publish'])
        ->name('reviews.publish');
});

Route::post('/message-post', [App\Http\Controllers\MessageController::class, 'store'])
    ->name('messages.store');

Route::post('/review-post', [App\Http\Controllers\ReviewController::class, 'store'])
    ->name('review.store');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
```

## 5. Migration: cebu_legacy (database/migrations/2025_05_22_193438_vehicle_route.php)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cebu_legacy', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('coordinates');
            $table->boolean('ispublished')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cebu_legacy');
    }
};
```

## 6. Package.json (package.json)
```json
{
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build",
        "build:ssr": "vite build && vite build --ssr",
        "dev": "vite",
        "format": "prettier --write resources/",
        "format:check": "prettier --check resources/",
        "lint": "eslint . --fix"
    },
    "devDependencies": {
        "@eslint/js": "^9.19.0",
        "@types/node": "^22.13.5",
        "@vue/eslint-config-typescript": "^14.3.0",
        "eslint": "^9.17.0",
        "eslint-config-prettier": "^10.0.1",
        "eslint-plugin-vue": "^9.32.0",
        "prettier": "^3.4.2",
        "prettier-plugin-organize-imports": "^4.1.0",
        "prettier-plugin-tailwindcss": "^0.6.11",
        "typescript-eslint": "^8.23.0",
        "vue-tsc": "^2.2.4"
    },
    "dependencies": {
        "@inertiajs/vue3": "^2.0.0",
        "@tailwindcss/vite": "^4.1.1",
        "@vitejs/plugin-vue": "^5.2.1",
        "@vueuse/core": "^12.8.2",
        "axios": "^1.9.0",
        "chart.js": "^4.5.0",
        "class-variance-authority": "^0.7.1",
        "clsx": "^2.1.1",
        "concurrently": "^9.0.1",
        "dotenv": "^16.5.0",
        "laravel-vite-plugin": "^1.0",
        "leaflet.markercluster": "^1.5.3",
        "lucide-vue-next": "^0.468.0",
        "reka-ui": "^2.2.0",
        "sweetalert2": "^11.22.0",
        "tailwind-merge": "^3.2.0",
        "tailwindcss": "^4.1.1",
        "tw-animate-css": "^1.2.5",
        "typescript": "^5.2.2",
        "vite": "^6.2.0",
        "vue": "^3.5.13",
        "vue-chartjs": "^5.3.2",
        "vue-star-rating": "^1.7.0",
        "vue-vr": "^0.0.77",
        "vue3-google-map": "^0.22.0"
    }
}
```

For full source code, clone the repository and explore the files. This provides key snippets.