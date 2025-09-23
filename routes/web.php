<?php

use App\Http\Controllers\SocialiteController;
use App\Models\Client;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Route;

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

if (request()->get('test')) {
    dd(Client::where('id', 9)->first()->candidates);
}

Route::get('login/google', [SocialiteController::class, 'redirectToGoogleProvider']);
Route::get('login/google/callback', [SocialiteController::class, 'handlerGoogleProviderCallback']);

Route::get('login/linkedin', [SocialiteController::class, 'redirectToLinkedinProvider']);
Route::get('login/linkedin/callback', [SocialiteController::class, 'handlerLinkedinProviderCallback']);

Route::get('/email', function () {
    return (new MailMessage)
        ->greeting('Parabéns sua vaga foi aprovada!')
        ->subject('Vaga aprovada | ' . config('app.name'))
        ->action('Acesse agora!', url('./?v=1'));
});
