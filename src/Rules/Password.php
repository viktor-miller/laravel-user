<?php

namespace ViktorMiller\LaravelUser\Rules;

use Illuminate\Support\Facades\Auth;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
class Password
{   
    /**
     * Determine if the validation rule passes.
     * 
     * @param  string $attribute
     * @param  string $value
     * @param  array  $parameters
     * @return bool
     */
    public function current($attribute, $value, array $parameters)
    {
        return $this->provider()->validateCredentials($this->user(), [
            $attribute => $value
        ]);
    }
    
    /**
     * 
     * @return \Illuminate\Contracts\Auth\UserProvider
     */
    protected function provider()
    {
        return Auth::getProvider();
    }
    
    /**
     * 
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function user()
    {
        return Auth::user();
    }
}
