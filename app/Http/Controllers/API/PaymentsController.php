<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentsRequest;

use App\Models\Payment;

use App\Models\WorkerSallary;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function getPayments(int $project_id,$worker_id)
    {
       $payment= Payment::where('project_id',$project_id)->where('worker_id',$worker_id)->where('value','!=',0)->get();
        
        $total= Payment::where('project_id',$project_id)->where('worker_id',$worker_id)->sum('value');
        
        return response()->json([
            'success'   => true,
            'message'   => '',
            'data' => $payment,
            'total'=>$total
        ]);
        
        
        
        
        
    }
    public function storePayments(PaymentsRequest $request,int $project_id)
    {
        $sallary_count = WorkerSallary::where('date_at',$request->date_at)
                                ->where('worker_id', $request->worker_id)
                                ->where('project_id',$project_id)->count();
                               

    if ($sallary_count == 0) {
        $sallary= WorkerSallary::create([
            'worker_id'=> $request->worker_id,
            'project_id'=>$project_id,
            'payment' => $request-> value,
            'date_at' =>$request->date_at, 
            'sallary'=>$request->sallary,
            'statement'=>$request->statement,
            'user_id'=>auth()->user()->id
        ]);
    }else{
        $value_sallary = WorkerSallary::where('date_at',$request->date_at)
        ->where('worker_id',$request->worker_id)
        ->where('project_id',$project_id)->value('payment');
        
        $sallary = WorkerSallary::where('date_at',$request->date_at)
            ->where('worker_id', $request->worker_id)
            ->where('project_id',$project_id);
        $sallary->update(['payment' => $request-> value +$value_sallary ]);
    }
    $payment= Payment::create([
        'worker_id'=> $request->worker_id,
        'value' => $request-> value,
        'statement'=>$request->statement,
        'project_id' => $project_id,
        'user_id' =>auth()->user()->id,
        'date_at' =>$request->date_at
    ]);
    return response()->json([
            'success'   => true,
            'message'   => 'تم التسجيل بنجاح',
            'data' => $payment
        ]);
    }
    public function updatePayments(Request $request, int $id)
    {

        $value_sallary = WorkerSallary::where('date_at',$request->date_at)
            ->where('worker_id',$request->worker_id)
            ->value('payment');
            
        $id_sallary = WorkerSallary::where('date_at',$request->date_at)
            ->where('worker_id',$request->worker_id);
            

        $value_payment =  Payment::where('id',$id)->value('value');

        $tatal = $value_sallary + $request->value -  $value_payment; 
        
        

        
        $id_sallary->update(['payment' => $value_sallary + $request->value -  $value_payment]);
        

        $payment= Payment::find($id);
        $payment->update([
            'value'=>$request->value
            ]);
        return response()->json([
            'success'   => true,
            'msg'=>'تم التسجيل بنجاح',
            'data'=> $payment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletePayments (int $id)
    {
        
        $worker = Payment::findOrFail($id);
        
    
        
      $value_sallary = WorkerSallary::where('date_at',$worker->date_at)
            ->where('worker_id',$worker->worker_id)
            ->where('project_id',$worker->project_id)
            ->value('payment');
            
        $id_sallary = WorkerSallary::where('date_at',$worker->date_at)
            ->where('worker_id',$request->worker_id);
             

        $value_payment =  Payment::where('id',$id)->value('value');

        
     
        $id_sallary->update(['payment' => $value_sallary  -  $value_payment]);
     
        $worker->delete();
        return response()->json([
            'success'   => true,
            'msg'=>'تم الحذف',
            'data'=> $worker
        ]);
    }

}
