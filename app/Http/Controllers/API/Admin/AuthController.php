<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Admin;
use App\Models\TypeUser;
use App\Traits\GeneralTrait;
use Validator;
use Auth;

class AuthController extends Controller
{
    use GeneralTrait;
    public function login(LoginRequest $request)
    {
        $rules = [
        "mobile"=> "required" ,
        "password" => "required"
        ];
        $type = TypeUser::where('mobile', $request->mobile)->value('type');
        //start auth admin
       // return response()->json(['type'=>$type]);
        if ($type == 1) {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login
            $credentials = $request->only(['mobile', 'password']);

            $token = Auth::guard('admin-api')->attempt($credentials);

            if (!$token) {
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
            }

            $admin = Auth::guard('admin-api')->user();
            $admin->api_token = $token;
            return $this->returnData('data', $admin);
        }//end auth admin
        elseif ($type == 2) { // start auth worker

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            //login
            $credentials = $request->only(['mobile', 'password']);

            $token = Auth::guard('api')->attempt($credentials);

            if (!$token) {
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
            }

            $user = Auth::guard('api')->user();
            $user->api_token = $token;
            return $this->returnData('data', $user);
        }//end auth user
        elseif ($type == 3) { // start auth user

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            //login
            $credentials = $request->only(['mobile', 'password']);

            $token = Auth::guard('worker-api')->attempt($credentials);

            if (!$token) {
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
            }

            $worker = Auth::guard('worker-api')->user();
            $worker->api_token = $token;
            return $this->returnData('data', $worker);
        }//end auth worker
    }
//register
public function register(RegisterRequest $request)
{
    $validator = Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|email',
        'mobile'=>'required',
        'password'=>'required|min:8', //confirmed
        ]);

    if($validator->fails()){
        return response()->json($validator->errors()->toJson(),400 );
    }
    $admin=Admin::create(array_merge(
        $validator->validate(),
        ['password'=>bcrypt($request->password)]
    ));
    $admin=TypeUser::create([
        'mobile' => $request->mobile,
        'type'=> 1
    ]);
    return response()->json([

        'stats'=>true,
        'msg' =>'تم تسجيل المستخدم بنجاح',
        'Admin'=>$admin,
    ]);
}

    public function logout(Request $request)
    {
         $token = $request -> header('auth-token');
        if($token){
            try {
                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','هناك مشكلة في تسجيل الخروج');
            }
            return $this->returnSuccessMessage('تم تسجيل الخروج بنجاح');
        }else{
            $this -> returnError('','هناك مشكلة في تسجيل الخروج');
        }
    }
}

