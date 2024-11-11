<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserLdap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

//buscar en el directorio activo
    public function findUser($username)
    {
      return User::where('username','=',$username)->get();
    }
      // Get authenticated user
      public function getUser($username)
      {
        $user=$this->findUser($username);
  
          return response()->json(compact('user'));
  
      }
    public function getUsers()
    {
    
       $users=User::whereNull('deleted_at')->orderBy('created_at','desc')->get();

        return response()->json(compact('users'));
    }

    public function store(UserRequest $request){
        $user = User::create($request->validated());
        return response()->json([
            'flash_message' => 'Usuario añadido satisfactoriamente.',
            'user' => $user
        ]);
    }

    public function update(UserRequest $request, $id){
        $user = User::find($id);
        $user->update($request->validated());
        return response()->json([
            'flash_message' => 'Usuario actualizado satisfactoriamente.',
            'user' => $user
        ]);

    }
    public function ldapUser( Request $request){
        //buscar en ldap (username,mail,solapin)
        $userLdap = UserLdap::select('employeenumber','mail','cn')->where('samaccountname', '=', $request['username'])->get();
 
        if(!$userLdap->isEmpty()){
             return response()->json([
                'message'=>'User exist.',
                'userLdap'=>$userLdap
             ], 201);
 
        }
         return response()->json([
            'message' => 'User not exist'
         ], 201);
     }
   
     public function infoperUser(Request $request)
     {
         $users = DB::connection("sqlsrv")->select('SELECT * FROM Employees WHERE expte = ?', [$request['solapin']]);
         return response()->json([
             'user' => $users
         ]);
     }

     public function destroy( $id)
    {
        $user = User::find($id);
        $user->delete(); 
        
        return response()->json([
            'flash_message' => 'Usuario eliminado satisfactoriamente.'
        ]);          
    }

    public function forceDestroy ($id)
    {
        $user = User::withoutTrashed()->find($id);
        $user->forceDelete();       
        return response()->json([
            'flash_message' => 'Usuario eliminado satisfactoriamente de la base de datos.'
        ]);   
    }

    public function getDeleted(){
   
        $users_deleted = User::onlyTrashed()->get();
        return response()->json([
            'areas' => $users_deleted
        ]);
    
    }
    public function restore($id){
    
        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return response()->json([
            'flash_message' => 'Usuario ha sido restaurado.'
        ]);   
    }
}
