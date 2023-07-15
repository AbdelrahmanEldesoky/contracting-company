<?php

namespace App\Http\Controllers\API\Worker;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Worker;
use App\Models\WorkerSallary;
use Illuminate\Http\Request;
class WorkerSallaryController extends Controller
{
    public function get($date)
    {
        $user = Project::where('worker_id',auth()->guard('worker-api')->user()->id)
                       ->where('finsh',0)->value('user_id');
                       
        $project_id = Worker::where('id',auth()->guard('worker-api')->user()->id)
                            ->value('project_id');
        $worker = Worker::where('project_id', '=', $project_id)
                        ->where('user_id', $user)->get();


      foreach ($worker as $workers){
      $count= WorkerSallary::where('project_id', '=', $project_id)
                           ->where('worker_id',$workers->id)
                           ->whereDate('date_at', $date)
                           ->count();
    if( $count == 0){
   // $time = strtotime($date);
    WorkerSallary::create([
            'worker_id'=> $workers->id ,
            'project_id' =>$workers->project_id,
            'sallary' => $workers->	sallary,
            'date_at'=> $date
        ]);}
      }

  $worker_get = WorkerSallary::join('workers', 'workers.id', '=', 'worker_salaries.worker_id')
            ->select('worker_salaries.id','workers.name','workers.mobile','worker_salaries.hours',
            'worker_salaries.sallary','add_sallary','deduct_sallary','total_sallary','Presence','date_at')
    ->where('worker_salaries.project_id', '=', $project_id)
    ->where('workers.user_id', '=', $user)
    ->where( 'worker_salaries.date_at','=',$date)->get();

    return response()->json([
             'success'   => true,
             'msg'       => '',
             'data'      => $worker_get
    ]);
    }


    public function sallarydaily(Request $request, $id)
    {
        if($request->statement ==null )
       { $statement='-';}else{$statement = $request->statement;}

    $sallarys=WorkerSallary::where('id', $id)->sum('sallary');

    $sallary = WorkerSallary::where('id', $id);

    if($request->Presence == null) {
        $presence = WorkerSallary::where('id', $id)->value('presence');
        $hours = WorkerSallary::where('id', $id)->value('hours');

    }if($request->Presence == '0') {
        $sallary->update([
            'Presence' => 0,
            'hours' => 0,
            'add_sallary'=> 0,
            'deduct_sallary'=> 0,
            'total_sallary'=> 0
        ]);

    return response()->json([
            'success'   => true,
            'msg'       => '',
            'data'      => 'total_sallary = 0'
       ]);

    }elseif($request->Presence == '1') {
        $presence = 1;
        $hours = 8;
    }

    if($request->add_hours == null) {
        $add_sallary = WorkerSallary::where('id', $id)->value('add_sallary');
    }else if($request->add_hours != null){
        $hours = 8 + $request->add_hours;
        $add_sallary = ($sallarys /8) * $request->add_hours;
    }

    if($request->deduct_hours == null) {
        $deduct_sallary = WorkerSallary::where('id', $id)->value('deduct_sallary');
    }else if($request->deduct_hours != null){
        $hours = 8 - $request->deduct_hours;
        $deduct_sallary = ($sallarys /8) * $request->deduct_hours;
    }


    if($request->deduct_money == null && $request->deduct_hours ==null ) {
            $deduct_sallary = WorkerSallary::where('id', $id)->value('deduct_sallary');
    }else if($request->deduct_money != null){
        $deduct_sallary =  $request->deduct_money;
    }

    if($request->add_money == null && $request->add_hours == null) {
            $add_sallary = WorkerSallary::where('id', $id)->value('add_sallary');
    }else if($request->add_money != null){
            $add_sallary =  $request->add_money;
    }

        $totals = $sallarys + $add_sallary - $deduct_sallary;

        $sallary = WorkerSallary::where('id', $id);

        $sallary->update([
            'Presence' => $presence,
            'hours' => $hours,
            'add_sallary'=> $add_sallary,
            'statement' =>$statement,
            'deduct_sallary'=> $deduct_sallary,
            'total_sallary'=> $totals
        ]);
    return response()->json([
            'success'   => true,
            'msg'       => '',
            'data'      => 'total_sallary = '. $totals
   ]);
    }










    public function sallarydailydetails($id){
        $details=WorkerSallary::where('id', $id)->get();
        return response()->json([
            'success'   => true,
            'msg'       => '',
            'data'      => $details
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroysallary(int $id)
    {

        $WorkerSallary = WorkerSallary::where('id', $id);

        $WorkerSallary->delete();

        return response()->json([
            'success' => true,
            'msg'     => '',
            'data'    => $WorkerSallary
        ]);

    }

}
