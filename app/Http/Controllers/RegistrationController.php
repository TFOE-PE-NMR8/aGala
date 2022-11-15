<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Guest;
use App\Models\Registrant;
use App\Models\Registration;
use Carbon\Carbon;
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

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $registrant = new Registrant();
        $registrant->first_name = $request->get('first_name');
        $registrant->last_name = $request->get('last_name');
        $registrant->phone = $request->get('phone');
        $registrant->email = $request->get('email');
        $registrant->title = $request->get('title');
        $registrant->club = $request->get('club');
        $registrant->marital_status = $request->get('marital_status');
        $registrant->save();

        $guest[] = new Guest();

        $last_reg = Registration::query()->last();
        $year_now = Carbon::now()->year;
        $reference_number = $last_reg ? $last_reg->reference_number++ : "AG{$year_now}-0001";
        $registration = new Registration();
        $registration->reference_number = $reference_number;
        $registration->registrant_id = $registrant->id;

        return redirect()->route('registered')
            ->with([
                'data' => [
                    'registrant' => $registrant,
                    'guests' => $guest
                ]
            ]);
    }

    public function registered(){
        return view('registration.registered');
    }
}
