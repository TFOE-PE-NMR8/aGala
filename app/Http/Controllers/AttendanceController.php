<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrant;
use App\Models\Registration;
use App\Models\Guest;
use App\Models\Attendance;
use DB;

class AttendanceController extends Controller
{
    public function index () 
    {
        // 
        return view('attendance.index');
    }

    public function scanQr($qr_code)
    {
        #Get the Registrant
        $getRegistrant = Registration::join('registrants', 'registrants.id', 'registrations.id')
            ->where('registrations.reference_number', $qr_code)
            ->select('registrations.*', 'registrants.first_name', 'registrants.last_name', 'registrants.title', 'registrants.club', 'registrants.marital_status', 'registrants.is_attend')
            ->first();

        $balance = $getRegistrant->total_amount - $getRegistrant->paid_amount; 
        $countNotYetPaid = $getRegistrant->paid_amount / 500;
        $countNotYetPaid = intval($countNotYetPaid);
        #Get the Registrant Guest
        $getRegistrantGuest = Guest::where('guests.registrant_id', $getRegistrant->id)->get();
            
        $arrayRegistrantAndGuest = [];
        $arrayRegistrantAndGuest[] = $getRegistrant;
        for ($i = 0; $i < count($getRegistrantGuest); $i++)
        {
            $arrayRegistrantAndGuest[] = $getRegistrantGuest[$i];
        }

      
        return view('attendance.viewRegistrantAndGuest', compact('getRegistrant', 'getRegistrantGuest', 'balance', 'countNotYetPaid', 'arrayRegistrantAndGuest'));

    }

    public function attend (Request $request, $status, $id) 
    {
        if ($status == "Registrant") {
            $getRegistrant = Registrant::where('id', $id)->first();
            $getRegistrantRegistrations = Registration::where('id', $getRegistrant->id)->first();

            $newAttendance = new Attendance();
            $newAttendance->status = $status;
            $newAttendance->registrant_id = $id;
            $newAttendance->paid_updated = $getRegistrantRegistrations->updated_at;
            $newAttendance->save();

            $data = array();
            $data['is_attend'] = "Attend";

            DB::table('registrants')
                ->where('id', $id)
                ->update($data);
        } else {

            $getGuest = Guest::where('id', $id)->first();
            $getRegistrant = Registrant::where('id', $getGuest->registrant_id)->first();
            $getRegistrantRegistrations = Registration::where('id', $getRegistrant->id)->first();
            $newAttendance = new Attendance();
            $newAttendance->status = $status;
            $newAttendance->registrant_id = $getRegistrant->id;
            $newAttendance->guest_id = $getGuest->id;
            $newAttendance->paid_updated = $getRegistrantRegistrations->updated_at;
            $newAttendance->save();

            $data = array();
            $data['is_attend'] = "Attend";

            DB::table('guests')
                ->where('id', $id)
                ->update($data);
        }
        return redirect()->back()->with('success', 'Successfull! Thank You For Attending The Event');
    }
}
