<?php

declare(strict_types=1);

namespace  Mofeier\Messages;

class  Messages
{
    // public  array  $default_return  =  [
    //     'code'  =>  20000,
    //     'message'   =>  'OK',
    // ];
    protected  int  $code;
    protected  string  $message;
    protected  string|array  $data;
    protected  int  $count;
    protected  int  $page;

    // public  function  __construct(?array $result)
    // {
    //     $this->default_return  =   $result;
    // }
    public  function  getStatusCode(array $statusCode=NULL)
    {
        if(is_null($statusCode)){
            return  require_once('StatusCode.php');
        }
        return  $statusCode;
    }
    // 设置自己的代码映射数组
    public  function  setStatusCode(array  $statusCode)
    {
        return  $this->getStatusCode($statusCode);
    }
    // 返回消息
    public  function  message(string $message=NULL)
    {
        if(is_null($message)){
            $statusCode  =  $this->getStatusCode();
            if(is_null($this->code)){
                $this->code  =  20000;
            }
            $this->message  =  isset($statusCode[$this->code])? $statusCode[$this->code]:'响应消息';
            return  $this;
        }
        $this->message  =   $message;
        return  $this;
    }
    private  function  getMessage()
    {
        if(!isset($this->message)){
            $this->message();
        }
        return  $this->message;
    }
    // 返回code
    public  function  code(int $code=20000)
    {
        $this->code  =  $code;
        return  $this;
    }
    private  function  getCode()
    {
        if(!isset($this->code)){
            $this->code();
        }
        return  $this->code;;
    }
    // 数据列表
    public  function  data(string|array  $data, array $other=NULL)
    {
        if($other){
            $data   =   array_merge($data, $other);
        }
        $this->data  =  $data ?? [];
        return  $this;
    }
    // 数据总数量
    public  function  count(int $count=NULL)
    {
        if($count){
            $this->count  =  $count ?? 0;
            return  $this;
        }
    }
    // 当前页码
    public  function  page(int $page=NULL, int $maxPage=NULL)
    {
        if ($page) {
            $this->page  =  $page ?? 0;
            $this->max_page  =  $maxPage??$page;
            return  $this;
        }
    }
    public  function  results()
    {
        $result  =  [
            'code'  =>  $this->getCode(),
            'message'  =>  iconv(iconv_get_encoding('input_encoding'), 'UTF-8', $this->getMessage()),
        ];

        if(isset($this->data)){
            $result['data'] =   $this->data;
        }
        if(isset($this->count)){
            $result['count'] =   $this->count;
        }
        if(isset($this->page)){
            $result['page'] =   $this->page;
            $result['max_page'] =   $this->max_page;
        }
        if(extension_loaded('swoole')){
            // var_dump('-swoole-');
            return  $result;
        }else{
            // var_dump('-no-');
            header('Content-type:application/json;charset=utf-8');
            return  json_encode($result, JSON_PRESERVE_ZERO_FRACTION + JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        }
    }
}