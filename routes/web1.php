<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SubSubCategoryController;
//use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\ProductController;
// Product CRUD
//  Route::resource('products', ProductController::class);


// ================= PRODUCT ROUTES =================

   // AJAX dependent dropdown routes
   Route::get('/categories/{id}/subcategories', [ProductController::class, 'getSubcategories'])->name('categories.subcategories');
   Route::get('/subcategories/{id}/subsubcategories', [ProductController::class, 'getSubSubcategories'])->name('subcategories.subsubcategories');



// Products Resource Routes
Route::resource('products', ProductController::class);

// Extra route for DataTables JSON
Route::get('products-data', [ProductController::class, 'indexData'])->name('products.data');


    //datatable
//     Route::get('/products/data', [ProductController::class, 'getData'])->name('products.data');

   
Route::prefix('products')->name('products.')->group(function () {

//     // List all products
//     Route::get('/', [ProductController::class, 'index'])->name('index');

//     // Show create form
//     Route::get('/create', [ProductController::class, 'create'])->name('create');

//     // Store new product
//     Route::post('/', [ProductController::class, 'store'])->name('store');

//     // Show edit form
//     Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');

//     // Update product
//     Route::put('/{product}', [ProductController::class, 'update'])->name('update');

//     // Delete product
    // Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');

//     // ================= PRODUCT IMAGE ROUTES =================
//     Route::delete('/images/{image}', [ProductImageController::class, 'destroy'])
//         ->name('images.destroy');

//     Route::post('/{product}/images/{image}/thumbnail', [ProductImageController::class, 'setThumbnail'])
//         ->name('images.thumbnail');

//             // === Export Routes ===
//     Route::get('/export/csv', [ProductController::class, 'exportCsv'])->name('export.csv');
//     Route::get('/export/excel', [ProductController::class, 'exportExcel'])->name('export.excel');
//     Route::get('/export/pdf', [ProductController::class, 'exportPdf'])->name('export.pdf');
//     Route::get('/export/print', [ProductController::class, 'exportPrint'])->name('export.print');


 
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Categories
    Route::resource('categories', CategoryController::class);

    // Subcategories
    Route::resource('subcategories', SubcategoryController::class);

    // Sub-subcategories
    Route::resource('subsubcategories', SubsubCategoryController::class);
    //Route::get('subsubcategories-data', [SubsubCategoryController::class, 'getData'])->name('subsubcategories.data');
    Route::get('subsubcategories-data', [SubsubCategoryController::class, 'getData'])->name('subsubcategories.data');

    // Products
    //Route::resource('products', ProductController::class);

    // Product Images
    Route::post('products/{product}/images', [ProductImageController::class, 'store'])
        ->name('products.images.store');
    Route::delete('products/images/{image}', [ProductImageController::class, 'destroy'])
        ->name('products.images.destroy');
    Route::post('products/images/{image}/set-primary', [ProductImageController::class, 'setPrimary'])
        ->name('products.images.setPrimary');

    // AJAX Endpoints for dynamic dropdowns
    //Route::get('get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('get-subcategories');
    //Route::get('get-subsubcategories/{subcategoryId}', [ProductController::class, 'getSubsubcategories'])->name('get-subsubcategories');

    // Product image delete + thumbnail
    Route::delete('products/{product}/images/{image}', [ProductController::class, 'deleteImage'])
        ->name('products.deleteImage');
    Route::put('products/{product}/images/{image}/thumbnail', [ProductController::class, 'setThumbnail'])
        ->name('products.setThumbnail');

    Route::delete('product-images/{productImage}', [ProductImageController::class, 'destroy'])
        ->name('product-images.destroy');
    Route::post('product-images/{productImage}/set-thumbnail', [ProductImageController::class, 'setThumbnail'])
        ->name('product-images.set-thumbnail');
});
