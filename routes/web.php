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
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\site\MessageController as SiteMessageController;

use App\Http\Controllers\UserAvatarController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BanMiddleware;
use App\Http\Middleware\ReadOnlyMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

//Route::get('/site/dashboard', function () {
//    return view('site.dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified', BanMiddleware::class]], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [UserAvatarController::class, 'update'])->name('avatar.update');
    Route::get('/profile/myTopics', [ProfileController::class, 'getMyTopics'])->name('profile/myTopics');

    Route::get('site/category', [SiteCategoryController::class, 'index'])->name('category');
    Route::get('site/category/search', [SiteCategoryController::class, 'index'])->name('site/category/search');

    Route::get('site/{id}/subcategories', [SiteSubcategoryController::class, 'index'])->name('site/subcategories');
    Route::get('site/{id}/subcategories/search', [SiteSubcategoryController::class, 'index'])->name('site/subcategories/search');

    Route::get('/site/{id}/forums', [SiteForumController::class, 'index'])->name('site/forums');
    Route::get('/site/{id}/forums/search', [SiteForumController::class, 'index'])->name('site/forums/search');

    Route::get('/site/{id}/topics', [SiteTopicController::class, 'index'])->name('site/topics');
    Route::get('/site/{id}/topics/search', [SiteTopicController::class, 'index'])->name('site/topics/search');
    Route::get('/site/{id}/topic/create', [SiteTopicController::class, 'create'])->name('site/topic/create')->middleware(ReadOnlyMiddleware::class);
    Route::post('/site/{forumId}/topic/store', [SiteTopicController::class, 'store'])->name('site/topic/store')->middleware(ReadOnlyMiddleware::class);
    Route::get('/site/topics/edit/{id}', [SiteTopicController::class, 'edit'])->name('site/topics/edit')->middleware(ReadOnlyMiddleware::class);
    Route::patch('/site/topic/update/{topic}', [SiteTopicController::class, 'update'])->name('site/topics/update')->middleware(ReadOnlyMiddleware::class);
    Route::delete('/site/topic/{id}/delete', [SiteTopicController::class, 'delete'])->name('site/topic/delete');

    Route::get('/site/topic/{id}/chat', [SiteMessageController::class, 'index'])->name('site/chat');
    Route::post('/site/topic/{id}/chat/store', [SiteMessageController::class, 'store'])->name('site/chat/store')->middleware(ReadOnlyMiddleware::class);;
    Route::get('/site/topic/{id}/chat/edit', [SiteMessageController::class, 'edit'])->name('site/chat/edit');
    Route::patch('/site/chat/{id}/update', [SiteMessageController::class, 'update'])->name('site/chat/update')->middleware(ReadOnlyMiddleware::class);;
    Route::delete('/site/message/{id}/delete', [SiteMessageController::class, 'delete'])->name('site/message/delete');
});

// ========================= admin Routes =========================

//Route::get('/admin/dashboard', function () {
//    return view('admin.dashboard');
//})->middleware(AdminMiddleware::class)->name('admin/dashboard');

