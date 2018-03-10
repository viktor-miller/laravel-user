<?php

namespace ViktorMiller\LaravelUser\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
trait Delete
{
    /**
     * Show html form
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.delete', [
            'user' => $this->user()
        ]);
    }
    
    /**
     * Handle delete request
     * 
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());
        
        $this->deleteUser($this->user());
        
        return back()->with('success', 'user.deleted');
    }
    
    /**
     * Delete user
     * 
     * @param Authenticatable $user
     */
    protected function deleteUser(Authenticatable $user)
    {
        $user->delete();
    }
    
    /**
     * Validation rules
     * 
     * @return array
     */
    protected function rules()
    {
        return [
            'password' => 'required|current_password',
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
