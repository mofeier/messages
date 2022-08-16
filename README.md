这是一个返回消息状态的组件！

## composer安装
composer  require  mofeier/messages

## 使用

```php
use  Mofeier\Messages;

// ……其他代码
// 使用默认返回状态值，也可以写自己的返回状态码，默认返回json数据，适合swoole相关框架和传统PHP。适合PHP5以上。
// 乱码问题：根据自使用框架调整。 swoole相关框架，返回为array
/*
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
 * message : 消息
 * 其他有数据时设置即可
 * data ： 字符或数组
 * count ：数据总数量，做接口需要总数量分页使用
 * page ： 当前页码
 * max_page ： 最大页码，可以不写，默认跟page一样
*/
$result  =  new  Messages;
// 默认返回 20000
$result->results();

// 设置自己状态码，$array 参数为数组
$result->setStatusCode($array);

// 使用状态码, 请设置默认消息值
$result->code(400)->results();

// 使用状态码和消息
$result->code(400)->message('操作失败')->results();

// 使用data
$result->data($data);

// 使用总数量 $count = 100
$result->count($count);

// 使用页码, page($page 当前页，max_page 最大页码)
$result->page(1, 5);

// 综合使用
$result->code(400)->message('操作失败')->data($data)->count(200)->page(1)->results();
