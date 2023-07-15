<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WorkerSallary;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
class WorkerAccountController extends Controller
{
    public function workers($project_id,$date)
   {
    $time = strtotime($date);
    $year = date('Y',$time);
    $month = date('m',$time);


    $account = WorkerSallary::join('workers', 'worker_salaries.worker_id', '=', 'workers.id')
    ->select(DB::raw(
              'sum(add_sallary)as add_sallary,
                      sum(deduct_sallary)as deduct_sallary,
                      sum(total_sallary)as total_sallary,
                      sum(hours) as hours,
                      sum(payment) as payment,
                      sum(total_sallary) -  sum(payment) as motabky,
                      person_id,mobile,
                      name,workers.sallary,workers.id as worker_id'))
    ->where('worker_salaries.project_id', '=', $project_id)
    ->whereYear('worker_salaries.date_at', '=', $year)
    ->whereMonth('worker_salaries.date_at', '=', $month)
    ->where(function ($query) {
        $query->where('worker_salaries.Presence', '=', 1)
              ->orWhere('payment', '!=', 0);})
    ->groupBy('name','workers.sallary','workers.id','person_id','mobile')->get();
    
    
$total = WorkerSallary::select(DB::raw('sum(hours) as hours,
    sum(sallary)as sallary,
    sum(add_sallary) as add_sallary,
    sum(deduct_sallary) as deduct_sallary,
    sum(total_sallary) as total_sallary,
    sum(Presence) as Presence,
    sum(payment) as payment,
    sum(total_sallary) -  sum(payment) as motabky' ))
->where('project_id',$project_id)
->whereYear('worker_salaries.date_at', '=', $year)
->whereMonth('worker_salaries.date_at', '=', $month)
->where(function ($query) {
$query->where('worker_salaries.Presence', '=', 1)
->orWhere('payment', '!=', 0);})
->get();
    
    return response()->json([
           'success'   => true,
            'msg'   => '',
            'data' => $account,
            'total'=>$total
            ]);
   }



   public function workers_rep($project_id,$date)
   {
    $time = strtotime($date);
    $year = date('Y',$time);
    $month = date('m',$time);

    $date_ym = $month .'-'.$year; 

     

    $account = WorkerSallary::join('workers', 'worker_salaries.worker_id', '=', 'workers.id')
    ->select(DB::raw(
              'sum(add_sallary)as add_sallary,
                      sum(deduct_sallary)as deduct_sallary,
                      sum(total_sallary)as total_sallary,
                      sum(hours) as hours,
                      sum(payment) as payment,
                      sum(total_sallary) -  sum(payment) as motabky,
                      person_id,mobile,
                      name,workers.sallary,workers.id as worker_id'))
    ->where('worker_salaries.project_id', '=', $project_id)
    ->whereYear('worker_salaries.date_at', '=', $year)
    ->whereMonth('worker_salaries.date_at', '=', $month)
    ->where(function ($query) {
        $query->where('worker_salaries.Presence', '=', 1)
              ->orWhere('payment', '!=', 0);})
    ->groupBy('name','workers.sallary','workers.id','person_id','mobile')->get();
    
    
$total = WorkerSallary::select(DB::raw('sum(hours) as hours,
    sum(sallary)as sallary,
    sum(add_sallary) as add_sallary,
    sum(deduct_sallary) as deduct_sallary,
    sum(total_sallary) as total_sallary,
    sum(Presence) as Presence,
    sum(payment) as payment,
    sum(total_sallary) -  sum(payment) as motabky' ))
->where('project_id',$project_id)
->whereYear('worker_salaries.date_at', '=', $year)
->whereMonth('worker_salaries.date_at', '=', $month)
->where(function ($query) {
$query->where('worker_salaries.Presence', '=', 1)
->orWhere('payment', '!=', 0);})
->get();
    
    
    
    
    return View('workers_rep',compact(['account','total','date_ym']) );
    
   }



   public function worker_month($date,$worker_id)
   {
    $time = strtotime($date);
    $year = date('Y',$time);
    $month = date('m',$time);

    $date_ym = $year. '-'.$month;


    $account = WorkerSallary::where('worker_salaries.worker_id',$worker_id)
    ->where(function ($query) {
        $query->where('worker_salaries.Presence', '=', 1)
              ->orWhere('worker_salaries.payment', '!=', 0);})
    ->whereYear('worker_salaries.date_at', '=', $year)
    ->where('user_id', auth()->user()->id)
    ->whereMonth('worker_salaries.date_at', '=', $month)->orderBy('worker_salaries.date_at', 'ASC')->get();



$total = WorkerSallary::select(DB::raw('sum(hours) as hours,
    sum(sallary)as sallary,
    sum(add_sallary) as add_sallary,
    sum(deduct_sallary) as deduct_sallary,
    sum(total_sallary) as total_sallary,
    sum(Presence) as Presence,
    sum(payment) as payment,
    sum(total_sallary) -  sum(payment) as motabky' ))
->where('worker_salaries.worker_id',$worker_id)
->where('worker_salaries.user_id', auth()->user()->id)
->whereYear('worker_salaries.date_at', '=', $year)
->whereMonth('worker_salaries.date_at', '=', $month)
->where(function ($query) {
$query->where('worker_salaries.Presence', '=', 1)
->orWhere('payment', '!=', 0);})
->get();


    return response()->json([
            'success'   => true,
            'msg'   => '',
            'data'=> $account,
            'total'=>$total]);
   }




   public function worker_month_rep($date,$worker_id,$user_id)
   {
    $time = strtotime($date);
    $year = date('Y',$time);
    $month = date('m',$time);

    $date_ym = $month .'-'.$year; 
    $worker_name = Worker::where('id',$worker_id)->value('name');

    $account = WorkerSallary::where('worker_salaries.worker_id',$worker_id)
    ->where(function ($query) {
        $query->where('worker_salaries.Presence', '=', 1)
              ->orWhere('worker_salaries.payment', '!=', 0);})
    ->where('user_id', $user_id)
    ->whereYear('worker_salaries.date_at', '=', $year)
    ->whereMonth('worker_salaries.date_at', '=', $month)->orderBy('worker_salaries.date_at', 'ASC')->get();



    $total = WorkerSallary::select(DB::raw('sum(hours) as hours,
        sum(sallary)as sallary,
        sum(add_sallary) as add_sallary,
        sum(deduct_sallary) as deduct_sallary,
        sum(total_sallary) as total_sallary,
        sum(Presence) as Presence,
        sum(payment) as payment,
        sum(total_sallary) -  sum(payment) as motabky' ))
    ->where('worker_salaries.worker_id',$worker_id)
    ->where('worker_salaries.user_id', $user_id)
    ->whereYear('worker_salaries.date_at', '=', $year)
    ->whereMonth('worker_salaries.date_at', '=', $month)
    ->where(function ($query) {
    $query->where('worker_salaries.Presence', '=', 1)
    ->orWhere('payment', '!=', 0);})
    ->get();

    return View('worker_month',compact(['account','total','date_ym','worker_name']));

}

   public function worker_month_name($date)
   {
    $time = strtotime($date);
    $year = date('Y',$time);
    $month = date('m',$time);
    $data = WorkerSallary::join('workers','workers.id','=','worker_salaries.worker_id')
    ->select(DB::raw( 'workers.id,workers.name,workers.person_id,workers.mobile,workers.sallary,
sum(hours) as hours,
sum(worker_salaries.sallary)as sum_sallary,
sum(add_sallary) as add_sallary,
sum(deduct_sallary) as deduct_sallary,
sum(total_sallary) as total_sallary,
sum(Presence) as Presence,
sum(payment) as payment,
sum(total_sallary) - sum(payment) as motabky'))

    ->where(function ($query) {
        $query->where('worker_salaries.Presence', '=', 1)
              ->orWhere('worker_salaries.payment', '!=', 0);})
    ->where('worker_salaries.user_id', auth()->user()->id)
    ->whereYear('worker_salaries.date_at', '=', $year)
    ->whereMonth('worker_salaries.date_at', '=', $month)
    ->distinct()
    ->groupBy('workers.id','workers.name','workers.person_id','workers.mobile','workers.sallary')->get();

    $total = WorkerSallary::select(DB::raw('sum(hours) as hours,
        sum(sallary)as sallary,
        sum(add_sallary) as add_sallary,
        sum(deduct_sallary) as deduct_sallary,
        sum(total_sallary) as total_sallary,
        sum(Presence) as Presence,
        sum(payment) as payment,
        sum(total_sallary) -  sum(payment) as motabky' ))
    ->where('worker_salaries.user_id', auth()->user()->id)
    ->whereYear('worker_salaries.date_at', '=', $year)
    ->whereMonth('worker_salaries.date_at', '=', $month)
    ->where(function ($query) {
    $query->where('worker_salaries.Presence', '=', 1)
    ->orWhere('payment', '!=', 0);})
    ->get();


    return response()->json([
            'success'   => true,
            'msg'   => '',
            'data'=> $data,
            'total'=> $total
            ]);
   }


   public function worker_month_name_rep($date,$user_id)
   {
    $time = strtotime($date);
    $year = date('Y',$time);
    $month = date('m',$time);
    $date_ym =$year.'-'.$month;
    $account = WorkerSallary::join('workers','workers.id','=','worker_salaries.worker_id')
    ->select(DB::raw( 'workers.id,workers.name,workers.person_id,workers.mobile,workers.sallary,
    sum(hours) as hours,
        sum(worker_salaries.sallary)as sum_sallary,
        sum(add_sallary) as add_sallary,
        sum(deduct_sallary) as deduct_sallary,
        sum(total_sallary) as total_sallary,
        sum(Presence) as Presence,
        sum(payment) as payment,
        sum(total_sallary) -  sum(payment) as motabky'))
    ->where(function ($query) {
        $query->where('worker_salaries.Presence', '=', 1)
              ->orWhere('worker_salaries.payment', '!=', 0);})
    ->where('worker_salaries.user_id', $user_id)
    ->whereYear('worker_salaries.date_at', '=', $year)
    ->whereMonth('worker_salaries.date_at', '=', $month)
    ->distinct()
    ->groupBy('workers.id','workers.name','workers.person_id','workers.mobile','workers.sallary')->get();


    $total = WorkerSallary::select(DB::raw('sum(hours) as hours,
        sum(sallary)as sallary,
        sum(add_sallary) as add_sallary,
        sum(deduct_sallary) as deduct_sallary,
        sum(total_sallary) as total_sallary,
        sum(Presence) as Presence,
        sum(payment) as payment,
        sum(total_sallary) -  sum(payment) as motabky' ))
    ->where('worker_salaries.user_id', $user_id)
    ->whereYear('worker_salaries.date_at', '=', $year)
    ->whereMonth('worker_salaries.date_at', '=', $month)
    ->where(function ($query) {
    $query->where('worker_salaries.Presence', '=', 1)
    ->orWhere('payment', '!=', 0);})
    ->get();

    return View('worker_month_name',compact(['account','total','date_ym']));

   }










   public function worker($project_id,$date,$worker_id)
   {
    $time = strtotime($date);
    $year = date('Y',$time);
    $month = date('m',$time);

    $account = WorkerSallary::where('project_id', '=', $project_id)
    ->where('worker_id',$worker_id)
    ->where(function ($query) {
        $query->where('worker_salaries.Presence', '=', 1)
              ->orWhere('payment', '!=', 0);})
    ->whereYear('date_at', '=', $year)
    ->whereMonth('date_at', '=', $month)->orderBy('date_at', 'ASC')->get();



$total = WorkerSallary::select(DB::raw('sum(hours) as hours,
    sum(sallary)as sallary,
    sum(add_sallary) as add_sallary,
    sum(deduct_sallary) as deduct_sallary,
    sum(total_sallary) as total_sallary,
    sum(Presence) as Presence,
    sum(payment) as payment,
    sum(total_sallary) -  sum(payment) as motabky' ))
->where('worker_salaries.worker_id',$worker_id)
->where('project_id', '=', $project_id)
->whereYear('worker_salaries.date_at', '=', $year)
->whereMonth('worker_salaries.date_at', '=', $month)
->where(function ($query) {
$query->where('worker_salaries.Presence', '=', 1)
->orWhere('payment', '!=', 0);})
->get();


    return response()->json([
            'success'   => true,
            'msg'   => '',
            'data'=> $account,
            'total'=>$total]);
   }

 public function worker_rep($project_id,$date,$worker_id)
   {
    $time = strtotime($date);
    $year = date('Y',$time);
    $month = date('m',$time);
    
    $date_ym = $month .'-'.$year;

    $worker_name = Worker::where('id',$worker_id)->value('name');

    $account = WorkerSallary::where('project_id', '=', $project_id)
    ->where('worker_id',$worker_id)
    ->where(function ($query) {
        $query->where('worker_salaries.Presence', '=', 1)
              ->orWhere('payment', '!=', 0);})
    ->whereYear('date_at', '=', $year)
    ->whereMonth('date_at', '=', $month)->orderBy('date_at', 'ASC')->get();



$total = WorkerSallary::select(DB::raw('sum(hours) as hours,
    sum(sallary)as sallary,
    sum(add_sallary) as add_sallary,
    sum(deduct_sallary) as deduct_sallary,
    sum(total_sallary) as total_sallary,
    sum(Presence) as Presence,
    sum(payment) as payment,
    sum(total_sallary) -  sum(payment) as motabky' ))
->where('worker_salaries.worker_id',$worker_id)
->whereYear('worker_salaries.date_at', '=', $year)
->whereMonth('worker_salaries.date_at', '=', $month)
->where(function ($query) {
$query->where('worker_salaries.Presence', '=', 1)
->orWhere('payment', '!=', 0);})
->get();

    return View('worker_rep',compact(['account','total','date_ym','worker_name']) );

    
   }


}
