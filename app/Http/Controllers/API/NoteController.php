<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
       $note = Note::where('user_id' ,auth()->user()->id )->orderBy('date_at','ASC')->get();
        
        return response()->json([
            'success'   => true,
            'msg'   => '',
            'data' => $note
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request)
    {
        $note = Note::create([
            'statement'=>$request->statement,
            'user_id'=>auth()->user()->id,
            'date_at'=>$request->date_at,
        ]);

        return response()->json([
            'success'   => true,
            'msg'=>'تم التسجيل بنجاح',
            'data'=> $note
        ]);
    }//end of store

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , $id)
    {
        $note = Note::findOrFail($id);
        $note->update($request->all());
        $note->save();
        return response()->json([
            'success'   => true,
            'msg'   => 'تم التعديل بنجاح',
            'data' => $note
    ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json([
            'success'   => true,
            'msg'   => '',
            'data'=>$note
        ]);
    }
}
