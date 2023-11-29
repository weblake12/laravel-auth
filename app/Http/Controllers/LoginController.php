<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * 
     */
    public function login () {
        if (!Auth::check()) {
            return view('login');
        }
        else return redirect()->route('admin.home');
    }

    /**
     * 
     */
    public function auth (Request $request) {
        try {
            if (!Auth::check()) {
                if ($request->ajax()) {
                    $validator = Validator::make($request->all(), [
                        'username' => 'required|string|max:100',
                        'password' => 'required|string|min:8', [
                            'required' => __(':attribute is required'),
                            'string' => __(':attribute must be string'),
                            'max' => __(':attribute is too long'),
                            'min' => __(':attribute is too short')]]);
                    if ($validator->fails()) 
                        return response()->json([
                            'action' => false,
                            'message' => __('Form submitted error'),
                            'errors' => $validator->errors(),
                        ]);
                    $email = e($request->username);
                    $password = e($request->password);
                    $remember = (isset($request->remember) && $request->remember == 'on') ? true:false;
                    if (
                        Auth::attempt(['email' => $email, 'password' => $password], $remember) || 
                        Auth::attempt(['username' => $email, 'password' => $password], $remember)) {
                        return response()->json([
                            'action' => true,
                            'href' => route('admin.home'),
                            'message' => __('You are connected')]);
                    }
                    else return response()->json([
                            'action' => false,
                            'message' => __('The credentials, you used are invalids.')]);
                }
                else response()->json([
                    'action' => false,
                    'message' => __('No action saved...'),
                ]);
            }
        } 
        catch (\Exception $e) {
            return response()->json([
                'action' => false,
                'message' => 'Error system',
                'erros' => $e->getMessage(),
            ]);
        }
    }

    /**
     * 
     */
    public function logout (Request $request) {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'action' => false,
                    'message' => __('No action saved...'),
                ]);
            }
            else {
                if ($request->ajax()) {
                    Auth::logout();
                    return response()->json([
                        'action' => true,
                        'href' => route('login'),
                        'message' => __('You are disconnected'),
                    ]);
                }
            }
        } 
        catch (\Exception $e) {
            return response()->json([
                'action' => false,
                'message' => 'Error system',
                'errors' => $e->getMessage(),
            ]);
        }
    }
}
