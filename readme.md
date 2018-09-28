## DoNews 检测用户登录通用package
- 获取用户信息(不在乎是否登录)
	- 注入 `DoNewsUser::class` , 使用 `id()` 获取用户ID, 使用 `info()` 获取用户全部信息

- 获取用户信息(必须登录)
	- 注入 `DoNewsLoginUser::class` , 未登录用户会抛出 `DoNewsUserException` 异常 , 使用方法同上

## 注意
> 使用前需要先注册服务: 在 `App\Providers\AppServiceProvider` 下 `register()` 方法中添加 `$this->app->register(DoNewsUserServiceProvider::class);`,  使用 `use Fangxu\Donews\Providers\DoNewsUserServiceProvider;`
