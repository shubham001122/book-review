<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    
public function register()
{

return view('account.register');
    
}

public function processRegister(Request $request)
{

$validator = Validator::make($request->all(),[
      'name'  => 'required|min:3' , 
      'email' => 'required|email' ,
      'password' => 'required|confirmed' ,
      'password_confirmation' => 'required'


]);

if($validator->fails())
{

return redirect()->route('account.register')
->withErrors($validator)->withInput($request->all());

}

// now register user

$user = new User();
$user->name = $request->name;
$user->email = $request->email;
$user->password = Hash::make($request->password);
$user->save();


return redirect()->route('account.login')
->with('register','You are registered successfully');

}


public function login()
{

return view('account.login');

}

public function authenticate(Request $request)
{

$email   =   $request->email;
$password =  $request->password;

$validator = Validator::make($request->all(),[

  'email'    => 'required|email', 
  'password' => 'required'

]);


if($validator->fails())
{

return redirect()->route('account.login')->withErrors($validator)
->withInput($email);

}


if(Auth::attempt(['email' => $email, 'password' => $password]) == true)
{

return redirect()->route('account.profile');

}

else
{

return redirect()->route('account.login')
->with('error','Either email or password is incorrect');

}

}


public function profile()
{

$id = Auth::user()->id;
$user = User::where('id',$id)->first();

return view('account.profile',['user' => $user]);

}

public function updateProfile(Request $request)
{

$name  = $request->name;
$email = $request->email;

$rules = [
  'name'  => 'required|min:5' ,
  'email' =>  'required|email|unique:users,email,'.Auth::user()->id ,
  
  ];

  if(!empty($request->image))
$rules['image'] = 'nullable|image';

$validator = Validator::make($request->all(),$rules);


if($validator->fails())
{

return redirect()->route('account.profile')
->withErrors($validator);

}

    $user = User::find(Auth::user()->id);
    $user->name = $name;
    $user->email = $email;
    $user->save();

    if(!empty($request->image))
    {
    $image = $request->image;
    $ext = $image->getClientOriginalExtension();
    $image_name = time().'.'.$ext;
    $image->move(public_path('uploads/profile'),$image_name);
    $user->image =  $image_name;
    $user->save();
    
}

return redirect()->route('account.profile')
->with('update','Profile Updated Succesully');    

}

public function logout()
{

Auth::logout();
return redirect()->route('account.login')
->with('logout','You have logged out successfully');



}

}
