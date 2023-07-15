<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SegalRequest;
use App\Models\Segal;
use Illuminate\Http\Request;

class SegalController extends Controller
{
    public function index()
    {
       $segal = Segal::where('user_id' ,auth()->user()->id )->orderBy('created_at','desc')->get();

        return response()->json([
            'success'   => true,
            'msg'   => '',
            'data' => $segal
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SegalRequest $request)
    {
        $segal = Segal::create([
            'name'=>$request->name,
            'user_id'=>auth()->user()->id,
        ]);

        return response()->json([
            'success'   => true,
            'msg'=>'تم التسجيل بنجاح',
            'data'=> $segal
        ]);
    }//end of store

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , $id)
    {
        $segal = Segal::findOrFail($id);
        $segal->update($request->all());
        $segal->save();
        return response()->json([
            'success'   => true,
            'msg'   => 'تم التعديل بنجاح',
            'data' => $segal
    ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $segal = Segal::findOrFail($id);
        $segal->delete();
        return response()->json([
            'success'   => true,
            'msg'   => '',
            'data'=>$segal
        ]);
    }
}
