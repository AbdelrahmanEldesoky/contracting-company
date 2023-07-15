<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkeradminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $worker =Worker::where('id','!=',1)->get();
        return response()->json([
            'success'   => true,
            'msg'=>'تم التعديل بنجاح',
            'data'=> $worker
        ],201);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $worker = Worker::findOrFail($id);
    
        if($request->password != null && $request->password != $worker->password){       
            $worker->update(['password'=>bcrypt($request->password)]);
        }
        $worker->update($request->except(['password']));
      
        return response()->json([
            'success'   => true,
            'msg'=>'تم التعديل بنجاح',
            'data'=> $worker
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $worker = Worker::findOrFail($id);
        $worker->delete();
        return response()->json([
            'success'   => true,
            'msg'=>'تم التسجيل بنجاح',
            'data'=> $worker
        ]);
    }
}
