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

use App\Http\Controllers\Dashboard\ShipmentComments\Controller as DashboardShipmentCommentsController;

use App\Http\Controllers\Dashboard\DeliveryComments\Controller as DashboardDeliveryCommentsController;

use App\Http\Controllers\Dashboard\FedexOrderItems\Controller as DashboardFedexOrderItemsController;

use App\Http\Controllers\Dashboard\ShipmentUsers\Controller as DashboardShipmentUsersController;

use App\Http\Controllers\Dashboard\OrderUsers\Controller as DashboardOrderUsersController;

use App\Http\Controllers\Dashboard\DeliveryUsers\Controller as DashboardDeliveryUsersController;

use App\Http\Controllers\Dashboard\Customers\Controller as DashboardCustomersController;

use App\Http\Controllers\Dashboard\Trackings\Controller as DashboardTrackingsController;

use App\Http\Controllers\Dashboard\Images\Controller as DashboardImagesController;

use App\Http\Controllers\Dashboard\Statuses\Controller as DashboardStatusesController;

use App\Http\Controllers\Dashboard\Phones\Controller as DashboardPhonesController;

use App\Http\Controllers\Dashboard\Addresses\Controller as DashboardAddressesController;

use App\Http\Controllers\Dashboard\ShipmentStatuses\Controller as DashboardShipmentStatusesController;

use App\Http\Controllers\Dashboard\Products\Controller as DashboardProductsController;

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

    Route::apiResource('senders', DashboardSendersController::class);

    Route::apiResource('warehouse-items', DashboardWarehouseItemsController::class);

    Route::apiResource('recipients', DashboardRecipientsController::class);

    Route::apiResource('messages', DashboardMessagesController::class);

    Route::apiResource('feedbacks', DashboardFeedbacksController::class);

    Route::apiResource('projects', DashboardProjectsController::class);

    Route::apiResource('customers', DashboardCustomersController::class);

    Route::group(['prefix' => 'fedex-orders', 'as' => 'fedex-orders.'], function () {

        Route::apiResource('/', DashboardFedexOrdersController::class);

        Route::apiResource('items', DashboardFedexOrderItemsController::class);
    });

    Route::apiResource('feedbacks', DashboardFeedbacksController::class);

    Route::group(['prefix' => 'orders', 'as'=> 'orders.'], function () {

        Route::apiResource('order', DashboardOrdersController::class);

        Route::apiResource('users', DashboardOrderUsersController::class);

        Route::apiResource('comments', DashboardOrderCommentsController::class);
    });

    Route::apiResource('projects', DashboardProjectsController::class);

    Route::group(['prefix' => 'status', 'as' => 'status.'], function() {
        Route::get('deliveries', [DashboardStatusesController::class, 'statusDeliveries']);

        Route::get('orders', [DashboardStatusesController::class, 'statusOrders']);

        Route::get('payment/orders', [DashboardStatusesController::class, 'statusPaymentOrders']);

        Route::get('shipments', [DashboardStatusesController::class, 'statusShipments']);
    });

    Route::group(['prefix' => 'deliveries', 'as' => 'deliveries.'], function(){

        Route::apiResource('/', DashboardDeliveriesController::class);

        Route::apiResource('users', DashboardDeliveryUsersController::class);

        Route::apiResource('comments', DashboardDeliveryCommentsController::class);

    });

    Route::group(['prefix' => 'shipments', 'as' => 'shipments.'], function(){

        Route::apiResource('shipment', DashboardShipmentsController::class);

        Route::apiResource('comments', DashboardShipmentCommentsController::class);

        Route::apiResource('users', DashboardShipmentUsersController::class);

        Route::apiResource('statuses', DashboardShipmentStatusesController::class);
    });

    Route::group(['prefix'=> 'boxes', 'as' => 'boxes.'], function(){

        Route::apiResource('/', DashboardBoxesController::class);

        Route::apiResource('items', DashboardBoxItemsController::class);
    });

    Route::group(['prefix' => 'spendings', 'as' => 'spendings.'], function(){

        Route::apiResource('categories', DashboardSpendingCategoriesController::class);

        Route::apiResource('spending', DashboardSpendingsController::class);

    });

    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function(){

        Route::apiResource('/', DashboardTasksController::class);

        Route::apiResource('files', DashboardTaskFilesController::class);

        Route::apiResource('users', DashboardTaskUsersController::class);

        Route::apiResource('steps', DashboardTaskStepsController::class);

    });

    Route::apiResource('customers', DashboardCustomersController::class);

    Route::apiResource('trackings', DashboardTrackingsController::class);

    Route::apiResource('images', DashboardImagesController::class);

    Route::apiResource('phones', DashboardPhonesController::class);

    Route::apiResource('addresses', DashboardAddressesController::class);

    Route::apiResource('products', DashboardProductsController::class);
});
