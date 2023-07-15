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
use App\Http\Traits\GeneralTrait;
use Validator;
use Auth;
use Mockery\Matcher\Type;

class AuthController extends Controller
{
    public function _construct(){
        $this->middleware('auth:api',['except'=>['login','register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    public function register(RegisterUserRequest $request)
    {
    try {
        $validator = Validator::make($request->all(),[
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required',
            'name'=>'required',
            'person_id'=>'required|unique:users,person_id',
            'address'=> 'required',
            'start_date'=>'required',
            'end_date'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400 );
        }

        $user=User::create(array_merge(
            $request->all(),
            ['password'=>bcrypt($request->password)],
           
        ));
            TypeUser::create([
            'mobile' => $request->mobile,
            'type'=> 2
        ]);
        return response()->json(['success' => true,
            'message'=>'تم التسجيل بنجاح',
            'user'=>$user,
        ]);
        }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            return  $this->returnError($e);
        }
    }
    public function updateuser(Request $request,int $id)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'address'=>'required',
            'person_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
          //  'password'=>'required|min:8', //confirmed
            ]);


  

   $count = User::where('id', $id)->count();

   $user = User::where('id', $id);

    if ($count != 0) {
    $mobile = User::findOrFail($id)->value('mobile');

    $type_user =TypeUser::where('mobile', $mobile)->value('id');

    $type = TypeUser::where('id',$type_user);

 
    $type ->update([
     'mobile' => $request->mobile,
     'type'=> 2
    ]);
    
    
    if($request->password == null or $request->password ==''){
        $user->update(array_merge(
        $validator->validate(),
        
    ));        
    }else{
    $user->update(['password'=>bcrypt($request->password),
                    'name'=>$request->name,
                    'address'=>$request->address,
                    'person_id'=>$request->person_id,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date]);
        
    }
    $user = User::where('id', $id)->get();

    return response()->json([
        'success'=>true,
        'msg'=>'User Successfully registered',
        'user'=>$user,
    ], 201);
    }else{
        return response()->json([
            'success'=>false,
            'msg'=>' ',
          //  'user'=>$user,
        ], 201);
    }
}
}

