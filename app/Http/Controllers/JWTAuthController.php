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
            'password' => 'required|string|min:6|confirmed',
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
        
         // $is_correct_user_ldap= $this->LDAPConnect($request['username'],$request['password']);
        $is_correct_user_ldap=true;
        if($is_correct_user_ldap){
                
                $id = DB::select('select users.id from users where username = ?', [$request['username']]);
                $user_jwt = User::find($id[0]->id);
                $jwt_token = Auth::login($user_jwt);
            
                $payloadable = [
                    'id' => $user_jwt->id,
                    'username' => $user_jwt->username,
                    'email' => $user_jwt->email,
                    'name' => $user_jwt->name,
            
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
    
                $token = Auth::customClaims($payloadable)->fromUser($user_jwt);
                $user = Auth::authenticate($request->token);
                return  response()->json([
                    'status' => 'Se ha logueado correctamente',
                    'token' => $token,
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

    // Get authenticated user
    public function getUser()
    {
    
        // Pasar el nombre de usuario invoca a la funion findUser y devuelvas el name y email
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }
    //buscar en el directorio activo
    public function findUser()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function infoperUser(Request $request)
    {
        $users = DB::connection("sqlsrv")->select('SELECT * FROM Employees WHERE expte = ?', [$request['solapin']]);
        return response()->json([
            'user' => $users
        ]);
    }

    public function ldapUser( Request $request){
       //buscar en ldap (username,mail,solapin)
       /*$userLdap = UserLdap::select('employeenumber','mail','cn')->where('samaccountname', '=', $request['username'])->get();

       if(!$userLdap->isEmpty()){
            return response()->json([
               'message'=>'User exist.',
               'userLdap'=>$userLdap
            ], 201);

       }*/
        return response()->json([
           'message' => 'User not exist'
        ], 201);
    }
    public function getUsers()
    {
    
       $users=User::get();

        return response()->json(compact('users'));
    }
}
