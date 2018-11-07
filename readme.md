# DoNews 检测用户登录通用package

> 未登录用户会抛出 `DoNewsUserException` 

## 环境变量配置
- Token加密密钥: `DONEWS_USER_TOKEN_KEY`, 默认: `1234567890123456`
- Token过期天数: `DONEWS_USER_TOKEN_EXPIRED_DAYS`, 默认: `7` 

## example

```php
# user must login
Route::get("UserNeedLogin", function (\Fangxu\Donews\Contracts\DoNewsLoginUser $user) {
    dd("ID: " . $user->id());
});

# user can not login
Route::get("UserMayNotLogin", function (\Fangxu\Donews\Contracts\DoNewsUser $user) {
    dd("ID: " . $user->id());
});
```

## 注意
- 安装完之后, 如果无法正常发现包, 使用命令 `composer dumpautoload` 来自动发现
- `config/database.php` 下添加 `redis` 配置
```
...
"redis" => [
	'client' => 'predis',
	...
 	'donews-user' => [
            "host" => env("USER_TOKEN_REDIS_HOST", '127.0.0.1'),
            "password" => env("USER_TOKEN_REDIS_PASSWORD", null),
            "port" => env("USER_TOKEN_REDIS_PORT", 6379),
            "database" => env("USER_TOKEN_REDIS_DB", 0),
        ],
]
```
- 如果使用集群Redis, 则需要在 `config/database.php` 下添加以下 `redis` 配置
```
...
"redis" => [
	'client' => 'predis',
	...
	"options" => [
            "cluster" => "redis",
        ],
 	'donews-user' => [
            [
            	"host" => env("USER_TOKEN_REDIS_CLUSTER_01_HOST", '127.0.0.1'),
            	"port" => env("USER_TOKEN_REDIS_CLUSTER_01_PORT", 6379),
            ],
	    [
            	"host" => env("USER_TOKEN_REDIS_CLUSTER_02_HOST", '127.0.0.1'),
            	"port" => env("USER_TOKEN_REDIS_CLUSTER_02_PORT", 6379),
            ],
	    ...
        ],
]
```
