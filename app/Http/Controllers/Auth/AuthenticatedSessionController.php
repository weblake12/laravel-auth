<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends AuthController
{
    public function create () {
        if (!Auth::check())
            return view('auth.login');
        else 
            return redirect()->route($this->authHomeRedirection);
    }

    public function store(Request $request) {
        try {
            if ($request->ajax()) {
                if (!Auth::check()) {
                    $validator = Validator::make($request->all(), [
                        'username' => 'required|string|max:100',
                        'password' => 'required|string|min:8'],[
                            'required' => __(':attribute is required'),
                            'string' => __(':attribute must be a string'),
                            'max' => __(':attribute is too long'),
                            'min' => __(':attribute is too short')]);
                    if ($validator->fails()) {
                        return response()->json([
                            'action' => false,
                            'message' => __('Form submitted error') . $validator->errors()->first(),
                            'errors' => $validator->errors()],200);
                    }
                    $email  = e($request->username);
                    $password =  e($request->password);
                    $remember =  (isset($request->remember) && $request->remember == 'on') ? true:false;

                    if (Auth::attempt(['email' => $email, 'password' => $password], $remember) ||  Auth::attempt(['username' => $email, 'password' => $password], $remember)) 
                        return response()->json([
                            'action' => true,
                            'href' => route($this->authHomeRedirection),
                            'message' => __('You are connected')],200);
                    else return response()->json([
                            'action' => false,
                            'message' => __('The credentials, you used are invalids')],200);
                }
            }
            return response()->json([
                'action' => false,
                'message' => __('No action saved...'),
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'action' => false,
                'message' => __('Error system'),
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function destroy (Request $request) {
        try {
            if (!Auth::check())  
                return response()->json([
                    'action' => false,
                    'message' => __('No action saved...')]);
            else {
                if ($request->ajax()) {
                    Auth::logout();
                    return response()->json([
                        'action' => true,
                        'href' => route($this->loginRedirection),
                        'message' => __('You are disconnected')], 200);
                }
            }           
        } 
        catch (\Exception $e) {
            return response()->json([
                'action' => false,
                'message' => __('Error system'),
                'errors' => $e->getMessage()
            ]);
        }
    }
}
