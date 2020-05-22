# think-generator

**thinkphp6 随机生成手机号、身份证号、邮箱地址、昵称等**

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
**可以使用`dashingGenerator()`帮助函数,或者`app('dashingGenerator')`随机生成手机号、身份证号、邮箱地址、昵称等 :**
```php

// 获取随机生成的手机号码
dashingGenerator('mobile')->make();

//指定手机号码前缀
dashingGenerator('mobile')->getPrefix('136')->make();//13635566666


```

**可以使用`identity_verity()`来验证身份号码的有效性:**


```

**其他功能：**
```php
use ArcherZdip\Identity\VerityChineseIDNumber;
// 获取生日
$birthday = (new VerityChinsesIDNumber(string $idNumber))->getBirthday()->format('Y-m-d');

// 获取年龄
$age = (new VerityChinsesIDNumber(string $idNumber))->getAge();

// 是否为男性
$isMale = (new VerityChinsesIDNumber(string $idNumber))->isMale();

// 是否为女性
$isFemale = (new VerityChinsesIDNumber(string $idNumber))->isFemale();

// 获取年份
$year = (new VerityChinsesIDNumber(string $idNumber))->getYear()

// 获取月份
$month = (new VerityChinsesIDNumber(string $idNumber))->getmonth()

// 获取日期
$day = (new VerityChinsesIDNumber(string $idNumber))->getday()
```



## 后续
身份证号码中携带附加信息，如地区信息、生日、性别等。