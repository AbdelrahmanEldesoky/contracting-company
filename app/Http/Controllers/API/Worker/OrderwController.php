<?php

namespace App\Http\Controllers\API\Worker;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserWorker;
use App\Models\Worker;
use Illuminate\Http\Request;

class OrderwController extends Controller
{
   public function order()
   {
   
   
    $order =  Order::join('users','users.id','=','orders.user_id')->select('orders.id','name','mobile')->
        where('worker_id',auth()->guard('worker-api')->user()->id)->where('orders.is_active','=',1)->get();
    
    return response()->json([
           'success'   => true,
            'msg'   => '',
            'data' => $order
            ]);
   }


   
   public function postorder(Request $request , $id)
   {
       $order = Order::findOrFail($id);
       $worker = Worker::where('id',auth()->guard('worker-api')->user()->id);


           UserWorker::create([
            'user_id'=>$order->user_id,
            'worker_id'=>auth()->guard('worker-api')->user()->id,
            'project_id'=>0,
            'user_id' => auth()->guard('worker-api')->user()->id
            
        ]);


       $worker->update([
           'user_id'=>$order->user_id,
           'Date_relation'=>$request->Date_relation,
           'project_id' => 0 
           ]);
        


       
       $order->update(['is_active'=>0]);
       $order->save();
       return response()->json([
           'success'   => true,
           'msg'   => 'تم التعديل بنجاح',
           'data' => $order
   ]);
   }

   public function delteorder(int $id)
   {
       $Order = Order::findOrFail($id);
       $Order->delete();
       return response()->json([
           'success'   => true,
           'msg'   => '',
           'data'=>$Order
       ]);
   }


   public function user_worker()
   {
      
 
 $w =  Worker::join('users','users.id','user_id')->select('users.id','users.name','users.mobile','Date_relation')->
 //where('user_id','!=',1)->
        where('workers.id',auth()->guard('worker-api')->user()->id)->get();

    return response()->json([
           'success'   => true,
            'msg'   => '',
            'data' => $w
        ]);
   }


   public function delete_relation()
   {
    
    $warker = Worker::where('id',auth()->guard('worker-api')->user()->id);

    $warker->update(['user_id'=>1]);
    
    return response()->json([
           'success'   => true,
            'msg'   => '',
            'data' => $warker
            ]);
   }





}
