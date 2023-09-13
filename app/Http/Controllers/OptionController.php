<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Bucket;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->title = 'Result';
    }


    public function index()
    {
        $title = $this->title;
        $results = Option::all();
        return view('result.list', compact('title','results'));
    }

    public function add()
    {
        $title = $this->title;
        $balls = Ball::all();
        $buckets = Bucket::all();
        return view('result.add', compact('title','buckets','balls'));
    }


    public function calculate(Request $request)
    {
        if ($request->ajax()) {
            $ball_obj = $request->json();
            $ball_data = [];
            $ball_ids = [];
            $tot_ball = 0;
            $extra_ball = [];
            $input_data = [];
            foreach($ball_obj as $k => $ball_qty){
                if(!empty($ball_qty) > 0){
                    $ball_data[$k] = (int)$ball_qty;
                    $extra_ball[$k] = ['name'=>'', 'qty' => $ball_data[$k]];
                    $input_data[$k] = ['name'=>'', 'unit' => 0, 'qty' => $ball_data[$k]];
                    array_push($ball_ids, $k);
                    $tot_ball += $ball_data[$k];
                }
            }
            $balls = Ball::whereIn('id', $ball_ids)->orderBy('unit','desc')->get();
            $min_ball = Ball::whereIn('id', $ball_ids)->orderBy('unit','asc')->first();
            $buckets = Bucket::orderBy('unit','asc')->get();
            $empty_bucket = [];
            $fill_bucket = [];
            $cnt = 1;
            foreach($buckets as $bucket){
                $bkt_vol = $bucket->unit;
                while($bkt_vol >= $min_ball->unit && $tot_ball > 0){
                    foreach($balls as $ball){
                        if(empty($extra_ball[$ball->id]['name'])){
                            $extra_ball[$ball->id]['name'] = $ball->name;
                            $input_data[$ball->id]['name'] = $ball->name;
                            $input_data[$ball->id]['unit'] = $ball->unit;
                        }
                        if($ball_data[$ball->id] > 0 && $bkt_vol >= $ball->unit){
                            if(!empty($fill_bucket[$bucket->name][$ball->name])){
                                $fill_bucket[$bucket->name][$ball->name] += 1;
                            }else{
                                $fill_bucket[$bucket->name][$ball->name] = 1;
                            }
                            $bkt_vol -= $ball->unit;
                            $ball_data[$ball->id] -= 1;
                            $extra_ball[$ball->id]['qty'] -= 1;
                            $tot_ball--;
                            $cnt = 1;
                        }
                        if($bkt_vol >= $min_ball->unit && $bkt_vol < $ball->unit){
                            $cnt = 0;
                        }
                    }
                    if($cnt < 1 ){
                        break;
                    }
                }
                if($bkt_vol == $bucket->unit || $bkt_vol >= $min_ball->unit){
                    array_push($empty_bucket, [$bucket->name=>$bkt_vol]);
                }

            }

            $total_data = ['fill' => $fill_bucket, 'empty' => $empty_bucket, 'extra' => $extra_ball, 'min' => $min_ball->unit, 'tot' => $tot_ball, 'input' => $input_data];
            

            return response()->json($total_data);
        }else{
            return response()->json('This is a fake call');
        }
    }

    public function store(Request $request)
    {
        $option = new Option();
        $option->raw = json_encode($request->raw);
        $option->fill = json_encode($request->fill);
        $option->empty = json_encode($request->empty);
        if($request->has('extra')){
            $option->extra = json_encode($request->extra);
        }
        
        $option->save();

        return redirect()->route('result.list')->with('success', 'New result stored successfully.');
    }


    public function show(Option $option)
    {
        $title = $this->title;
        $fill = json_decode($option->fill);
        $raw = json_decode($option->raw);
        $empty = '';
        if(!empty($option->extra)){
            $empty = json_decode($option->empty);
        }
        $extra = '';
        if(!empty($option->extra)){
            $extra = json_decode($option->extra);
        }
        //  dd($empty);
        return view('result.show', compact('title','fill','raw','empty','extra'));
    }
}
