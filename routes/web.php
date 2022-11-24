<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DiapazonController;
use App\Http\Controllers\SkidkiController;
use App\Http\Controllers\PostavshikiController;
use App\Http\Controllers\Armtek;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

Route::get('/', [IndexController::class, 'index']); //Главная страница
Route::post('/changeuser', [IndexController::class, 'changeUser']); //Главная страница

Route::get('/catalog', [IndexController::class, 'catalog']);
Route::get('/catalogs/{catalog_code}', [IndexController::class, 'catalogs']);
Route::get('/catalogs/modifications/{catalog_code}', [IndexController::class, 'modifications']);
Route::get('/catalogs/tree/{catalog_code}', [IndexController::class, 'tree']);
Route::get('/catalogs/parts/{i}/{mi}', [IndexController::class, 'partsget']);


Route::get('/parts/brands-list/{part_code}', [PartController::class, 'brands_list']); //Поиск по артикулу
Route::get('/parts/brands-list/{part_code}/brand', [PartController::class, 'parts_list']); //Поиск по артикулу и бренду. Возвращает список товаров.
Route::resource('basket', OrderController::class); //Страница корзины

Route::group(['middleware' => ['auth','role:admin']], function () {
    Route::resource('/dashboard/users', UserController::class);
    Route::get('/dashboard/personal', [UserController::class, 'personal'])->name('personal');
    Route::post('/basket/createOrder', [OrderController::class, 'createOrder']);
    Route::get('/dashboard/orders', [OrderController::class, 'orders'])->name('dashboard.orders');
    Route::get('/dashboard/postavshiki', [PostavshikiController::class, 'index'])->name('dashboard.postavshiki.index');
    Route::get('/dashboard/postavshiki/{status}/{id}', [PostavshikiController::class, 'change_status']);
    Route::post('/dashboard/orders/{id}', [OrderController::class, 'change_status']);
    Route::get('/dashboard/providers', [OrderController::class, 'providers'])->name('dashboard.providers');
    Route::get('/dashboard/obrabotka', [OrderController::class, 'obrabotka'])->name('dashboard.obrabotka');
    Route::resource('/dashboard/diapazon', DiapazonController::class);
    Route::resource('/dashboard/skidki', SkidkiController::class);
});

Route::inertia('/faq', 'Frontend/Faq');

Route::get('/movement', [OrderController::class, 'movement'])->name('move');

Route::inertia('/contacts', 'Frontend/Contacts');

Route::inertia('/modifications', 'Frontend/Mods');



// Для авторизаций и восстановлений
Route::resource('posts', PostController::class);


Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Код для подтверждения отправлен!');
})->middleware(['auth', 'throttle:3,1'])->name('verification.send');

Route::post('/users/verification', [UserController::class, 'verification']);

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['phone' => 'required']);

    $status = Password::sendResetLink(
        $request->only('phone')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['phone' => __($status)]);
})->middleware('guest')->name('password.email');


Route::get('/test', [Armtek::class, 'getUserVkorgList']);
Route::get('/test2', [Armtek::class, 'getUserInfo']);
Route::get('/test3', [Armtek::class, 'get_brands_list']);
Route::get('/test4', [Armtek::class, 'get_parts_list']);





