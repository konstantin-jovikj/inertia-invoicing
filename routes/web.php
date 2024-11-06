<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerTypeController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // COUNTRIES

    Route::get('/countries', [CountryController::class, 'index'])->name('country.index');
    Route::get('/countries/add', [CountryController::class, 'create'])->name('country.create');
    Route::post('/countries/store', [CountryController::class, 'store'])->name('country.store');
    Route::get('/countries/edit/{country}', [CountryController::class, 'edit'])->name('country.edit');
    Route::put('/countries/update/{country}', [CountryController::class, 'update'])->name('country.update');
    Route::delete('/countries/delete/{country}', [CountryController::class, 'destroy'])->name('country.delete');

    // PLACES

    Route::get('/places', [PlaceController::class, 'index'])->name('place.index');
    Route::get('/places/edit/{place}', [PlaceController::class, 'edit'])->name('place.edit');
    Route::delete('/places/delete/{place}', [PlaceController::class, 'destroy'])->name('place.delete');
    Route::get('/places/add', [PlaceController::class, 'create'])->name('place.create');
    Route::post('/places/store', [PlaceController::class, 'store'])->name('place.store');
    Route::get('/places/edit/{place}', [PlaceController::class, 'edit'])->name('place.edit');
    Route::put('/places/update/{place}', [PlaceController::class, 'update'])->name('place.update');

    // CUSTOMER TYPE

    Route::get('/customertype', [CustomerTypeController::class, 'index'])->name('customertype.index');
    Route::get('/customertype/edit/{customer_type}', [CustomerTypeController::class, 'edit'])->name('customertype.edit');
    Route::delete('/customertype/delete/{customer_type}', [CustomerTypeController::class, 'destroy'])->name('customertype.delete');
    Route::get('/customertype/add', [CustomerTypeController::class, 'create'])->name('customertype.create');
    Route::post('/customertype/store', [CustomerTypeController::class, 'store'])->name('customertype.store');
    Route::put('/customertype/update/{customer_type}', [CustomerTypeController::class, 'update'])->name('customertype.update');

    // CUSTOMERS - Komintenti

    Route::get('/customers/add', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');



    // COMPANIES
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');

    Route::get('/companies/notcustomer', [CompanyController::class, 'index'])->name('companies.notcustomer.index');

    Route::get('/companies/edit/{company}', [CompanyController::class, 'edit'])->name('company.edit');
    Route::get('/companies/edit/logo/{company}', [CompanyController::class, 'editLogo'])->name('company.logo.edit');

    Route::put('/companies/update/{company}', [CompanyController::class, 'update'])->name('company.update');
    Route::post('/companies/update/logo/{company}', [CompanyController::class, 'updateLogo'])->name('company.logo.update');

    Route::get('/companies/add', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/companies/store', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/companies/show/{company}', [CompanyController::class, 'show'])->name('company.show');
    Route::delete('/companies/delete/{company}', [CompanyController::class, 'destroy'])->name('company.delete');


    // CONTACTS

    Route::get('/contacts/add/{company}', [ContactController::class, 'create'])->name('contacts.create');
    Route::get('/contacts/edit/{contact}', [ContactController::class, 'edit'])->name('contact.edit');
    Route::post('/contacts/store', [ContactController::class, 'store'])->name('contacts.store');
    Route::delete('/contacts/delete/{contact}', [ContactController::class, 'destroy'])->name('contact.delete');

    // BANKS

    Route::get('/banks', [BankController::class, 'index'])->name('banks.index');
    Route::get('/banks/edit/{bank}', [BankController::class, 'edit'])->name('bank.edit');
    Route::get('/banks/add', [BankController::class, 'create'])->name('bank.create');
    Route::delete('/bank/delete/{bank}', [BankController::class, 'destroy'])->name('bank.delete');
    Route::post('/banks/store', [BankController::class, 'store'])->name('bank.store');
    Route::put('/banks/update/{bank}', [BankController::class, 'update'])->name('bank.update');

    // ACCOUNTS

    Route::get('/accounts/add/{company}', [AccountController::class, 'create'])->name('account.create');
    Route::post('/accounts/store', [AccountController::class, 'store'])->name('account.store');
    Route::patch('/activate/account/{account}', [AccountController::class, 'toggleActive'])->name('toggle.account');
    Route::get('/accounts/edit/{account}', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/accounts/update/{account}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/accounts/delete/{account}', [AccountController::class, 'destroy'])->name('account.delete');


     // OFFERS


});

require __DIR__ . '/auth.php';
