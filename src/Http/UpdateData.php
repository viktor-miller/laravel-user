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
trait UpdateData
{
    /**
     * Show html form
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.data', [
            'user' => $this->user()
        ]);
    }
    
    /**
     * Handle update request
     * 
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());
        
        $this->updateData($this->user(), $this->data($request));
        
        return $this->sendSuccessResponse();
    }
    
    /**
     * Update data
     * 
     * @param Authenticatable $user
     * @param array $data
     */
    protected function updateData(Authenticatable $user, array $data)
    {
        $user->fill($data);
        $user->save();
    }
    
    /**
     * Get request data
     * 
     * @param  Request $request
     * @return array
     */
    protected function data(Request $request)
    {
        return $request->all();
    }
    
    /**
     * Validator rules
     * 
     * @return array
     */
    protected function rules()
    {
        return [];
    }
    
    /**
     * Validator messages
     * 
     * @return array
     */
    protected function messages()
    {
        return [];
    }
    
    /**
     * Send success response
     * 
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendSuccessResponse()
    {
        return back()->with('success', __('user::messages.updated'));
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
