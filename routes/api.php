<?php

use App\Helpers\Json;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\Login as AuthLoginController;

use App\Http\Controllers\Auth\Logout as AuthLogoutController;

use App\Http\Controllers\Auth\Register as AuthRegisterController;

use App\Http\Controllers\User\Controller as UserController;

use App\Http\Controllers\User\Sessions\Controller as UserSessionsController;

use App\Http\Controllers\Dashboard\Users\Controller as DashboardUsersController;

use App\Http\Controllers\Dashboard\Roles\Controller as DashboardRolesController;

use App\Http\Controllers\Dashboard\Pickups\Controller as DashboardPickupsController;

use App\Http\Controllers\Dashboard\Shipments\Controller as DashboardShipmentsController;

use App\Http\Controllers\Dashboard\Orders\Controller as DashboardOrdersController;

use App\Http\Controllers\Dashboard\Senders\Controller as DashboardSendersController;

use App\Http\Controllers\Dashboard\FedexOrders\Controller as DashboardFedexOrdersController;

use App\Http\Controllers\Dashboard\WarehouseItems\Controller as DashboardWarehouseItemsController;

use App\Http\Controllers\Dashboard\Deliveries\Controller as DashboardDeliveriesController;

use App\Http\Controllers\Dashboard\Recipients\Controller as DashboardRecipientsController;

use App\Http\Controllers\Dashboard\Boxes\Controller as DashboardBoxesController;

use App\Http\Controllers\Dashboard\BoxItems\Controller as DashboardBoxItemsController;

use App\Http\Controllers\Dashboard\Messages\Controller as DashboardMessagesController;

use App\Http\Controllers\Dashboard\Feedbacks\Controller as DashboardFeedbacksController;

use App\Http\Controllers\Dashboard\SpendingCategories\Controller as DashboardSpendingCategoriesController;

use App\Http\Controllers\Dashboard\Spendings\Controller as DashboardSpendingsController;

use App\Http\Controllers\Dashboard\Projects\Controller as DashboardProjectsController;

use App\Http\Controllers\Dashboard\Tasks\Controller as DashboardTasksController;

use App\Http\Controllers\Dashboard\OrderComments\Controller as DashboardOrderCommentsController;

use App\Http\Controllers\Dashboard\TaskFiles\Controller as DashboardTaskFilesController;

use App\Http\Controllers\Dashboard\TaskUsers\Controller as DashboardTaskUsersController;

use App\Http\Controllers\Dashboard\TaskSteps\Controller as DashboardTaskStepsController;

use App\Http\Controllers\Dashboard\DeliveryComments\Controller as DashboardDeliveryCommentsController;

use App\Http\Controllers\Dashboard\FedexOrderItems\Controller as DashboardFedexOrderItemsController;

use App\Http\Controllers\Dashboard\OrderUsers\Controller as DashboardOrderUsersController;

/*
|--------------------------------------------------------------
------------
| API Routes
|--------------------------------------------------------------------------
*/

// App routers
Route::name('app')->get('/', function () {
    return Json::sendJsonWith200([
        'app' => [
            'name' => config('app.name'),

            'version' => config('app.version'),
        ],
    ]);
});

// Authentication routes
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('login', AuthLoginController::class)->name('login');

    Route::post('logout', AuthLogoutController::class)->name('logout');

    Route::post('register', AuthRegisterController::class)->name('register');
});

// User routes
Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::get('/', UserController::class)->name('user');

    // User sessions routes
    Route::group(['prefix' => 'sessions', 'as' => 'sessions.'], function () {
        Route::get('/', [UserSessionsController::class, 'index'])->name('index');

        Route::delete('other', [UserSessionsController::class, 'deleteOther'])->name('delete.other');

        Route::delete('{token}', [UserSessionsController::class, 'delete'])->name('delete');
    });
});

// Dashboard routes
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:api', 'as' => 'dashboard.'], function () {
    Route::apiResource('users', DashboardUsersController::class);

    Route::apiResource('roles', DashboardRolesController::class);

    Route::apiResource('pickups', DashboardPickupsController::class);

    Route::apiResource('shipments', DashboardShipmentsController::class);

    Route::apiResource('fedex-orders', DashboardFedexOrdersController::class);

    Route::apiResource('orders', DashboardOrdersController::class);

    Route::apiResource('senders', DashboardSendersController::class);

    Route::apiResource('warehouse-items', DashboardWarehouseItemsController::class);

    Route::apiResource('deliveries', DashboardDeliveriesController::class);

    Route::apiResource('recipients', DashboardRecipientsController::class);

    Route::apiResource('boxes', DashboardBoxesController::class);

    Route::apiResource('box-items', DashboardBoxItemsController::class);

    Route::apiResource('messages', DashboardMessagesController::class);

    Route::apiResource('feedbacks', DashboardFeedbacksController::class);

    Route::apiResource('spending-categories', DashboardSpendingCategoriesController::class);

    Route::apiResource('spendings', DashboardSpendingsController::class);

    Route::apiResource('projects', DashboardProjectsController::class);

    Route::apiResource('tasks', DashboardTasksController::class);

    Route::apiResource('order-comments', DashboardOrderCommentsController::class);

    Route::apiResource('task-files', DashboardTaskFilesController::class);

    Route::apiResource('task-users', DashboardTaskUsersController::class);

    Route::apiResource('task-steps', DashboardTaskStepsController::class);

    Route::apiResource('delivery-comments', DashboardDeliveryCommentsController::class);

    Route::apiResource('fedex-order-items', DashboardFedexOrderItemsController::class);

    Route::apiResource('order-users', DashboardOrderUsersController::class);
});
