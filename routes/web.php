<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SubSubCategoryController;
use App\Http\Controllers\Admin\ProductImageController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\FrontendProductController;


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
    //return redirect()->route('admin.products.index');
    return view('home');
});



Route::prefix('products')->group(function () {
    Route::get('/{categorySlug}', [FrontendProductController::class, 'listing'])
        ->name('products.listing');

    Route::get('/{categorySlug}/{subcategorySlug}', [FrontendProductController::class, 'listing'])
        ->name('products.subcategory');

    Route::get('/{categorySlug}/{subcategorySlug}/{subSubCategorySlug}', [FrontendProductController::class, 'listing'])
        ->name('products.subsubcategory');

    // ✅ Product details (works for category / subcategory / sub-subcategory levels)
    Route::get('/{categorySlug}/{slug1?}/{slug2?}/{productSlug}', [FrontendProductController::class, 'show'])
    ->name('products.show');
});


// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Categories
    Route::resource('categories', CategoryController::class);

    // Subcategories
    Route::resource('subcategories', SubcategoryController::class);

    // Sub-subcategories
    Route::resource('subsubcategories', SubsubCategoryController::class);
    Route::get('subsubcategories-data', [SubsubCategoryController::class, 'getData'])->name('subsubcategories.data');


    // AJAX dependent dropdown routes
    Route::get('/categories/{id}/subcategories', [ProductController::class, 'getSubcategories'])->name('categories.subcategories');
    Route::get('/subcategories/{id}/subsubcategories', [ProductController::class, 'getSubSubcategories'])->name('subcategories.subsubcategories');

    // Products Resource Routes
    Route::resource('products', ProductController::class);

    // Extra route for DataTables JSON
    Route::get('products-data', [ProductController::class, 'indexData'])->name('products.data');

    // Product Images
    Route::post('product-images', [ProductImageController::class, 'store'])
        ->name('product-images.store');

    Route::delete('product-images/{id}', [ProductImageController::class, 'destroy'])
        ->name('product-images.destroy');

    Route::post('product-images/{id}/set-thumbnail', [ProductImageController::class, 'setThumbnail'])
        ->name('product-images.setThumbnail');

    Route::delete('product-images/{id}', [ProductImageController::class, 'deleteImage'])->name('product-images.destroy');

});
