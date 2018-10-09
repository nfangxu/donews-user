## DoNews 检测用户登录通用package
- 获取用户信息(不在乎是否登录)
	- 注入 `DoNewsUser::class` , 使用 `id()` 获取用户ID, 使用 `info()` 获取用户全部信息

- 获取用户信息(必须登录)
	- 注入 `DoNewsLoginUser::class` , 未登录用户会抛出 `DoNewsUserException` 异常 , 使用方法同上

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
