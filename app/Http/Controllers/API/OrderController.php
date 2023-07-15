<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\WorkerSallary;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    public function index()
   {
    $order =  Order::join('users','users.id','orders.user_id')
    ->join('workers' , 'workers.id','orders.worker_id')
    ->select('orders.id','orders.worker_id','workers.name','workers.address','address_work','workers.person_id','workers.mobile')
    ->where('orders.user_id',auth()->user()->id)->where('is_active',1)->get();
    return response()->json([
           'success'   => true,
            'msg'   => '',
            'data' => $order]);
   }


   public function store(Request $request)
   {
       $order = Order::create([
           'worker_id'=>$request->worker_id,
           'user_id'=>auth()->user()->id
        ]);

       return response()->json([
           'success'   => true,
           'msg'=>'تم التسجيل بنجاح',
           'data'=> $order
       ]);
   }//end of store


   public function destroy(string $id)
   {
       $Order = Order::findOrFail($id);
       $Order->delete();
       return response()->json([
           'success'   => true,
           'msg'   => '',
           'data'=>$Order
       ]);
   }



}
