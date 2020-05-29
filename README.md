# think-generator

**thinkphp6 随机生成手机号、身份证号、邮箱地址、昵称等测试数据**

**特此申明：本类的初衷是生成测试数据，不可进行任何违法行为，不可进行任何违法行为，不可进行任何违法行为！！！**
## Installation
通过在composer.json中配置安装：
```php
composer require dashingunique/think-generator
```
or
```php
// composer.json
composer install
// composer update
composer update
```
## Usage
** 

## 生成手机号码
** 
```php
$generator = (new Generator($this->app))->generator('mobile');

//随机生成一个手机号
$generator->get();  //13611111111

//随机生成一个号段为182的手机号
$generator->prefix(182)->get();//18211111111

//允许13,14,15,17,18,19号段的手机号生成（从中生成一个号码段）
$generator->allow([3, 4, 5, 7, 8, 9])->get();//13011111111

//获取多个手机号
$generator->limit(10)->get();

//若同时存在prefix 和 allow prefix强制覆盖allow
$generator->prefix(182)->allow([3, 4, 5, 7, 8, 9])->limit(10)->get();//18211111111

```

## 生成邮箱地址
** 
```php
$generator = (new Generator($this->app))->generator('email');

//随机生成一个邮箱地址
$generator->get();//12345678@qq.com

//随机生成一个前缀为123456789的邮箱
$generator->prefix(123456789)->get();//123456789@163.com

//随机生成一个后缀为@qq.com的邮箱
$generator->suffix('@qq.com')->get();//12345678@qq.com

//生成一个指定长度的邮箱地址
$generator->length(6)->get();//123456@qq.com

//获取多个邮箱
$generator->limit(10)->get();

```

### 生成身份证号码
```php
$generator = (new Generator($this->app))->generator('identity');

//随机生成一个身份证号码
$generator->get();

//随机生成一个指定性别的身份证号码（1男性 2女性）
$generator->sex(1)->get();

//随机生成一个北京市的身份证号码
$generator->province('北京市')->get();

//随机生成一个省份城市的身份证号码
$generator->city('成都市')->get();

//随机生成一个地区的身份证号码
$generator->city('高新区')->get();

//随机生成一个指定出生日期的身份证号码
$generator->birthday('2000-01-01')->get();

//获取多个身份证号码
$generator->limit(10)->get();

```

## 生成昵称
```php
$generator = (new Generator($this->app))->generator('nickname');

//随机生成一个用户昵称
$generator->get();

//随机生成一个指定姓氏的用户昵称
$generator->surname('张')->get();//张三

//随机生成一个指定姓氏类型的用户昵称（1单姓 2复姓）
$generator->compound(2)->get();//上官三

//随机生成一个指定性别的用户昵称（1男性 2女性）
$generator->sex(2)->get();//张美

//获取一个指定长度的用户昵称
$generator->length(3)->get();//张大麻子

//获取多个用户昵称
$generator->limit(10)->get();

```



```




## 后续
增加银行卡号的生成
验证生成的数据为一性
增加数据驱动类型：本地文件、Redis、数据库
