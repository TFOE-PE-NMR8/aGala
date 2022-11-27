<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Registrant;
class RaffleController extends Controller
{
    
    public function index()
    {
        return view('raffle.index');
    }

    public function csv()
    {
        $data = Registrant::with('guests')->get();
        $final = [];
        foreach($data as $item){
            
            $final[]=array(
                'name' => "{$item->first_name} {$item->last_name}"
            );
            foreach($item->guests as $guest) {
                $final[]=array(
                    'name' => $guest->name
                );
            }
        }
        
        $fileName = 'names.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );


        $callback = function() use($final) {
            $file = fopen('php://output', 'w');

            foreach ($final as $item) {
                fputcsv($file, [$item['name']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }
}
