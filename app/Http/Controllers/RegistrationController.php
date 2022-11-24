<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Guest;
use App\Models\PaymentLog;
use App\Models\Registrant;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

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

        $quantity = 1 + count($guests);
        $registration = new Registration();
        $registration->reference_number = $reference_number;
        $registration->registrant_id = $registrant_id;
        $registration->quantity = $quantity;
        $registration->total_amount = $quantity * 500;
        $registration->save();

        return response()->json(['redirect' => route('registered', ['reference_number' => $reference_number])]);
    }

    public function registered($reference_number){
        $data = Registration::where('reference_number', $reference_number)->with('registrant')->first();
        if(!$reference_number || !$data){
            return redirect(route('registration'));
        }

        return view('registration.registered')->with('data', $data);
    }

    public function pay(Request $request){

        $amount = floatval($request->get('amount', 0));
        $registration_id = $request->get('registration_id');
        $payment_method = $request->get('payment_method');
        $date = Carbon::now();

        $user = Auth::user();

        if(!$user){
            return response()->json(['redirect' => route('login')]);
        }

        $user_id = $user->id;

        $registration = Registration::find($registration_id);
        $registration->paid_amount = floatval($registration->paid_amount) + $amount;
        $registration->save();

        $payment = PaymentLog::create([
            'paid_user_id' => $user_id,
            'registration_id' => $registration_id,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'date' => $date
        ]);

        return response()->json($payment, 200);
    }
}
