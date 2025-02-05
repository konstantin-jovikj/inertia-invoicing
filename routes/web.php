<?php

use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\ProductModelController;
use App\Http\Controllers\TermsController;
use App\Models\PackingList;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Document;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurencyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DirectiveController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\DeclarationController;
use App\Http\Controllers\PackingListController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\DocumentTypeController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $clientsCount = Company::whereNotNull('customer_id')->count();
    $packingListCount = PackingList::count();
    $documentsCount = Document::count();
    $totalDocs = $packingListCount + $documentsCount;
    return Inertia::render('Dashboard', [
        'clientsCount' => $clientsCount,
        'documentsCount' => $documentsCount,
        'totalDocs' => $totalDocs,
        'packingListCount' => $packingListCount,
    ]);
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
    Route::put('/contact/update/{contact}', [ContactController::class, 'update'])->name('contact.update');
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

    // TAXES

    Route::get('/taxes', [TaxController::class, 'index'])->name('taxes.index');
    Route::get('/taxes/add', [TaxController::class, 'create'])->name('taxes.create');
    Route::post('/taxes/store', [TaxController::class, 'store'])->name('taxes.store');
    Route::delete('/taxes/delete/{tax}', [TaxController::class, 'destroy'])->name('taxes.delete');

    // CURRENCY

    Route::get('/currency', [CurencyController::class, 'index'])->name('currency.index');
    Route::get('/currency/add', [CurencyController::class, 'create'])->name('currency.create');
    Route::post('/currency/store', [CurencyController::class, 'store'])->name('currency.store');
    Route::delete('/currency/delete/{curency}', [CurencyController::class, 'destroy'])->name('currency.delete');

    // DRIVERS

    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/drivers/add', [DriverController::class, 'create'])->name('drivers.create');
    Route::post('/drivers/store', [DriverController::class, 'store'])->name('drivers.store');
    Route::delete('/drivers/delete/{driver}', [DriverController::class, 'destroy'])->name('drivers.delete');
    Route::get('/drivers/edit/{driver}', [DriverController::class, 'edit'])->name('drivers.edit');
    Route::put('/drivers/update/{driver}', [DriverController::class, 'update'])->name('drivers.update');

    // VEHICLES

    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/add', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::delete('/vehicles/delete/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.delete');
    Route::get('/vehicles/edit/{vehicle}', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/vehicles/update/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');

    // DOCUMENT TYPES

    Route::get('/document/types', [DocumentTypeController::class, 'index'])->name('document.type.index');

    // DOCUMENTS

    Route::get('/documents', [DocumentController::class, 'index'])->name('document.index');
    Route::get('/documents/add/{documentType}', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents/store', action: [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/document/edit/{document}', [DocumentController::class, 'edit'])->name('document.edit');
    Route::put('/document/update/{document}', [DocumentController::class, 'update'])->name('document.update');
    Route::delete('/document/delete/{document}', [DocumentController::class, 'destroy'])->name('document.delete');

    //Create specific document type for selected Client

    Route::post('/documents/client/{company}/store/{documentType}', action: [DocumentController::class, 'createClientDocument'])->name('clientDocument.store');

    Route::get('/documents/add/row/{document}/{product}', [DocumentController::class, 'addEmptyRow'])->name('documents.addrow');

    // CONVERT DOCUMENTS
    Route::post('/convert/document/{document}/{documentTypeNew}', action: [DocumentController::class, 'convert'])->name('documents.convert');
    Route::post('/convert/document/{document}/{documentTypeNew}', action: [DocumentController::class, 'convertCompanyDocument'])->name('documents.convertCompany');

    // PRODUCTS

    Route::get('/products/add/{document}', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/add/modal/{document}', [ProductController::class, 'createModal'])->name('products-modal.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

    Route::put('/products/update/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{product}', [ProductController::class, 'destroy'])->name('products.delete');
    Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');

    // PDF

    Route::get('/product/warranty/{product}', [PDFController::class, 'createWarranty'])->name('warranty');
    Route::get('/document/print/{document}', [PDFController::class, 'printDocument'])->name('print.document');
    Route::get('/ce/print/{product}', [PDFController::class, 'printCe'])->name('print.ce');
    Route::get('/freon/print/{product}', [PDFController::class, 'freonCert'])->name('print.freon');
    Route::get('/travelorder/print/{document}', [PDFController::class, 'printTravelOrder'])->name('print.travelorder');

    //Packing List

    Route::get('/packinglist/create/{packingList}', [PackingListController::class, 'create'])->name('packinglist.create');
    Route::post('/packinglist/add/{document}', [PackingListController::class, 'store'])->name('packinglist.store');
    Route::get('/packinglist/edit/{packingList}', [PackingListController::class, 'edit'])->name('packinglist.edit');
    Route::put('/packinglist/update/{packingList}', [PackingListController::class, 'update'])->name('packinglist.update');
    Route::get('/packinglist/add/modal/{packingList}', [ProductController::class, 'createPackingListModal'])->name('packinglist-modal.create');
    Route::post('/products/packinglist/store', [ProductController::class, 'storePackingListProducts'])->name('products.packinglist.store');

    Route::get('/products/packinglist/edit/{product}', [ProductController::class, 'editPackingListProduct'])->name('product.packinglist.edit');
    Route::put('/products/packinglist/update/{product}', [ProductController::class, 'updatePackingListProducts'])->name('product.packinglist.update');

    Route::get('/packinglist/add/row/{packingList}/{product}', [PackingListController::class, 'addEmptyRow'])->name('packinglist.addrow');

    Route::delete('/packinglist/delete/{packingList}', [PackingListController::class, 'destroy'])->name('packinglist.delete');

    //Declarations

    Route::get('/declarations', [DeclarationController::class, 'index'])->name('declarations.index');
    Route::get('/declaration/edit/{declaration}', [DeclarationController::class, 'edit'])->name('declaration.edit');
    Route::post('/toggle/declaration/{declaration}/{document}', [DeclarationController::class, 'toggleDeclaration'])->name('declarations.toggle');
    Route::get('/declaration/create', [DeclarationController::class, 'create'])->name('declaration.create');
    Route::post('/declaration/store', [DeclarationController::class, 'store'])->name('declaration.store');
    Route::put('/declaration/update/{declaration}', [DeclarationController::class, 'update'])->name('declaration.update');
    Route::delete('/declaration/delete/{declaration}', [DeclarationController::class, 'destroy'])->name('declaration.delete');

    //Regulatives and Directives
    Route::get('/directives', [DirectiveController::class, 'index'])->name('directives.index');
    Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('categoryDirectivesAndRegulations.edit');
    Route::post('/categories/{category}/toggle-regulation', [CategoryController::class, 'toggleRegulation']);
    Route::post('/categories/{category}/toggle-directive', [CategoryController::class, 'toggleDirective']);

    //Regulations

    Route::get('/regulations', [RegulationController::class, 'index'])->name('regulations.index');
    Route::get('/regulation/edit/{regulation}', [RegulationController::class, 'edit'])->name('regulation.edit');

    Route::get('/regulation/create', [RegulationController::class, 'create'])->name('regulation.create');
    Route::post('/regulation/store', [RegulationController::class, 'store'])->name('regulation.store');
    Route::delete('/regulation/delete/{regulation}', [RegulationController::class, 'destroy'])->name('regulation.delete');
    Route::put('/regulation/update/{regulation}', [RegulationController::class, 'update'])->name('regulation.update');

    //Directives

    Route::get('/directives/index', [DirectiveController::class, 'directivesAll'])->name('directivesAll.index');
    Route::get('/directive/create', [DirectiveController::class, 'create'])->name('directive.create');
    Route::post('/directive/store', [DirectiveController::class, 'store'])->name('directive.store');
    Route::get('/directive/edit/{directive}', [DirectiveController::class, 'edit'])->name('directive.edit');
    Route::put('/directive/update/{directive}', [DirectiveController::class, 'update'])->name('directive.update');
    Route::delete('/directive/delete/{directive}', [DirectiveController::class, 'destroy'])->name('directive.delete');

    //Travel Order
    Route::get('/travelorder/{document}', [DocumentController::class, 'viewTravelOrder'])->name('travelorder.view');
    Route::get('/travelorder/edit/{document}', action: [DocumentController::class, 'editTravelOrder'])->name('travelorder.edit');
    Route::put('/travelorder/update/{document}', [DocumentController::class, 'updateTravelOrder'])->name('travelorder.update');

    //Manufacturers

    Route::get('/manufacturers', [ManufacturerController::class, 'index'])->name('manufacturers.index');
    Route::get('/manufacturer/edit/{manufacturer}', [ManufacturerController::class, 'edit'])->name('manufacturer.edit');
    Route::get('/manufacturer/create', [ManufacturerController::class, 'create'])->name('manufacturer.create');
    Route::post('/manufacturer/store', [ManufacturerController::class, 'store'])->name('manufacturer.store');
    Route::put('/manufacturer/update/{manufacturer}', [ManufacturerController::class, 'update'])->name('manufacturer.update');
    Route::delete('/manufacturer/delete/{manufacturer}', [ManufacturerController::class, 'destroy'])->name('manufacturer.delete');

    //Product Models

    Route::get('/productmodels', [ProductModelController::class, 'index'])->name('productmodels.index');
    Route::get('/productmodels/create', [ProductModelController::class, 'create'])->name('productmodels.create');
    Route::post('/productmodels/store', [ProductModelController::class, 'store'])->name('productmodels.store');
    Route::delete('/productmodels/delete/{product_model}', [ProductModelController::class, 'destroy'])->name('productmodels.delete');
    Route::get('/productmodels/edit/{product_model}', [ProductModelController::class, 'edit'])->name('productmodels.edit');
    Route::put('/productmodels/update/{product_model}', [ProductModelController::class, 'update'])->name('productmodels.update');

    //Categories

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit{category}', [CategoryController::class, 'editCatName'])->name('categories.edit');
    Route::put('/categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');

    //Terms

    Route::get('/terms/index', [TermsController::class, 'index'])->name('terms.index');
    Route::get('/terms/create', [TermsController::class, 'create'])->name('term.create');
    Route::post('/terms/store', [TermsController::class, 'store'])->name('term.store');
    Route::get('/terms/edit/{terms}', [TermsController::class, 'edit'])->name('term.edit');
    Route::put('/terms/update/{terms}', [TermsController::class, 'update'])->name('term.update');
    Route::delete('/terms/delete/{terms}', [TermsController::class, 'destroy'])->name('directive.delete');


});

require __DIR__ . '/auth.php';
