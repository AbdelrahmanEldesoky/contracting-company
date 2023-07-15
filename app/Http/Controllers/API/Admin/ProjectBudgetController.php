<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use App\Models\Project;
use App\Models\ProjectBudget;
use Illuminate\Http\Request;

class ProjectBudgetController extends Controller
{

    public function get(int $project_id){
        $budget = ProjectBudget::join('users' , 'users.id' ,'=','user_id')
        ->select('project_budgets.id','users.name','value','statement','project_budgets.date_at')
        ->where('value','!=',0)
        ->where('project_id',$project_id)->get();


        $total = ProjectBudget::where('project_id',$project_id)->sum('value');

        if($total ==0){
        return response()->json([
            'success'   => true,
            'msg'   => 'تم التسجيل بنجاح',
            'data' => $budget,
            'total'=>"0"
        ]);     
        }

        return response()->json([
            'success'   => true,
            'msg'   => 'تم التسجيل بنجاح',
            'data' => $budget,
            'total'=>$total
        ]);
    }

    public function store(BudgetRequest $request , int $project_id)
    {

        $user = Project::where('id',$project_id)->value('user_id');
        $budget= ProjectBudget::create([
            'user_id'=> $user,
            'value' => $request->value,
            'statement'=>$request->statement,
            'project_id' => $project_id,
            'date_at'=> $request->date_at
        ]);
        return response()->json([
            'success'   => true,
            'msg'   => 'تم التسجيل بنجاح',
            'data' => $budget
        ]);
    }

    public function update(Request $request , int $id)
    {
        $budget = ProjectBudget::where('id',$id);
        $budget->update(
            $request->all()
        );
        return response()->json([
            'success'   => true,
            'msg'   => 'تم التعديل بنجاح',
            'data' => $budget
        ]);
    }
    public function delete(int $id)
    {
    
        $budget = ProjectBudget::findorfail($id);
        $budget->delete();
        return response()->json([
            'success'   => true,
            'msg'   => 'تم الحذف بنجاح',
            'data' => $budget
        ]);
    }
}
