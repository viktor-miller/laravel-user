<?php

namespace ViktorMiller\LaravelUser\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use ViktorMiller\LaravelUser\Events\EmailUpdated;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
trait UpdateEmail
{
    /**
     * Show html form
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.email', [
            'user' => $this->user()
        ]);
    }
    
    /**
     * Handle email update request
     * 
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());
        
        $this->updateEmail($this->user(), $this->data($request));
        
        event(new EmailUpdated($this->user()));
        
        return back()->with('success', 'user.email.updated');
    }
    
    /**
     * Update email
     * 
     * @param Authenticatable $user
     * @param string $email
     */
    protected function updateEmail(Authenticatable $user, $email)
    {
        $user->email = $email;
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
        return $request->input('email');
    }
    
    /**
     * Validation rules
     * 
     * @return array
     */
    protected function rules()
    {
        return [
            'email' => 'required|email|unique:users,email,'. $this->user()->id,
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
}
