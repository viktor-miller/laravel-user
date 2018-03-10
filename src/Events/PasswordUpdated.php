<?php

namespace ViktorMiller\LaravelUser\Events;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
class PasswordUpdated
{
    /**
     * User
     *
     * @var Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  Authenticatable $user
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }
}
