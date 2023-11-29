<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Str;
use DB;
use Mail;
use App\Models\User;
use App\Mail\SendTokenMail;

class PasswordResetLinkController extends Controller
{
    public function create () {
        return view('auth.passwords.email');
    } 
    
    public function store (Request $request) {
        try {
            if ($request->ajax()) {
                if (!Auth::check()) {
                    $validator = Validator::make($request->all(), [
                        'email' => 'required|string|min:8|max:100'],[
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
                    $user = DB::table('users')->where('email', '=', e($request->email))->first();
                    if (empty($user)) {
                        return response()->json([
                            'action' => false,
                            'message' => __("This user doesn't exist"),
                        ]);
                    }
                    else {
                        DB::table('password_resets')->where('email', e($request->email))->where('used', false)->delete();
                    }
                    DB::table('password_resets')->insert([
                        'email' => e($request->email),
                        'token' => Str::random(20),
                        'created_at' => time()
                    ]);
        
                    $tokenData = DB::table('password_resets')->where('email', e($request->email))->latest('created_at')->first();
        
                    if ($this->sendResetEmail(e($request->email), $tokenData->token)) {
                        return response()->json([
                            'action' => true,
                            'message' => __('A reset link sended to :email.', ['email' => e($request->email)])
                        ]);
                    }
                }
            }
            return response()->json([
                'action' => false,
                'message' => __("Reset link doesn't send, try again")
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

    private function sendResetEmail($email, $token) {
        /* Retrieve the user from the database */
        try {
            $user = User::where('email', $email)->select('email', 'name')->first();
            if (!empty($user)) {
                Mail::to($email)->send(new SendTokenMail([
                    'name' => $user->name,
                    'reply_to' => config('app.email'),
                    'link' => route('password.reset', ['token' => md5($token)]) . '?email=' . urlencode($email),
                    'email' => $email,
                    'token_expiration' => config('app.token_expiration')]));
                return true;
            }
            else return false;
        } 
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
