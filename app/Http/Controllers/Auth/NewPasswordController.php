<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class NewPasswordController extends AuthController
{
    public function reset (Request $request) {
        try {
            if ($request->ajax()) {
                if (!Auth::check()) {
                    $email = e($request->email);
                    $token_hashed = e($request->token_hashed);
                    if (!empty($token_hashed) && !empty($email)) {
                        $password_reset = DB::table('password_resets')->where('email', $email)->where('used', false)->latest('created_at')->first();
                        if (!empty($password_reset)) {
                            if (md5($password_reset->token) == $token_hashed) {
                                if (($password_reset->created_at + (int) config('app.token_expiration')) >= time()) {                                    
                                    return response()->json([
                                        'action' => true,
                                        'message' => __("Save your new credentials now"),
                                    ]);
                                }
                                else{
                                    // Link expired not found
                                    return response()->json([
                                        'action' => false,
                                        'href' => route('password.email'),
                                        'message' => __("This reset link is'nt working, this link expired. Please Try again."),
                                    ]);
                                }
                            }
                            else{
                                // Token hashed not found
                                return response()->json([
                                    'action' => false,
                                    'href' => route('password.email'),
                                    'message' => __("This reset link is'nt working, token hashed not correct. Please Try again."),
                                ]);
                            }
                        }
                        else{
                            // Process not found
                            return response()->json([
                                'action' => false,
                                'href' => route('password.email'),
                                'message' => __("This reset link is'nt working, process not found. Please Try again."),
                            ]);
                        }
                    }
                    else{
                        return response()->json([
                            'action' => false,
                            'href' => route('password.email'),
                            'message' => __("This reset link is'nt working, Please Try again."),
                        ]);
                    }
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

    public function create (Request $request, $token_hashed = null) {
        if (!empty($request->email) && !is_null($token_hashed)) {
            $email = e($request->email);
            return view('auth.passwords.reset', compact('email', 'token_hashed'));
        }
        else return redirect()->route('password.request');
    }

    public function store (Request $request) {
        try {
            if ($request->ajax()) {
                $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required|string|min:6',
                    'password_confirmation' => 'required|same:password|min:6'],[
                        'required' => __(':attribute is required'),
                        'email' => __(':attribute must be an email'),
                        'string' => __(':attribute must be a string'),
                        'max' => __(':attribute is too long'),
                        'min' => __(':attribute is too short'),
                        'same' => __('Password must be the same with his confirmation.')]);
                if ($validator->fails()) {
                    return response()->json([
                        'action' => false,
                        'message' => __('Form submitted error: ') . $validator->errors()->first(),
                        'errors' => $validator->errors()],200);
                }
                if (!Auth::check()) {
                    $password_reset = DB::table('password_resets')->where('email', $request->email)->where('used', false)->first();
                    if (!empty($password_reset)) {
                        if (md5($password_reset->token) == $request->token_hashed) {
                            if (DB::table('users')->where('email', $request->email)->update(['password' => Hash::make($request->password)])) {
                                DB::table('password_resets')->where('token', $password_reset->token)->where('used', false)->update(['used' => true]);
                                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                                    return response()->json([
                                        'action' => true,
                                        'href' => route($this->authHomeRedirection),
                                        'message' => __("Operation performed."),
                                    ]);
                                }
                                else{   
                                    return response()->json([
                                        'action' => false,
                                        'href' => route('password.email'),
                                        'message' => __("The process is'nt working. Please Try again."),
                                    ]);
                                }
                            }   
                            return response()->json([
                                'action' => false,
                                'href' => route('password.email'),
                                'message' => __("The process is'nt working. Please Try again."),
                            ]);
                        }
                        else{
                            return response()->json([
                                'action' => false,
                                'href' => route('password.email'),
                                'message' => __("The process is'nt working, security problem. Please Try again."),
                            ]);
                        }
                    }
                }
            }
            return response()->json([
                'action' => false,
                'href' => route('password.email'),
                'message' => __("The process is'nt working. Please Try again."),
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
}
