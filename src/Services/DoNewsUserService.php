<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/9/28
 * Time: 13:19
 */

namespace Fangxu\Donews\Services;


use Fangxu\Donews\Contracts\DoNewsLoginUser;
use Fangxu\Donews\Contracts\DoNewsUser;
use Fangxu\Donews\Exceptions\DoNewsUserException;
use Fangxu\Donews\User;

class DoNewsUserService implements DoNewsUser, DoNewsLoginUser
{
    protected $user = null;

    public function __construct($login = false)
    {
        $token = request()->header("token");

        $user = User::check($token);

        if ($login) {
            if ($user === -1) {
                throw new DoNewsUserException("Token is not valid ", 401);
            }

            if ($user === 0) {
                throw new DoNewsUserException("you need to login in first", 404);
            }

            if ($user === 1) {
                throw new DoNewsUserException("This account is already logged in elsewhere", 410);
            }
        }

        $this->user = is_object($user) ? $user : null;
    }

    public function info()
    {
        return $this->user;
    }

    public function id()
    {
        return $this->user ? $this->user->id : null;
    }
}
