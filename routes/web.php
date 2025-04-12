<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\site\CategoryController as SiteCategoryController;
use App\Http\Controllers\site\SubcategoryController as SiteSubcategoryController;
use App\Http\Controllers\admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\admin\SubcategoryController as AdminSubcategoryController;
use App\Http\Controllers\admin\ForumController as AdminForumController;
use App\Http\Controllers\site\ForumController as SiteForumController;
use App\Http\Controllers\site\TopicController as SiteTopicController;
use App\Http\Controllers\admin\TopicController as AdminTopicController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/site/dashboard', function () {
    return view('site.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('site/category', [SiteCategoryController::class, 'index'])->name('category');
    Route::get('site/category/search', [SiteCategoryController::class, 'index'])->name('site/category/search');

    Route::get('site/{id}/subcategories', [SiteSubcategoryController::class, 'index'])->name('site/subcategories');
    Route::get('site/{id}/subcategories/search', [SiteSubcategoryController::class, 'index'])->name('site/subcategories/search');

    Route::get('/site/{id}/forums', [SiteForumController::class, 'index'])->name('site/forums');
    Route::get('/site/{id}/forums/search', [SiteForumController::class, 'index'])->name('site/forums/search');

    Route::get('/site/{id}/topics', [SiteTopicController::class, 'index'])->name('site/topics');
    Route::get('/site/{id}/topics/search', [SiteTopicController::class, 'index'])->name('site/topics/search');
    Route::post('/site/topic/create', [SiteTopicController::class, 'create'])->name('site/topic/create');
    Route::post('/site/topic/store', [SiteTopicController::class, 'store'])->name('site/topic/store');
});

// ========================= admin Routes =========================

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(AdminMiddleware::class)->name('admin/dashboard');

Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get('/admin/category', [AdminCategoryController::class, 'index'])->name('admin/category');
    Route::get('/admin/category/create', [AdminCategoryController::class, 'create'])->name('admin/category/create');
    Route::post('/admin/category/store', [AdminCategoryController::class, 'store'])->name('admin/category/store');
    Route::get('/admin/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin/category/edit');
    Route::patch('/admin/category/update/{category}', [AdminCategoryController::class, 'update'])->name('admin/category/update');
    Route::delete('/admin/category/{id}', [AdminCategoryController::class, 'delete'])->name('admin/category.delete');
    Route::patch('/admin/category/restore/{id}', [AdminCategoryController::class, 'restore'])->name('admin/category/restore');
    Route::get('/admin/category/search', [AdminCategoryController::class, 'index'])->name('admin/category/search');

    Route::get('/admin/subcategory', [AdminSubcategoryController::class, 'index'])->middleware(AdminMiddleware::class)->name('admin/subcategory');
    Route::get('/admin/subcategory/create', [AdminSubcategoryController::class, 'create'])->name('admin/subcategory/create');
    Route::post('/admin/subcategory/store', [AdminSubcategoryController::class, 'store'])->name('admin/subcategory/store');
    Route::get('/admin/subcategory/edit/{id}', [AdminSubcategoryController::class, 'edit'])->name('admin/subcategory/edit');
    Route::patch('/admin/subcategory/update/{subcategory}', [AdminSubcategoryController::class, 'update'])->name('admin/subcategory/update');
    Route::delete('/admin/subcategory/{id}', [AdminSubcategoryController::class, 'delete'])->name('admin/subcategory.delete');
    Route::patch('/admin/subcategory/restore/{id}', [AdminSubcategoryController::class, 'restore'])->name('admin/subcategory/restore');
    Route::get('/admin/subcategory/search', [AdminSubcategoryController::class, 'index'])->name('admin/subcategory/search');

    Route::get('/admin/forums', [AdminForumController::class, 'index'])->middleware(AdminMiddleware::class)->name('admin/forum');
    Route::get('/admin/forum/create', [AdminForumController::class, 'create'])->name('admin/forum/create');
    Route::post('/admin/forum/store', [AdminForumController::class, 'store'])->name('admin/forum/store');
    Route::get('/admin/forum/edit/{id}', [AdminForumController::class, 'edit'])->middleware(AdminMiddleware::class)->name('admin/forum/edit');
    Route::patch('/admin/forum/update/{forum}', [AdminForumController::class, 'update'])->middleware(AdminMiddleware::class)->name('admin/forum/update');
    Route::delete('/admin/forum/{id}', [AdminForumController::class, 'delete'])->name('admin/forum/delete');
    Route::patch('/admin/forum/restore/{id}', [AdminForumController::class, 'restore'])->name('admin/forum/restore');
    Route::get('/admin/forum/search', [AdminforumController::class, 'index'])->name('admin/forum/search');

    Route::get('/admin/topics', [AdminTopicController::class, 'index'])->middleware(AdminMiddleware::class)->name('admin/topics');
    Route::get('/admin/topics/create', [AdminTopicController::class, 'create'])->name('admin/topics/create');
    Route::post('/admin/topic/store', [AdminTopicController::class, 'store'])->name('admin/topic/store');
    Route::get('/admin/topics/edit/{id}', [AdminTopicController::class, 'edit'])->middleware(AdminMiddleware::class)->name('admin/topics/edit');
    Route::patch('/admin/topic/update/{topic}', [AdminTopicController::class, 'update'])->middleware(AdminMiddleware::class)->name('admin/topic/update');
    Route::delete('/admin/topics/{id}', [AdminTopicController::class, 'delete'])->name('admin/topic/delete');
    Route::patch('/admin/topic/restore/{id}', [AdminTopicController::class, 'restore'])->name('admin/topic/restore');
    Route::get('/admin/topics/search', [AdminTopicController::class, 'index'])->name('admin/topics/search');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
