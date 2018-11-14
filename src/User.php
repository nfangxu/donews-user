<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/9/28
 * Time: 13:28
 */

namespace Fangxu\Donews;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class User
{
    protected static function getAppId($app_id = null)
    {
        $headerAppId = request()->header("appid");

        $return = $headerAppId ?: $app_id;

        return strtolower($return);
    }

    protected static function config()
    {
        return [
            "key" => env("DONEWS_USER_TOKEN_KEY", "1234567890123456"),
            "expired" => env("DONEWS_USER_TOKEN_EXPIRED_DAYS", 7),
        ];
    }

    public static function check($token)
    {
        if (!$token) {
            return 0;
        }

        $user = static::decode($token);

        if (!$user) {
            return -1;
        }

        if (!isset($user->expired_at) || $user->expired_at < Carbon::now("PRC")->timestamp) {
            return 1;
        }

        $redisToken = Redis::connection("donews-user")->get(static::getAppId(request("app_id")) . ":login:" . $user->id);

        if (!$redisToken) {
            return 0;
        }

        return $user;
    }

    public static function token($user)
    {
        if (is_object($user)) {
            $user = $user->toArray();
        }

        $user["expired_at"] = static::config()["expired"] * 24 * 60 * 60 + Carbon::now("PRC")->timestamp;

        $token = static::encode(json_encode($user), static::config()["key"]);

        Redis::connection("donews-user")->set(static::getAppId(request("app_id")) . ":login:" . $user["id"], $token);

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
