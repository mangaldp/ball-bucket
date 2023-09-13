<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use Illuminate\Http\Request;

class BallController extends Controller
{
    public function __construct()
    {
        $this->title = 'Ball';
    }


    public function index()
    {
        $title = $this->title;
        $balls = Ball::all();
        return view('ball.list',compact('title','balls'));
    }


    public function add()
    {
        $title = $this->title;
        return view('ball.add', compact('title'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:balls,name',
            'unit' => 'required|numeric'

        ]);

        $ball = new Ball();
        $ball->name = $request->name;
        $ball->unit = $request->unit;
        $ball->save();

        return redirect()->route('ball.list')->with('success', 'New ball created successfully.');
    }


    public function edit(Ball $ball)
    {
        $title = $this->title;
        return view('ball.edit', compact('title', 'ball'));
    }


    public function update(Request $request, Ball $ball)
    {
        $this->validate($request, [
            'name' => 'required|unique:balls,id,'.$ball->id,
            'unit' => 'required|numeric'
        ]);

        $ball->name = $request->name;
        $ball->unit = $request->unit;
        $ball->save();

        return redirect()->route('ball.list')->with('success', 'Ball updated successfully.');
    }


    public function delete(Ball $ball)
    {
        $ball->delete();

        return redirect()->route('ball.list')->with('success', 'Ball deleted successfully.');
    }
}
