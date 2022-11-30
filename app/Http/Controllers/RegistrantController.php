<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegistrantResource;
use App\Models\Registrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class RegistrantController extends Controller
{

    public function index()
    {
        return view('backend.registrants.index');
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function show(Registrant $registrant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function edit(Registrant $registrant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registrant $registrant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registrant $registrant)
    {
        //
    }

    //API FUNCTIONS

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegistrantsDataTable(Request $request){
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $data = Registrant::with(['guests', 'registration'])->paginate($length);

        return response()->json($data);
    }
}
