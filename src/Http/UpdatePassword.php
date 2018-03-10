<?php

namespace ViktorMiller\LaravelUser\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ViktorMiller\LaravelUser\Facades\User;
use Illuminate\Contracts\Auth\Authenticatable;
use ViktorMiller\LaravelUser\Events\PasswordUpdated;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
trait UpdatePassword
{
    /**
     * Show html form
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.password', [
            'user' => $this->user()
        ]);
    }
    
    /**
     * Handle update password request
     * 
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());
        
        $this->updatePassword($this->user(), $this->data($request));
        
        event(new PasswordUpdated($this->user()));
        
        return back()->with('success', 'user.password.updated');
    }
    
    /**
     * Update password
     * 
     * @param Authenticatable $user
     * @param string $password
     */
    protected function updatePassword(Authenticatable $user, $password)
    {
        $user->password = $this->broker()->cryptPassword($password);
        $user->save();
    }
    
    /**
     * Get request data
     * 
     * @param  Request $request
     * @return string
     */
    protected function data(Request $request)
    {
        return $request->input('new_password');
    }
    
    /**
     * Validation rules
     * 
     * @return array
     */
    protected function rules()
    {
        return [
            'new_password' => 'required|min:6|confirmed',
            'password' => 'required|current_password'
        ];
    }
    
    /**
     * Validation messages
     * 
     * @return array
     */
    protected function messages()
    {
        return [];
    }
    
    /**
     * Authenticated user
     * 
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function user()
    {
        return Auth::user();
    }
    
    /**
     * 
     * @return \ViktorMiller\LaravelUser\BrokerInterface
     */
    protected function broker()
    {
        return User::broker();
    }
}
