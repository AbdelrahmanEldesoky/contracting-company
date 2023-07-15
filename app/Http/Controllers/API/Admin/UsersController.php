<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;


class UsersController extends Controller
{

    public function alluser()
    {

        $user = User::where('id','!=',1)->get();
        return response()->json([
            'msg' => '',
             'status' => true,
            'users'=>$user]);
    }

  public function deleteuser(int $id)
    {
        $user = User::where('id',$id);
        $count = User::where('id',$id)->count();
        if($count !=0){
        $user->delete();
        return response()->json([
               'msg' => 'تم الحذف بنجاح',
             'status' => true,
            'data'=>$user]);
        }else{
            return response()->json([
               'msg' => '',
             'status' => false,
            'data'=>$user]);

        }
    }



}

