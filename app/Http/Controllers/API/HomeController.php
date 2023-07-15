<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\TypeUser;
use Illuminate\Http\Request;
use http\Env\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\Project;
use App\Http\Traits\GeneralTrait;
use Validator;
use Auth;
use Mockery\Matcher\Type;

class HomeController extends Controller
{

    public function profile()
    {
        $user=User::where('id',auth()->user()->id)->get(['id' ,'name','mobile','person_id','address','admin']);
        
       $ex= (object) [
                'success'   => true,
                'msg'   => '',
                'data'=> $user,
            ];
    return response()->json($ex); 
    }
    
    
    public function home()
    {
        $project_all=Project::where('user_id',auth()->user()->id)->count('id');
        $project_not_end=Project::where('user_id',auth()->user()->id)->where('finsh',0)->count('id');
        $project_end=Project::where('user_id',auth()->user()->id)->where('finsh',1)->count('id');
        
       $ex= (object) [
                'success'   => true,
                'msg'   => '',
                'project_all'=> $project_all,
                'project_not_end'=> $project_not_end,
                'project_end'=>$project_end,
            ];
    return response()->json($ex); 
    }
    
    
    
}

