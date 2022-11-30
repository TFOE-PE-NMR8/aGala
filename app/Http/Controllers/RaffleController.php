<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Registrant;
class RaffleController extends Controller
{
    
    public function index()
    {
        $url = "https://pickerwheel.com/emb/?choices=kuya,ate";
        return view('raffle.index')->with('data', $url);
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

    public function raffle_100()
    {
        $data = Registrant::with('guests')->get();
        $final = "";
        foreach($data as $item){
            
            $final= $final . "{$item->first_name} {$item->last_name},";

            foreach($item->guests as $guest) {
                $final= $final . "{$guest->name},";
            }
        }
        $url = "https://pickerwheel.com/emb/?choices=".$final;
        $url = rtrim($url,",");
        return view('raffle.index')->with('data', $url);
    }

    public function raffle_main()
    {
        $data = Registration::whereRaw('total_amount = paid_amount')->with(['registrant','registrant.guests'])->get();
        
        $final = "";
        foreach($data as $item){
            
            $final= $final . "{$item->registrant->first_name} {$item->registrant->last_name},";
            
            foreach($item->registrant->guests as $guest) {
                $final= $final . "{$guest->name},";
            }
        }
        $url = "https://pickerwheel.com/emb/?choices=".$final;
        $url = rtrim($url,",");
        return view('raffle.index')->with('data', $url);
    }
}
