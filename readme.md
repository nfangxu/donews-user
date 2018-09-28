## DoNews 检测用户登录通用package
- 获取用户信息(不在乎是否登录)
	- 注入 `DoNewsUser::class` , 使用 `id()` 获取用户ID, 使用 `info()` 获取用户全部信息

- 获取用户信息(必须登录)
	- 注入 `DoNewsLoginUser::class` , 未登录用户会抛出 `DoNewsUserException` 异常 , 使用方法同上