<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\OpeningTimeController;
use App\Http\Controllers\BookingRuleController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CustomDomainController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 *Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
 *    return $request->user();
 *});
 */

Route::get(
    'bookings/get_available_tables',
    [
        BookingController::class, 'getAvailableTables'
    ]
);
Route::get(
    'bookings/get_available_guests_number',
    [
        BookingController::class, 'getAvailableGuestsNumber'
    ]
);
Route::get(
    'bookings/get_available_time_interval',
    [
        BookingController::class, 'getAvailableTimeInterval'
    ]
);
Route::get(
    'comments/get_list_waiting_in_area',
    [
        CommentController::class, 'getListWaitingInArea'
    ]
);

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
        Route::post('register', [AuthController::class, 'register']);
    }
);

Route::apiResources(
    [
        'customers' => CustomerController::class,
        'customers.businesses' => BusinessController::class,
        'businesses.payment_gateways' => PaymentGatewayController::class,
        'businesses.areas' => AreaController::class,
        'areas.tables' => TableController::class,
        'opening_times' => OpeningTimeController::class,
        'opening_times.booking_rules' => BookingRuleController::class,
        'custom_domains' => CustomDomainController::class,
        'bookings' => BookingController::class,
    ]
);
Route::resource('comments', CommentController::class)->only([
    'index',
    'store'
]);

Route::post(
    'customers/{customer}/businesses/{business}/assign_to_customer',
    [
        BusinessController::class, 'assignToCustomer'
    ]
);
Route::post(
    'opening_times/{opening_time}/assign_to',
    [
        OpeningTimeController::class, 'assignTo'
    ]
);
Route::post(
    'areas/{area}/tables/{table}/assign_to_area',
    [
        TableController::class, 'assignToArea'
    ]
);
Route::post(
    'areas/{area}/tables/{table}/combine_tables',
    [
        TableController::class, 'combineTables'
    ]
);
Route::post(
    'bookings/auto',
    [
        BookingController::class, 'bookingOnline'
    ]
);
Route::post(
    'comments/guest_send',
    [
        CommentController::class, 'guestSend'
    ]
);
