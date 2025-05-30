<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Stripe\Stripe;
    use Stripe\Checkout\Session;
    use Illuminate\Support\Facades\Mail;
    use App\Mail\EventNotification;
    use App\Models\Event;

    
    class PaymentController extends Controller
    {
        public function index()
        {
            return view('payment');
        }
    
    
    public function checkout(Request $request)
        {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $eventId = $request->input('event_id');
            $amount = $request->input('amount'); // in cents

            // Save the student details in session to retrieve after payment
            session([
                'registration_data' => $request->only(['student_name', 'matric_no', 'email', 'phone', 'faculty', 'event_id'])
            ]);

            try {
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'myr',
                            'product_data' => [
                                'name' => 'Event Fee for Event ID ' . $eventId,
                            ],
                            'unit_amount' => $amount,
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => route('payment.success'),
                    'cancel_url' => route('payment.cancel'),
                ]);

                return redirect($session->url, 303);
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Unable to create payment session: ' . $e->getMessage()]);
            }
        }


//     public function success()
// {
//     $data = session('registration_data');

//     if ($data) {
//         // Store in database
//         \App\Models\StudentEvent::create([
//             'event_id' => $data['event_id'],
//             'student_name' => $data['student_name'],
//             'matric_no' => $data['matric_no'],
//             'email' => $data['email'],
//             'phone' => $data['phone'],
//             'faculty' => $data['faculty'],
//             'payment_status' => 'paid'
//         ]);

//         session()->forget('registration_data');

//         return redirect()->route('events.upcoming', $eventId)
//         ->with('success', 'Your payment was successful! Thank you for registering.');
//     }

//     return redirect()->route('events.index')->withErrors('No registration data found.');
// }

public function paymentSuccess() // UPDATE SEBAB NAK HANTAR NOTI LEPAS BUAT PAYMENT
{
    $data = session('registration_data');
    if ($data) {
        // Check if already registered to prevent duplicate
        $existing = \App\Models\StudentEvent::where('event_id', $data['event_id'])
            ->where(function ($query) use ($data) {
                $query->where('email', $data['email'])
                      ->orWhere('matric_no', $data['matric_no']);
            })
            ->first();

        if (!$existing) {
            \App\Models\StudentEvent::create([
                'user_id' => auth()->id(),
                'event_id' => $data['event_id'],
                'student_name' => $data['student_name'],
                'matric_no' => $data['matric_no'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'faculty' => $data['faculty'],
                'payment_status' => 'Paid'
            ]);
        }

        // ✅ Send Email Notification
        $event = Event::find($data['event_id']);
        Mail::to($data['email'])->send(new EventNotification($event, $data['student_name']));

        session()->forget('registration_data');

        return redirect()->route('events.upcoming')
            ->with('success', 'Your payment was successful! Thank you for registering. A confirmation email has been sent.');
    }

    return redirect()->route('events.upcoming')
        ->with('error', 'Payment was successful, but we could not find your registration details.');
}

// public function paymentSuccess() // CODE SEBELUM UPDATE
// {
//     $data = session('registration_data');

//     if ($data) {
//         // Check if already registered to prevent duplicate
//         $existing = \App\Models\StudentEvent::where('event_id', $data['event_id'])
//             ->where(function ($query) use ($data) {
//                 $query->where('email', $data['email'])
//                       ->orWhere('matric_no', $data['matric_no']);
//             })
//             ->first();

//         if (!$existing) {
//             \App\Models\StudentEvent::create([
//                 'user_id' => auth()->id(),
//                 'event_id' => $data['event_id'],
//                 'student_name' => $data['student_name'],
//                 'matric_no' => $data['matric_no'],
//                 'email' => $data['email'],
//                 'phone' => $data['phone'],
//                 'faculty' => $data['faculty'],
//                 'payment_status' => 'Paid'
//             ]);
//         }

//         session()->forget('registration_data');

//         return redirect()->route('events.upcoming')
//             ->with('success', 'Your payment was successful! Thank you for registering.');
//     }

//     return redirect()->route('events.upcoming')
//         ->with('error', 'Payment was successful, but we could not find your registration details.');
// }



// public function paymentSuccess(Request $request)
// {
//     $studentEventId = session('student_event_id');
//     $eventId = null;

//     if ($studentEventId) {
//         $studentEvent = StudentEvent::find($studentEventId);

//         if ($studentEvent) {
//             $studentEvent->payment_status = 'paid';
//             $studentEvent->save();

//             $eventId = $studentEvent->event_id;
//         }
//     }

//     if ($eventId) {
//         return redirect()->route('events.showRegistrationForm', $eventId)
//             ->with('success', 'Payment successful! Thank you for your registration.');
//     } else {
//         return redirect()->route('events.index') // or some fallback route
//             ->with('error', 'Something went wrong: payment was successful but registration was not found.');
//     }
// }



    }
