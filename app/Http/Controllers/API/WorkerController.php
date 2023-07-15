<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterWorkerRequest;
use App\Models\TypeUser;
use App\Models\UserWorker;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\WorkerSallary;
use Validator;
class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $worker = Worker::join('projects', 'projects.id', '=', 'workers.project_id')->select('workers.id','projects.name as project_name','project_id','workers.name as worker_name' , 'workers.mobile' , 'workers.person_id','admin','workers.sallary' ,'password')->where('workers.user_id',auth()->user()->id)->where('workers.id','!=',1)->get();
        return response()->json([
            'success'   => true,
            'msg'=>'  ',
            'data'=> $worker
        ]);
    }


    public function user_worker($project_id)
    {
        $worker = Worker::join('user_workers', 'user_workers.worker_id', '=', 'workers.id')
                        ->join('user_workers', 'user_workers.project_id', '=', 'projects.id')
        ->select('workers.id','projects.name as project_name','project_id','workers.name as worker_name' , 'workers.mobile' , 'workers.person_id','admin','workers.sallary' ,'password')
        ->where('user_workers.user_id',auth()->user()->id)
        ->where('workers.id','!=',1)
        ->where('user_workers.project_id',$project_id)->get();
        
        return response()->json([
            'success'   => true,
            'msg'=>'  ',
            'data'=> $worker
        ]);
    }


    
    public function allworker()
    {
        $worker = Worker::where('id','!=',auth()->user()->id)
        ->where('workers.id','!=',1)
        ->where('workers.user_id','!=',auth()->user()->id)
        ->whereNotIn('id',function($query) {
   $query->select('orders.worker_id')->from('orders')->where('orders.user_id','=',auth()->user()->id)->Where('orders.is_active',1);

})->get();
        return response()->json([
            'success'   => true,
            'msg'=>'  ',
            'data'=> $worker
        ]);
    }
    
    public function projectnull()
    {
        $worker = Worker::where('workers.user_id',auth()->user()->id)->where('project_id' ,0 )->get();
        return response()->json([
            'success'   => true,
            'msg'=>'  ',
            'data'=> $worker
        ]);
    }
    
    public function get($project_id)
    {
        $worker = Worker::where('user_id',auth()->user()->id)
                        ->where('project_id',$project_id)
                        ->get();
        return response()->json([
            'success'   => true,
            'msg'=>'',
            'data'=> $worker
        ]);
    }

public function show($id){
    
}
    public function store(RegisterWorkerRequest $request)
   {
        $worker=Worker::create([
            'name'=>$request->name,
            'mobile'=>$request->mobile,
            'person_id'=>$request->person_id,
            'sallary' =>$request->sallary,
            'user_id' => 1,
            'address_work'=>$request->address_work,
            'address'=>$request->address,
            'password'=>bcrypt($request->password)
            ]);
     
        TypeUser::create([
            'mobile' => $request->mobile,
            'type'=> 3
        ]);
            
        return response()->json([
            'success'   => true,
            'msg'=>'تم التعديل بنجاح',
            'data'=> $worker
        ],201);
    }
/**
     * Show the form for editing the specified resource.
     */


    public function update(Request $request, int $id)
    {
        $worker = Worker::where('id',$id);
        
        $worker->update($request->all());
       
        if($request->has('project_id')){

            $cheak= UserWorker::where('worker_id',$id)->where('project_id',0)
            ->where('user_id',auth()->user()->id)->count('id');
    
            if($cheak==0){
                $user_worker= UserWorker::where('worker_id',$id)->where('project_id',0)
                ->where('user_id',auth()->user()->id);
                $user_worker->update([
                    'project_id'=>$request->project_id
                ]);
            }else{
                UserWorker::create([
                    'user_id'=>auth()->user()->id , 
                    'project_id'=>$request->project_id,
                    'worker_id'=>$id
                ]);
            }
        }



        return response()->json([
            'success'   => true,
            'msg'=>'تم التسجيل بنجاح',
            'data'=> $worker
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $worker = Worker::findOrFail($id);
        $worker->update(['user_id' => 1]);
        return response()->json([
            'success'   => true,
            'msg'=>'تم التسجيل بنجاح',
            'data'=> $worker
        ]);
    }
}
