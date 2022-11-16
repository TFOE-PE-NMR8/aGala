<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Guest;
use App\Models\Registrant;
use App\Models\Registration;
use Carbon\Carbon;
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

        $registrant = new Registrant();
        $registrant->first_name = trim($request->get('first_name'));
        $registrant->last_name = trim($request->get('last_name'));
        $registrant->phone = trim($request->get('phone'));
        $registrant->email = trim($request->get('email'));
        $registrant->title = trim($request->get('title'));
        $registrant->club = trim($request->get('club'));
        $registrant->marital_status = trim($request->get('marital_status'));

        $registrant->save();

        $guests = $request->get('guests', null);

        if($guests){
            foreach ($guests as $guest){
                $g = new Guest();
                $g->name = $guest["name"];
                $g->relation = $guest["relation"];
                $g->registrant_id = $registrant->id;
                $g->save();
            }
        }

        $year_now = Carbon::now()->year;
        $reference_number = "AG{$year_now}-" . rand(1000,9999);
        while(Registration::where('reference_number', $reference_number)->count() > 0) {
            $reference_number = "AG{$year_now}-" . rand(1000,9999);
        }
        $registration = new Registration();
        $registration->reference_number = $reference_number;
        $registration->registrant_id = $registrant->id;
        $registration->total_amount = (1 + count($guests)) * 500;
        $registration->save();

        $request->session()->flash('data', [
            'registrant' => $registrant
        ]);

        return response()->json(['redirect' => route('registered')]);
    }

    public function registered(){

        $data = session()->get('data');

        if(!$data){
            return redirect(route('registration'));
        }

        return view('registration.registered')->with($data);
    }
}
