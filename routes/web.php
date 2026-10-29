<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminPhotoController;


Route::livewire('/', 'home')->name('home');
Route::livewire('/livewire', 'home')->name('livewire');

Route::middleware('guest')->group(function (): void {
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/settings', [AdminController::class, 'editSettings'])->name('settings.edit');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/whatsapp-message', [AdminController::class, 'editWhatsAppMessage'])->name('whatsapp-message.edit');
    Route::put('/whatsapp-message', [AdminController::class, 'updateWhatsAppMessage'])->name('whatsapp-message.update');
    Route::delete('/whatsapp-message', [AdminController::class, 'resetWhatsAppMessage'])->name('whatsapp-message.reset');
    Route::get('/photos', [AdminPhotoController::class, 'index'])->name('photos.index');
    Route::post('/photos', [AdminPhotoController::class, 'store'])->name('photos.store');
    Route::patch('/photos/{photo}', [AdminPhotoController::class, 'update'])->whereNumber('photo')->name('photos.update');
    Route::delete('/photos/{photo}', [AdminPhotoController::class, 'destroy'])->whereNumber('photo')->name('photos.destroy');
    Route::post('/invitations', [AdminController::class, 'storeInvitation'])->name('invitations.store');
    Route::delete('/invitations/{guest}', [AdminController::class, 'destroyInvitation'])->whereNumber('guest')->name('invitations.destroy');
    Route::patch('/rsvps/{guest}/reply', [AdminController::class, 'reply'])->whereNumber('guest')->name('rsvps.reply');
    Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');
});
