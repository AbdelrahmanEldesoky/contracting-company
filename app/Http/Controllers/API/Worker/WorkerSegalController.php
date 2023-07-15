<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\WorkerSegal;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerSegalController extends Controller
{
    public function get( $date, $segal_id)
    {
        $user = Project::where('worker_id',auth()->guard('worker-api')->user()->id)
                            ->where('finsh',0)->value('user_id');

        $project_id = Worker::where('id',auth()->guard('worker-api')->user()->id)
                            ->value('project_id');
        $worker = Worker::where('project_id', '=', $project_id)
                            ->where('user_id', $user)->get();


        // $worker = Worker::where('project_id', '=', $project_id)->where('user_id', auth()->user()->id)->get();

        foreach ($worker as $workers) {
            $count= WorkerSegal::where('project_id', '=', $project_id)
                                 ->where('worker_id', $workers->id)
                                 ->whereDate('date_at', $date)
                                 ->where('segal_id', $segal_id)
                                 ->count();
            if($count == 0) {
            WorkerSegal::create([
                        'worker_id'=> $workers->id ,
                        'project_id' =>$workers->project_id,
                        'segal_id'=>$segal_id,
                        'sallary' => $workers->	sallary,
                        'date_at'=> $date
                    ]);
                }
            }

            $worker_get = WorkerSegal::join('workers', 'workers.id', '=', 'worker_segal.worker_id')
            ->select('worker_segal.id','workers.name','worker_segal.hours', 'workers.mobile',
            'worker_segal.sallary','total_sallary','Presence','date_at')
            ->where('worker_segal.project_id', '=', $project_id)
            ->where('workers.user_id', '=', auth()->user()->id)
            ->where( 'worker_segal.date_at','=',$date)->get();

            return response()->json([
                        'success'   => true,
                        'msg'       => '',
                        'data'      => $worker_get
                    ]);
        }

        public function sallarydaily(Request $request, $id)
        {

            $sallarys=WorkerSegal::where('id', $id)->sum('sallary');

            $totals = ($sallarys/8)*$request->hours;

            $sallary = WorkerSegal::where('id', $id);

            $sallary->update([
                'Presence' => $request->presence,
                'hours' => $request->hours,
                'statement'=>$request->statement,
                'total_sallary'=> $totals,
            ]);

            return response()->json([
                'success'   => true,
                'msg'       => '',
                'data'      => 'total_sallary = '. $totals
            ]);
        }
    
    
       public function sallarydailydetails($id){
        $details=WorkerSegal::where('id', $id)->get();
        return response()->json([
            'success'   => true,
            'msg'       => '',
            'data'      => $details
        ]);
    
    
    
    
}





