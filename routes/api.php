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

use App\Http\Controllers\Dashboard\Permissions\Controller as DashboardPermissionsController;

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

use App\Http\Controllers\Dashboard\Drivers\Controller as DashboardDriversController;

use App\Http\Controllers\Password\Forgot as PasswordForgotController;

use App\Http\Controllers\Password\Reset as PasswordResetController;

use App\Http\Controllers\Dashboard\Country\Controller as DashboardCountryController;

use App\Http\Controllers\Dashboard\Cities\Controller as DashboardCitiesController;

use App\Http\Controllers\Dashboard\Regions\Controller as DashboardRegionsController;

use App\Http\Controllers\Dashboard\Partners\Controller as DashboardPartnersController;

use App\Http\Controllers\Dashboard\Payment\Type\Controller as PaymentTypeController;

use App\Http\Controllers\Dashboard\Orders\Limit\Controller as LimitController;

use App\Http\Controllers\Notifications\Email\Controller as EmailController;

use App\Http\Controllers\Dashboard\Reports\Controller as ReportController;

/*
|--------------------------------------------------------------------------
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

//Commands
Route::group(['prefix' => 'commands', 'as' => 'commands.'], function() {
    Route::get('artisan/migrate-seed', [\App\Http\Controllers\Commands\ArtisanController::class, 'migrateSeed']);

    Route::get('artisan/cache-clear', [\App\Http\Controllers\Commands\ArtisanController::class, 'cacheClear']);
});

// Authentication routes
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('login', AuthLoginController::class)->name('login');

    Route::post('logout', AuthLogoutController::class)->name('logout');

    Route::post('register', AuthRegisterController::class)->name('register');
});

//Password routes
Route::group(['prefix' => 'password', 'as' => 'password'], function () {
    Route::post('forgot', [PasswordForgotController::class, 'forgot']);

    Route::post('reset', [PasswordResetController::class, 'reset']);
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
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:api','checkPermission'], 'as' => 'dashboard.'], function () {
    //CRUD for users
    Route::apiResource('users', DashboardUsersController::class);

    //Get permissions list
    Route::apiResource('permissions', DashboardPermissionsController::class)->only(['index']);

    //CRUD for user roles
    Route::apiResource('roles', DashboardRolesController::class);

    //Update single pickup status
    Route::put('pickups/status/{id}', [DashboardPickupsController::class, 'updateStatus'])->name('updatePickupStatus');

    //CRUD for
    Route::apiResource('pickups', DashboardPickupsController::class);

    //Get pickups for update
    Route::get('pickups/update/show/{id}', [DashboardPickupsController::class, 'updateShow']);

    Route::group(['prefix' => 'senders', 'as'=> 'senders.'], function () {

        //CRUD for sender
        Route::apiResource('sender', DashboardSendersController::class);

        //Check sender phone number
        Route::get('phone-check', [DashboardSendersController::class, 'senderPhoneCheck'])->name('phone.check');

        //Search sender phone number
        Route::get('phone-search', [DashboardSendersController::class, 'phoneSearch'])->name('phone.search');
    });

    Route::group(['prefix' => 'recipients', 'as' => 'recipients.'], function() {
        //CRUD for recipient
        Route::apiResource('recipient', DashboardRecipientsController::class);

        //Check recipient phone number
        Route::get('phone-check', [DashboardRecipientsController::class, 'recipientPhoneCheck'])->name('phone.check');

        //Search recipient phone number
        Route::get('phone-search', [DashboardRecipientsController::class, 'phoneSearch'])->name('phone.search');
    });

    //CRUD for warehouse
    Route::apiResource('warehouse-items', DashboardWarehouseItemsController::class);

    //Get current user message with other user
    Route::get('messages/user', [DashboardMessagesController::class, 'getMessagesUser'])->name('getMessages.user');

    //Send message to other user
    Route::apiResource('messages', DashboardMessagesController::class);

    Route::apiResource('feedbacks', DashboardFeedbacksController::class);

    Route::apiResource('projects', DashboardProjectsController::class);

    //CRUD for customers
    Route::apiResource('customers', DashboardCustomersController::class);

    Route::group(['prefix' => 'fedex-orders', 'as' => 'fedex-orders.'], function () {
        Route::apiResource('order', DashboardFedexOrdersController::class);

        Route::apiResource('items', DashboardFedexOrderItemsController::class);

        Route::post('rate', [DashboardFedexOrdersController::class, 'rate'])->name('rate');

        Route::post('ship', [DashboardFedexOrdersController::class, 'ship'])->name('ship');
    });

    Route::apiResource('feedbacks', DashboardFeedbacksController::class);

    Route::group(['prefix' => 'orders', 'as'=> 'orders.'], function () {
        //Update for order status
        Route::put('status-set', [DashboardOrdersController::class, 'statusSet'])->name('status-set');

        //Update for payment status orders
        Route::put('status-payment-set', [DashboardOrdersController::class, 'statusPaymentSet'])->name('status-payment-set');

        //CRUD for order
        Route::apiResource('order', DashboardOrdersController::class);

        Route::apiResource('users', DashboardOrderUsersController::class);

        Route::apiResource('comments', DashboardOrderCommentsController::class);

        //Show order for update
        Route::get('update/show/{id}', [DashboardOrdersController::class, 'updateShow']);

        //Show recipient limit
        Route::get('limit-recipient', [LimitController::class, 'checkSender'])->name('limit-check.recipient');
    });

    Route::apiResource('projects', DashboardProjectsController::class);

    Route::group(['prefix' => 'status', 'as' => 'status.'], function() {
        //CRUD for statuses
        Route::apiResource('statuses', DashboardStatusesController::class);

        //Get statuses deliveries
        Route::get('deliveries', [DashboardStatusesController::class, 'statusDeliveries']);

        //Get statuses orders
        Route::get('orders', [DashboardStatusesController::class, 'statusOrders']);

        //Get statuses of payment orders
        Route::get('orders/payment', [DashboardStatusesController::class, 'statusPaymentOrders']);

        //Get statuses shipments
        Route::get('shipments', [DashboardStatusesController::class, 'statusShipments']);

        //Get statuses pickups
        Route::get('pickups', [DashboardStatusesController::class, 'statusPickups']);
    });

    Route::group(['prefix' => 'deliveries', 'as' => 'deliveries.'], function(){
        //CRUD for deliveries
        Route::apiResource('delivery', DashboardDeliveriesController::class);

        //CRUD for delivery users
        Route::apiResource('users', DashboardDeliveryUsersController::class);

        Route::apiResource('comments', DashboardDeliveryCommentsController::class);

        //Show delivery for update
        Route::get('update/show/{id}', [DashboardDeliveriesController::class, 'updateShow']);

        //Update delivery status
        Route::put('{id}/status', [DashboardDeliveriesController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::group(['prefix' => 'shipments', 'as' => 'shipments.'], function(){
        //Remove boxes from shipment
        Route::put('shipment/unattach-boxes', [DashboardShipmentsController::class, 'unAttachBoxes'])->name('unattach-boxes');

        //CRUD for shipment
        Route::apiResource('shipment', DashboardShipmentsController::class);

        Route::apiResource('comments', DashboardShipmentCommentsController::class);

        Route::apiResource('users', DashboardShipmentUsersController::class);

        Route::apiResource('statuses', DashboardShipmentStatusesController::class);

        //Attach boxes to shipment
        Route::put('shipment/{id}/attach-boxes', [DashboardShipmentsController::class, 'attachBoxes'])->name('attach-boxes');

        //Update shipment status
        Route::put('{id}/status', [DashboardShipmentsController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::group(['prefix'=> 'boxes', 'as' => 'boxes.'], function(){
        //Get boxes from orders
        Route::get('order/{id}', [DashboardBoxesController::class, 'getBoxes']);

        //Update box status
        Route::put('set-status', [DashboardBoxesController::class, 'setStatus'])->name('set-status');

        //CRUD for box
        Route::apiResource('box', DashboardBoxesController::class);

        //Get products of box
        Route::get('products/{id}', [DashboardBoxItemsController::class, 'getProducts']);

        //CRUD for products
        Route::apiResource('items', DashboardBoxItemsController::class);

        Route::get('shipments/{id}', [DashboardBoxesController::class, 'getShipments']);

        Route::get('free', [DashboardBoxesController::class, 'boxesFree'])->name('boxesFree');
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

    Route::delete('images/delete', [DashboardImagesController::class, 'deleteOne'])->name('images.delete');

    Route::delete('images/delete/multiple', [DashboardImagesController::class, 'deleteMultiple'])->name('images.delete.multiple');

    //CRUD for image
    Route::apiResource('images', DashboardImagesController::class);

    //CRUD for phones
    Route::apiResource('phones', DashboardPhonesController::class);

    //CRUD for addresses
    Route::apiResource('addresses', DashboardAddressesController::class);

    Route::apiResource('products', DashboardProductsController::class);

    Route::group(['prefix' => 'drivers', 'as' => 'drivers.'], function () {
        //CRUD for driver
        Route::apiResource('driver', DashboardDriversController::class);

        //Check driver phone
        Route::get('phone-check', [DashboardDriversController::class, 'driverPhoneCheck'])->name('phone.check');

        //Search driver phone
        Route::get('phone-search', [DashboardDriversController::class, 'phoneSearch'])->name('phone.search');
    });

    //Get counties list
    Route::get('countries', [DashboardCountryController::class, 'index']);

    //CRUD cities
    Route::apiResource('cities', DashboardCitiesController::class);

    //CRUD regions
    Route::apiResource('regions', DashboardRegionsController::class);

    //CRUD partners
    Route::apiResource('partners', DashboardPartnersController::class);

    //CRUD payment types
    Route::apiResource('payment/types', PaymentTypeController::class);

    Route::group(['prefix' => 'export', 'as' => 'export.'], function () {
        Route::get('boxes', [\App\Http\Controllers\ExportController::class, 'boxes'])->name('boxes');

        Route::get('declaration', [\App\Http\Controllers\ExportController::class, 'shipmentDeclaration'])->name('shipment-declaration');

        Route::get('declaration-order', [\App\Http\Controllers\ExportController::class, 'orderDeclaration'])->name('order-declaration');
    });

    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function() {
        Route::get('user-profile', [ReportController::class, 'userProfile'])->name('user-profile');
    });
});

Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
    Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
        Route::post('send', [EmailController::class, 'send'])->name('send');
    });
});
