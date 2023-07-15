<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
 public function underway()
   {
        $underway = Project::join('users', 'projects.user_id', '=', 'users.id')
                            ->select('projects.id','projects.name as project_name' ,'projects.address','projects.sallary','projects.date_at','users.name as user_name' )
                            ->where('finsh',0)->get();
        return response()->json([
            'success'   => true,
            'msg'   => '',
            'data' => $underway
        ]);
   }
   public function finshed()
   {
        $finsh = Project::join('users', 'projects.user_id', '=', 'users.id')
        ->select('projects.id','projects.name as project_name' ,'projects.address','projects.sallary','projects.date_at','users.name as user_name' )
        ->where('finsh',1)->get();
        return response()->json([
            'success'   => true,
            'msg'   => '',
            'data' => $finsh
        ]);
   }

      public function summary($project_id){
    $project = User::join('projects', 'users.id', '=', 'projects.user_id')
    ->join('payments','projects.id', '=','payments.project_id')
    ->join('project_budgets','projects.id', '=','project_budgets.project_id')
    ->join('monthly_expenses','projects.id','=', 'monthly_expenses.project_id')
->select(DB::raw('sum(payments.value)as payments,
                sum(project_budgets.value)as budgets,
                sum(monthly_expenses.sallary)as expenses,
                projects.date_at,users.name ,
sum(project_budgets.value) - sum(monthly_expenses.sallary)-sum(payments.value) as profits'))
->where('projects.id', '=', $project_id)
->groupBy( 'projects.date_at','users.name')->count('projects.id');

if($project == 0){
    return response()->json([
    'success'   => false,
    'msg'   => 'لم تكتمل البيانات',
     'data'=>null,
]);}



        $project = User::join('projects', 'users.id', '=', 'projects.user_id')
                       ->join('payments','projects.id', '=','payments.project_id')
                       ->join('project_budgets','projects.id', '=','project_budgets.project_id')
                       ->join('monthly_expenses','projects.id','=', 'monthly_expenses.project_id')
                 ->select(DB::raw('sum(payments.value)as payments,
                                   sum(project_budgets.value)as budgets,
                                   sum(monthly_expenses.sallary)as expenses,
                                   projects.date_at,users.name ,
    sum(project_budgets.value) - sum(monthly_expenses.sallary)-sum(payments.value) as profits'))
                 ->where('projects.id', '=', $project_id)
                 ->groupBy( 'projects.date_at','users.name')->get();

                 if (is_array($project)) {
                    // Extract the first element of the array
                    $project = reset($project);
                }

                $pr= (object) [
                    'success'   => true,
                    'msg'   => '',
                    'data' => $project[0]

                ];
                  return response()->json($pr);}
    }
