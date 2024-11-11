<?php

namespace App\Http\Controllers;

use adLDAP\adLDAP;
use App\Models\User;
use App\Models\UserLdap;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
          
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'), 201);
    }

    // User login
    public function login(Request $request)
    {
       
        $credentials = $request->only(['username', 'password']);
        $user = User::where('username', '=', $credentials['username'])->first();
        if (!is_null($user)) 
       {
        
        $is_correct_user_ldap= $this->LDAPConnect($request['username'],$request['password']);
        //$is_correct_user_ldap=true;
        if($is_correct_user_ldap){
                
                $id = DB::select('select users.id from users where username = ?', [$request['username']]);
                $user_jwt = User::find($id[0]->id);
                $jwt_token = Auth::login($user_jwt);
            
                $payloadable = [
                    'id' => $user_jwt->id,
                    'username' => $user_jwt->username,
                    'email' => $user_jwt->email                
                ];

                try {
                
                    if (!$jwt_token = Auth::login($user_jwt)) {
                        return  response()->json([
                            'status' => 'invalid_credentials',
                            'message' => 'Correo o contraseña no válidos.',
                        ], 401);
                    }
                } catch (\Throwable $th) {
                    return  response()->json([
                        'status' => 'unknow_error',
                        'message' => $th,
                    ], 401);
                }
    
                $jwt_token = Auth::customClaims($payloadable)->fromUser($user_jwt);
                $user = Auth::authenticate($request->token);
                return  response()->json([
                    'status' => 'Se ha logueado correctamente',
                    'token' => $jwt_token,
                    'data' => $user,
                ]);
            }
            else{
                return  response()->json([
                    'status' => 'invalid_credentials',
                    'message' => 'Correo o contraseña no válidos.',
                ], 401);
            }

        }        
        else
        {
            return  response()->json([
                'status' => 'invalid_credentials',
                'message' => 'No tiene acceso al sistema,consulte al administrador',
            ], 401);
        }
    }

    public function LDAPConnect($username, $password){
        require_once(app_path(). "../../vendor/adLDAP/adLDAP.php");
        try {
            $adldap = new adLDAP();
        } catch (Exception $e) {
            exit();
        }
       return $result = $adldap->authenticate($username, $password);
    }


    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }


   
}
