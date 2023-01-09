<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public $authHomeRedirection = 'admin.home';
    public $loginRedirection = 'login';

    public function login () {
        if (!Auth::check())
            return view('login');
        else 
            return redirect()->route($this->authHomeRedirection);
    }
    public function auth (Request $request) {
        try {
            if (!Auth::check()) {
                if ($request->ajax()) {
                    $validator = Validator::make($request->all(), [
                        'username' => 'required|string|max:100',
                        'password' => 'required|string|min:8'],[
                            'required' => ':attribute est obligatoire',
                            'string' => ':attribute doit être un chaîne de caractère',
                            'max' => 'Le contenu de :attribute est trop long',
                            'min' => 'Le contenu de :attribute est trop court',
                        ]);
                    if ($validator->fails()) {
                        return response()->json([
                            'action' => false,
                            'message' => 'Erreur sur le formulaire',
                            'errors' => $validator->errors()],200);
                    }
                    $email  = e($request->username);
                    $password =  e($request->password);
                    $remember =  (isset($request->remember) && $request->remember == 'on') ? true:false;
                    if (Auth::attempt(['email' => $email, 'password' => $password], $remember) || Auth::attempt(['username' => $email, 'password' => $password], $remember)) {
                        return response()->json([
                            'action' => true,
                            'href' => route($this->authHomeRedirection),
                            'message' => 'Vous êtes connecté à cotre compte'],200);
                    }
                    else {
                        return response()->json([
                            'action' => false,
                            'message' => 'Les accès que vous avez utilisés sont invalides. Veuillez réssayez à nouveau.'],200);
                    }
                }
            }
            return response()->json([
                'action' => false,
                'message' => 'Aucune action éffectée. Réessayez...',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'action' => false,
                'message' => 'Erreur système',
                'errors' => $e->getMessage()
            ]);
        }
    }
    public function logout (Request $request) {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'action' => false,
                    'message' => 'Aucune action éffectée. Réessayez...',
                ]);
            }
            else{
                if ($request->ajax()) {
                    Auth::logout();
                    return response()->json([
                        'action' => true,
                        'href' => route($this->loginRedirection),
                        'message' => 'Vous êtes correctement déconnecté du compte'
                    ], 200);
                }
            }           
        } 
        catch (\Exception $e) {
            return response()->json([
                'action' => false,
                'message' => 'Erreur système',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
