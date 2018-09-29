<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/9/28
 * Time: 13:28
 */

namespace Fangxu\Donews;

use Illuminate\Support\Facades\Redis;

class User
{
    protected static function config()
    {
        return [
            "key" => env("DONEWS_USER_TOKEN_KEY", "1234567890123456"),
        ];
    }

    public static function check($token)
    {
        $user = static::decode($token);

        if (!$user) {
            return -1;
        }

        $redisToken = Redis::connection("donews-user")->get(strtolower(request("app_id")) . ":login:" . $user->id);

        if (!$redisToken) {
            return 0;
        }

        if ($redisToken != $token) {
            return 1;
        }

        return $user;
    }

    public static function token($user)
    {
        $token = static::encode(json_encode($user), static::config()["key"]);

        Redis::connection("donews-user")->set(strtolower(request("app_id")) . ":login:" . $user->id, $token);

        return $token;
    }

    protected static function encode($data, $key)
    {
        $aes = substr($key, strlen($key) - 16);
        return base64_encode(openssl_encrypt($data, "AES-128-ECB", $aes));
    }

    protected static function decode($data)
    {
        $aes = substr(static::config()["key"], strlen(static::config()["key"]) - 16);
        return json_decode(openssl_decrypt(base64_decode($data), "AES-128-ECB", $aes));
    }
}
