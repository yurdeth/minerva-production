<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\ResourceTypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\NoBrowserCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//Pruebas de rutas carreras con nombres repetidos
Route::get('/departments', [DepartmentsController::class, 'index'])->name("departments");
Route::get('/careers/{id}', [CareersController::class, 'show'])->name("careers.show");
Route::get('/careers/', [CareersController::class, 'index'])->name("careers");

// Rutas no protegidass
Route::post("register", [AuthController::class, "register"])->name("register");
//Pruebas de rutas login con nombres repetidos
Route::post("login", [AuthController::class, "login"])->name("login.post");

Route::get("login", [AuthController::class, "login"])->name("login");
Route::get('/appointments/calendar-items', [AppointmentsController::class, 'getCalendarItems'])->name("appointments.calendarItems");
Route::get('/appointments/filtrar', [AppointmentsController::class, 'AvailableSchedules'])->name("appointments.filtrar");

Route::middleware(['auth:api', NoBrowserCache::class])->group(function () {

    // *********************************************** Citas ******************************************************
    Route::get('/appointments', [AppointmentsController::class, 'index'])->name("appointments.index");
    Route::get('/appointments/ver/{id}', [AppointmentsController::class, 'show'])->name("appointments.show");
    Route::post('/appointments', [AppointmentsController::class, 'store'])->name("appointments.create");
    Route::put('/appointments/editar/{id}', [AppointmentsController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/eliminar/{id}', [AppointmentsController::class, 'destroy'])->name("appointments.destroy");
    Route::get('/appointments/available', [AppointmentsController::class, 'AvailableSchedules'])->name("appointments.available");
//    Route::get('/appointments/calendar-items', [AppointmentsController::class, 'getCalendarItems'])->name("appointments.calendarItems");
    Route::post('/reservation/', [ReservationController::class, 'calculateTime'])->name('reservation.reservation');

    // **************************************** Usuarios ******************************************************
    Route::get('/users', [UsersController::class, "index"])->name('usuarios.index');
    Route::get("/users/ver/{id}", [UsersController::class, "show"])->name("users.show");
    Route::get("/users/ver/email/{email}", [UsersController::class, "showByEmail"])->name("users.showByEmail");
    Route::put("/users/editar/{id}", [UsersController::class, "update"])->name("users.updateById");
    Route::delete("/users/eliminar/{id}", [UsersController::class, "destroy"])->name("users.destroy");
    Route::get('/users/randomize-password', [UsersController::class, 'generateRandomPassword'])->name("users.recover-password");

    // **************************************** Inventarios ******************************************************
    Route::get('/statuses', [StatusesController::class, 'index']);
    Route::post('/statuses/create', [StatusesController::class, 'store']);

    Route::get('/resourcesTypes', [ResourceTypeController::class, 'index']);
    Route::post('/resourcesTypes/create', [ResourceTypeController::class, 'store']);

    Route::get('/room', [RoomController::class, 'index']);
    Route::post('/room/create', [RoomController::class, 'store']);

    Route::get('/resources', [ResourcesController::class, 'index']);
    Route::get('/resources/ver/{id}', [ResourcesController::class, 'show']);
    Route::post('/resources/create', [ResourcesController::class, 'store']);
    Route::put('/resources/editar/{id}', [ResourcesController::class, 'update']);
    Route::delete('/resources/eliminar/{id}', [ResourcesController::class, 'destroy']);

    // **************************************** Carreras ******************************************************
    Route::post('/careers/nueva', [CareersController::class, 'store'])->name("careers.store");
    Route::get('/careers/ver/{id}', [CareersController::class, 'getCareerData'])->name("careers.getCareerData");
    Route::put('/careers/editar/{id}', [CareersController::class, 'update'])->name("careers.update");
    Route::delete('/careers/eliminar/{id}', [CareersController::class, 'destroy'])->name("careers.destroy");

    // **************************************** Departamentos ******************************************************
    Route::post('/departments/nuevo', [DepartmentsController::class, 'store'])->name("departments.store");
    Route::get('/departments/ver/{id}', [DepartmentsController::class, 'show'])->name("departments.show");
    Route::put('/departments/editar/{id}', [DepartmentsController::class, 'update'])->name("departments.update");
    Route::delete('/departments/eliminar/{id}', [DepartmentsController::class, 'destroy'])->name("departments.destroy");

    // **************************************** Notificaciones ******************************************************
    Route::get('/notifications', [NotificationsController::class, 'index'])->name("notifications.index");
    Route::get('/notifications/ver/{id}', [NotificationsController::class, 'show'])->name("notifications.show");
    Route::get('/count-notifications', [NotificationsController::class, 'countNotifications'])->name("notifications.count");
    Route::put('/notifications/editar/{id}', [NotificationsController::class, 'update'])->name("notifications.update");
    Route::delete('/notifications/eliminar/{id}', [NotificationsController::class, 'destroy'])->name("notifications.destroy");

    // **************************************** Notificaciones ******************************************************
    Route::post('/sendmail', [ContactFormController::class, 'sendEmail'])->name('enviarCorreo');
    Route::get('/get-key', [ApiController::class, 'getKey'])->name('get-key');
    Route::post('/get-decrypted', [ApiController::class, 'decryptPassword'])->name('get-decrypted');

    Route::get('/mail-form', function () {
        return view('email.contact');
    })->name('contact');
});
