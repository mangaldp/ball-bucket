<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use Illuminate\Http\Request;

class BucketController extends Controller
{
    public function __construct()
    {
        $this->title = 'Bucket';
    }
    
    public function index()
    {
        $title = $this->title;
        $buckets = Bucket::all();
        return view('bucket.list',compact('title','buckets'));
    }

    public function add()
    {
        $title = $this->title;
        return view('bucket.add', compact('title'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:buckets,name',
            'unit' => 'required|numeric'

        ]);

        $bucket = new Bucket();
        $bucket->name = $request->name;
        $bucket->unit = $request->unit;
        $bucket->save();

        return redirect()->route('bucket.list')->with('success', 'New bucket created successfully.');
    }


    public function edit(Bucket $bucket)
    {
        $title = $this->title;
        return view('bucket.edit', compact('title', 'bucket'));
    }


    public function update(Request $request, Bucket $bucket)
    {
        $this->validate($request, [
            'name' => 'required|unique:buckets,id,'.$bucket->id,
            'unit' => 'required|numeric'
        ]);

        $bucket->name = $request->name;
        $bucket->unit = $request->unit;
        $bucket->save();

        return redirect()->route('bucket.list')->with('success', 'Bucket updated successfully.');
    }


    public function delete(Bucket $bucket)
    {
        $bucket->delete();

        return redirect()->route('bucket.list')->with('success', 'Bucket deleted successfully.');
    }
}
