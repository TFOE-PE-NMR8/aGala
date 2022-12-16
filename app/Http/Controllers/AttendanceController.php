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
        // $getRegistrant = Registration::join('registrants', 'registrants.id', 'registrations.id')
        //     ->where('registrations.reference_number', $qr_code)
        //     ->select('registrations.*', 'registrants.first_name', 'registrants.last_name', 'registrants.title', 'registrants.club', 'registrants.marital_status', 'registrants.is_attend')
        //     ->first();


        $getRegistrationId = Registration::where('registrations.reference_number', $qr_code)
            ->first();
        
        $getRegistrant = Registrant::where('id', $getRegistrationId->registrant_id)
            ->first();

        $ifItHasData = "";
        if ($getRegistrationId) {
            $ifItHasData = "Has Data";
            $balance = $getRegistrationId->total_amount - $getRegistrationId->paid_amount; 
            $countNotYetPaid = $getRegistrationId->paid_amount / 500;
            $countNotYetPaid = intval($countNotYetPaid);
            #Get the Registrant Guest
            $getRegistrantGuest = Guest::where('guests.registrant_id', $getRegistrant->id)->get();
                
            $arrayRegistrantAndGuest = [];
            $arrayRegistrantAndGuest[] = $getRegistrant;
            for ($i = 0; $i < count($getRegistrantGuest); $i++)
            {
                $arrayRegistrantAndGuest[] = $getRegistrantGuest[$i];
            }
        } else {
            $ifItHasData = "No Data";
        }

        // return $arrayRegistrantAndGuest;

        if ($ifItHasData == "No Data") {
            return redirect()->back()->with("warning", "The Reference number you entered does not exist, Thank you!");
        } else {
            return view('attendance.viewRegAndGuest', compact('getRegistrant', 'getRegistrantGuest', 'balance', 'countNotYetPaid', 'arrayRegistrantAndGuest', 'ifItHasData', 'getRegistrationId'));
        }
        
        // return view('attendance.viewRegistrantAndGuest', compact('getRegistrant', 'getRegistrantGuest', 'balance', 'countNotYetPaid', 'arrayRegistrantAndGuest', 'ifItHasData'));

    }

    public function attend (Request $request, $status, $id) 
    {
        if ($status == "Registrant") {
            $getRegistrant = Registrant::where('id', $id)->first();
            $getRegistrantRegistrations = Registration::where('registrant_id', $getRegistrant->id)->first();

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
            $getRegistrantRegistrations = Registration::where('registrant_id', $getRegistrant->id)->first();
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

    public function attendance (Request $request) 
    {
        if ($request->title){

            $getRegistrantRegistrations = Registration::where('registrant_id', $request->id)->first();
            $newAttendance = new Attendance();
            $newAttendance->status = "Registrant";
            $newAttendance->registrant_id = $request->id;
            $newAttendance->paid_updated = $getRegistrantRegistrations->updated_at;
            $newAttendance->save();

            $data1 = array();
            $data1['is_attend'] = "Attend";

            DB::table('registrants')
                ->where('id', $request->id)
                ->update($data1);
            
            $data3 = ["Registrant", "Ni"];
            return response()->json($newAttendance, 200); 
        } else {
            $getRegistrant = Registrant::where('id', $request->registrant_id)->first();
            $getRegistrantRegistrations = Registration::where('registrant_id', $getRegistrant->id)->first();

            $newAttendance = new Attendance();
            $newAttendance->status = "Guest";
            $newAttendance->registrant_id = $getRegistrant->id;
            $newAttendance->guest_id = $request->id;
            $newAttendance->paid_updated = $getRegistrantRegistrations->updated_at;
            $newAttendance->save();

            $data = array();
            $data['is_attend'] = "Attend";

            DB::table('guests')
                ->where('id', $request->id)
                ->update($data);

            $data = ["Guest", "Ni"];
            return response()->json($data, 200); 
        }   
    }

    public function registrant_guest(Request $request) 
    {
        $getRegistrationId = Registration::where('registrations.reference_number', $request->qr_code)
            ->first();
        
        $getRegistrant = Registrant::where('id', $getRegistrationId->registrant_id)
            ->first();

        $balance = $getRegistrationId->total_amount - $getRegistrationId->paid_amount; 
        $countNotYetPaid = $getRegistrationId->paid_amount / 500;
        $countNotYetPaid = intval($countNotYetPaid);
        #Get the Registrant Guest
        $getRegistrantGuest = Guest::where('guests.registrant_id', $getRegistrant->id)->get();
            
        $arrayRegistrantAndGuest = [];
        $arrayRegistrantAndGuest[] = $getRegistrant;
        for ($i = 0; $i < count($getRegistrantGuest); $i++)
        {
            $arrayRegistrantAndGuest[] = $getRegistrantGuest[$i];
        }

        
        return response()->json($arrayRegistrantAndGuest, 200); 
    }

    public function listOfAttend() 
    {
        $attendRegistrants = Attendance::join('registrants', 'registrants.id', 'attendances.registrant_id')
            ->where('status', 'Registrant')
            ->get();
        $attendGuest = Attendance::join('registrants', 'registrants.id', 'attendances.registrant_id')
            ->join('guests', 'guests.id', 'attendances.guest_id')    
            ->where('status', 'Guest')
            ->get();
        $listOfGuest = [];

        for ($i = 0; $i < count($attendRegistrants); $i++)
        {
            $listOfGuest[] = $attendRegistrants[$i];
        }

        for ($i = 0; $i < count($attendGuest); $i++)
        {
            $listOfGuest[] = $attendGuest[$i];
        }

        return view('attendance.listOfAttend', compact('listOfGuest'));
    }
}
