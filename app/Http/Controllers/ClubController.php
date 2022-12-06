<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function getAll(){
        $clubs = Club::all();
        return response()->json($clubs);
    }
}
