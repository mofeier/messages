这是一个返回消息状态的组件！

## composer安装
composer  require  mofeier/messages

## 使用

```php
use  Mofeier\Messages;

/**
 * 1、状态码可追加，可使用默认和自定义。
 * 2、返回数据多格式：json，array，默认array
 * 3、参数命名可指定，可追加参数
 * 4、返回参数自定义
 */

// ……其他代码
// 使用默认返回状态值，也可以写自己的返回状态码，适合PHP5以上。
// 乱码问题：根据自使用框架调整。
/* 默认状态码，在StatusCode
 20000   =>  'OK',
// 账号操作相关
20001   =>  '账号有误',
20002   =>  '密码错误',
20003   =>  '验证码错误',
20004   =>  '验证未通过',
20005   =>  '短信验证码错误',
20006   =>  '登录超时',
20007   =>  '账号已登陆',
20008   =>  '账号在其他地方登陆',
20009   =>  '锁屏密码错误',
20010   =>  '账号已退出',
20011   =>  '账号退出失败',

// 路由操作相关
40001   =>  '操作失败',
40004   =>  '无此方法',
40005   =>  '无此权限',
*/

/*
 * 默认返回参数
 * code ： 状态码
 * msg : 消息
 * 其他有数据自行设置
*/
### 1.消息体
$result  =  new  Messages;
// 默认返回 array
$result->result();
// 返回json，json($cn=false)，默认原json格式，中文会转义；cn=true时，转义中文，如框架自带json，可能会出现乱码，请使用result。
$result->json();
// 可设置默认消息文字，默认为：请设置消息语
$result->defMsg('默认消息');

### 2. 可自定义字段名
// 默认属性为 code，msg。自定义代码号和消息语，其他根据自设置字段增加。
$result->code(2022)->result();
$result->code(2022)->msg('错误')->result();

### 3. 自定义:count,page,limit,data,都是自定义参数，会根据定义名称输出。也可以定义为其他名称
$result->code(2022)->msg('错误')->count(20)->page(1)->limit(5)->data($array)->result();

### 4. 替换字段名：replace ，可提前设置，可以链式追加，只有相同字段才能替换。
$result->code(2022)->msg('错误')->replace($array)->result();
// 也可提前设置
$result->replace($array);
$result->code(2022)->msg('错误')->result();

### 5. 状态码使用
// 1. 获取状态映射
(new StatusCode)->getCode();
// 2. 默认code
(new StatusCode)->getDefCode();
// 3. 自定义code映射
(new StatusCode)->setCode($array);
// 3. 自定义code 和默认合并
(new StatusCode)->merge(true)->setCode($array);

## 实现
// 映射码
$codes  =   [
    200 =>  'Success',
    201 =>  'Error',
    202 =>  'Action',
];
// 替换字段名
$datas  =  [
    'code'  =>  'codes',
    'msg'  =>  'mesg',
    'limit'  =>  'page_num',
];
// 设置自定义状态码
// $status =   $this->statusCode->setCode($codes);
// 替换数据
$this->messages->replace($datas);
$this->messages->code(2022)->msg('我是好人')->limit(15)->page(1)->count(100)->result();