Route::middleware([AdminMiddleware::class, BanMiddleware::class])->group(function () {
    Route::get('/admin/category', [AdminCategoryController::class, 'index'])->name('admin/category');
    Route::get('/admin/category/create', [AdminCategoryController::class, 'create'])->name('admin/category/create')->middleware(ReadOnlyMiddleware::class);
    Route::post('/admin/category/store', [AdminCategoryController::class, 'store'])->name('admin/category/store')->middleware(ReadOnlyMiddleware::class);
    Route::get('/admin/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin/category/edit')->middleware(ReadOnlyMiddleware::class);
    Route::patch('/admin/category/update/{category}', [AdminCategoryController::class, 'update'])->name('admin/category/update')->middleware(ReadOnlyMiddleware::class);
    Route::delete('/admin/category/{id}', [AdminCategoryController::class, 'delete'])->name('admin/category.delete')->middleware(ReadOnlyMiddleware::class);
    Route::patch('/admin/category/restore/{id}', [AdminCategoryController::class, 'restore'])->name('admin/category/restore')->middleware(ReadOnlyMiddleware::class);
    Route::get('/admin/category/search', [AdminCategoryController::class, 'index'])->name('admin/category/search');

    Route::get('/admin/subcategory', [AdminSubcategoryController::class, 'index'])->name('admin/subcategory');
    Route::get('/admin/subcategory/create', [AdminSubcategoryController::class, 'create'])->name('admin/subcategory/create')->middleware(ReadOnlyMiddleware::class);
    Route::post('/admin/subcategory/store', [AdminSubcategoryController::class, 'store'])->name('admin/subcategory/store')->middleware(ReadOnlyMiddleware::class);
    Route::get('/admin/subcategory/edit/{id}', [AdminSubcategoryController::class, 'edit'])->name('admin/subcategory/edit')->middleware(ReadOnlyMiddleware::class);
    Route::patch('/admin/subcategory/update/{subcategory}', [AdminSubcategoryController::class, 'update'])->name('admin/subcategory/update')->middleware(ReadOnlyMiddleware::class);
    Route::delete('/admin/subcategory/{id}', [AdminSubcategoryController::class, 'delete'])->name('admin/subcategory.delete')->middleware(ReadOnlyMiddleware::class);
    Route::patch('/admin/subcategory/restore/{id}', [AdminSubcategoryController::class, 'restore'])->name('admin/subcategory/restore')->middleware(ReadOnlyMiddleware::class);
    Route::get('/admin/subcategory/search', [AdminSubcategoryController::class, 'index'])->name('admin/subcategory/search');

    Route::get('/admin/forums', [AdminForumController::class, 'index'])->name('admin/forum');
    Route::get('/admin/forum/create', [AdminForumController::class, 'create'])->name('admin/forum/create')->middleware(ReadOnlyMiddleware::class);
    Route::post('/admin/forum/store', [AdminForumController::class, 'store'])->name('admin/forum/store')->middleware(ReadOnlyMiddleware::class);
    Route::get('/admin/forum/edit/{id}', [AdminForumController::class, 'edit'])->name('admin/forum/edit')->middleware(ReadOnlyMiddleware::class);
    Route::patch('/admin/forum/update/{forum}', [AdminForumController::class, 'update'])->name('admin/forum/update')->middleware(ReadOnlyMiddleware::class);
    Route::delete('/admin/forum/{id}', [AdminForumController::class, 'delete'])->name('admin/forum/delete')->middleware(ReadOnlyMiddleware::class);
    Route::patch('/admin/forum/restore/{id}', [AdminForumController::class, 'restore'])->name('admin/forum/restore')->middleware(ReadOnlyMiddleware::class);
    Route::get('/admin/forum/search', [AdminforumController::class, 'index'])->name('admin/forum/search');

    Route::get('/admin/topics', [AdminTopicController::class, 'index'])->name('admin/topics');
    Route::get('/admin/topics/create', [AdminTopicController::class, 'create'])->name('admin/topics/create')->middleware(ReadOnlyMiddleware::class);
    Route::post('/admin/topic/store', [AdminTopicController::class, 'store'])->name('admin/topic/store')->middleware(ReadOnlyMiddleware::class);
    Route::get('/admin/topics/edit/{id}', [AdminTopicController::class, 'edit'])->name('admin/topics/edit')->middleware(ReadOnlyMiddleware::class);
    Route::patch('/admin/topic/update/{topic}', [AdminTopicController::class, 'update'])->name('admin/topic/update')->middleware(ReadOnlyMiddleware::class);
    Route::delete('/admin/topics/{id}', [AdminTopicController::class, 'delete'])->name('admin/topic/delete')->middleware(ReadOnlyMiddleware::class);
    Route::patch('/admin/topic/restore/{id}', [AdminTopicController::class, 'restore'])->name('admin/topic/restore')->middleware(ReadOnlyMiddleware::class);
    Route::get('/admin/topics/search', [AdminTopicController::class, 'index'])->name('admin/topics/search');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin/users');
    Route::post('/admin/changeStatus', [AdminUserController::class, 'changeStatus'])->name('admin/users/changeStatus')->middleware(ReadOnlyMiddleware::class);
    Route::post('/admin/changeRole', [AdminUserController::class, 'changeRole'])->name('admin/users/changeRole')->middleware(ReadOnlyMiddleware::class);
});


require __DIR__ . '/auth.php';
