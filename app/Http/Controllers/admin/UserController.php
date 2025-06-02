<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('created_at','DESC')->paginate(10);
        return view('admin.users.list',[
            'users' => $users
        ]);
    }


    public function edit($id){
        $user= User::findOrFail($id);
        // dd($user);
        return view('admin.users.edit',[

            'user' => $user,
        ]);
    }

     public function update($id, Request $request){


        $validator= Validator::make($request->all(),[
            
            'name' => 'required|min:5|max:20',
            //login time email alread exist then this email ignore the email
            'email' =>'required|email|unique:users,email,'.$id.',id'
          ]);

          if($validator->passes()){

         $user = User::find($id); //find method use to fetch the user details
         $user->name=$request->name;
         $user->email=$request->email;
         $user->mobile=$request->mobile;
         $user->designation=$request->designation;
         $user->save();

         session()->flash('success','User information updated successfully.');

         return response()->json([

            'status' => true,
            'errors' =>[]
        ]);

          }
          else{
            return response()->json([

                'status' => false,
                'errors' => $validator->errors()
            ]);
          }

     }

     public function updateRole(Request $request)
     {
         $request->validate([
             'id' => 'required|exists:users,id',
             'role' => 'required|in:user,employer'
         ]);
 
         $user = User::findOrFail($request->id);
         $user->role = $request->role;
         $user->save();
 
         return response()->json(['status' => true, 'message' => 'User role updated successfully']);
     }


        //yaha pe user delete hog tab job bhi delete hogi 
        //hamne migration me cascade use kiya tha ishka matalb ki ham jab ham parent ko delete,
        //karege tab child automatic delete ho jayega yaniki user ki job delete ho jayegi


        public function destroy(Request $request){

            $id = $request->id;

            $user = User::find($id);

            if ($user == null){

              session()->flash('error','User not found');

              return response()->json([
                'status' => false,

              ]);
            }

            $user->delete();

            session()->flash('success','User deleted successfully');

              return response()->json([
                'status' => true,

              ]);

        }



     }
