<?php

namespace App\Http\Controllers;

use App\Mail\userCreated;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class User extends Controller
{
    public function getUsers()
    {
        $items = 3;
        $index = paginator($items);

        //dd($index);

        $users = UserModel::get()->slice($index, $items);

        // if(request()->has('sort_by')){
        //     request()->except('sort_by');

        // }

        // foreach(request()->query() as $query=>$value){
        //     if(isset($query,$value)){
        //         $users=$users->where($query,$value);
        //     }
        // }

        //fliterResults(4);
        //   if(request()->has('filtter_by_name')){
        //     $users = DB::table('users')
        //           ->where('id','>', '1') ->orderBy('name', 'asc')->paginate(2)
        //          ;
        //   }
        //       if(request()->has('sort_by')){
        //         $attr=request()->sort_by;
        //   $users=$users->sortBy->{$attr};
        //       }
        // $users = UserModel::where('id', '>', 1)->paginate(5);
        //       if(request()->has('sort_by')){
        //         $attr=request()->sort_by;

        //       $users = DB::table('users')
        //       ->orderBy('name', 'asc')->paginate(2)
        //      ;
        //       }
        return response()->json(['users' => $users], 200);
    }

    public function getSpecificUser($id)
    {
        //try{
        $user = UserModel::findOrFail($id);

        return response()->json(['user' => $user], 200);
        //}
        // catch(\Exception $exception){
        //     return $exception->getMessage();
        // }
    }
    public function createUser(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed',

        ];

        // $this->validate($request, $rules);

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {

            return response()->json($validator->errors());
        }
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = false;
        $data['role'] = 'admin';
        $data['verification_token'] = UserModel::generateVerificationCode();
        $user = UserModel::create($data);
        return response()->json('user created', 201);
    }
    public function updateUser(Request $req, $id)
    {
        $user = UserModel::findOrFail($id);
        $rules = [

            'email' => 'email',
            'password' => 'min:4|confirmed',
            'role' => 'in: admin , regular',

        ];
        // $validation = Validator::make(request()->all(), $rules);
        // if ($validation->fails()) {
        //     return response()->json($validation->errors(), 400);
        // }

        if ($req->has('name')) {
            $user->name = $req->name;
        }
        if ($req->has('email') && $user->email != $req->email) {
            $user->email = $req->email;
            $user->verified = false;
            $user->verification_token = UserModel::generateVerificationCode();
        }
        if ($req->has('password')) {
            $user->passwprd = bcrypt($req->password);
        }
        // if ($req->has('role')) {
        //     $user->role=$req->role;
        // }

        $user->save();
        return response()->json('user updated', 201);
    }

    public function deleteUser($id)
    {
        $user = UserModel::findOrFail($id);

        $user->delete();
        return response()->json('user deleted', 201);
    }

    public function verifyUser($token)
    {
        $user = UserModel::where('verification_token', $token)->firstOrFail();
        $user->verified = true;
        $user->save();
        return response()->json('user verified', 201);
    }

    public function resend($id)
    {
        $user = UserModel::findOrFail($id);
        if ($user->verified) {
            return response()->json('user is already verified', 201);
        }
        Mail::to($user)->send(new userCreated($user));
        return response()->json('resnded ', 201);
    }
}
