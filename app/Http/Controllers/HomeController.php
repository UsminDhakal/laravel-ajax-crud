<?php

namespace App\Http\Controllers;

use App\Models\DataStoring;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function submit(Request $request)
    {
        $id = $request->id;


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 200);
        }

        $data = ($id == null ? new DataStoring : DataStoring::where('id', $id)->first());
        $data->name = $request->name;
        $data->email = $request->email;
        $data->address = $request->address;

        if ($data->save()) {
            return response()->json(['status' => true, 'message' => "Data Saved Successfully"], 200);
        }
    }

    public function getData()
    {
        $data = DataStoring::all();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function editId($id)
    {
        $data = DataStoring::where('id', $id)->first();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function deleteId($id){
        $data = DataStoring::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => "Deleted"]);

    }
}
