<?php

declare(strict_types=1);

namespace  Mofeier\Messages;

class  StatusCode
{
    public  function  __construct()
    {
        $this->defaultCode();
    }
    // 默认数据
    public  function  defaultCode()
    {
        $this->statusCode =  [
            20000   =>  'OK',
            // 账号操作相关
            20001   =>  '账号有误',
            20002   =>  '密码错误',
            20003   =>  '验证码错误',
            20004   =>  '验证未通过',
            20005   =>  '短信验证码错误',
            20006   =>  '登录已失效',
            20007   =>  '账号已登陆',
            20008   =>  '账号在其他地方登陆',
            20009   =>  '锁屏密码错误',
            20010   =>  '账号已退出',
            20011   =>  '账号退出失败',

            // 路由操作相关
            40001   =>  '操作失败',
            40004   =>  '无此方法',
            40005   =>  '无此权限',
        ];
        return  $this;
    }
    // 合并
    public  function  merge(bool $isMerge=false)
    {
        $this->isMerge  =  $isMerge;
        return  $this;
    }
    // 自定义数据
    public  function  setCode(array  $codes=NULL)
    {
        $array  =  [];
        if(isset($this->isMerge) && $codes){
            // $array  =  array_merge($this->statusCode, $codes);
            foreach($codes as $key=>$item){
                $this->statusCode[$key] = $item;
            }
        }else{
            if($codes){
                $this->statusCode =   $codes;
            }
        }
        // $this->statusCode   =   $array;
        return  $this;
    }
    // 自定义数据后在调用此方法
    public  function  getDefCode():int
    {
        $code   =   0;
        if(isset($this->statusCode) && is_array($this->statusCode)){
            $code  =  array_key_first($this->statusCode);
        }
        return  $code;
    }
    // 获取code映射
    public  function  getCode()
    {
        return  $this->statusCode;
    }
}