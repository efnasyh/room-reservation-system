<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomReservationController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return view('dashboard', compact('role'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// anonymous function (function yang takde nama)
Route::get('/hello', function(){
    return "Hello World";
});

Route::get('/hello/{name}', function ($name) {
    return "Hello ".$name;
});
Route::get('/roomreservations/bookingList', [RoomReservationController::class, 'bookingListForAdmin'])->name('roomreservations.bookingListForAdmin');

Route::put('/roomreservations/{id}/status', [RoomReservationController::class, 'updateStatus'])->name('roomreservations.updateStatus'); // ni cover function yang kita create sendiri

Route::resource('rooms', RoomController::class);
Route::resource('roomreservations', RoomReservationController::class); //ni cover general untuk function je which is laravel yang createkan sendiri



use App\Http\Controllers\EventController;

Route::get('/events/create', [EventController::class, 'create'])->name('events.create')->middleware('auth');
Route::post('/events', [EventController::class, 'store'])->name('events.store')->middleware('auth');
Route::get('/events/status', [EventController::class, 'eventStatus'])->name('events.status')->middleware('auth');
Route::get('/events', [EventController::class, 'index'])->name('events.index')->middleware('auth');
Route::get('/events/{event}/comments', [EventController::class, 'comments']) ->name('events.comments');
Route::get('/events/{id}/comments', [EventController::class, 'comments'])->name('events.comments');
Route::get('/events/status', [EventController::class, 'eventStatus'])->name('events.status')
    ->middleware('auth');
    Route::get('/events/{eventId}/comments', [EventController::class, 'comments'])->name('events.comments');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::put('/events/{event}/update-status', [EventController::class, 'updateStatus'])->name('events.updateStatus');
    Route::get('/events/requests', [EventController::class, 'eventRequestedList'])->name('events.eventRequestedList');
    Route::post('events/{eventId}/add-comment', [EventController::class, 'addComment'])->name('events.addComment');
    Route::get('events/{eventId}/comments', [EventController::class, 'comments'])->name('events.comments');
    Route::put('/events/{id}/updateStatusAndComment', [EventController::class, 'updateStatusAndComment'])->name('events.updateStatusAndComment');
    Route::put('/events/update/{id}', [EventController::class, 'updateStatusAndComment'])->name('events.updateStatusAndComment');
    Route::get('/events/{id}/download', [EventController::class, 'download'])->name('events.download');
// // Routes to handle comments
Route::post('events/{eventId}/add-comment', [EventController::class, 'addComment'])->name('events.addComment');
Route::get('/events/{eventId}/comments', [EventController::class, 'comments'])->name('events.comments');

// Routes to handle status and comment updates
Route::put('/events/{event}/update-status', [EventController::class, 'updateStatus'])->name('events.updateStatus');
Route::put('/events/{event}/update-status-and-comment', [EventController::class, 'updateStatusAndComment'])->name('events.updateStatusAndComment');

// Route for downloading paperwork
Route::get('/events/{id}/download', [EventController::class, 'download'])->name('events.download');


Route::get('/event-calendar', [EventController::class, 'eventCalendar'])->name('event.calendar');

// Route for displaying the event status
Route::get('/event-status', [EventController::class, 'eventStatus'])->name('events.event_status');

Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

Route::get('/events/status', [EventController::class, 'eventStatus'])->name('events.status')->middleware('auth');

// For event requested list
Route::get('/event-requested-list', [EventController::class, 'eventRequestedList'])->name('events.eventRequestedList');

Route::get('/events/report', [EventController::class, 'eventReport'])->name('events.report')->middleware('auth');

Route::get('/events/list-report', [EventController::class, 'eventListReport'])->name('events.listReport')->middleware('auth');
Route::get('/events/{event}/view-report', [EventController::class, 'viewReport'])->name('events.viewReport')->middleware('auth');
Route::get('/events/{event}/report', [EventController::class, 'viewReport'])->name('events.viewReport');

//MPP HEP (TOTAL EVENT OF EVERY CLUB)
Route::get('/events/report', [EventController::class, 'report'])->name('events.report');


Route::get('/events/{event}/download-paperwork', [EventController::class, 'downloadPaperwork'])->name('events.downloadPaperwork');

// Route to show the event registration form
Route::get('events/{event}/register', [EventController::class, 'showRegistrationForm'])->name('events.register');

// Route to store the event registration
Route::post('events/{event}/register', [EventController::class, 'storeRegistration'])->name('events.storeRegistration');

Route::get('/events/organized-by-user', [EventController::class, 'userOrganizedEvents'])->name('events.userOrganized');

//Upcoming Events
Route::get('/events/upcoming', [EventController::class, 'upcomingEvents'])->name('events.upcoming');
Route::get('/events/register/{id}', [EventController::class, 'register'])->name('events.register');

use App\Http\Controllers\ClubController;

Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');

use App\Http\Controllers\ClubAssociationController;

Route::resource('club_associations', ClubAssociationController::class);

Route::get('/club-associations', [ClubAssociationController::class, 'index'])->name('club_associations.index');

// Feedback
use App\Http\Controllers\FeedbackController;
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/feedback/{event}/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback/{event}', [FeedbackController::class, 'store'])->name('feedback.store');
});

// Student Register Event
use App\Http\Controllers\StudentEventController;

Route::get('/events/register/{id}', [StudentEventController::class, 'create'])->name('events.register');
Route::post('/events/register/{id}', [StudentEventController::class, 'store'])->name('events.storeRegistration');

//EMAIL NOTIFICATION
Route::get('/events/{id}/notify', [EventController::class, 'notifyRegisteredStudents'])->name('events.notify');

//PAYMENT STRIPE
use App\Http\Controllers\PaymentController;

    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.form');
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/cancel', function () {
        return "Payment Canceled!";
    })->name('payment.cancel');

    
require __DIR__.'/auth.php';
