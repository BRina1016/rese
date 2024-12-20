<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [StoreController::class, 'index']);

Route::get('/stores', [StoreController::class, 'index'])->name('store.index');
Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');

Route::get('/detail/{store_id}', [StoreController::class, 'show'])->name('store.detail');
Route::post('/detail/{store_id}/complete', [ReservationController::class, 'completeReservation'])
    ->middleware('auth')
    ->name('reservation.store');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{store_id}', [ReviewController::class, 'index'])->name('reviews.index');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/thanks', function () { return view('thanks'); })->name('thanks');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $previousUrl = $request->header('referer');

    if (parse_url($previousUrl, PHP_URL_PATH) === '/mypage') {
        return redirect('/');
    }

    return redirect()->back();
})->name('logout.get');

Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
Route::delete('/reservation/{id}/delete', [ReservationController::class, 'delete'])->name('reservation.delete');
Route::get('/reservation/{id}/edit', [MyPageController::class, 'editReservation'])->name('reservation.edit');
Route::patch('/reservation/{id}', [MyPageController::class, 'updateReservation'])->name('reservation.update');

Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites', [FavoriteController::class, 'store'])->name('favorites.destroy');
Route::delete('/mypage/favorites', [FavoriteController::class, 'destroyFromMypage'])->name('favorites.destroy.mypage');

Route::post('/detail/{store_id}/complete', [ReservationController::class, 'completeReservation'])->name('reservation.store');
Route::get('/done', [ReservationController::class, 'showDonePage'])->name('reservation.done');

Auth::routes();

Auth::routes(['verify' => true]);

Route::get('/', [StoreController::class, 'index'])->middleware(['auth'])->name('home');
