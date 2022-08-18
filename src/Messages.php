<?php
declare(strict_types=1);

namespace  Mofeier\Messages;

/**
 * 1、状态码可追加，可使用默认和自定义。
 * 2、返回数据多格式：json，array，xml，默认array
 * 3、参数命名可指定，可追加参数
 * 4、返回参数自定义
 */

class  Messages
{
    // this方法
    public  function  __call($name, $arguments)
    {
        if(!isset($this->data[$name])){
            // var_dump($arguments);
            $this->data[$name]  =   $arguments[0];
        }
        return  $this;
    }
    // 默认格式
    public  function  __construct()
    {
        $this->data =   [];
    }
    // 替换key名字参数，约束替换第一层，使用中替换
    public  function  replace(array $replace=NULL)
    {
        if($replace){
            $this->replace  =  $replace;
            return  $this;
        }
    }
    // 替换字段
    private  function  replace_key(array $replace)
    {
        foreach ($replace as $key => $item) {
            if (isset($this->data[$key])) {
                $this->data[$item]  =   $this->data[$key];
                unset($this->data[$key]);
            }
        }
        return  $this;
    }
    // 设置默认消息
    public  function  defMsg(string $defMsg=NULL)
    {
        $this->defMsg  =  $defMsg;
        return  $this;
    }
    // 组合数据，主要为code，msg，替换key字段名
    private  function  combData()
    {
        $statusCode  =  (new StatusCode)->getCode();
        if(!isset($this->code)){
            $this->code();
        }
        $this->data['code'] =   $this->code;
        $defMsg  =  '请设置消息语';
        if(isset($this->defMsg)){
            $defMsg  =  $this->defMsg;
        }
        $this->data['msg']  =  $statusCode[$this->code]??$defMsg;
        if(isset($this->msg)){
            $this->data['msg']  =   $this->msg;
        }
        if(isset($this->set_replace)){
            $this->replace_key($this->set_replace);
        }
        if (isset($this->replace)) {
            $this->replace_key($this->replace);
        }
        return  $this;
    }
    // 基础数据
    public  function  code(int $code=NULL)
    {
        if(is_null($code)){
            $this->code =   (new StatusCode)->getDefCode();
        }elseif(is_int($code)){
            $this->code =   $code;
        }
        return  $this;
    }
    public  function  msg(?string $msg = NULL)
    {
        $this->msg =   $msg;
        return  $this;
    }
    // 默认返回array
    public  function  result()
    {
        $this->combData();
        return  $this->data;
    }
    // 返回json，未处理异常
    public  function   json(bool $cn=false)
    {
        $this->combData();
        // | JSON_HEX_TAG| JSON_HEX_AMP| JSON_HEX_APOS| JSON_HEX_QUOT| JSON_NUMERIC_CHECK| JSON_UNESCAPED_SLASHES
        if($cn){
            return  json_encode($this->data, JSON_UNESCAPED_UNICODE);
        }
        return  json_encode($this->data);
    }
}