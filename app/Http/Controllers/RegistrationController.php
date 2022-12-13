<?php

namespace App\Http\Controllers;

use App\Mail\PaymentNotification;
use App\Mail\TicketNotification;
use App\Models\Club;
use App\Models\Guest;
use App\Models\PaymentLog;
use App\Models\Registrant;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Vluzrmos\SlackApi\Facades\SlackChat;
use Vluzrmos\SlackApi\Facades\SlackUser;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registration $registration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registration $registration)
    {
        //
    }

    public function registration(){
        $clubs = Club::all();
        return view('registration.index', ['clubs' => $clubs]);
    }

    public function register(Request $request){

        $club = trim($request->get('club'));
        if($club === "other"){
            $club = trim($request->get('other_club'));
        }

        $registrant = new Registrant();
        $registrant->first_name = trim($request->get('first_name'));
        $registrant->last_name = trim($request->get('last_name'));
        $registrant->phone = trim($request->get('phone'));
        $registrant->email = trim($request->get('email'));
        $registrant->title = trim($request->get('title'));
        $registrant->club = $club;
        $registrant->marital_status = trim($request->get('marital_status'));

        $registrant->save();
        $registrant_id = $registrant->id;

        $guests = $request->get('guests', null);

        if($guests){
            foreach ($guests as $guest){
                $g = new Guest();
                $g->name = $guest["name"];
                $g->relation = $guest["relation"];
                $g->registrant_id = $registrant_id;
                $g->save();
            }
        }

        $year_now = Carbon::now()->year;
        $reference_number = "AG{$year_now}-" . rand(1000,9999);
        while(Registration::where('reference_number', $reference_number)->count() > 0) {
            $reference_number = "AG{$year_now}-" . rand(1000,9999);
        }
        $guest_count = count($guests);
        $quantity = 1 + count($guests);
        $registration = new Registration();
        $registration->reference_number = $reference_number;
        $registration->registrant_id = $registrant_id;
        $registration->quantity = $quantity;
        $registration->total_amount = $quantity * 500;
        $registration->save();


        $subjectMsg = "Thank you for registering to the aGala";
        $msg = "Please pay the amount through our selected payment options";
        $email = $registrant->email ?: "bagsprin@gmail.com";
        Mail::to($email)->send(new TicketNotification($registration, $subjectMsg, $msg));

        if(env('APP_ENV') == 'local'){
            $slack = SlackChat::message('#test-reg', ":bangbang: Kuya/Ate *<https://agala.devbroph.com/registered/{$registration->reference_number}|{$registrant->first_name} {$registrant->last_name}>* from *{$registrant->club}* is now registered on our Database, number of guest is *{$guest_count}*, with the reference number: {$registration->reference_number} :bangbang: <!here>");

        }else{
            $slack = SlackChat::message('#agala-registration', ":bangbang: Kuya/Ate *<https://agala.devbroph.com/registered/{$registration->reference_number}|{$registrant->first_name} {$registrant->last_name}>* from *{$registrant->club}* is now registered on our Database, number of guest is *{$guest_count}*, with the reference number: {$registration->reference_number} :bangbang: <!here>");

        }

        return response()->json(['redirect' => route('registered', ['reference_number' => $reference_number])]);
    }

    public function registered($reference_number){
        $data = Registration::where('reference_number', $reference_number)->with(['registrant', 'registrant.guests'])->first();
        if(!$reference_number || !$data){
            return redirect(route('registration'));
        }

        return view('registration.registered')->with('data', $data);
    }

    public function pay(Request $request){

        $amount = floatval($request->post('amount', 0));
        $registration_id = $request->post('registration_id');
        $payment_date = Carbon::parse($request->post('payment_date'));
        $payment_method = $request->post('payment_method');
        $date = Carbon::now();

        $user = Auth::user();

        if(!$user){
            return response()->json(['redirect' => route('login')]);
        }

        $user_id = $user->id;

        $registration = Registration::find($registration_id);
        $registration->paid_amount = floatval($registration->paid_amount) + $amount;
        $registration->updated_at = $date;
        $registration->save();

        $payment = PaymentLog::create([
            'paid_user_id' => $user_id,
            'registration_id' => $registration_id,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'date' => $payment_date
        ]);

        $registration->load('registrant');

        $subjectMsg = "We received your payment for the aGala";
        $msg = "Thank you for your Payment";
        $email = $registration->registrant->email ?: "bagsprin@gmail.com";
        Mail::to($email)->send(new PaymentNotification($registration, $subjectMsg, $msg, $payment));

        return response()->json($payment, 200);
    }

    public function dowloadQRCode($registration_id){
        $registration = Registration::find($registration_id);
        $image = base64_encode(QrCode::errorCorrection('H')->format('png')->merge('theme/img/eagles-logo.png', .4, true)->size(200)->generate($registration->reference_number));
        $raw_image_string = base64_decode($image);
        $filename = "agala_qr_code_{$registration->id}.png";
        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename='. $filename,
        ];
        return response()->stream(function() use ($raw_image_string) {
            echo $raw_image_string;
        }, 200, $headers);
    }
}
