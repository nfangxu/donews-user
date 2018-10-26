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
                throw new DoNewsUserException("非法的 Token 值", 401);
            }

            if ($user === 0) {
                throw new DoNewsUserException("请先登录", 404);
            }

            if ($user === 1) {
                throw new DoNewsUserException("该账户已在别处登录, 请重新登录", 410);
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
