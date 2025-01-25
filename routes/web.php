<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LkController;
use App\Http\Controllers\ProfileController;
use Laravel\Fortify\Features;                                       // читаю советы ИИ (не могу настроить изменение пароля) 06.01.2025  - 10.01.2025 - думаю, что это лишнее - можно будет удалить (осторожно)
use App\Http\Controllers\RegisteredUserController;                  // 09.01.2025 Обновим файл routes/web.php, чтобы использовать наш самописный контроллер для регистрации:
use App\Http\Controllers\Auth\ResendVerificationEmailController;    // 10.01.2025 делаем кнопку для повторной отправки ссылки на подтверждение электронной почты

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/posts/{year}/{month}/{day}', function ($year, $month, $day) {
    return 'Пост №: ' . $year;
})->where('year', '2024')->where('month', '0[1-9]|1[012]')->where('day', '0[1-9]|1[0-9]|2[0-9]|3[01]');

Route::prefix('admin/users')->group(function() {
    Route::get('/', function () {
        return 'all';
    });
    Route::get('/{id}', function ($id) {
        return $id;
    })->whereNumber('id');
});

Route::match(['get', 'post'], '/products/card/{prodUrlSemantic}', [CardController::class, 'index']);
Route::match(['get', 'post'], '/products/basket', [BasketController::class, 'show']);
Route::match(['get', 'post'], '/products/favorites', [PackageController::class, 'show']);
Route::match(['get', 'post'], '/orders', [PackageController::class, 'show']);
// Route::get('/products/catalog', ['App\\Http\\Controllers\\CatalogController', 'index']);
Route::match(['get', 'post'], '/products/{category?}', ['App\\Http\\Controllers\\CatalogController', 'index']);
Route::match(['get', 'post'], '/', ['App\\Http\\Controllers\\IndexController', 'index']);
Route::match(['get', 'post'], '/products', ['App\\Http\\Controllers\\ProductController', 'show']);
Route::match(['get', 'post'], '/lk', [LkController::class, 'index']);
Route::match(['get', 'post'], '/profile', [ProfileController::class, 'index'])->middleware(['verified']);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::middleware('auth')->group(function () {
    Route::get('/update-password', function () {
        return view('auth.update-password');
    })->name('password.update');

    Route::get('/update-email', function () {
        return view('auth.update-email');
    })->middleware('password.confirm')->name('user-profile-information.update');
});

// 09.01.2025 Обновим файл routes/web.php, чтобы использовать наш самописный контроллер для регистрации:
// затем отключаем стандартные маршруты Fortify config/fortify.php и найдите раздел features
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// 10.01.2025 делаем кнопку для повторной отправки ссылки на подтверждение электронной почты
// Маршрут для отображения формы
Route::get('/resend-verification-email', function () {
    return view('auth.resend-verification-email');
})->name('verification.resend.form');

// Маршрут для обработки запроса повторной отправки письма
Route::post('/resend-verification-email', [ResendVerificationEmailController::class, 'resend'])
    ->name('verification.resend');
