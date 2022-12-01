<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Registrant;
use App\Models\Raffle;

use function PHPUnit\Framework\isNull;

class RaffleController extends Controller
{
    
    public function index()
    {
        $url = "https://pickerwheel.com/emb/?choices=kuya,ate";
        return view('raffle.index')->with('url', $url);
    }

    public function csv()
    {
        $data = Registrant::with('guests')->get();
        dd($data);
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

    public function raffle_main()
    {
        #$data = Registrant::with('guests')->get();
        $data = Raffle::whereRaw('is_hundred = 0 AND has_won = 0')->get();
        $final = "";
        foreach($data as $item){
            $final = $final . "{$item->name},";
        }
        $url = "https://pickerwheel.com/emb/?choices=".$final;
        $url = rtrim($url,",");
        return view('raffle.index')->with('url', $url);
    }

    public function raffle_100()
    {
        #$data = Registrant::with('guests')->get();
        $data = Raffle::whereRaw('is_hundred = 1 AND has_won = 0')->get();
        $final = "";
        foreach($data as $item){
            $final = $final . "{$item->name},";
        }
        $url = "https://pickerwheel.com/emb/?choices=".$final;
        $url = rtrim($url,",");
        return view('raffle.index')->with('url', $url);
    }

    public function generate_100_entry()
    {
        #$data = Registrant::with('guests')->get();
        #$data = Registration::whereRaw('paid_amount = total_amount')->with(['registrant','registrant.guests'])->get();
        $data1 = Registration::whereRaw('total_amount = paid_amount ORDER BY updated_at ASC')->with(['registrant','registrant.guests'])->get();
        
        $final = "";
        $limit = 100;
        foreach($data1 as $item){
            $name = "{$item->registrant->first_name} {$item->registrant->last_name}";
            $ret = Raffle::where('name',$name)->where('is_hundred',1)->get()->first();
            if(empty($ret))
            { 
                Raffle::create([
                        'name' => $name,
                        'is_hundred' => true,
                        'has_won' => false
                    ]);
            }
            $limit = $limit - 1;
            if($limit=='0')break 1;

            foreach($item->registrant->guests as $guest) {
                $name = $guest->name;
                $ret = Raffle::where('name',$name)->where('is_hundred',1)->get()->first();
                if(empty($ret))
                { 
                    Raffle::create([
                        'name' => $name,
                        'is_hundred' => true,
                        'has_won' => false
                    ]);
                }
                $limit = $limit - 1;
                if($limit=='0')break 2;
            }
        }
        $message = "1st 100 Paid Registrant Entry Created!";
        $url = "https://pickerwheel.com/emb/?choices=kuya,ate";
        return view('raffle.index')->with(compact(['message','url']));
    }

    public function generate_main_entry()
    {
        #$data = Registration::whereRaw('total_amount = paid_amount')->with(['registrant','registrant.guests'])->get();
        $data1 = Registration::whereRaw('total_amount = paid_amount ORDER BY updated_at ASC')->with(['registrant','registrant.guests'])->get();
        #dd($data1);
        foreach($data1 as $item){
            $name = "{$item->registrant->first_name} {$item->registrant->last_name}";
            $ret = Raffle::where('name',$name)->where('is_hundred',0)->get()->first();
            
            if(empty($ret))
            {
                Raffle::create([
                    'name' => $name,
                    'is_hundred' => false,
                    'has_won' => false
                ]);
            }
            foreach($item->registrant->guests as $guest) {
                $name = $guest->name;
                $ret = Raffle::where('name',$name)->where('is_hundred',0)->get()->first();
                
                if(empty($ret)){
                    Raffle::create([
                        'name' => $guest->name,
                        'is_hundred' => false,
                        'has_won' => false
                    ]);
                }
            }
        }
        
        $url = "https://pickerwheel.com/emb/?choices=kuya,ate";
        return view('raffle.index')->with('url', $url);
    }
}
