<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Registrant;
use App\Models\Raffle;


class RaffleController extends Controller
{
    
    public function index()
    {
        $data_main = Raffle::whereRaw('is_hundred = 0 AND has_won = 1 ORDER BY name ASC')->get();
        $data_100 = Raffle::whereRaw('is_hundred = 1 AND has_won = 1 ORDER BY name ASC')->get();
        $final = "";
        $winner_main = array();
        $winner_100 = array();
        foreach($data_main as $item){
            array_push($winner_main,$item->name);
        }
        foreach($data_100 as $item){
            array_push($winner_100,$item->name);
        }
        $url = "https://pickerwheel.com/emb/?choices=kuya,ate";
        return view('raffle.index')->with(compact(['winner_main','winner_100','url']));
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
        $data_main = Raffle::whereRaw('is_hundred = 0 AND has_won = 1 ORDER BY name ASC')->get();
        $data_100 = Raffle::whereRaw('is_hundred = 1 AND has_won = 1 ORDER BY name ASC')->get();
        $final = "";
        $winner_main = array();
        $winner_100 = array();

        foreach($data as $item){
            $final = $final . "{$item->name},";
        }
        foreach($data_main as $item){
            array_push($winner_main,$item->name);
        }
        foreach($data_100 as $item){
            array_push($winner_100,$item->name);
        }

        $url = "https://pickerwheel.com/emb/?choices=".$final;
        $url = rtrim($url,",");
        return view('raffle.index')->with(compact(['winner_main','winner_100','url']));
    }

    public function raffle_100()
    {
        #$data = Registrant::with('guests')->get();
        $data = Raffle::whereRaw('is_hundred = 1 AND has_won = 0')->get();
        $data_main = Raffle::whereRaw('is_hundred = 0 AND has_won = 1 ORDER BY name ASC')->get();
        $data_100 = Raffle::whereRaw('is_hundred = 1 AND has_won = 1 ORDER BY name ASC')->get();
        $final = "";
        $winner_main = array();
        $winner_100 = array();

        foreach($data as $item){
            $final = $final . "{$item->name},";
        }
        foreach($data_main as $item){
            array_push($winner_main,$item->name);
        }
        foreach($data_100 as $item){
            array_push($winner_100,$item->name);
        }

        $url = "https://pickerwheel.com/emb/?choices=".$final;
        $url = rtrim($url,",");
        return view('raffle.index')->with(compact(['winner_main','winner_100','url']));
    }

    public function generate_100_entry()
    {
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
        return redirect('/raffle/raffle-100');
    }

    public function generate_main_entry()
    {
        $data1 = Registration::whereRaw('total_amount = paid_amount ORDER BY updated_at ASC')->with(['registrant','registrant.guests'])->get();
        
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
        return redirect('/raffle/raffle-main');
    }

    public function update(Request $request)
    {
        // Raffle::where('name',$request->name)
        //     ->where('is_hundred',$request->mode)
        //     ->get()
        //     ->first()
        //     ->update(['has_won'=>'1']);


        $winner = Raffle::where('name',$request->name)
                    ->where('is_hundred',$request->mode)
                    ->get()
                    ->first();
        $msg ="";
        if(is_null($winner))
        {
            $wild_card = Raffle::select('name')->whereRaw("name LIKE '%{$request->name}%'")
                    ->get()
                    ->first();
            if(is_null($wild_card))
            {
                return redirect()->back()->withSuccess('Name not found: '.$request->name);
            }else{
                $msg = "Name '{$request->name}' not found. Do you mean '{$wild_card->name}'?";
                return redirect()->back()->withSuccess($msg);
            }
            
        }else{
            $winner->update(['has_won'=>'1']);
        }

        if($request->mode == 1){
            return redirect('/raffle/raffle-100')->with('msg',$msg);
        }else{
            return redirect('/raffle/raffle-main')->with('msg',$msg);
        }
    }

    
}
